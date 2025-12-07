<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employer;
use App\Models\JobPost;
use App\Models\JobPostActivity;

class EmployerAnalyticController extends Controller
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
        $employerId = auth()->user()->employer->id;

        $employer = Employer::with(['jobPosts', 'activities'])->find($employerId);

        if(!$employer){
            return reponse()->json(['error' => 'Employer not found'], 404);
        }

        $now = now();
        $last7Days = now()->subDays(7);
        $prev7Days = now()->subDays(14);

        
        $totalJobPosts = $employer->jobPosts->count();
        $totalActivities = $employer->activities->count();
        $totalAccepted = $employer->activities->where('apply_status', 'accepted')->count();
        //Job Posts trend
        $jobPostsLast7 = $employer->jobPosts->where('created_at', '>=', $last7Days)
                                            ->where('created_at', '<=', $now)
                                            ->count();
        $jobPostsPrev7 = $employer->jobPosts->where('created_at', '>=', $prev7Days)
                                            ->where('created_at', '<', $last7Days)
                                            ->count();
        $jobPostTrend = $this->getTrend($jobPostsLast7, $jobPostsPrev7);
        //applications trend
        $activitiesLast7 = $employer->activities->where('created_at', '>=', $last7Days)
                                            ->where('created_at', '<=', $now)
                                            ->count();
        $activitiesPrev7 = $employer->activities->where('created_at', '>=', $prev7Days)
                                            ->where('created_at', '<', $last7Days)
                                            ->count();
        $activityTrend = $this->getTrend($activitiesLast7, $activitiesPrev7);
        // approved applicants trend
        $acceptedLast7 = $employer->activities->where('apply_status', 'accepted')
                                              ->where('created_at','>=', $last7Days)
                                              ->where('created_at', '<=', $now)
                                              ->count();
        $acceptedPrev7 = $employer->activities->where('apply_status', 'accepted')
                                              ->where('created_at','>=', $prev7Days)
                                              ->where('created_at', '<', $last7Days)
                                              ->count();
        $acceptedTrend = $this->getTrend($acceptedLast7, $acceptedPrev7);

        $recentJobs =JobPost::where('employer_id', $employerId)
                                        ->where('job_post_status','!=', 'deleted')
                                        ->select('id', 'job_title','job_type_id', 'created_at', 'job_post_status','street_address', 'state', 'city')
                                        ->with('jobType')
                                        ->latest()
                                        ->take(5)
                                        ->get();

        $recentActivities = JobPostActivity::whereHas('jobPost', function($query) use ($employerId) {
        $query->where('employer_id', $employerId)
              ->where('job_post_status', '!=', 'deleted');
        })
        ->with([
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
                'trends' => [
                    'jobPosts' => $jobPostTrend,
                    'activities' => $activityTrend,
                    'accepted' => $acceptedTrend,
                ]
            ],
            'data' => [
                'recentJobs' => $recentJobs,
                'recentActivities' => $recentActivities,
            ]

            

        ]);
    }
}
