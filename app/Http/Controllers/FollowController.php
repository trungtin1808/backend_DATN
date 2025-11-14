<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Follow;
use App\Models\Employer;

class FollowController extends Controller
{
    public function followers(string $employerId)
    {
        $jobSeeker = auth()->user()->jobSeeker;
        $employer = Employer::find($employerId);

        if(!$employer){
             return response()->json([
                'success' => false,
                'message' => 'Cong ty không tồn tại.'
            ], 404);
        }

        $followers = $employer->followers()
        ->with('jobSeeker') 
        ->orderBy('created_at', 'desc')
        ->get();

        if($followers->isEmpty()){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'follower not found'
                ],
                404

            );
        }

         return response()->json([
            'success' => true,
            'data' => $followers
        ]);

    }


    public function store(Request $request, string $employerId)
    {
        $jobSeeker = auth()->user()->jobSeeker;

        $employer = Employer::find($employerId);

        if(!$employer){
             return response()->json([
                'success' => false,
                'message' => 'Cong ty không tồn tại.'
            ], 404);
        }

        $existingfollow = $jobSeeker->follows()->where('employer_id', $employerId)->first();

        if ($existingfollow) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn đã follow cong ty này rồi.'
                ], 400);
        }


        $follow = Follow::create([
            'employer_id' => $employerId,
            'job_seeker_id' => $jobSeeker->id,
            
        ]);

        $follow->refresh();

         return response()->json([
            'success' => true,
            'message' => 'Da follow thành công!',
            'data' => $follow
        ]);



    }

    public function followEmployers()
    {
        $jobSeeker = auth()->user()->jobSeeker;

        $followEmployers = $jobSeeker->follows()
        ->with('employer') 
        ->orderBy('created_at', 'desc')
        ->get();

        if($followEmployers->isEmpty()){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'followEmployer not found'
                ],
                404

            );
        }

         return response()->json([
            'success' => true,
            'data' => $followEmployers
        ]);


    }

    public function show(string $employerId)
    {
        $jobSeeker = auth()->user()->jobSeeker;

        $employer = Employer::find($employerId);

        if(!$employer){
             return response()->json([
                'success' => false,
                'message' => 'Cong ty không tồn tại.'
            ], 404);
        }

        $followEmployer = $jobSeeker->follows()->where('employer_id', $employerId)->first();

        if(!$followEmployer){
            return response()->json([
                'success' => false,
                'message' => 'Bạn chua follow cong ty nay'
                ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Truy van thanh cong!',
            'data' => $followEmployer
        ]);



    }

    public function destroy(string $employerId)
    {
        $jobSeeker = auth()->user()->jobSeeker;

        $employer = Employer::find($employerId);

        if(!$employer){
             return response()->json([
                'success' => false,
                'message' => 'Cong ty không tồn tại.'
            ], 404);
        }

        $followEmployer = $jobSeeker->follows()->where('employer_id', $employerId)->first();

        if(!$followEmployer){
            return response()->json([
                'success' => false,
                'message' => 'Bạn chua follow cong ty nay'
                ], 400);
        }

        $followEmployer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Bo theo doi thành công!',
        ]);


    }
    
}
