<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobType;

class JobTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobTypes = JobType::all();

        if($jobTypes->isEmpty()){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'JobType not found'
                ],
                404

            );
        }

        return response()->json(
            [
                'success' => true,
                'data' => $jobTypes,
                'message' => 'JobType retrieved successfully'
            ]
        );
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $jobType = JobType::create([
            'job_type' => $request->job_type,
        ]);

        $jobType->refresh();

        return response()->json([
            'message' => 'JobType created successfully',
            'jobpost' => $jobType,
        ], 201);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jobType = JobType::find($id);

        if(!$jobType){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'JobType not found'
                ],
                404

            );
        }

        return response()->json([
        'success' => true,
        'data' => $jobType
        ], 200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $jobType = JobType::find($id);

        if(!$jobType){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'JobType not found'
                ],
                404

            );
        }

        $jobType->job_type = $request->job_type;
        $jobType->save();

         return response()->json([
            'success' => true,
            'message' => 'jobtype updated successfully'
            ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jobType = JobType::find($id);

        if(!$jobType){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'JobType not found'
                ],
                404

            );
        }

        
        $jobType->delete();

         return response()->json([
            'success' => true,
            'message' => 'jobtype deleted successfully'
            ], 200);
        
    }
}
