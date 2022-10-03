<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['namespace'=>'vendor'],function () {
    Route::post('/signup',[UserAuth::class,'register']);
    Route::post('/signup',[UserAuth::class,'login']);
});

Route::group(['namespace'=>'vendor','middleware'=>'auth:vendor'],function () {

});
