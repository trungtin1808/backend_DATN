<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UpdateForJobSeekerProfileRequest;
use Illuminate\Support\Facades\Storage;



class JobSeekerProfileController extends Controller
{
    public function profile()
    {
        $user = auth()->user();

        $jobSeeker = $user->jobSeeker; 

        if (!$jobSeeker) {
            return response()->json([
                'success' => false,
                'message' => 'JobSeeker profile not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
            'user_id' => $user->id,
            'job_seeker_id' => $jobseeker->id,
            'name' => $jobseeker->name,
            'gender' => $jobseeker->gender ?? '',
            'email' => $jobseeker->email,
            'phone' => $jobseeker->phone,
            'date_of_birh' => $jobseeker->date_of_birth ?? '',
            'role' => $user->role,
            'avatar' => $user->avatar ?? '',
            'street_address' => $user->street_address??'',
            'state' => $user->state ?? '',
            'city' => $user->city ?? '',
            
            ]
        ]);

    }

    public function update(UpdateForJobSeekerProfileRequest $request){

        $user = auth()->user();
        $jobSeeker = $user->jobSeeker;

        if (!$jobSeeker) {
            return response()->json([
                'success' => false,
                'message' => 'Jobseeker not found'
            ], 404);
        }


        if($request->has('name')){
            
            
            $user->name = $request->name;

        }

        if($request->has('gender')){

            $jobSeeker->gender = $request->gender;

        }

        if($request->has('date_of_birth')){

            $jobSeeker->date_of_birth = $request->date_of_birth;

        }


        if($request->hasFile('avatar')){

            

            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        if($request->has('street_address')){

            $user->street_address = $request->street_address;
        }

        if($request->has('state')){

            $user->state = $request->state;
        }

        if($request->has('city')){
            
            $user->city = $request->city;
        }



         

        $user->save();
        $jobSeeker->save();

        return response()->json([
            'data' => [
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'avatar' => $user->avatar ?? '',
                'street_address' => $user->street_address??'',
                'state' => $user->state ?? '',
                'city' => $user->city ?? '',
                'role' => $user->role,

                'job_seeker_id' => $jobSeeker->id,
                'gender' => $jobSeeker->gender ?? '',
                'date_of_birth' => $jobSeeker->date_of_birth ?? '',
        ],

        ], 200);


    }


    
}
