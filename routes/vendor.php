<?php

use App\Http\Controllers\vendor\auth\Login;
use App\Http\Controllers\vendor\auth\Signin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['namespace'=>'vendor','prefix'=>'vendor'],function () {
    Route::post('/signup',[Signin::class,'signin']);
    Route::post('/login',[Login::class,'login']);
});

Route::group(['namespace'=>'vendor','middleware'=>'auth:vendor'],function () {

});
