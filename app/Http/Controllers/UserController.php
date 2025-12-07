<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Employer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        $users = User::where("role","!=","admin")->whereIn("status", ["pending", "rejected"])->latest()->get();
        if($users->isEmpty()){
            return response()->json([
            'success' => false,
            'message' => 'User Not Found'

        ], 404);

        }

        return response()->json([
            'success' => true,
            'data' => $users,
            'message' => 'Users retrieved successfully'

        ]);
    }

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

       if($request->status == "accepted"){
          $user->status = "accepted";
          Employer::create([
            'user_id' => $user->id,
            
          ]);

       } else {
         $user->status = "rejected";
       }
        
       $user->save();

       return response()->json(
            [
                'success' => true,
                
                'message' => 'User updated successfully'
            ]

        );

    }

    
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
