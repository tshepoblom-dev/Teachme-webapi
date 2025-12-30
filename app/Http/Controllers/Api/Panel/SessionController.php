<?php

namespace App\Http\Controllers\Api\Panel;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Panel\AgoraController;
use App\Http\Resources\SessionResource;
use App\Models\AgoraHistory;
use App\Models\Api\WebinarChapter;
use App\Models\File;
use App\Models\Sale;
use App\Models\Api\Session;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; 
use Tymon\JWTAuth\Facades\JWTAuth;


class SessionController extends Controller
{
    public function show($id)
    {
        $session = Session::where('id', $id)
            ->where('status', WebinarChapter::$chapterActive)->first();
        abort_unless($session, 404);
        if ($error = $session->canViewError()) {
            //       return $this->failure($error, 403, 403);
        }
        $resource = new SessionResource($session);
        return apiResponse2(1, 'retrieved', trans('api.public.retrieved'), $resource);
    }

    public function bigBlueButton(Request $request, $sessionId)
    {
        try
        {      
            Log::info('Headers', $request->headers->all());
            Log::info('Cookies', $request->cookies->all());
            // 1️⃣ Extract token from cookie
            $token = $request->cookie('laravel_token');

            if (!$token) {
                return response('Unauthorized', 401);
            }

            // 2️⃣ Authenticate via JWT
            $user = JWTAuth::setToken($token)->authenticate();
            if (!$user) {
                return response('Unauthorized', 401);
            }

            Log::info("SessionController BigBlueButton user ", [json_encode($user)]);

            // 3️⃣ Log user into WEB guard (critical)
            auth()->login($user);

            $session = Session::findOrFail($sessionId);
            return redirect(url('panel/sessions/' . $sessionId . '/joinToBigBlueButton'));
        }catch(\Exception $e)
        {
            Log::error("SessionController BigBlueButton error ", ['error' => $e->getMessage()]);
            return response()->json(['message' => 'An error occurred while processing your request.'], 500);
        }
    }

    public function agora(Request $request, $session_id)
    {

        $user = apiAuth();
        Auth::login($user);

        return redirect(url('panel/sessions/' . $session_id . '/joinToAgora'));
    }
}
