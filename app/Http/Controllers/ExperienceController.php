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
        $jobSeeker = auth()->user()->jobSeeker;

        $experienceDetails = $jobSeeker->experienceDetails;

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
        $jobSeeker =  auth()->user()->jobSeeker;

        $experienceDetail = ExperienceDetail::create([
            'job_seeker_id' => $jobSeeker->id,
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
        $jobSeeker = auth()->user()->jobSeeker;
        $experienceDetail = $jobSeeker->experienceDetails()->where('id',$id)->first();

        if(!$experienceDetail){
            return response()->json([
            'success' => false,
            'message' => 'experiencedetail not found'
            ], 404);
        }

        return response()->json([
        'success' => true,
        'data' => $experienceDetail
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $jobSeeker = auth()->user()->jobSeeker;
        $experienceDetail = $jobSeeker->experienceDetails()->where('id',$id)->first();

        if(!$experienceDetail){
            return response()->json([
            'success' => false,
            'message' => 'experiencedetail not found'
            ], 404);
        }

        if($request->has('start_date')){
            $experienceDetail->start_date = $request->start_date;
        }

        if($request->has('end_date')){
            $experienceDetail->end_date = $request->end_date;
        }

        if($request->has('job_title')){
            $experienceDetail->job_title = $request->job_title;
        }

        if($request->has('company_name')){
            $experienceDetail->company_name = $request->company_name;
        }

        if($request->has('job_location')){
            $experienceDetail->job_location = $request->job_location;
        }

        if($request->has('description')){
            $experienceDetail->description = $request->description;
        }

        $experienceDetail->save();

        return response()->json([
            'success' => true,
            'message' => 'experiencedetail updated successfully'
            ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jobSeeker = auth()->user()->jobSeeker;
        $experienceDetail = $jobSeeker->experienceDetails()->where('id',$id)->first();

          if(!$experienceDetail){
            return response()->json([
            'success' => false,
            'message' => 'experiencedetail not found'
            ], 404);
        }

        $experienceDetail->delete();

        return response()->json([
            'success' => true,
            'message' => 'experiencedetail deleted successfully'
            ], 200);
        
    }
}
