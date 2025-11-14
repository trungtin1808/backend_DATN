<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPost;

class JobPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employer = auth()->user()->employer;
        $jobPosts = $employer->jobPosts()
                    ->where('job_post_status', '!=', 'deleted')
                    ->get();

        if($jobPosts->isEmpty()){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'JobPost not found'
                ],
                404

            );
        }
        $data = $jobPosts->map(function($post) {
            return $post->toCustomArray();
        });

       

        return response()->json(
            [
                'success' => true,
                'data' => $data,
                'message' => 'JobPost retrieved successfully'
            ]
        );

    }

    public function pendingPosts()
    {

        $employer = auth()->user()->employer;
        $jobPosts = $employer->jobPosts()
                    ->where('job_post_status', 'pending')
                    ->get();

        if($jobPosts->isEmpty()){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'PendingPost not found'
                ],
                404

            );
        }
        $data = $jobPosts->map(function($post) {
            return $post->toCustomArray();
        });

       

        return response()->json(
            [
                'success' => true,
                'data' => $data,
                'message' => 'PendingPost retrieved successfully'
            ]
        );


    }

    public function approvedPosts()
    {
        $employer = auth()->user()->employer;
        $jobPosts = $employer->jobPosts()
                    ->where('job_post_status', 'approved')
                    ->get();

        if($jobPosts->isEmpty()){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'ApprovedPost not found'
                ],
                404

            );
        }
        $data = $jobPosts->map(function($post) {
            return $post->toCustomArray();
        });

       

        return response()->json(
            [
                'success' => true,
                'data' => $data,
                'message' => 'ApprovedPost retrieved successfully'
            ]
        );


    }

    public function rejectedPosts()
    {
        $employer = auth()->user()->employer;
        $jobPosts = $employer->jobPosts()
                    ->where('job_post_status', 'rejected')
                    ->get();

        if($jobPosts->isEmpty()){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'RejectedPost not found'
                ],
                404

            );
        }
        $data = $jobPosts->map(function($post) {
            return $post->toCustomArray();
        });

       

        return response()->json(
            [
                'success' => true,
                'data' => $data,
                'message' => 'RejectedPost retrieved successfully'
            ]
        );


    }


    public function expiredPosts()
    {
        $employer = auth()->user()->employer;
        $jobPosts = $employer->jobPosts()
                    ->where('job_post_status', 'expired')
                    ->get();

        if($jobPosts->isEmpty()){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'ExpiredPost not found'
                ],
                404

            );
        }
        $data = $jobPosts->map(function($post) {
            return $post->toCustomArray();
        });

       

        return response()->json(
            [
                'success' => true,
                'data' => $data,
                'message' => 'ExpiredPost retrieved successfully'
            ]
        );
    }

    public function hiddenPosts()
    {
        $employer = auth()->user()->employer;
        $jobPosts = $employer->jobPosts()
                    ->where('job_post_status', 'hidden')
                    ->get();

        if($jobPosts->isEmpty()){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'HiddenPost not found'
                ],
                404

            );
        }
        $data = $jobPosts->map(function($post) {
            return $post->toCustomArray();
        });

       

        return response()->json(
            [
                'success' => true,
                'data' => $data,
                'message' => 'HiddenPost retrieved successfully'
            ]
        );
    }

    public function deletedPosts()
    {
        $employer = auth()->user()->employer;
        $jobPosts = $employer->jobPosts()
                    ->where('job_post_status', 'deleted')
                    ->get();

        if($jobPosts->isEmpty()){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'DeletedPost not found'
                ],
                404

            );
        }
        $data = $jobPosts->map(function($post) {
            return $post->toCustomArray();
        });

       

        return response()->json(
            [
                'success' => true,
                'data' => $data,
                'message' => 'DeletedPost retrieved successfully'
            ]
        );
    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $employer = auth()->user()->employer;

        $jobPost = JobPost::create([
            'employer_id' => $employer->id,
            'job_type_id' => $request->job_type_id,
            'category_id' => $request->category_id,
            'job_title' => $request->job_title,
            'job_description' => $request->job_description,
            'expire_date' => $request->expire_date,
            'salary' => $request->salary,
            'street_address' => $request->street_address,
            'state' => $request->state,
            'city' => $request->city,
            

        ]);

        $jobPost->refresh();

        return response()->json([
            'message' => 'JobPost created successfully',
        ], 201);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         $employer = auth()->user()->employer;
         $jobPost = $employer->jobPosts()->where('id', $id)->where('job_post_status', '!=', 'deleted')->first();

        if(!$jobPost){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'JobPost not found'
                ],
                404

            );
        }
        

        return response()->json(
            [
                'success' => true,
                'data' => [
                    'id' => $jobPost->id,
                    'employer' => $jobPost->employer->company_name,
                    'job_type' => $jobPost->jobType->job_type,
                    'category' => $jobPost->category->category_name,
                    'job_title' => $jobPost->job_title,
                    'job_description' => $jobPost->job_description,
                    'job_post_status' => $jobPost->job_post_status,
                    'post_date' => $jobPost->post_date,
                    'expire_date' => $jobPost->expire_date,
                    'salary' => $jobPost->salary,
                    'street_address' => $jobPost->street_address,
                    'state' => $jobPost->state,
                    'city' => $jobPost->city,

                ]
                
            ]
        );


    }

    public function pendingPostById(string $id)
    {
         $employer = auth()->user()->employer;

         $jobPost = $employer->jobPosts()
                    ->where('id', $id)
                    ->where('job_post_status', 'pending')
                    ->first();

        if (!$jobPost) {
            return response()->json([
                'success' => false,
                'message' => 'Pending job post not found'
            ], 404);
         }


        return response()->json(
            [
                'success' => true,
                'data' => [
                    'id' => $jobPost->id,
                    'employer' => $jobPost->employer->company_name,
                    'job_type' => $jobPost->jobType->job_type,
                    'category' => $jobPost->category->category_name,
                    'job_title' => $jobPost->job_title,
                    'job_description' => $jobPost->job_description,
                    'job_post_status' => $jobPost->job_post_status,
                    'post_date' => $jobPost->post_date,
                    'expire_date' => $jobPost->expire_date,
                    'salary' => $jobPost->salary,
                    'street_address' => $jobPost->street_address,
                    'state' => $jobPost->state,
                    'city' => $jobPost->city,

                ]
                
            ]
        );


    }

    public function approvedPostById(string $id)
    {
        $employer = auth()->user()->employer;

        $jobPost = $employer->jobPosts()
                    ->where('id', $id)
                    ->where('job_post_status', 'approved')
                    ->first();

        if (!$jobPost) {
            return response()->json([
                'success' => false,
                'message' => 'Approved job post not found'
            ], 404);
         }


        return response()->json(
            [
                'success' => true,
                'data' => [
                    'id' => $jobPost->id,
                    'employer' => $jobPost->employer->company_name,
                    'job_type' => $jobPost->jobType->job_type,
                    'category' => $jobPost->category->category_name,
                    'job_title' => $jobPost->job_title,
                    'job_description' => $jobPost->job_description,
                    'job_post_status' => $jobPost->job_post_status,
                    'post_date' => $jobPost->post_date,
                    'expire_date' => $jobPost->expire_date,
                    'salary' => $jobPost->salary,
                    'street_address' => $jobPost->street_address,
                    'state' => $jobPost->state,
                    'city' => $jobPost->city,

                ]
                
            ]
        );

    }

    public function rejectedPostById(string $id)
    {
        $employer = auth()->user()->employer;

         $jobPost = $employer->jobPosts()
                    ->where('id', $id)
                    ->where('job_post_status', 'rejected')
                    ->first();

        if (!$jobPost) {
            return response()->json([
                'success' => false,
                'message' => 'Rejected job post not found'
            ], 404);
         }


        return response()->json(
            [
                'success' => true,
                'data' => [
                    'id' => $jobPost->id,
                    'employer' => $jobPost->employer->company_name,
                    'job_type' => $jobPost->jobType->job_type,
                    'category' => $jobPost->category->category_name,
                    'job_title' => $jobPost->job_title,
                    'job_description' => $jobPost->job_description,
                    'job_post_status' => $jobPost->job_post_status,
                    'post_date' => $jobPost->post_date,
                    'expire_date' => $jobPost->expire_date,
                    'salary' => $jobPost->salary,
                    'street_address' => $jobPost->street_address,
                    'state' => $jobPost->state,
                    'city' => $jobPost->city,

                ]
                
            ]
        );

    }

    public function expiredPostById(string $id)
    {
        $employer = auth()->user()->employer;

         $jobPost = $employer->jobPosts()
                    ->where('id', $id)
                    ->where('job_post_status', 'expired')
                    ->first();

        if (!$jobPost) {
            return response()->json([
                'success' => false,
                'message' => 'Expired job post not found'
            ], 404);
         }


        return response()->json(
            [
                'success' => true,
                'data' => [
                    'id' => $jobPost->id,
                    'employer' => $jobPost->employer->company_name,
                    'job_type' => $jobPost->jobType->job_type,
                    'category' => $jobPost->category->category_name,
                    'job_title' => $jobPost->job_title,
                    'job_description' => $jobPost->job_description,
                    'job_post_status' => $jobPost->job_post_status,
                    'post_date' => $jobPost->post_date,
                    'expire_date' => $jobPost->expire_date,
                    'salary' => $jobPost->salary,
                    'street_address' => $jobPost->street_address,
                    'state' => $jobPost->state,
                    'city' => $jobPost->city,

                ]
                
            ]
        );

    }

    public function hiddenPostById(string $id)
    {
        $employer = auth()->user()->employer;

         $jobPost = $employer->jobPosts()
                    ->where('id', $id)
                    ->where('job_post_status', 'hidden')
                    ->first();

        if (!$jobPost) {
            return response()->json([
                'success' => false,
                'message' => 'Hidden job post not found'
            ], 404);
         }


        return response()->json(
            [
                'success' => true,
                'data' => [
                    'id' => $jobPost->id,
                    'employer' => $jobPost->employer->company_name,
                    'job_type' => $jobPost->jobType->job_type,
                    'category' => $jobPost->category->category_name,
                    'job_title' => $jobPost->job_title,
                    'job_description' => $jobPost->job_description,
                    'job_post_status' => $jobPost->job_post_status,
                    'post_date' => $jobPost->post_date,
                    'expire_date' => $jobPost->expire_date,
                    'salary' => $jobPost->salary,
                    'street_address' => $jobPost->street_address,
                    'state' => $jobPost->state,
                    'city' => $jobPost->city,

                ]
                
            ]
        );

    }

    public function deletedPostById(string $id)
    {
        $employer = auth()->user()->employer;

         $jobPost = $employer->jobPosts()
                    ->where('id', $id)
                    ->where('job_post_status', 'deleted')
                    ->first();

        if (!$jobPost) {
            return response()->json([
                'success' => false,
                'message' => 'Deleted job post not found'
            ], 404);
         }


        return response()->json(
            [
                'success' => true,
                'data' => [
                    'id' => $jobPost->id,
                    'employer' => $jobPost->employer->company_name,
                    'job_type' => $jobPost->jobType->job_type,
                    'category' => $jobPost->category->category_name,
                    'job_title' => $jobPost->job_title,
                    'job_description' => $jobPost->job_description,
                    'job_post_status' => $jobPost->job_post_status,
                    'post_date' => $jobPost->post_date,
                    'expire_date' => $jobPost->expire_date,
                    'salary' => $jobPost->salary,
                    'street_address' => $jobPost->street_address,
                    'state' => $jobPost->state,
                    'city' => $jobPost->city,

                ]
                
            ]
        );
    }




    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $employer = auth()->user()->employer;
        $jobPost = $employer->jobPosts()->where('id', $id)->where('job_post_status', '!=', 'deleted')->first();

        if(!$jobPost){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'JobPost not found'
                ],
                404

            );
        }

        $jobPost->expire_date = $request->expire_date;

        $jobPost->save();

         return response()->json([
            'success' => true,
            'message' => 'expire_date updated successfully'
            ], 200);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employer = auth()->user()->employer;
        $jobPost = $employer->jobPosts()->where('id', $id)->where('job_post_status', '!=', 'deleted')->first();

        if(!$jobPost){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'JobPost not found'
                ],
                404

            );
        }

        $jobPost->job_post_status = "deleted";
        $jobPost->save();

        return response()->json([
            'success' => true,
            'message' => 'JobPost deleted successfully'
            ], 200);

    }

    public function hidden(string $id)
    {
        $employer = auth()->user()->employer;
        $jobPost = $employer->jobPosts()->where('id', $id)->first();

        if (!$jobPost) {
            return response()->json([
                'success' => false,
                'message' => 'JobPost not found'
            ], 404);
         }

         if($jobPost->job_post_status != 'approved'){
            return response()->json([
                'success' => false,
                'message' => 'Only approved posts can be hidden'
            ], 404);
         }

        $jobPost->job_post_status = "hidden";
        $jobPost->save();

        return response()->json([
            'success' => true,
            'message' => 'JobPost hidden successfully'
            ], 200);
        




    }

    public function unhidden(string $id)
    {
        $employer = auth()->user()->employer;
        $jobPost = $employer->jobPosts()->where('id', $id)->first();

        if (!$jobPost) {
            return response()->json([
                'success' => false,
                'message' => 'JobPost not found'
            ], 404);
         }

         if($jobPost->job_post_status != 'hidden'){
            return response()->json([
                'success' => false,
                'message' => 'Only hidden posts can be reactivated'
            ], 404);
         }

        $jobPost->job_post_status = "approved";
        $jobPost->save();

        return response()->json([
            'success' => true,
            'message' => 'JobPost unhidden successfully'
            ], 200);
        

    }
}
