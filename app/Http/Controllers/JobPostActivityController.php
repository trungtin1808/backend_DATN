<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPostActivity;
use App\Models\JobPost;

class JobPostActivityController extends Controller
{
    public function apply(Request $request, string $jobPostId)
    {
        $jobSeeker = auth()->user()->jobSeeker;
        $jobPost = JobPost::find($jobPostId);

        if (!$jobPost) {
            return response()->json([
                'success' => false,
                'message' => 'Bài đăng không tồn tại.'
            ], 404);
        }

        $existingApplication = $jobSeeker->appliedJobs()->where('job_post_id',$jobPostId)->first();

        if ($existingApplication) {
        return response()->json([
            'success' => false,
            'message' => 'Bạn đã ứng tuyển vào bài đăng này rồi.'
            ], 400);
        }

        $application = JobPostActivity::create([
            'job_post_id' => $jobPostId,
            'job_seeker_id' => $jobSeeker->id,
            'link_cv' => $request->link_cv,
        ]);

        $application->refresh();

         return response()->json([
        'success' => true,
        'message' => 'Ứng tuyển thành công!',
        'data' => $application
        ]);




    }


    public function jobseeker_applications()
    {
        $jobSeeker = auth()->user()->jobSeeker;
        $applications = $jobSeeker->appliedJobs() 
        ->with('jobPost') 
        ->orderBy('created_at', 'desc')
        ->get();

        if($applications->isEmpty()){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'application not found'
                ],
                404

            );
        }

        return response()->json([
        'success' => true,
        'data' => $applications
        ]);

    }

    public function employer_applications(string $jobPostId)
    {
        $employer = auth()->user()->employer;
        $jobPost = JobPost::find($jobPostId);

        if (!$jobPost) {
            return response()->json([
                'success' => false,
                'message' => 'Bài đăng không tồn tại.'
            ], 404);
        }

        if ($jobPost->employer_id !== $employer->id) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền xem danh sách ứng viên cho bài đăng này.'
            ], 403);
        }

        $applications = $jobPost->activities()
            ->with('jobSeeker') 
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $applications
        ]);




    }


    public function updateForEmployer(Request $request, string $jobPostId, string $jobSeekerId)
    {
        $employer = auth()->user()->employer;
        $jobPost = JobPost::find($jobPostId);

        if (!$jobPost) {
            return response()->json([
                'success' => false,
                'message' => 'Bài đăng không tồn tại.'
            ], 404);
        }

        if ($jobPost->employer_id !== $employer->id) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền cho bài đăng này.'
            ], 403);
        }

        $application = $jobPost->activities()->where('job_seeker_id',$jobSeekerId)->first();

        if(!$application){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'application not found'
                ],
                404

            );

        }

        $application->apply_status = $request->apply_status;

        $application->save();

        return response()->json([
        'success' => true,
        'message' => 'Application status updated successfully',
        'data' => $application,
        ]);

        





    }

    public function updateForJobSeeker(Request $request, string $jobPostId)
    {
        $jobSeeker = auth()->user()->jobSeeker;
        $jobPost = JobPost::find($jobPostId);

        if (!$jobPost) {
            return response()->json([
                'success' => false,
                'message' => 'Bài đăng không tồn tại.'
            ], 404);
        }

        $application = $jobSeeker->appliedJobs()->where('job_post_id', $jobPostId)->first();

         if(!$application){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'application not found'
                ],
                404

            );

        }

        if($application->apply_status !== "pending"){
             return response()->json(
                [
                    'success' => false,
                    'message' => 'Khong duoc phep cap nhat'
                ],
                404

            );
        }

        if($request->has("apply_status")){
            $application->apply_status = $request->apply_status;
        }

        if($request->has("link_cv")){
            $application->link_cv = $request->link_cv;
        }


        $application->save();


        return response()->json([
            'success' => true,
            'message' => 'Application updated successfully',
            'data' => $application,
            ]);





        
    }


    
}
