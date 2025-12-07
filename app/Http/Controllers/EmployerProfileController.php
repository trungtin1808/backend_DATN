<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UpdateForEmployerProfileRequest;
use Illuminate\Support\Facades\Storage;

class EmployerProfileController extends Controller
{
    

    public function update(Request $request){

        $user = auth()->user();
        $employer = $user->employer;

        if (!$employer) {
            return response()->json([
                'success' => false,
                'message' => 'Employer not found'
            ], 404);
        }

         if($request->hasFile('avatar')){
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        if($request->hasFile('logo')){
            if ($employer->logo) {
                Storage::disk('public')->delete($employer->logo);
            }

            $logoPath = $request->file('logo')->store('logos', 'public');
            $employer->logo = $logoPath;
        }

        if($request->has('name')){
            $user->name = $request->name;

        }

        if($request->has('email')){
            $user->email = $request->email;
        }

        

        if($request->has('companyName')){
            $employer->company_name = $request->companyName;

        }

        if($request->has('companyDescription')){
            $employer->profile_description = $request->companyDescription;

        }


        if($request->has('companyEstablishment')){
            $employer->establishment_date = $request->companyEstablishment;

        }

        if($request->has('companyWebsite')){
            $employer->company_website_url = $request->companyWebsite;

        }

        if($request->has('companyStreet')){
            $user->street_address = $request->companyStreet;

        }

        if($request->has('companyState')){
            $user->state = $request->companyState;

        }

        if($request->has('companyCity')){
            $user->city = $request->companyCity;

        }

        if($request->has('phone')){
            $user->phone = $request->phone;

        }


        $user->save();
        $employer->save();

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

                'employer_id' => $employer->id,
                'company_name' => $employer->company_name ?? '',
                'logo' => $employer->logo ?? '',
                'profile_description' => $employer->profile_description ?? '',
                'establishment_date' => $employer->establishment_date ?? '',
                'company_website_url' => $employer->company_website_url ?? '',

            ]
        ], 200);


    }

    public function upload_image(Request $request){

        $user = auth()->user();
        $employer = $user->employer;

        if (!$employer) {
            return response()->json([
                'success' => false,
                'message' => 'Employer not found'
            ], 404);
        }

        

        if($request->hasFile('avatar')){
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        if($request->hasFile('logo')){
            if ($employer->logo) {
                Storage::disk('public')->delete($employer->logo);
            }

            $logoPath = $request->file('logo')->store('logos', 'public');
            $employer->logo = $logoPath;
        }



        $user->save();
        $employer->save();

        return response()->json([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'avatar' => $user->avatar ?? '',
                'street_address' => $user->street_address??'',
                'state' => $user->state ?? '',
                'city' => $user->city ?? '',
                'role' => $user->role,

                'employer_id' => $employer->id,
                'company_name' => $employer->company_name ?? '',
                'logo' => $employer->logo ?? '',
                'profile_description' => $employer->profile_description ?? '',
                'establishment_date' => $employer->establishment_date ?? '',
                'company_website_url' => $employer->company_website_url ?? '',


        ], 200);

    }

    

}
