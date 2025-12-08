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
        $jobPost = JobPost::where('id', $jobPostId)
                  ->where('job_post_status', 'accepted')
                  ->first();

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


       $defaultCv = $jobSeeker->CVs()->where('is_default', 1)->first();

        if (!$defaultCv) {
            return response()->json([
            'success' => false,
            'message' => 'No default CV found. Please mark a CV as default before applying.',
            ], 400);
        }

        JobPostActivity::create([
            "job_seeker_id" => $jobSeeker->id,
            "job_post_id"   => $jobPost->id,
            "link_cv"         => $defaultCv->link_cv,
        ]);

        return response()->json([
        'success' => true,
        'message' => 'Applied successfully',
        ], 201);



         




    }


    public function getAppliedJobs()
    {
        $jobSeeker = auth()->user()->jobSeeker;
        $appliedJobList = $jobSeeker->appliedJobs()
        ->with(['jobPost', 'jobPost.employer']) 
        ->orderBy('created_at', 'desc')
        ->get();

        if($appliedJobList->isEmpty()){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'application not found'
                ],
                404

            );
        }

        $appliedJobList = $appliedJobList->map(function ($item) {
            $item->jobPost->applicationStatus = $item->apply_status; 
            return $item;
            });


        return response()->json([
        'success' => true,
        'data' => $appliedJobList
        ]);

    }

    public function employer_applications(string $jobPostId)
    {
        $employer = auth()->user()->employer;
        $jobPost = JobPost::where('id', $jobPostId)
                  ->where('job_post_status','!=', 'deleted')
                  ->first();

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
            ->with(['jobSeeker.user','jobPost']) 
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $applications
        ]);




    }

    public function admin_applications(string $jobPostId)
    {
        
        $jobPost = JobPost::where('id', $jobPostId)
                  ->first();

        if (!$jobPost) {
            return response()->json([
                'success' => false,
                'message' => 'Bài đăng không tồn tại.'
            ], 404);
        }


        $applications = $jobPost->activities()
            ->with(['jobSeeker.user','jobPost']) 
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
        $jobPost = JobPost::where('id', $jobPostId)
                  ->where('job_post_status','!=', 'deleted')
                  ->first();

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

    

    
}
