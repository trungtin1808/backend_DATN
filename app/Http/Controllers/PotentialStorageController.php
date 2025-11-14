<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PotentialStorage;
use App\Models\JobPost;
use App\Models\JobSeeker;
use App\Models\JobPostActivity;

class PotentialStorageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $jobPostId)
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
                'message' => 'Bạn không có quyền xem danh sach ung vien tiem nang nay.'
            ], 403);
        }

        $potentialJobSeekers = $jobPost->potentialStorages;

        if($potentialJobSeekers->isEmpty()){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'PotentailJobSeeker not found'
                ],
                404

            );
        }

         return response()->json(
            [
                'success' => true,
                'data' => $potentialJobSeekers,
                'message' => 'PotentailJobSeeker retrieved successfully'
            ]
        );

        
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $jobPostId)
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
                'message' => 'Bạn không có quyền luu tru ung vien tiem nang cho bai dang nay.'
            ], 403);
        }

        $jobSeekerId = $request->jobSeekerId;

        $jobSeeker = $jobPost->activities()->where("job_seeker_id", $jobSeekerId)->first();

        if(!$jobSeeker){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'jobSeeker not found'
                ],
                404

            );
        }

        $potentialJobSeeker = PotentialStorage::create([
            "job_post_id" => $jobPostId,
            "job_seeker_id" => $jobSeekerId
        ]);

        $potentialJobSeeker->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Tao ung vien tiem nang thanh cong!',
            'data' => $potentialJobSeeker
         ]);



        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $jobPostId, string $id)
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
                'message' => 'Bạn không có quyền xem ung vien tiem nang cho bai dang nay.'
            ], 403);
        }


        $potentialJobSeeker = $jobPost->potentialStorages()->where('id', $id)->first();

        if(!$potentialJobSeeker){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'potentialJobSeeker not found'
                ],
                404

            );
        }

        return response()->json([
            'success' => true,
            'message' => "truy van thanh cong",
            'data' => $potentialJobSeeker
         ]);



        
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $jobPostId, string $id)
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
                'message' => 'Bạn không có quyền xoa ung vien tiem nang cho bai dang nay.'
            ], 403);
        }

        $potentialJobSeeker = $jobPost->potentialStorages()->where('id', $id)->first();

        if(!$potentialJobSeeker){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'potentialJobSeeker not found'
                ],
                404

            );
        }

        $potentialJobSeeker->delete();

        return response()->json([
            'success' => true,
            'message' => "delete thanh cong",
         ]);
    }
}
