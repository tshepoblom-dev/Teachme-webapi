<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\traits\UserFormFieldsTrait;
use App\Mixins\RegistrationBonus\RegistrationBonusAccounting;
use App\Models\Affiliate;
use App\Models\Category;
use App\Models\Reward;
use App\Models\RewardAccounting;
use App\Models\Role;
use App\Models\UserMeta;
use App\User;
use App\Jobs\UploadUserFiles;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    use UserFormFieldsTrait;
    use RegistersUsers;

    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    */

    protected $redirectTo = '/panel';

    /**
     * Path to the institutions JSON file.
     * Stored in resources/data/ so it is not publicly accessible.
     */
    private const INSTITUTIONS_JSON = 'data/institutions.json';

    public function __construct()
    {
        $this->middleware('guest');
    }

    // -------------------------------------------------------------------------
    // View
    // -------------------------------------------------------------------------

    public function showRegistrationForm(Request $request)
    {
        $seoSettings    = getSeoMetas('register');
        $pageTitle       = $seoSettings['title']       ?? trans('site.register_page_title');
        $pageDescription = $seoSettings['description'] ?? trans('site.register_page_title');
        $pageRobot       = getPageRobot('register');

        $referralSettings = getReferralSettings();
        $referralCode     = Cookie::get('referral_code');
        $formFields       = $this->getFormFieldsByUserType($request, 'user', true);

        // Pre-load institutions for the blade's inline JSON — avoids an HTTP
        // round-trip on every keystroke in the institution autocomplete field.
        $institutionsForJs = $this->loadInstitutionsForJs();

        return view(getTemplate() . '.auth.register', [
            'pageTitle'        => $pageTitle,
            'pageDescription'  => $pageDescription,
            'pageRobot'        => $pageRobot,
            'referralCode'     => $referralCode,
            'referralSettings' => $referralSettings,
            'formFields'       => $formFields,
            'institutionsForJs' => $institutionsForJs,
        ]);
    }

    // -------------------------------------------------------------------------
    // Validation
    // -------------------------------------------------------------------------

    protected function validator(array $data)
    {
        $registerMethod = getGeneralSettings('register_method') ?? 'mobile';

        if (!empty($data['mobile']) && !empty($data['country_code'])) {
            $data['mobile'] = ltrim($data['country_code'], '+') . ltrim($data['mobile'], '0');
        }

        $rules = [
            'country_code'        => ($registerMethod === 'mobile') ? 'required' : 'nullable',
            'mobile'              => (($registerMethod === 'mobile') ? 'required' : 'nullable') . '|numeric|unique:users',
            'email'               => (($registerMethod === 'email') ? 'required' : 'nullable') . '|email|max:255|unique:users',
            'term'                => 'required',
            'full_name'           => 'required|string|min:3',
            'password'            => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|same:password',
            'referral_code'       => 'nullable|exists:affiliates_codes,code',

            // Registration-specific fields
            'study_course'        => 'nullable|string|max:255',
            'institution_name'    => 'nullable|string|max:255',
            // South African ID: 13 digits. Adjust the regex if needed.
            'id_number'           => 'nullable|digits:13',
        ];

        if (!empty(getGeneralSecuritySettings('captcha_for_register'))) {
            $rules['captcha'] = 'required|captcha';
        }

        return Validator::make($data, $rules);
    }

    // -------------------------------------------------------------------------
    // User creation
    // -------------------------------------------------------------------------

    protected function create(array $data)
    {
        if (!empty($data['mobile']) && !empty($data['country_code'])) {
            $data['mobile'] = ltrim($data['country_code'], '+') . ltrim($data['mobile'], '0');
        }

        $referralSettings     = getReferralSettings();
        $usersAffiliateStatus = (!empty($referralSettings) && !empty($referralSettings['users_affiliate_status']));

        if (empty($data['timezone'])) {
            $data['timezone'] = getGeneralSettings('default_time_zone') ?? null;
        }

        $disableViewContentAfterUserRegister = getFeaturesSettings('disable_view_content_after_user_register');
        $accessContent = !($disableViewContentAfterUserRegister ?? false);

        $roleName = Role::$user;
        $roleId   = Role::getUserRoleId();

        if (!empty($data['account_type'])) {
            if ($data['account_type'] === Role::$teacher) {
                $roleName = Role::$teacher;
                $roleId   = Role::getTeacherRoleId();
            } elseif ($data['account_type'] === Role::$organization) {
                $roleName = Role::$organization;
                $roleId   = Role::getOrganizationRoleId();
            }
        }

        $user = User::create([
            'role_name'        => $roleName,
            'role_id'          => $roleId,
            'mobile'           => $data['mobile']           ?? null,
            'email'            => $data['email']            ?? null,
            'full_name'        => $data['full_name'],
            'status'           => User::$pending,
            'access_content'   => $accessContent,
            'password'         => Hash::make($data['password']),
            'affiliate'        => $usersAffiliateStatus,
            'timezone'         => $data['timezone']         ?? null,
            'created_at'       => time(),

            // Registration-specific fields
            'study_course'     => $data['study_course']     ?? null,
            'institution_name' => $data['institution_name'] ?? null,
            'id_number'        => $data['id_number']        ?? null,
        ]);

        if (!empty($data['certificate_additional'])) {
            UserMeta::updateOrCreate(
                ['user_id' => $user->id, 'name' => 'certificate_additional'],
                ['value'   => $data['certificate_additional']]
            );
        }

        $this->storeFormFields($data, $user);

        return $user;
    }

    // -------------------------------------------------------------------------
    // Registration handler
    // -------------------------------------------------------------------------

    public function register(Request $request)
    {
        $validate = $this->validator($request->all());

        if ($validate->fails()) {
            $errors = $validate->errors();

            $form = $this->getFormFieldsByType($request->get('account_type'));
            if (!empty($form)) {
                foreach ($this->checkFormRequiredFields($request, $form) as $id => $error) {
                    $errors->add($id, $error);
                }
            }

            throw new ValidationException($validate);
        }

        // Check custom form fields even when base validation passes
        $form   = $this->getFormFieldsByType($request->get('account_type'));
        $errors = [];

        if (!empty($form)) {
            $errors = $this->checkFormRequiredFields($request, $form);
        }

        if (!empty($errors)) {
            return back()->withErrors($errors)->withInput($request->all());
        }

        $data = $request->all();

        if (!empty($data['mobile']) && !empty($data['country_code'])) {
            $data['mobile'] = $data['country_code'] . ltrim($data['mobile'], '0');
        }

        if (!empty($data['mobile']) && !checkMobileNumber($data['mobile'])) {
            return back()
                ->withErrors(['mobile' => [trans('update.mobile_number_is_not_valid')]])
                ->withInput($request->all());
        }

        $user = $this->create($request->all());

        event(new Registered($user));

        // Dispatch the file upload job properly — closures cannot be serialised
        // to a real queue driver and would silently fail when not using `sync`.
        try {
            UploadUserFiles::dispatch($request->allFiles(), $user->id);
        } catch (Exception $ex) {
            \Log::error('File upload dispatch failed: ' . $ex->getMessage(), [
                'user_id' => $user->id,
            ]);
        }

        sendNotification('new_registration', [
            '[u.name]'   => $user->full_name,
            '[u.role]'   => trans("update.role_{$user->role_name}"),
            '[time.date]' => dateTimeFormat($user->created_at, 'j M Y H:i'),
        ], 1);

        $registerMethod = getGeneralSettings('register_method') ?? 'mobile';
        $value = $request->get($registerMethod);

        if ($registerMethod === 'mobile') {
            $value = $request->get('country_code') . ltrim($request->get('mobile'), '0');
        }

        $referralCode = $request->get('referral_code');
        if (!empty($referralCode)) {
            session()->put('referralCode', $referralCode);
        }

        $verificationController = new VerificationController();
        $checkConfirmed = $verificationController->checkConfirmed($user, $registerMethod, $value);

        if ($checkConfirmed['status'] === 'send') {
            return redirect('/verification');
        }

        if ($checkConfirmed['status'] === 'verified') {
            $this->guard()->login($user);

            $registrationBonusSettings = getRegistrationBonusSettings();
            $enableRegistrationBonus   = !empty($registrationBonusSettings['status'])
                                         && !empty($registrationBonusSettings['registration_bonus_amount']);
            $registrationBonusAmount   = $enableRegistrationBonus
                                         ? $registrationBonusSettings['registration_bonus_amount']
                                         : null;

            $user->update([
                'status'                   => User::$active,
                'enable_registration_bonus' => $enableRegistrationBonus,
                'registration_bonus_amount' => $registrationBonusAmount,
            ]);

            $registerReward = RewardAccounting::calculateScore(Reward::REGISTER);
            RewardAccounting::makeRewardAccounting($user->id, $registerReward, Reward::REGISTER, $user->id, true);

            if (!empty($referralCode)) {
                Affiliate::storeReferral($user, $referralCode);
            }

            (new RegistrationBonusAccounting())->storeRegistrationBonusInstantly($user);

            if ($response = $this->registered($request, $user)) {
                return $response;
            }

            return $request->wantsJson()
                ? new JsonResponse([], 201)
                : redirect($this->redirectPath());
        }
    }

    // -------------------------------------------------------------------------
    // Autocomplete endpoints
    // -------------------------------------------------------------------------

    /**
     * Search course categories by title.
     *
     * The `categories` table does not carry a `title` column directly —
     * titles live in `category_translations` (the app's standard translation
     * pattern). We join that table to search and return human-readable names.
     * Slug is kept as a secondary match so partial technical searches still work.
     *
     * Route: GET /search-categories/{query}
     */
    public function searchCategories(string $query)
    {
        $query = trim($query);

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $categories = Category::join('category_translations', 'categories.id', '=', 'category_translations.category_id')
            ->where(function ($q) use ($query) {
                $q->where('category_translations.title', 'LIKE', "%{$query}%")
                  ->orWhere('categories.slug', 'LIKE', "%{$query}%");
            })
            ->select('categories.id', 'category_translations.title')
            ->limit(30)
            ->get();

        return response()->json($categories);
    }

    /**
     * Search institutions from the static JSON file.
     *
     * Previously queried the `users` table, which (a) is empty for new sites,
     * (b) only returns values that previous users happened to type, and
     * (c) leaks data patterns. The JSON is the canonical source.
     *
     * Returns a flat array of matching institution name strings so the
     * blade autocomplete can render them directly.
     *
     * Route: GET /search-schools/{query}
     */
    public function getSchools(string $query)
    {
        $query = strtolower(trim($query));

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $all     = $this->loadAllInstitutionNames();
        $matches = array_values(array_filter(
            $all,
            fn (string $name) => str_contains(strtolower($name), $query)
        ));

        return response()->json($matches);
    }

    // -------------------------------------------------------------------------
    // Private helpers
    // -------------------------------------------------------------------------

    /**
     * Load all institution names from the JSON file as a flat array.
     */
    private function loadAllInstitutionNames(): array
    {
        $path = resource_path(self::INSTITUTIONS_JSON);

        if (!file_exists($path)) {
            \Log::warning('institutions.json not found at: ' . $path);
            return [];
        }

        $raw   = json_decode(file_get_contents($path), true);
        $names = [];

        foreach ($raw as $group) {
            foreach ($group as $name) {
                $names[] = $name;
            }
        }

        sort($names);

        return $names;
    }

    /**
     * Load institutions with type labels for the blade's inline JSON constant.
     * Returns an array of ['name' => string, 'type' => string] objects.
     */
    private function loadInstitutionsForJs(): array
    {
        $path = resource_path(self::INSTITUTIONS_JSON);

        if (!file_exists($path)) {
            return [];
        }

        $raw    = json_decode(file_get_contents($path), true);
        $result = [];

        $typeLabels = [
            'universities'    => 'University',
            'tvet_colleges'   => 'TVET',
            'private_colleges' => 'Private',
        ];

        foreach ($raw as $type => $names) {
            $label = $typeLabels[$type] ?? ucfirst(str_replace('_', ' ', $type));
            foreach ($names as $name) {
                $result[] = ['name' => $name, 'type' => $label];
            }
        }

        usort($result, fn ($a, $b) => strcmp($a['name'], $b['name']));

        return $result;
    }
}