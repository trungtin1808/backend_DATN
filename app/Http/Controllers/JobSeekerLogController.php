<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPost;
use App\Models\JobSeekerLog;

class JobSeekerLogController extends Controller
{
    public function store(Request $request, string $jobPostId)
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




        $existingJobPost = $jobSeeker->logs()->where('job_post_id', $jobPostId)->first();

        if ($existingJobPost) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn đã luu bài đăng này rồi.'
                ], 400);
        }


        $jobSeekerLog = JobSeekerLog::create([
            'job_post_id' => $jobPostId,
            'job_seeker_id' => $jobSeeker->id,
        ]);

        $jobSeekerLog->refresh();

         return response()->json([
            'success' => true,
            'message' => 'Da luu thành công!',
            'data' => $jobSeekerLog
        ]);



    }

    public function getSavedJobs()
    {
        $jobSeeker = auth()->user()->jobSeeker;
        $savedJobList = $jobSeeker->logs()
        ->with(['jobPost', 'jobPost.employer']) 
        ->orderBy('created_at', 'desc')
        ->get();

        if($savedJobList->isEmpty()){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Saved Job not found'
                ],
                404

            );
        }

         return response()->json([
            'success' => true,
            'data' => $savedJobList
        ]);

    }

    



    public function destroy(string $jobPostId)
    {
        $jobSeeker = auth()->user()->jobSeeker;
        $jobPost = JobPost::find($jobPostId);

        if (!$jobPost) {
            return response()->json([
                'success' => false,
                'message' => 'Bài đăng không tồn tại.'
            ], 404);
        }


        $jobSeekerLog = $jobSeeker->logs()->where('job_post_id', $jobPostId)->first();

        if (!$jobSeekerLog) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn chua luu bai dang nay'
                ], 400);
        }

        $jobSeekerLog->delete();

        

        return response()->json([
            'success' => true,
            'message' => 'Bo luu thành công!',
        ]);



    }

}
