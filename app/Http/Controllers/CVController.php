<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CV;

class CVController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobseeker = auth()->user()->jobSeeker;

        $cvs = $jobseeker->CVs;

        if($cvs->isEmpty()){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'cv not found'
                ],
                404

            );
        }

         return response()->json(
            [
                'success' => true,
                'data' => $cvs,
                'message' => 'cv retrieved successfully'
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $jobseeker =  auth()->user()->jobSeeker;

        $cv = CV::create([
            'job_seeker_id' => $jobseeker->id,
            'link_cv' => $request->link_cv

        ]);

        $cv->refresh();

        return response()->json([
            'message' => 'cv created successfully',
            'cv' => $cv,
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
