<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Employer;
use App\Models\JobPost;
use App\Models\JobPostActivity;
use App\Models\User;

class AdminAnalyticController extends Controller
{

    function getTrend($current, $previous)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }

        return round((($current - $previous) / $previous) * 100);
    }

    public function overview()
    {
        
        $now = now();
        $last7Days = now()->subDays(7);
        $prev7Days = now()->subDays(14);

        
        $totalJobPosts = JobPost::count();
        $totalActivities = JobPostActivity::count();
        $totalAccepted = JobPostActivity::where('apply_status', 'accepted')->count();
        $totalUsers = User::count();
        //Job Posts trend
        $jobPostsLast7 = JobPost::where('created_at', '>=', $last7Days)
                                            ->where('created_at', '<=', $now)
                                            ->count();
        $jobPostsPrev7 = JobPost::where('created_at', '>=', $prev7Days)
                                            ->where('created_at', '<', $last7Days)
                                            ->count();
        $jobPostTrend = $this->getTrend($jobPostsLast7, $jobPostsPrev7);
        //applications trend
        $activitiesLast7 = JobPostActivity::where('created_at', '>=', $last7Days)
                                            ->where('created_at', '<=', $now)
                                            ->count();
        $activitiesPrev7 = JobPostActivity::where('created_at', '>=', $prev7Days)
                                            ->where('created_at', '<', $last7Days)
                                            ->count();
        $activityTrend = $this->getTrend($activitiesLast7, $activitiesPrev7);
        // approved applicants trend
        $acceptedLast7 = JobPostActivity::where('apply_status', 'accepted')
                                              ->where('created_at','>=', $last7Days)
                                              ->where('created_at', '<=', $now)
                                              ->count();
        $acceptedPrev7 = JobPostActivity::where('apply_status', 'accepted')
                                              ->where('created_at','>=', $prev7Days)
                                              ->where('created_at', '<', $last7Days)
                                              ->count();
        $acceptedTrend = $this->getTrend($acceptedLast7, $acceptedPrev7);

        // user trend
        $usersLast7 = User::where('created_at', '>=', $last7Days)
                                            ->where('created_at', '<=', $now)
                                            ->count();
        $usersPrev7 = User::where('created_at', '>=', $prev7Days)
                                            ->where('created_at', '<', $last7Days)
                                            ->count();
        $userTrend = $this->getTrend($usersLast7, $usersPrev7);



        $recentJobs =JobPost::select('id', 'job_title','job_type_id', 'created_at', 'job_post_status','street_address', 'state', 'city')
                                        ->with('jobType')
                                        ->latest()
                                        ->take(5)
                                        ->get();

        $recentActivities = JobPostActivity::with([
        'jobSeeker.user',  // load user để có avatar
        'jobPost'
             ])
        ->latest()
        ->take(5)
        ->get();

        return response()->json([
            'counts'=> [
                'total_job_posts' => $totalJobPosts,
                'total_activities' => $totalActivities,
                'total_accepted' => $totalAccepted,
                'total_users' => $totalUsers,
                'trends' => [
                    'jobPosts' => $jobPostTrend,
                    'activities' => $activityTrend,
                    'accepted' => $acceptedTrend,
                    'users' => $userTrend,
                ]
            ],
            'data' => [
                'recentJobs' => $recentJobs,
                'recentActivities' => $recentActivities,
            ]

            

        ]);
    }

    


}
