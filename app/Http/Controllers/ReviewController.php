<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employer;
use App\Models\Review;

class ReviewController extends Controller
{
    public function reviews(string $employerId)
    {
        $jobSeeker = auth()->user()->jobSeeker;

        $employer = Employer::find($employerId);

        if(!$employer){
             return response()->json([
                'success' => false,
                'message' => 'Cong ty không tồn tại.'
            ], 404);
        }

        $reviews = $employer->reviewsByJobSeekers()
        ->with('jobSeeker') 
        ->orderBy('created_at', 'desc')
        ->get();

        if($reviews->isEmpty()){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'review not found'
                ],
                404

            );
        }

         return response()->json([
            'success' => true,
            'data' => $reviews
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


        $existingReview = $jobSeeker->reviewsForEmployers()->where('employer_id', $employerId)->first();

        if ($existingReview) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn đã danh gia cong ty này rồi.'
                ], 400);
        }


        $review = Review::create([
            'employer_id' => $employerId,
            'job_seeker_id' => $jobSeeker->id,
            'rating' => $request->rating,
            'comment' => $request->comment
            
        ]);



        $review->refresh();

         return response()->json([
            'success' => true,
            'message' => 'Da danh gia thành công!',
            'data' => $review
        ]);

    }

    public function reviewed()
    {
        $jobSeeker = auth()->user()->jobSeeker;

        $reviewed = $jobSeeker->reviewsForEmployers()
        ->with('employer') 
        ->orderBy('created_at', 'desc')
        ->get();

        if($reviewed->isEmpty()){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'review not found'
                ],
                404

            );
        }

         return response()->json([
            'success' => true,
            'data' => $reviewed
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

        $reviewed = $jobSeeker->reviewsForEmployers()->where('employer_id', $employerId)->first();

        if(!$reviewed){
            return response()->json([
                'success' => false,
                'message' => 'Bạn chua danh gia cong ty nay'
                ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Truy van thanh cong!',
            'data' => $reviewed
        ]);



    }

    public function update(Request $request, string $employerId)
    {
        $jobSeeker = auth()->user()->jobSeeker;

        $employer = Employer::find($employerId);

        if(!$employer){
             return response()->json([
                'success' => false,
                'message' => 'Cong ty không tồn tại.'
            ], 404);
        }

        $reviewed = $jobSeeker->reviewsForEmployers()->where('employer_id', $employerId)->first();

        if(!$reviewed){
            return response()->json([
                'success' => false,
                'message' => 'Bạn chua danh gia cong ty nay'
                ], 400);
        }

        if($request->has('rating')){
            $reviewed->rating = $request->rating;
        }

        if($request->has('comment')){
            $reviewed->comment = $request->comment;
        }

        $reviewed->save();

        return response()->json([
            'success' => true,
            'message' => 'Updated thanh cong!',
            
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

        $reviewed = $jobSeeker->reviewsForEmployers()->where('employer_id', $employerId)->first();

        if(!$reviewed){
            return response()->json([
                'success' => false,
                'message' => 'Bạn chua danh gia cong ty nay'
                ], 400);
        }

        $reviewed->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted thanh cong!',
            
        ]);




    }


    


}
