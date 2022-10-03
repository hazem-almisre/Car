<?php

use App\Http\Controllers\Like;
use App\Http\Controllers\user\auth\Login;
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
    Route::post('/signup',[Signin::class,'signin']);
    Route::post('/login',[Login::class,'login']);
});

Route::group(['namespace'=>'user','prefix'=>'user','middleware'=>'auth:user'],function () {
    //like
    Route::get('/like/show',[Like::class,'Like@index']);
    Route::post('/like/add',[Like::class,'Like@store']);
    Route::post('/like/delete',[Like::class,'Like@destroy']);

});
