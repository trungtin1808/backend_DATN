<?php

namespace App\Http\Controllers;

use App\Models\JobSeeker;
use Illuminate\Http\Request;

class JobSeekerController extends Controller
{

    public function profile()
    {
        $jobSeeker = JobSeeker::where('user_id', auth()->id())->first();
        return response()->json([
            'success' => true,
            'data' => $jobSeeker,
            'message' => 'Jobseeker retrieved successfully'

        ]);
    }


    public function index()
    {
        $job_seekers = JobSeeker::latest()->get();
        return response()->json([
            'success' => true,
            'data' => $job_seekers,
            'message' => 'Jobseekers retrieved successfully'

        ]);
    }

    public function store(Request $request)
    {
        
    }

    public function show(string $id)
    {
        $job_seeker = JobSeeker::find($id);
        if(!$job_seeker){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'job_seeker not found'
                ],
                404

            );
        }

        return response()->json(
            [
                'success' => true,
                'data' => $job_seeker,
                'message' => 'job_seeker retrieved successfully'
            ]
        );
    }

    public function update(Request $request, string $id)
    {

        
    }

    public function destroy(string $id)
    {
        
    }
}
