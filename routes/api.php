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
use App\Http\Controllers\ManagementUserController;
use App\Http\Controllers\ManagementJobSeekerController;
use App\Http\Controllers\ManagementEmployerController;
use App\Http\Controllers\ManagementJobPostController;
use App\Http\Controllers\PublicJobPostController;
use App\Http\Controllers\PublicEmployerController;





//public
Route::group([
    'middleware' => 'api'
], function ($router) {

    Route::post('login', [AuthController::class,'login']);

    Route::post('register', [AuthController::class,'register']);

    Route::get('job-posts',[PublicJobPostController::class, 'jobPosts']);
    Route::get('job-posts/{id}', [PublicJobPostController::class, 'show']);

    Route::get('employers', [PublicEmployerController::class,'employers']);
    Route::get('employers/{id}', [PublicEmployerController::class, 'show']);
    Route::get('employers/{id}/followers', [FollowController::class,'followers']);
    Route::get('employers/{id}/reviews',[ReviewController::class,'reviews']);


   


});

//jobseeker
Route::group([
    'middleware' => ['api','auth:api', 'jobseeker'],
    'prefix' => 'jobseeker'
], function ($router) {

    Route::post('logout', [AuthController::class,'logout']);

    Route::get('profile',[JobSeekerProfileController::class,'profile']);
    Route::patch('profile',[JobSeekerProfileController::class,'update']);

    Route::resource('profile/educations', EducationController::class);

    Route::resource('profile/experiences', ExperienceController::class);

    Route::resource('profile/cvs', CVController::class);

    Route::resource('profile/certificates', CertificateController::class);



    Route::post('job-posts/{id}/apply',[JobPostActivityController::class,'apply']);
    Route::get('jobseeker-applications',[JobPostActivityController::class,'jobseeker_applications']);
    Route::patch('jobseeker-applications/{jobPostId}',[JobPostActivityController::class,'updateForJobSeeker']);


    Route::post('job-posts/{id}', [JobSeekerLogController::class,'store']);
    Route::delete('job-posts/{id}',[JobSeekerLogController::class,'destroy']);
    Route::get('jobseekerlogs', [JobSeekerLogController::class,'jobSeekerLogs']);
    Route::get('jobseekerlogs/{jobPostId}', [JobSeekerLogController::class,'show']);
    Route::delete('jobseekerlogs/{jobPostId}',[JobSeekerLogController::class,'destroy']);

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

    Route::get('profile',[EmployerProfileController::class,'profile']);
    Route::patch('profile',[EmployerProfileController::class,'update']);

    Route::get('job-posts/pending',[JobPostController::class,'pendingPosts']);
    Route::get('job-posts/pending/{id}',[JobPostController::class,'pendingPostById']);

    Route::get('job-posts/approved',[JobPostController::class,'approvedPosts']);
    Route::get('job-posts/approved/{id}',[JobPostController::class,'approvedPostById']);

    Route::get('job-posts/rejected',[JobPostController::class,'rejectedPosts']);
    Route::get('job-posts/rejected/{id}',[JobPostController::class,'rejectedPostById']);

    Route::get('job-posts/expired',[JobPostController::class,'expiredPosts']);
    Route::get('job-posts/expired/{id}',[JobPostController::class,'expiredPostById']);

    Route::get('job-posts/hidden',[JobPostController::class,'hiddenPosts']);
    Route::get('job-posts/hidden/{id}',[JobPostController::class,'hiddenPostById']);

    Route::get('job-posts/deleted',[JobPostController::class,'deletedPosts']);
    Route::get('job-posts/deleted/{id}',[JobPostController::class,'deletedPostById']);

    Route::patch('job-posts/{id}/hidden',[JobPostController::class,'hidden']);

    Route::patch('job-posts/{id}/unhidden',[JobPostController::class,'unhidden']);

    Route::get('job-posts/{id}/applications',[JobPostActivityController::class,'employer_applications']);

    Route::patch('job-posts/{id}/applications/{jobSeekerId}',[JobPostActivityController::class,'updateForEmployer']);


    Route::resource('job-posts',JobPostController::class);

    Route::resource('job-posts/{jobPostId}/potentials',PotentialStorageController::class);

    

    

    

});

//admin
Route::group([
    'middleware' => ['api', 'auth:api', 'admin'], 
    'prefix' => 'admin'
], function ($router) {

    Route::resource('job-types',JobTypeController::class);

    Route::resource('categories',CategoryController::class);

    Route::get('users',[ManagementUserController::class, 'users']);
    Route::get('users/{id}', [ManagementUserController::class, 'show']);
    Route::patch('users/{id}', [ManagementUserController::class, 'update']);

    Route::get('jobseekers', [ManagementJobSeekerController::class,'jobSeekers']);
    Route::get('jobseekers/{id}', [ManagementJobSeekerController::class,'show']);

    Route::get('employers', [ManagementEmployerController::class, 'employers']);
    Route::get('employers/{id}', [ManagementEmployerController::class, 'show']);

    Route::get('job-posts', [ManagementJobPostController::class, 'jobPosts']);
    Route::get('job-posts/{id}', [ManagementJobPostController::class, 'show']);
    Route::patch('job-posts/{id}', [ManagementJobPostController::class, 'update']);

    

  
});








