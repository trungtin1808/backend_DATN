<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPost;

class PublicJobPostController extends Controller
{
    public function jobPosts()
    {
        $approvedPosts = JobPost::where('job_post_status', 'approved')
                        ->orderBy('created_at', 'desc')
                        ->get();
        
        if ($approvedPosts->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No approvedPosts found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $approvedPosts
        ], 200);

    }

    public function show(string $id)
    {
        
        $jobPost = JobPost::where('id', $id)
                ->where('job_post_status', 'approved')
                ->first();

        if (!$jobPost) {
            return response()->json([
                'success' => false,
                'message' => 'JobPost not found or not approved'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $jobPost
        ]);
    }
    
}
