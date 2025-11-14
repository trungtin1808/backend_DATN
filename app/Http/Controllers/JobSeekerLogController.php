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
        $jobPost = JobPost::find($jobPostId);

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

        $currentDate = now(); 

        $jobSeekerLog = JobSeekerLog::create([
            'job_post_id' => $jobPostId,
            'job_seeker_id' => $jobSeeker->id,
            'saved_at' => $currentDate,
        ]);

        $jobSeekerLog->refresh();

         return response()->json([
            'success' => true,
            'message' => 'Da luu thành công!',
            'data' => $jobSeekerLog
        ]);



    }

    public function jobSeekerLogs()
    {
        $jobSeeker = auth()->user()->jobSeeker;
        $jobSeekerLogs = $jobSeeker->logs()
        ->with('jobPost') 
        ->orderBy('created_at', 'desc')
        ->get();

        if($jobSeekerLogs->isEmpty()){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'jobseekerlog not found'
                ],
                404

            );
        }

         return response()->json([
            'success' => true,
            'data' => $jobSeekerLogs
        ]);




    }

    public function show(string $jobPostId)
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

        return response()->json([
            'success' => true,
            'message' => 'Truy van thanh cong!',
            'data' => $jobSeekerLog
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
