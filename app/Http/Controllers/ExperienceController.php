<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExperienceDetail;

class ExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobseeker = auth()->user()->jobSeeker;

        $experienceDetails = $jobseeker->experienceDetails;

        if($experienceDetails->isEmpty()){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'experienceDetail not found'
                ],
                404

            );
        }

         return response()->json(
            [
                'success' => true,
                'data' => $experienceDetails,
                'message' => 'experienceDetail retrieved successfully'
            ]
        );
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $jobseeker =  auth()->user()->jobSeeker;

        $experienceDetail = ExperienceDetail::create([
            'job_seeker_id' => $jobseeker->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'job_title' => $request->job_title,
            'company_name' => $request->company_name,
            'job_location' => $request->job_location,
            'description' => $request->description

        ]);

        $experienceDetail->refresh();

        return response()->json([
            'message' => 'experienceDetail created successfully',
            'experience' => $experienceDetail,
        ], 201);

        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
