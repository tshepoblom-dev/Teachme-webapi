<?php

use App\Http\Controllers\Api\Panel\PaymentsController;
use App\Http\Controllers\Api\Panel\ReserveMeetingsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['prefix' => '/development'], function () {

    Route::get('/', function () {
        return 'api test';
    });

    Route::middleware('api') ->group(base_path('routes/api/auth.php'));

    Route::namespace('Web')->group(base_path('routes/api/guest.php'));

    // This is outside of any middleware group!
    Route::post('/panel/payments/request-webview', [PaymentsController::class, 'paymentRequest'])->withoutMiddleware(['api.identify','api.auth']);
    Route::get('/panel/payments/verify/{gateway}', ['as' => 'payment_verify', 'uses' => [PaymentsController::class, 'paymentVerify']])->withoutMiddleware(['api.identify','api.auth']);
    Route::post('/panel/payments/verify/{gateway}', ['as' => 'payment_verify_post', 'uses' => [PaymentsController::class, 'paymentVerify']])->withoutMiddleware(['api.identify','api.auth']);
    Route::post('/panel/payments/charge-verify/{gateway}', [PaymentsController::class, 'chargeVerify'])->withoutMiddleware(['api.identify','api.auth']);
    Route::post('/panel/payments/api-charge/{gateway}', [PaymentsController::class, 'api_charge'])->withoutMiddleware(['api.identify']);
    Route::get('/panel/payments/payment-channels', [PaymentsController::class, 'getPaymentChannels'])->withoutMiddleware(['api.identify','api.auth']);

    Route::prefix('panel')->middleware('api.auth')->namespace('Panel')->group(base_path('routes/api/user.php'));

    Route::group(['namespace' => 'Config', 'middleware' => []], function () {
        Route::get('/config', ['uses' => 'ConfigController@list']);
        Route::get('/config/register/{type}', ['uses' => 'ConfigController@getRegisterConfig']);
    });

    Route::prefix('instructor')->middleware(['api.auth', 'api.level-access:teacher'])->namespace('Instructor')->group(base_path('routes/api/instructor.php'));

});
