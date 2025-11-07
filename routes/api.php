<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;



//route public
Route::group([
    'middleware' => 'api'
], function ($router) {

    Route::post('login', [AuthController::class,'login']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('register', [AuthController::class,'register']);

});





// route chi danh cho user
Route::group([

    'middleware' => ['api','auth:api','jobseeker'],
    'prefix' => 'user',
], function ($router) {

    Route::post('logout', [AuthController::class,'logout']);
    Route::get('profile', [AuthController::class,'profile']);

});

//route chi danh cho employer
Route::group([

    'middleware' => ['api','auth:api','employer'],
    'prefix' => 'employer',
], function ($router) {

    Route::post('logout', [AuthController::class,'logout']);
    Route::get('profile', [AuthController::class,'profile']);

});


//route chi danh cho admin
Route::group([

    'middleware' => ['api','auth:api','admin'],
    'prefix' => 'admin',
], function ($router) {

    Route::post('logout', [AuthController::class,'logout']);
    Route::get('profile', [AuthController::class,'profile']);

});


Route::group([
    'middleware' => 'api',
    'prefix' => 'admin',
], function ($router) {
    Route::apiResource('users', UserController::class);
});


