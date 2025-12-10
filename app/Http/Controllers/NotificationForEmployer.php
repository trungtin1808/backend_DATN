<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
class NotificationForEmployer extends Controller
{
    public function getNotifications(){
        $employer = auth()->user()->employer;

        $notifications = Notification::where("employer_id", $employer->id)
                                     ->with(["jobSeeker.user", "jobPost"])
                                     ->orderBy("created_at", "desc")
                                     ->get();

        $count = Notification::where("employer_id", $employer->id)
                            ->where("is_read", 0)
                            ->count();

        return response()->json([
        'success' => true,
        'data' => $notifications,
        'unread' => $count,
        ]);
    }

    public function getCountUnread(){
        $employer = auth()->user()->employer;

        $count = Notification::where("employer_id", $employer->id)
                            ->where("is_read", 0)
                            ->count();
         return response()->json([
        'success' => true,
        'count' => $count,
        ]);
        
    }

    public function update(string $id){
        $employer = auth()->user()->employer;
        
        $notification = Notification::where("employer_id", $employer->id)
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
        $notification = Notification::find($id);
        if(!$notification) {
            return response()->json([
                'success' => false,
                'message' => "Not found",
        ], 404);

        }

        $notification->delete();

         return response()->json([
            'success' => true,
            'message' => "Deleted successfully",
        ], 200);


    }
}
