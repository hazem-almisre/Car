<?php

use App\Http\Controllers\vendor\CarController;
use App\Http\Controllers\vendor\auth\Login;
use App\Http\Controllers\vendor\auth\Signin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['namespace'=>'vendor'],function () {
    Route::post('/signup',[Signin::class,'signin']);
    Route::post('/login',[Login::class,'login']);
});


        Route::group(['namespace'=>'vendor','middleware'=>'auth:vendor'],function () {
        Route::post('/carstore',[CarController::class,'carStore']);
        Route::get('/cars/{id}',[CarController::class,'carShow']);
        Route::post('/carsu/{id}',[CarController::class,'update']);
        Route::post('/carsd/{id}',[CarController::class,'destroy']);
        });


