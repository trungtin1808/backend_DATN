<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobSeeker;
class ManagementJobSeekerController extends Controller
{
    public function jobSeekers()
    {
        $jobSeekers = JobSeeker::all();

        if ($jobSeekers->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No jobseekers found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $jobSeekers
        ], 200);
    }

    public function show(string $id)
    {
        $jobSeeker = JobSeeker::find($id);

        if (!$jobSeeker) {
            return response()->json([
                'success' => false,
                'message' => 'JobSeeker not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $jobSeeker
        ], 200);

    }
    
}
