<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class EmployerProfileController extends Controller
{
    public function profile()
    {
        $user = auth()->user();

        $employer = $user->employer; 

        if (!$employer) {
            return response()->json([
                'success' => false,
                'message' => 'Employer profile not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
            'company_name'          => $employer->company_name,
            'profile_description' => $employer->profile_description,
            'establishment_date' => $employer->establishment_date,
            'company_email' => $employer->company_email,
            'company_phone' => $employer->company_phone,
            'company_website_url' => $employer->company_website_url,
            'company_image' => $employer->company_image,
            'street_address' => $user->street_address,
            'state'          => $user->state,
            'city'           => $user->city,
        ]
        ]);

    }

    public function update(Request $request){

        $user = auth()->user();
        $employer = $user->employer;

        if (!$employer) {
            return response()->json([
                'success' => false,
                'message' => 'Employer not found'
            ], 404);
        }

        if($request->has('company_name')){
            
            $employer->company_name = $request->company_name;
            $user->name = $request->company_name;

        }

        if($request->has('profile_description')){

            $employer->profile_description = $request->profile_description;

        }

        if($request->has('establishment_date')){

            $employer->establishment_date = $request->establishment_date;

        }

        if($request->has('company_website_url')){

            $employer->company_website_url = $request->company_website_url;

        }

        if($request->has('company_image')){
            $employer->company_image = $request->company_image;
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
        $employer->save();

        return response()->json([
        'success' => true,
        'message' => 'Cập nhật employer thành công',
        'data' => [
            'company_name'          => $employer->company_name,
            'profile_description' => $employer->profile_description,
            'establishment_date' => $employer->establishment_date,
            'company_email' => $employer->company_email,
            'company_phone' => $employer->company_phone,
            'company_website_url' => $employer->company_website_url,
            'company_image' => $employer->company_image,
            'street_address' => $user->street_address,
            'state'          => $user->state,
            'city'           => $user->city,
        ]

        ], 200);

    }
}
