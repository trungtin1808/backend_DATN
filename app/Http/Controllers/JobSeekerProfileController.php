<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


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
            'name'          => $jobSeeker->name,
            'gender'        => $jobSeeker->gender,
            'email'         => $jobSeeker->email,
            'phone'         => $jobSeeker->phone,
            'date_of_birth' => $jobSeeker->date_of_birth,
            'image'         => $jobSeeker->image,
            'street_address' => $user->street_address,
            'state'          => $user->state,
            'city'           => $user->city,
        ]
        ]);

    }

    public function update(Request $request){

        $user = auth()->user();
        $jobSeeker = $user->jobSeeker;

        if (!$jobSeeker) {
            return response()->json([
                'success' => false,
                'message' => 'Jobseeker not found'
            ], 404);
        }

        if($request->has('name')){
            
            $jobSeeker->name = $request->name;
            $user->name = $request->name;

        }

        if($request->has('gender')){

            $jobSeeker->gender = $request->gender;

        }

        if($request->has('date_of_birth')){

            $jobSeeker->date_of_birth = $request->date_of_birth;

        }

        
        

        if($request->has('image')){
            $jobSeeker->image = $request->image;
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
        'success' => true,
        'message' => 'Cập nhật jobSeeker thành công',
        'data' => [
            'name'          => $jobSeeker->name,
            'gender'        => $jobSeeker->gender,
            'email'         => $jobSeeker->email,
            'phone'         => $jobSeeker->phone,
            'date_of_birth' => $jobSeeker->date_of_birth,
            'image'         => $jobSeeker->image,
            'street_address' => $user->street_address,
            'state'          => $user->state,
            'city'           => $user->city,
        ]

        ], 200);


    }


    
}
