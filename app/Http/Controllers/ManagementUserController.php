<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employer;

class ManagementUserController extends Controller
{
    public function users()
    {
        $users = User::all();

        if ($users->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No users found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $users
        ], 200);


    }

    public function show(string $id)
    {
        $user = User::find($id);

         if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $user
        ], 200);


    }

    public function update(Request $request, string $id)
    {
        $user = User::find($id);

         if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        $user->status = $request->status;
        $user->save();

        if($user->role == 'employer'){
            Employer::firstOrCreate([
            'user_id' => $user->id,
            'company_name' => $user->name,
            'company_email' => $user->email,
            'company_phone' => $user->phone,
            ]);

        }

        return response()->json([
            'success' => true,
            'data' => $user, // data chứa user
            'message' => 'Trạng thái đã được cập nhật'
        ]);


    }

    
}
