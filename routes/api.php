<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\UserController;
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

//Route::middleware('auth:sanctum')->post('api/v1/user', function (Request $request) {
//    return $request->user();
//});
Route::middleware('auth:api')->post('v1/get-user', function (Request $request) {
    return $request->user();
});



Route::group(['namespace' => '\App\Http\Controllers\Api\V1', 'prefix' => '/v1'], function () {

    Route::group(['prefix' => 'user'], function () {
        Route::get('/login', [AuthController::class, 'login']);
        Route::get('/check-otp', [AuthController::class, 'checkOtp']);
    });

//    Route::group(['middleware' => ['auth:api']], function () {
//        Route::group(['prefix' => 'user'], function () {
//          //  Route::post('/', [UserController::class,'user']);//get data of user
//        });
//    });
});
