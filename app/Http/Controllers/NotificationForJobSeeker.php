<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NotificationJobSeeker;

class NotificationForJobSeeker extends Controller
{
    public function getNotifications(){
        $jobSeeker = auth()->user()->jobSeeker;

        $notifications = NotificationJobSeeker::where("job_seeker_id", $jobSeeker->id)
                                     ->with(["employer.user", "jobPost"])
                                     ->orderBy("created_at", "desc")
                                     ->get();

        $count = NotificationJobSeeker::where("job_seeker_id", $jobSeeker->id)
                            ->where("is_read", 0)
                            ->count();

        return response()->json([
        'success' => true,
        'data' => $notifications,
        'unread' => $count,
        ]);
    }

     public function update(string $id){
        $jobSeeker = auth()->user()->jobSeeker;
        
        $notification = NotificationJobSeeker::where("job_seeker_id", $jobSeeker->id)
                            ->where("id", $id)
                            ->update([
                                "is_read" => 1
                            ]);
        
        return response()->json([
        'success' => true,
        'message' => "updated successfully",
        ]);


        
    }

    public function destroy(string $id){
        $notification = NotificationJobSeeker::find($id);

        if(!$notification) {
             return response()->json([
            'success' => false,
            'message' => "Not found",
            ],404);

        }

        $notification->delete();

         return response()->json([
        'success' => true,
        'message' => "deleted successfully",
        ]);

    }
}
