<?php

use App\Api\Response;
use App\Api\Request;
use App\Models\Api\UserFirebaseSessions;
use Kreait\Firebase\Messaging\CloudMessage;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Messaging\AndroidConfig;

function validateParam($request_input, $rules, $somethingElseIsInvalid = null)
{
    $request = new Request();
    return $request->validateParam($request_input, $rules, $somethingElseIsInvalid);
}

function apiResponse2($success, $status, $msg, $data = null, $title = null)
{
    $response = new Response();
    return $response->apiResponse2($success, $status, $msg, $data, $title);
}


function apiAuth()
{
    if (request()->input('test_auth_id')) {
        return App\Models\Api\User::find(request()->input('test_auth_id')) ?? die('test_auth_id not found');
    }
    return auth('api')->user();


}

function nicePrice($price)
{
    $nice = handlePrice($price, false);

    if (is_string($nice)) {
        $nice = (float)$nice;
    }

    return round($nice, 2);
}

function nicePriceWithTax($price)
{
    if (empty($price) or $price == 0) {
        return [
            "price" => 0,
            "tax" => 0
        ];
    }

    // return round(handlePrice($price, true,false,true), 2);
    $nice = handlePrice($price, false, false, true);

    if ($nice === 0) {
        return [
            "price" => 0,
            "tax" => 0
        ];
    }

    return $nice;
}

/*
function handleSendFirebaseMessages($user_id, $group_id, $sender, $type, $title, $message)
{
    $fcmTokens = UserFirebaseSessions::where('user_id', $user_id)
        ->select('fcm_token')->get()->all();

    $deviceTokens = [];

    foreach ($fcmTokens as $fcmToken) {
        $deviceTokens[] = $fcmToken->fcm_token;
    }

    if (count($deviceTokens) > 0) {
        $messageFCM = app('firebase.messaging');

        foreach ($deviceTokens as $fcmToken) {
            $fcmMessage = CloudMessage::withTarget('token', $fcmToken);

            $fcmMessage = $fcmMessage->withNotification([
                'title' => $title,
                'body' => preg_replace('/<[^>]*>/', '', $message)
            ]);

            $fcmMessage = $fcmMessage->withData([
                'user_id' => $user_id,
                'group_id' => $group_id,
                'title' => $title,
                'message' => preg_replace('/<[^>]*>/', '', $message),
                'sender' => $sender,
                'type' => $type,
                'created_at' => time()
            ]);

            $fcmMessage = $fcmMessage->withAndroidConfig(\Kreait\Firebase\Messaging\AndroidConfig::fromArray([
                'ttl' => '3600s',
                'priority' => 'high',
                'notification' => [
                    'color' => '#f45342',
                    'sound' => 'default',
                ],
            ]));

            try {
                $messageFCM->send($fcmMessage);
            } catch (\Exception $exception) {

            }

        }

    }
}
*/

function handleSendFirebaseMessages($user_id, $group_id, $sender, $type, $title, $message)
{
    try {
        $fcmTokens = UserFirebaseSessions::where('user_id', $user_id)
            ->select('fcm_token')
            ->pluck('fcm_token')
            ->filter()
            ->toArray();

        if (count($fcmTokens) === 0) {
            Log::warning('No FCM tokens found for user', ['user_id' => $user_id]);
            return;
        }

        $messaging = app('firebase.messaging');
        $cleanMessage = preg_replace('/<[^>]*>/', '', $message);

        foreach ($fcmTokens as $fcmToken) {
            $fcmMessage = CloudMessage::withTarget('token', $fcmToken)
                ->withNotification([
                    'title' => $title,
                    'body' => $cleanMessage,
                ])
                ->withData([
                    'user_id'   => $user_id,
                    'group_id'  => $group_id,
                    'title'     => $title,
                    'message'   => $cleanMessage,
                    'sender'    => $sender,
                    'type'      => $type,
                    'created_at'=> time(),
                ])
                ->withAndroidConfig(AndroidConfig::fromArray([
                    'ttl' => '3600s',
                    'priority' => 'high',
                    'notification' => [
                        'color' => '#f45342',
                        'sound' => 'default',
                    ],
                ]));

            try {
                $messaging->send($fcmMessage);

                // ✅ Log successful send
              /*  Log::info('FCM notification sent successfully', [
                    'token'   => $fcmToken,
                    'user_id' => $user_id,
                    'title'   => $title,
                    'body'    => $cleanMessage,
                ]);*/
            } catch (\Throwable $e) {
                // ❌ Log failure with reason
                Log::error('FCM send failed', [
                    'token'   => $fcmToken,
                    'user_id' => $user_id,
                    'error'   => $e->getMessage(),
                ]);
            }
        }
    } catch (\Throwable $e) {
        Log::critical('handleSendFirebaseMessages failed', [
            'user_id' => $user_id,
            'error'   => $e->getMessage(),
            'trace'   => $e->getTraceAsString(),
        ]);
    }
}



