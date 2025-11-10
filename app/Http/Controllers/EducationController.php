<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EducationDetail;

class EducationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobseeker = auth()->user()->jobSeeker;

        $educationDetails = $jobseeker->educationDetails;

        if($educationDetails->isEmpty()){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'educationDetail not found'
                ],
                404

            );
        }

         return response()->json(
            [
                'success' => true,
                'data' => $educationDetails,
                'message' => 'educationDetail retrieved successfully'
            ]
        );
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $jobseeker =  auth()->user()->jobSeeker;

        $educationDetail = EducationDetail::create([
            'job_seeker_id' => $jobseeker->id,
            'education_level' => $request->education_level,
            'certificate_degree_name' => $request->certificate_degree_name,
            'institute_university_name'=> $request->institute_university_name,
            'major' => $request->major,
            'status' => $request->status,
            'start_date' => $request->start_date,
            'complete_date' => $request->complete_date,
            'cgpa' => $request->cgpa,

        ]);

        $educationDetail->refresh();

        return response()->json([
            'message' => 'educationDetail created successfully',
            'education' => $educationDetail,
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
