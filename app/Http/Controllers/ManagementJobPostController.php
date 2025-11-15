<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPost;

class ManagementJobPostController extends Controller
{
    public function jobPosts()
    {
        $jobPosts = JobPost::all();
        if ($jobPosts->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No JobPosts found'
            ], 404);
        }

         return response()->json([
            'success' => true,
            'data' => $jobPosts
        ], 200);
    }

    public function show(string $id)
    {
        $jobPost = JobPost::find($id);

        if (!$jobPost) {
            return response()->json([
                'success' => false,
                'message' => 'JobPost not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $jobPost
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $jobPost = JobPost::find($id);

        if (!$jobPost) {
            return response()->json([
                'success' => false,
                'message' => 'JobPost not found'
            ], 404);
        }

        $jobPost->job_post_status = $request->job_post_status;

        $jobPost->save();

        return response()->json([
            'success' => true,
            'message' => 'Updated successfully'
        ], 200);
   
    }
}
