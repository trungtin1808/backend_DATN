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
        $jobSeeker = auth()->user()->jobSeeker;

        $certificates = $jobSeeker->Certificates;

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
        $jobSeeker =  auth()->user()->jobSeeker;

        $certificate = Certificate::create([
            'job_seeker_id' => $jobSeeker->id,
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
        $jobSeeker =  auth()->user()->jobSeeker;
        $certificate = $jobSeeker->Certificates()->where('id',$id)->first();

        if(!$certificate){
            return response()->json([
            'success' => false,
            'message' => 'Certificate not found'
            ], 404);
        }

        return response()->json([
        'success' => true,
        'data' => $certificate
        ], 200);
        
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $jobSeeker = auth()->user()->jobSeeker;
        $certificate = $jobSeeker->Certificates()->where('id',$id)->first();

        if(!$certificate){

             return response()->json([
            'success' => false,
            'message' => 'Certificate not found'
            ], 404);

        }

        if($request->has('certificate_name')){
            $certificate->certificate_name = $request->certificate_name;
        }

        if($request->has('organization')){
            $certificate->organization = $request->organization;
        }

        if($request->has('issue_date')){
            $certificate->issue_date = $request->issue_date;
        }

        if($request->has('expire_date')){
            $certificate->expire_date = $request->expire_date;
        }

        if($request->has('certificate_url')){
            $certificate->certificate_url = $request->certificate_url;
        }

        if($request->has('score')){
            $certificate->score = $request->score;
        }

        $certificate->save();



        return response()->json([
            'success' => true,
            'message' => 'Certificate updated successfully'
            ], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jobSeeker = auth()->user()->jobSeeker;
        $certificate = $jobSeeker->Certificates()->where('id',$id)->first();

        if(!$certificate){

            return response()->json([
            'success' => false,
            'message' => 'Certificate not found'
            ], 404);

        }

        $certificate->delete();

        return response()->json([
            'success' => true,
            'message' => 'Certificate deleted successfully'
            ], 200);
    }
}
