<?php

use App\Http\Controllers\user\auth\Signin;
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

Route::group(['namespace'=>'user/auth'],function () {
    Route::post('/signup',[Signin::class,'fs']);
    Route::post('/sign',[UserAuth::class,'login']);
});

Route::group(['namespace'=>'user','middleware'=>'auth:user'],function () {

});
