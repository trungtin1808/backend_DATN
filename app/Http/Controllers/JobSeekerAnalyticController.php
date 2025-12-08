<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employer;
use App\Models\JobPost;
use App\Models\JobPostActivity;
use App\Models\JobSeekerLog;


class JobSeekerAnalyticController extends Controller
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
        $jobSeeker = auth()->user()->jobSeeker;
        $jobSeekerId = $jobSeeker->id;
        

        

        if(!$jobSeekerId){
            return reponse()->json(['error' => 'Jobseeker not found'], 404);
        }

        $now = now();
        $last7Days = now()->subDays(7);
        $prev7Days = now()->subDays(14);

        
        $totalAppliedJobs = $jobSeeker->appliedJobs->count();
        $totalSavedJobs = $jobSeeker->logs->count();
        $totalReviewing = $jobSeeker->appliedJobs->where('apply_status', 'reviewing')->count();
        //Job Posts trend
        $appliedJobsLast7 = $jobSeeker->appliedJobs->where('created_at', '>=', $last7Days)
                                            ->where('created_at', '<=', $now)
                                            ->count();
        $appliedJobsPrev7 = $jobSeeker->appliedJobs->where('created_at', '>=', $prev7Days)
                                            ->where('created_at', '<', $last7Days)
                                            ->count();
        $appliedTrend = $this->getTrend($appliedJobsLast7, $appliedJobsPrev7);
        //applications trend
        $savedJobsLast7 = $jobSeeker->logs->where('created_at', '>=', $last7Days)
                                            ->where('created_at', '<=', $now)
                                            ->count();
        $savedJobsPrev7 = $jobSeeker->logs->where('created_at', '>=', $prev7Days)
                                            ->where('created_at', '<', $last7Days)
                                            ->count();
        $savedJobsTrend = $this->getTrend($savedJobsLast7, $savedJobsPrev7);
        // approved applicants trend
        $reviewingLast7 = $jobSeeker->appliedJobs->where('apply_status', 'reviewing')
                                              ->where('created_at','>=', $last7Days)
                                              ->where('created_at', '<=', $now)
                                              ->count();
        $reviewingPrev7 = $jobSeeker->appliedJobs->where('apply_status', 'reviewing')
                                              ->where('created_at','>=', $prev7Days)
                                              ->where('created_at', '<', $last7Days)
                                              ->count();
        $reviewingTrend = $this->getTrend($reviewingLast7, $reviewingPrev7);

        $recentSaves =JobSeekerLog::where('job_seeker_id', $jobSeekerId)
                                        ->with(['jobPost','jobPost.employer'])
                                        ->latest()
                                        ->take(5)
                                        ->get();

        $recentApplies = JobPostActivity::whereHas('jobPost', function($query) use ($jobSeekerId) {
        $query->where('job_seeker_id', $jobSeekerId)
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
                'total_apply_jobs' => $totalAppliedJobs,
                'total_save_jobs' => $totalSavedJobs,
                'total_reviewing' => $totalReviewing,
                'trends' => [
                    'applied' => $appliedTrend,
                    'saved' => $savedJobsTrend,
                    'reviewing' => $reviewingTrend,
                ]
            ],
            'data' => [
                'recentApplies' => $recentApplies,
                'recentSaves' => $recentSaves,
            ]

            

        ]);


    }
}
