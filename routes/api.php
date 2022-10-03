<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\user\auth\Signin;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/cars',[Controller::class,'index']);
Route::post('/car',[Controller::class,'carStore']);
Route::get('/cars/{id}',[Controller::class,'carShow']);
Route::put('/cars/{id}',[Controller::class,'update']);
Route::delete('/cars/{id}',[Controller::class,'destroy']);
Route::get('/cars/search/id/{id}', [Controller::class, 'idSearchCar']);
Route::get('/cars/search/name/{name}', [Controller::class, 'nameSearchCar']);
Route::get('/cars/search/model/{model}', [Controller::class, 'modelSearchCar']);
Route::get('/cars/search/color/{color}', [Controller::class, 'colorSearchCar']);
Route::get('/cars/search/description/{description}', [Controller::class, 'descriptionSearchCar']);


