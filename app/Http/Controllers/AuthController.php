<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Models\JobSeeker;
use App\Models\Employer;



class AuthController extends \Illuminate\Routing\Controller
{

    public function register(RegisterRequest $request)
    {   
        $avatarPath = null;
        
        if($request->hasFile('avatar')){
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'avatar' => $avatarPath        
        ]);

        $user->refresh();



        if($request->role == 'jobseeker'){
            $user->status = 'accepted';
            $user->save();
          

            JobSeeker::create([
            'user_id' => $user->id,
            ]);

            

        } else if($user->role == 'admin'){
            $user->status = 'accepted';
            $user->save();

        }


        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
        ], 201);

    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return response()->json(['error' => 'Email does not exist'], 401);
        }

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Incorrect password'], 401);
        }

        if ($user->status !== 'accepted') {
            return response()->json([
                'error' => 'Your account has not been accepted or has been banned'
            ], 401);
        }

        return $this->respondWithToken($token);
    }
    
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    //  public function refresh()
    // {
    //     $refreshToken = request()->refresh_token;
    //     try{
    //         $decoded = JWTAuth::getJWTProvider()->decode($refreshToken);
    //         $user = User::find($decoded['sub']);

    //         if(!$user){
    //             return response()->json(['error'=>'User not found'],404);
    //         }

    //         auth()->invalidate(); //khi access_token khac con han
    //         $token = auth()->login($user);
    //         $refreshToken = $this->createRefreshToken();

    //         return $this->respondWithToken($token, $refreshToken);
    //     } catch(JWTException $exception){
    //         return response()->json(['error' => 'Refresh Token Invalid'],500);

    //     }



    // }

    // public function createRefreshToken(){
    //     $payload = [
    //         'sub' => auth()->user()->id,        
    //         'iat' => time(),
    //         'exp' => time() + config('jwt.refresh_ttl'),
    //     ];


    //     $refreshToken = JWTAuth::getJWTProvider()->encode($payload);

    //     return $refreshToken;


    // }
   

     protected function respondWithToken($token)
    {
        $user = auth()->user();
        if($user->role == "jobseeker"){
            $jobseeker = $user->jobseeker;
            return response()->json([
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'token' => $token,
            'role' => $user->role,
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

                'job_seeker_id' => $jobseeker->id,
                'gender' => $jobseeker->gender ?? '',
                'date_of_birth' => $jobseeker->date_of_birth ?? '',
                'cv' => $jobseeker->cv ?? '',
                'cv_name' => $jobseeker->cv_name ?? '',

            ]

            

            
            ]);

        } else if($user->role == "employer"){
            $employer = $user->employer;
             return response()->json([
            
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'token' => $token,
            'role' => $user->role,
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
            
            ]);


        } else {
             return response()->json([
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'token' => $token,
            'role' => $user->role,
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
            ]

            

            
            ]);

        }
        
    }

}
