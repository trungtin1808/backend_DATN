<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class EmployerProfileController extends Controller
{
    public function profile()
    {
        $user = auth()->user();

        $employer = $user->jobSeeker; 

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
}
