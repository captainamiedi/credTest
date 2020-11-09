<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
    return response()->json([
        $request->user()
    ]);
});

//Route::group(['prefix' => 'api'], function () {
    Route::get('users', function (Request $request) {
       dd('here');
    });

    Route::prefix('auth')->group(function () {
        Route::post('register', 'Auth\RegisterController@create');
        Route::post('login', 'Auth\RegisterController@login');
        Route::get('referer', 'Auth\RegisterController@checkReferral');
//        Route::post('transfer', 'walletController@transfer');
    });

    Route::group(['middleware' => 'auth:api'], function () {
       Route::get('wallet/balance', 'walletController@balance');
       Route::post('transfer', 'walletController@transfer');
       Route::get('account', 'accountController@index');

    });

Route::fallback(function () {
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact super@admin.com'
    ], 404);
});
//});
