<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Auth\VerificationController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\UploadFileManager;
use App\Models\Affiliate;
use App\Models\Role;
use App\User;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    public function stepRegister(Request $request, $step)
    {
        if ($step == 1) {
            return $this->stepOne($request);

        } elseif ($step == 2) {
            return $this->stepTwo($request);

        } elseif ($step == 3) {
            return $this->stepThree($request);
        }
        abort(404);

    }

    private function stepOne(Request $request)
    {
        $registerMethod = getGeneralSettings('register_method') ?? 'mobile';
        $data = $request->all();
        $username = $this->username();

        $account_type = $data["account_type"] ?? 1;

        if ($registerMethod !== $username && $username) {
            return apiResponse2(0, 'invalid_register_method', trans('api.auth.invalid_register_method'));
        }

        $rules = [
            'country_code' => ($username == 'mobile') ? 'required' : 'nullable',
            // if the username is unique check
            //   $username => ($username == 'mobile') ? 'required|numeric|unique:users' : 'required|string|email|max:255|unique:users',
            $username => ($username == 'mobile') ? 'required|numeric' : 'required|string|email|max:255',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|same:password',
        ];

        validateParam($data, $rules);
        if ($username == 'mobile') {
            $data[$username] = ltrim($data['country_code'], '+') . ltrim($data[$username], '0');

        }
        $userCase = User::where($username, $data[$username])->first();
        if ($userCase) {
            //  $userCase->update(['password' => Hash::make($data['password'])]);
            $verificationController = new VerificationController();
            $checkConfirmed = $verificationController->checkConfirmed($userCase, $username, $data[$username]);

            if ($checkConfirmed['status'] == 'verified') {
                if ($userCase->full_name) {
                    return apiResponse2(0, 'already_registered', trans('api.auth.already_registered'));
                } else {
                    $userCase->update(['password' => Hash::make($data['password'])]);
                    return apiResponse2(0, 'go_step_3', trans('api.auth.go_step_3'), [
                        'user_id' => $userCase->id
                    ]);
                }
            } else {
                $userCase->update(['password' => Hash::make($data['password'])]);
                return apiResponse2(0, 'go_step_2', trans('api.auth.go_step_2'), [
                    'user_id' => $userCase->id
                ]);
            }

        }


        $referralSettings = getReferralSettings();
        $usersAffiliateStatus = (!empty($referralSettings) and !empty($referralSettings['users_affiliate_status']));


        $user = User::create([
            'role_name' => $account_type == 2 ? Role::$teacher : Role::$user,
            'role_id' => $account_type == 2 ? Role::getTeacherRoleId() : Role::getUserRoleId(),
            $username => $data[$username],
            'status' => User::$pending,
            'password' => Hash::make($data['password']),
            'affiliate' => $usersAffiliateStatus,
            'created_at' => time(),
             // Adding new fields
            'study_course' =>  isset($data['course']) ? $data['course'] : null,
            'institution_name' => isset($data['institution_name']) ? $data['institution_name'] : null,
            'id_number' => isset($data['id_number']) ? $data['id_number'] : null,

            // File fields, assuming they are already received as byte arrays
          /*  'id' => isset($data['id']) ? gzdecode($data['id']) : null,
            'cv' => isset($data['cv']) ? gzdecode($data['cv']) : null,
            'qualification' => isset($data['qualification']) ? gzdecode($data['qualification']) : null,
            'proof_of_address' => isset($data['proof_of_address']) ? gzdecode($data['proof_of_address']) : null,
            'bank_account_letter' => isset($data['bank_account_letter']) ? gzdecode($data['bank_account_letter']) : null
*/
        ]);

        $verificationController = new VerificationController();
        $verificationController->checkConfirmed($user, $username, $data[$username]);

        return apiResponse2('1', 'stored', trans('api.public.stored'), [
            'user_id' => $user->id
        ]);
    }

    private function stepTwo(Request $request)
    {
        $data = $request->all();
        validateParam($data, [
            'user_id' => 'required|exists:users,id',
            //  'code'=>
        ]);

        $user = User::find($data['user_id']);
        $verificationController = new VerificationController();
        $ee = $user->email ?? $user->mobile;
        return $verificationController->confirmCode($request, $ee);
    }

    private function stepThree(Request $request)
    {
        $data = $request->all();
        validateParam($request->all(), [
            'user_id' => 'required|exists:users,id',
            'full_name' => 'required|string|min:3',
            'referral_code' => 'nullable|exists:affiliates_codes,code'

        ]);

        $user = User::find($request->input('user_id'));
        $user->update([
            'full_name' => $data['full_name']
        ]);
        $referralCode = $request->input('referral_code', null);
        if (!empty($referralCode)) {
            Affiliate::storeReferral($user, $referralCode);
        }
        event(new Registered($user));
        $token = auth('api')->tokenById($user->id);
        $data['token'] = $token;
        $data['user_id'] = $user->id;
        return apiResponse2(1, 'login', trans('api.auth.login'), $data);

    }

    public function username()
    {
        $email_regex = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i";

        $data = request()->all();

        if (empty($this->username)) {
            if (in_array('mobile', array_keys($data))) {
                $this->username = 'mobile';
            } else if (in_array('email', array_keys($data))) {
                $this->username = 'email';
            }
        }

        return $this->username ?? '';
    }
    public function registerFilesUpload(Request $request)
    {
        \Log::info($request->all());
        try
        {
           /* $value = $request->input('userId');
            $cleanValue = trim($value, '"');
            $user = User::find($cleanValue);*/
            $userId = filter_var($request->input('userId'), FILTER_SANITIZE_STRING);
            $user = User::find($userId);

            if (!$user) {
                return apiResponse2(0, 'error', 'User not found.');
            }
            $fileFields = [
                'idDocument' => 'identity_scan',
                'qualification' => 'certificate',
                'cv' => 'cvdoc',
                'proofOfAddress' => 'proofofaddress',
                'bankAccountLetter' => 'bankconfirmation'
            ];
            $updateData = [];
            foreach ($fileFields as $inputName => $column) {
                if ($request->file($inputName)) {
                    $storage = new UploadFileManager($request->file($inputName), $user);
                    $updateData[$column] = $storage->storage_path;
                }
            }

            if (!empty($updateData)) {
                $user->update($updateData);
            }
            return apiResponse2(1, 'updated', trans('api.public.updated'),$user);

/*
            if ($request->file('idDocument')) {

                $storage = new UploadFileManager($request->file('idDocument'),$user);

                $user->update([
                    'identity_scan' => $storage->storage_path,
                ]);
            }
            if ($request->file('qualification')) {

                $storage = new UploadFileManager($request->file('qualification'),$user);

                $user->update([
                    'certificate' => $storage->storage_path,
                ]);
            }
            if ($request->file('cv')) {
                $storage = new UploadFileManager($request->file('cv'),$user);
                $user->update([
                    'cvdoc' => $storage->storage_path,
                ]);
            }

            if ($request->file('proofOfAddress')) {
                $storage = new UploadFileManager($request->file('proofOfAddress'),$user);
                $user->update([
                    'proofofaddress' => $storage->storage_path,
                ]);
            }

            if ($request->file('bankAccountLetter')) {
                $storage = new UploadFileManager($request->file('bankAccountLetter'),$user);
                $user->update([
                    'bankconfirmation' => $storage->storage_path,
                ]);
            }

            return apiResponse2(1, 'updated', trans('api.public.updated'),$user);
*/
        }
        catch(Exception $ex)
        {
            \Log::error($ex->getMessage());
            return apiResponse2(0, 'error', $ex->getMessage());
        }
    }
/*
    public function registerFilesUpload(Request $request)
    {
        //$user = apiAuth();
        $user = User::find($request->input('user_id'));

        if ($request->file('idDocument')) {

            $storage = new UploadFileManager($request->file('idDocument'));

            $user->update([
                'identity_scan' => $storage->storage_path,
            ]);

        }

        if ($request->file('qualification')) {

            $storage = new UploadFileManager($request->file('qualification'));

            $user->update([
                'certificate' => $storage->storage_path,
            ]);

        }
        if ($request->file('cv')) {
            $storage = new UploadFileManager($request->file('cv'));
            $user->update([
                'cv' => $storage->storage_path,
            ]);
        }

        if ($request->file('proofOfAddress')) {
            $storage = new UploadFileManager($request->file('proofOfAddress'));
            $user->update([
                'proof_of_address' => $storage->storage_path,
            ]);
        }

        if ($request->file('bankAccountLetter')) {
            $storage = new UploadFileManager($request->file('bankAccountLetter'));
            $user->update([
                'bank_confirmation' => $storage->storage_path,
            ]);
        }
        return apiResponse2(1, 'updated', trans('api.public.updated'));
    }
*/
}
