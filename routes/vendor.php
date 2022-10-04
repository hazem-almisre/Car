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

Route::post('/car',[CarController::class,'carStore']);
Route::get('/cars/{id}',[CarController::class,'carShow']);
Route::put('/cars/{id}',[CarController::class,'update']);
Route::delete('/cars/{id}',[CarController::class,'destroy']);
});
