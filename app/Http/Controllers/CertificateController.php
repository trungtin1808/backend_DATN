<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificate;

class CertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobseeker = auth()->user()->jobSeeker;

        $certificates = $jobseeker->Certificates;

        if($certificates->isEmpty()){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'certificate not found'
                ],
                404

            );
        }

         return response()->json(
            [
                'success' => true,
                'data' => $certificates,
                'message' => 'certificate retrieved successfully'
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $jobseeker =  auth()->user()->jobSeeker;

        $certificate = Certificate::create([
            'job_seeker_id' => $jobseeker->id,
            'certificate_name' => $request->certificate_name,
            'organization' => $request->organization,
            'issue_date' => $request->issue_date,
            'expire_date' => $request->expire_date,
            'certificate_url' => $request->certificate_url,
            'score' => $request->score,

        ]);

        $certificate->refresh();

        return response()->json([
            'message' => 'certificate created successfully',
            'certificate' => $certificate,
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
