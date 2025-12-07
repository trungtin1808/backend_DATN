<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CV;
use App\Http\Requests\CvRequest;
use Illuminate\Support\Facades\Storage;
class CVController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobSeeker = auth()->user()->jobSeeker;

        $cvs = $jobSeeker->CVs;

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
            ], 200
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CvRequest $request)
    {
        $jobSeeker = auth()->user()->jobSeeker;
        $cvs = $jobSeeker->CVs;


        $is_default = 0;


    if ($cvs->isEmpty()) {

        $is_default = 1;

    } else {

    
    if ($request->boolean('is_default')) {

        
        Cv::where('job_seeker_id', $jobSeeker->id)
            ->where('is_default', 1)
            ->update(['is_default' => 0]);

            $is_default = 1;
        }
    }


    $cvPath = $request->file('file')->store('cvs', 'public');


    $cv = Cv::create([
    'job_seeker_id' => $jobSeeker->id,
    'name' => $request->name ?? null,   
    'link_cv' => $cvPath,
    'is_default' => $is_default,
    ]);

    $cv->refresh();

    return response()->json([
    'message' => 'CV created successfully',
    'data' => $cv,
    ], 201);

    }


    public function update(Request $request, string $id)
    {
        $jobSeeker = auth()->user()->jobSeeker;


    
        $cv = $jobSeeker->CVs()->where('id', $id)->first();

        if (!$cv) {
            return response()->json([
            'success' => false,
            'message' => 'CV not found'
            ], 404);
        }

    // --- Reset default trên tất cả CV ---
        $jobSeeker->CVs()->update(['is_default' => 0]);

    
        $cv->is_default = 1;
        $cv->save();

        $cvs = $jobSeeker->CVs;

        return response()->json([
            'success' => true,
            'message' => 'Default CV updated successfully',
            'data' => $cvs
        ], 200);
    }

    public function destroy(string $id)
    {
        $jobSeeker = auth()->user()->jobSeeker;

        // Lấy CV cần xóa
        $cv = $jobSeeker->CVs()->where('id', $id)->first();

        if (!$cv) {
            return response()->json([
                'success' => false,
                'message' => 'CV not found'
            ], 404);
        }

        $wasDefault = $cv->is_default; // Lưu trạng thái CV có phải mặc định không
        $cv->delete();

    // Nếu CV bị xoá là mặc định → tìm CV khác để set mặc định
        if ($wasDefault) {
            $newDefault = $jobSeeker->CVs()->orderBy('created_at', 'desc')->first();

        if ($newDefault) {
            $newDefault->update(['is_default' => 1]);
            }
        }

        $cvs = $jobSeeker->Cvs;

        return response()->json([
            'success' => true,
            'message' => 'CV deleted successfully',
            'data' => $cvs,
        ], 200);
        }
}
