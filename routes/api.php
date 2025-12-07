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

    Route::get('job-posts',[PublicJobPostController::class, 'jobPosts']);//xem các tin tuyển dụng công khai
    Route::get('job-posts/{id}', [PublicJobPostController::class, 'show']);//xem chi tiết tin tuyển dụng

    Route::get('employers', [PublicEmployerController::class,'employers']);//xem các công ty
    Route::get('employers/{id}', [PublicEmployerController::class, 'show']);//xem chi tiết công ty
    //Route::get('employers/{id}/followers', [FollowController::class,'followers']);//xem những người theo dõi công ty
    Route::get('employers/{id}/reviews',[ReviewController::class,'reviews']);//xem các đánh giá về công ty

});

//jobseeker
Route::group([
    'middleware' => ['api','auth:api', 'jobseeker'],
    'prefix' => 'jobseeker'
], function ($router) {

    Route::post('logout', [AuthController::class,'logout']);

    Route::get('profile',[JobSeekerProfileController::class,'profile']);//xem thông tin cá nhân
    Route::patch('profile',[JobSeekerProfileController::class,'update']);//cập nhật thông tin cá nhân

    Route::resource('profile/educations', EducationController::class); //CRUD trình độ học vấn

    Route::resource('profile/experiences', ExperienceController::class);//CRUD kinh nghiệm làm việc

    Route::resource('profile/cvs', CVController::class);//CRUD CV

    Route::resource('profile/certificates', CertificateController::class);//CRUD chứng chỉ



    Route::post('job-posts/{id}/apply',[JobPostActivityController::class,'apply']);//nộp đơn ứng tuyển
    Route::get('jobseeker-applications',[JobPostActivityController::class,'jobseeker_applications']);//xem các đơn ứng tuyển
    Route::patch('jobseeker-applications/{jobPostId}',[JobPostActivityController::class,'updateForJobSeeker']);//cập nhật trạng thái đơn ứng tuyển


    Route::post('job-posts/{id}', [JobSeekerLogController::class,'store']);//lưu tin tuyển dụng
    Route::delete('job-posts/{id}',[JobSeekerLogController::class,'destroy']);//hủy lưu tin tuyển dụng
    Route::get('jobseekerlogs', [JobSeekerLogController::class,'jobSeekerLogs']);//xem các tin đã lưu
    Route::get('jobseekerlogs/{jobPostId}', [JobSeekerLogController::class,'show']);//xem chi tiết tin đã lưu
    Route::delete('jobseekerlogs/{jobPostId}',[JobSeekerLogController::class,'destroy']);//xóa tin đã lưu

    Route::post('employers/{id}/followers',[FollowController::class,'store']);//theo dõi công ty
    Route::delete('employers/{id}/followers', [FollowController::class,'destroy']);//hủy theo dõi công ty
    Route::get('follow-employers',[FollowController::class,'followEmployers']);//xem các công ty đã theo dõi
    Route::get('follow-employers/{id}',[FollowController::class,'show'] );//xem chi tiết công ty đã theo dõi
    Route::delete('follow-employers/{id}',[FollowController::class,'destroy']);//hủy theo dõi công ty đã theo dõi
    

    Route::post('employers/{id}/reviews', [ReviewController::class,'store']);//đánh giá công ty
    Route::patch('employers/{id}/reviews',[ReviewController::class,'update']);//cập nhật đánh giá công ty
    Route::delete('employers/{id}/reviews', [ReviewController::class,'destroy']);//xóa đánh giá công ty
    Route::get('reviewed', [ReviewController::class,'reviewed']);//xem các đánh giá đã viết
    Route::get('reviewed/{id}', [ReviewController::class,'show']);//xem chi tiết đánh giá đã viết
    

});

//employer
Route::group([
    'middleware' => ['api','auth:api', 'employer'],
    'prefix' => 'employer'
], function ($router) {

    Route::post('logout', [AuthController::class,'logout']);

    Route::get('profile',[EmployerProfileController::class,'profile']);//xem thông tin công ty
    Route::patch('profile',[EmployerProfileController::class,'update']);//cập nhật thông tin công ty

    Route::get('job-posts/pending',[JobPostController::class,'pendingPosts']);//xem các tin tuyển dụng đang chờ duyệt
    Route::get('job-posts/pending/{id}',[JobPostController::class,'pendingPostById']);//xem chi tiết tin tuyển dụng đang chờ duyệt

    Route::get('job-posts/approved',[JobPostController::class,'approvedPosts']);//xem các tin tuyển dụng đã được duyệt
    Route::get('job-posts/approved/{id}',[JobPostController::class,'approvedPostById']);//xem chi tiết tin tuyển dụng đã được duyệt
    Route::get('job-posts/rejected',[JobPostController::class,'rejectedPosts']);//xem các tin tuyển dụng bị từ chối
    Route::get('job-posts/rejected/{id}',[JobPostController::class,'rejectedPostById']);//xem chi tiết tin tuyển dụng bị từ chối

    Route::get('job-posts/expired',[JobPostController::class,'expiredPosts']);//xem các tin tuyển dụng đã hết hạn
    Route::get('job-posts/expired/{id}',[JobPostController::class,'expiredPostById']);//xem chi tiết tin tuyển dụng đã hết hạn

    Route::get('job-posts/hidden',[JobPostController::class,'hiddenPosts']);//xem các tin tuyển dụng đã ẩn
    Route::get('job-posts/hidden/{id}',[JobPostController::class,'hiddenPostById']);//xem chi tiết tin tuyển dụng đã ẩn

    Route::get('job-posts/deleted',[JobPostController::class,'deletedPosts']);//xem các tin tuyển dụng đã xóa
    Route::get('job-posts/deleted/{id}',[JobPostController::class,'deletedPostById']);//xem chi tiết tin tuyển dụng đã xóa

    Route::patch('job-posts/{id}/hidden',[JobPostController::class,'hidden']);//ẩn tin tuyển dụng

    Route::patch('job-posts/{id}/unhidden',[JobPostController::class,'unhidden']);//bỏ ẩn tin tuyển dụng

    Route::get('job-posts/{id}/applications',[JobPostActivityController::class,'employer_applications']);//xem các đơn ứng tuyển cho tin tuyển dụng

    Route::patch('job-posts/{id}/applications/{jobSeekerId}',[JobPostActivityController::class,'updateForEmployer']);//cập nhật trạng thái đơn ứng tuyển cho tin tuyển dụng

    Route::get('job-types', [JobTypeController::class, 'index']);//danh sách loại hình công việc
    Route::get('categories', [CategoryController::class, 'index']);//danh sách danh mục công việc

    Route::resource('job-posts',JobPostController::class);//CRUD tin tuyển dụng
    Route::resource('job-posts/{jobPostId}/potentials',PotentialStorageController::class);//quản lý hồ sơ tiềm năng


});

//admin
Route::group([
    'middleware' => ['api', 'auth:api', 'admin'], 
    'prefix' => 'admin'
], function ($router) {

    Route::resource('job-types',JobTypeController::class);//CRUD loại hình công việc (parttime, fulltime, internship)

    Route::resource('categories',CategoryController::class);//CRUD danh mục công việc (IT, Marketing, Sales,...)

    Route::get('users',[ManagementUserController::class, 'users']);//xem tất cả người dùng
    Route::get('users/{id}', [ManagementUserController::class, 'show']);//xem chi tiết người dùng
    Route::patch('users/{id}', [ManagementUserController::class, 'update']);//cập nhật trạng thái người dùng

    Route::get('jobseekers', [ManagementJobSeekerController::class,'jobSeekers']);//xem tất cả người tìm việc
    Route::get('jobseekers/{id}', [ManagementJobSeekerController::class,'show']);//xem chi tiết người tìm việc

    Route::get('employers', [ManagementEmployerController::class, 'employers']);//xem tất cả nhà tuyển dụng
    Route::get('employers/{id}', [ManagementEmployerController::class, 'show']);//xem chi tiết nhà tuyển dụng

    Route::get('job-posts', [ManagementJobPostController::class, 'jobPosts']);//xem tất cả tin tuyển dụng
    Route::get('job-posts/{id}', [ManagementJobPostController::class, 'show']);//xem chi tiết tin tuyển dụng
    Route::patch('job-posts/{id}', [ManagementJobPostController::class, 'update']);//cập nhật tin tuyển dụng

    Route::resource('job-posts/{id}',ManagementJobPostController::class);  
});








