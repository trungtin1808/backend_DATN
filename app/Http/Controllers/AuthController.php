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
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        $user->refresh();

        if($request->role == 'jobseeker'){
            JobSeeker::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            ]);
        } else if($request->role == 'employer'){
            Employer::create([
            'user_id' => $user->id,
            'company_name' => $user->name,
            'company_email' => $user->email,
            'company_phone' => $user->phone,
            ]);


        }


        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
        ], 201);

    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        


        $refreshToken = $this->createRefreshToken();

        return $this->respondWithToken($token, $refreshToken);
    }
    
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

     public function refresh()
    {
        $refreshToken = request()->refresh_token;
        try{
            $decoded = JWTAuth::getJWTProvider()->decode($refreshToken);
            $user = User::find($decoded['sub']);

            if(!$user){
                return response()->json(['error'=>'User not found'],404);
            }

            auth()->invalidate(); //khi access_token khac con han
            $token = auth()->login($user);
            $refreshToken = $this->createRefreshToken();

            return $this->respondWithToken($token, $refreshToken);
        } catch(JWTException $exception){
            return response()->json(['error' => 'Refresh Token Invalid'],500);

        }



    }

    public function createRefreshToken(){
        $payload = [
            'sub' => auth()->user()->id,        
            'iat' => time(),
            'exp' => time() + config('jwt.refresh_ttl'),
        ];


        $refreshToken = JWTAuth::getJWTProvider()->encode($payload);

        return $refreshToken;


    }
   

     protected function respondWithToken($token, $refreshToken)
    {
        return response()->json([
            'access_token' => $token,
            'refresh_token' => $refreshToken,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }

}
