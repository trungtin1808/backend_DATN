<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobSeekerProfileController;
use App\Http\Controllers\EmployerProfileController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\CVController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\JobTypeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\JobPostActivityController;
use App\Http\Controllers\PotentialStorageController;
use App\Http\Controllers\JobSeekerLogController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\EmployerAnalyticController;
use App\Http\Controllers\AdminAnalyticController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JobSeekerAnalyticController;
use App\Http\Controllers\NotificationForEmployer;
use App\Http\Controllers\NotificationForJobSeeker;





//public
Route::group([
    'middleware' => 'api'
], function ($router) {

    Route::post('login', [AuthController::class,'login']);

    Route::post('register', [AuthController::class,'register']);

    Route::get('job-posts',[JobPostController::class, 'getJobs']);
    Route::get('job-posts/{id}', [JobPostController::class, 'getJobById']);
    

    
    Route::get('employers/{id}/followers', [FollowController::class,'followers']);
    Route::get('employers/{id}/reviews',[ReviewController::class,'reviews']);


   


});

//jobseeker
Route::group([
    'middleware' => ['api','auth:api', 'jobseeker'],
    'prefix' => 'jobseeker'
], function ($router) {

    Route::post('logout', [AuthController::class,'logout']);

    Route::post('profile',[JobSeekerProfileController::class,'update']); 

    Route::resource('profile/educations', EducationController::class);

    Route::resource('profile/experiences', ExperienceController::class);

    
    Route::post('cvs', [CVController::class, 'store']);
    Route::get('cvs', [CVController::class, 'index']);
    Route::patch('cvs/{id}', [CVController::class, 'update']);
    Route::delete('cvs/{id}', [CVController::class,'destroy']);

    Route::resource('profile/certificates', CertificateController::class);



    Route::post('job-posts/{id}/apply',[JobPostActivityController::class,'apply']);
    Route::get('apply-jobs',[JobPostActivityController::class,'getAppliedJobs']);
    Route::patch('jobseeker-applications/{jobPostId}',[JobPostActivityController::class,'updateForJobSeeker']);

    Route::post('job-posts/{id}/save', [JobSeekerLogController::class,'store']);
    Route::delete('job-posts/{id}',[JobSeekerLogController::class,'destroy']);


    Route::get('save-jobs', [JobSeekerLogController::class,'getSavedJobs']);
    Route::get('overview', [JobSeekerAnalyticController::class, 'overview']);

    Route::get('notifications', [NotificationForJobSeeker::class, 'getNotifications']);
    Route::patch('notifications/{id}', [NotificationForJobSeeker::class, 'update']);

    Route::delete('notifications/{id}', [NotificationForJobSeeker::class, 'destroy']);
   



    Route::post('employers/{id}/followers',[FollowController::class,'store']);
    Route::delete('employers/{id}/followers', [FollowController::class,'destroy']);
    Route::get('follow-employers',[FollowController::class,'followEmployers']);
    Route::get('follow-employers/{id}',[FollowController::class,'show'] );
    Route::delete('follow-employers/{id}',[FollowController::class,'destroy']);
    
    Route::post('employers/{id}/reviews', [ReviewController::class,'store']);
    Route::patch('employers/{id}/reviews',[ReviewController::class,'update']);
    Route::delete('employers/{id}/reviews', [ReviewController::class,'destroy']);
    Route::get('reviewed', [ReviewController::class,'reviewed']);
    Route::get('reviewed/{id}', [ReviewController::class,'show']);


    

    

});

//employer
Route::group([
    'middleware' => ['api','auth:api', 'employer'],
    'prefix' => 'employer'
], function ($router) {

    Route::post('logout', [AuthController::class,'logout']);

    Route::post('profile',[EmployerProfileController::class,'update']);
    Route::post('profile/upload_image',[EmployerProfileController::class,'upload_image']);

    Route::patch('job-posts/{id}/toggleHiddenJob',[JobPostController::class,'toggleHiddenJob']);

    Route::get('job-posts/{id}/applications',[JobPostActivityController::class,'employer_applications']);
    Route::patch('job-posts/{id}/applications/{jobSeekerId}',[JobPostActivityController::class,'updateForEmployer']);


    Route::resource('job-posts',JobPostController::class);


    Route::get('overview',[EmployerAnalyticController::class,'overview']);

    Route::get('notifications', [NotificationForEmployer::class, 'getNotifications']);

    Route::get('notifications/count_unread', [NotificationForEmployer::class, 'getCountUnread']);

    Route::patch('notifications/{id}', [NotificationForEmployer::class, 'update']);

    Route::delete('notifications/{id}', [NotificationForEmployer::class, 'destroy']);

    Route::post('storages', [PotentialStorageController::class, 'store']);


});

//admin
Route::group([
    'middleware' => ['api', 'auth:api', 'admin'], 
    'prefix' => 'admin'
], function ($router) {
    Route::resource('job-types',JobTypeController::class);
    Route::resource('categories',CategoryController::class);


    Route::get("overview", [AdminAnalyticController::class,"overview"]);
    Route::patch("job-posts/{id}", [JobPostController::class, "updateForAdmin"]);

    Route::delete("job-posts/{id}", [JobPostController::class, "destroyForAdmin"]);

    Route::get("job-posts", [JobPostController::class, "indexForAdmin"]);
    Route::get('job-posts/{id}/applications',[JobPostActivityController::class,'admin_applications']);

    Route::get("users", [UserController::class, "index"]);
    Route::patch("users/{id}",[UserController::class, "update"]);

});








