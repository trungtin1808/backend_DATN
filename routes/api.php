<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobSeekerProfileController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\CVController;
use App\Http\Controllers\CertificateController;

//public

Route::group([
    'middleware' => 'api'
], function ($router) {

    Route::post('login', [AuthController::class,'login']);
    Route::post('register', [AuthController::class,'register']);

});

//jobseeker
Route::group([
    'middleware' => ['api','auth:api', 'jobseeker'],
    'prefix' => 'jobseeker'
], function ($router) {

    Route::post('logout', [AuthController::class,'logout']);
    Route::get('profile',[JobSeekerProfileController::class,'profile']);
    Route::resource('profile/educations', EducationController::class);
    Route::resource('profile/experiences', ExperienceController::class);
    Route::resource('profile/cvs', CVController::class);
    Route::resource('profile/certificates', CertificateController::class);
    

});

//employer
Route::group([
    'middleware' => ['api','auth:api', 'employer'],
    'prefix' => 'employer'
], function ($router) {

    Route::post('logout', [AuthController::class,'logout']);
    

});






