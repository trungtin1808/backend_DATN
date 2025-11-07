<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->get();
        return response()->json([
            'success' => true,
            'data' => $users,
            'message' => 'Users retrieved successfully'

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = new User;
        $user->fill($request->all());
        $user->password = Hash::make($request->password);
        $user->save();
        $user->refresh();
        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => 'User created successfully'
        ],201);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        if(!$user){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'User not found'
                ],
                404

            );
        }

        return response()->json(
            [
                'success' => true,
                'data' => $user,
                'message' => 'User retrieved successfully'
            ]
        );

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        if(!$user){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'User not found'
                ],
                404

            );
        }

        if($request->has('name')){
            $user->name = $request->name;
        }
        if($request->has('email')){
            $user->email = $request->email;
        }

        if($request->has('phone')){
            $user->phone = $request->phone;
        }


        if($request->has('password')){
            $user->password = Hash::make($request->password);
        }

        if($request->has('active')){
            $user->active = $request->active;
        }
        $user->save();
        $user->refresh();
        return response()->json(
            [
                'success' => true,
                'data' => $user,
                'message' => 'User updated successfully'
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if(!$user){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'User not found'
                ],
                404

            );
        }
        $user->delete();
        return response()->json(
            [
                'success' => true,
                
                'message' => 'User deleted successfully'
            ]

        );
    }
}
