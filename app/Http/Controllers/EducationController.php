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
        $jobSeeker = auth()->user()->jobSeeker;

        $educationDetails = $jobSeeker->educationDetails;

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
        $jobSeeker =  auth()->user()->jobSeeker;

        $educationDetail = EducationDetail::create([
            'job_seeker_id' => $jobSeeker->id,
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
        $jobSeeker =  auth()->user()->jobSeeker;
        $educationDetail = $jobSeeker->educationDetails()->where('id',$id)->first();

        if(!$educationDetail){
            return response()->json([
            'success' => false,
            'message' => 'educationdetail not found'
            ], 404);
        }

        return response()->json([
        'success' => true,
        'data' => $educationDetail
        ], 200);
        
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $jobSeeker =  auth()->user()->jobSeeker;
        $educationDetail = $jobSeeker->educationDetails()->where('id',$id)->first();

        if(!$educationDetail){
            return response()->json([
            'success' => false,
            'message' => 'educationdetail not found'
            ], 404);
        }

        if($request->has('education_level')){
            $educationDetail->education_level = $request->education_level;
        }

        if($request->has('certificate_degree_name')){
            $educationDetail->certificate_degree_name = $request->certificate_degree_name;
        }

        if($request->has('institute_university_name')){
            $educationDetail->institute_university_name = $request->institute_university_name;
        }

        if($request->has('major')){
            $educationDetail->major = $request->major;
        }

        if($request->has('status')){
            $educationDetail->status = $request->status;
        }

        if($request->has('start_date')){
            $educationDetail->start_date = $request->start_date;
        }

        if($request->has('complete_date')){
            $educationDetail->complete_date = $request->complete_date;
        }

        if($request->has('cgpa')){
            $educationDetail->cgpa = $request->cgpa;
        }

        $educationDetail->save();

        return response()->json([
            'success' => true,
            'message' => 'educationdetail updated successfully'
            ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jobSeeker =  auth()->user()->jobSeeker;
        $educationDetail = $jobSeeker->educationDetails()->where('id',$id)->first();

        if(!$educationDetail){
            return response()->json([
            'success' => false,
            'message' => 'educationdetail not found'
            ], 404);
        }

        $educationDetail->delete();

        return response()->json([
            'success' => true,
            'message' => 'educationdetail deleted successfully'
            ], 200);

        
    }
}
