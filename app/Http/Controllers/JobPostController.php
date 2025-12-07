<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPost;
use App\Models\JobSeekerLog;
use App\Models\JobPostActivity;

class JobPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employer = auth()->user()->employer;
        $jobPosts = $employer->jobPosts()
                    ->where('job_post_status', '!=', 'deleted')
                    ->withCount('activities')
                    ->with(["employer"])
                    ->get();

        if($jobPosts->isEmpty()){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'JobPost not found'
                ],
                404

            );
        }
       
        return response()->json([
            "success" => true,
            "data" => $jobPosts->map(function ($job){

                return [
                    "id" => $job->id,
                    "title" => $job->job_title,
                    "company" => $job->employer->company_name,
                    "status" => $job->job_post_status,
                    "applicants" => $job->activities_count,
                    "datePosted" => $job->created_at,
                    "logo" => $job->employer->logo,

                    "street" => $job->street_address,
                    "state" => $job->state,
                    "city" => $job->city,
                    "jobType" => $job->job_type_id,
                    "category" => $job->category_id,
                    "description" => $job->job_description,
                    "requirements" => $job->job_requirements,
                    "salaryMin" => $job->salaryMin,
                    "salaryMax" => $job->salaryMax,
                    "expiration" => $job->expire_date,

                ];
            }),

        ]);

    }

    

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $employer = auth()->user()->employer;

        $jobPost = JobPost::create([
            'employer_id' => $employer->id,
            'job_type_id' => $request->jobType,
            'category_id' => $request->category,
            'job_title' => $request->title,
            'job_description' => $request->description,
            'job_requirements' => $request->requirements,
            'expire_date' => $request->expiration,
            'salaryMin' => $request->salaryMin,
            'salaryMax' => $request->salaryMax,
            'street_address' => $request->street,
            'state' => $request->state,
            'city' => $request->city,
            

        ]);

        $jobPost->refresh();

        return response()->json([
            'message' => 'JobPost created successfully',
        ], 201);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         $employer = auth()->user()->employer;
         $jobPost = $employer->jobPosts()->where('id', $id)->where('job_post_status', '!=', 'deleted')->first();

        if(!$jobPost){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'JobPost not found'
                ],
                404

            );
        }
        

        return response()->json(
            [
                
                    'jobType' => $jobPost->job_type_id,
                    'category' => $jobPost->category_id,
                    'title' => $jobPost->job_title,
                    'description' => $jobPost->job_description,
                    'requirements' => $jobPost->job_requirements,
                    'expiration' => $jobPost->expire_date,
                    'salaryMin' => $jobPost->salaryMin,
                    'salaryMax' => $jobPost->salaryMax,
                    'street' => $jobPost->street_address,
                    'state' => $jobPost->state,
                    'city' => $jobPost->city,

              
                
            ]
        );


    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $employer = auth()->user()->employer;
        $jobPost = $employer->jobPosts()->where('id', $id)->where('job_post_status', '!=', 'deleted')->first();

        if(!$jobPost){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'JobPost not found'
                ],
                404

            );
        }

        $jobPost->employer_id = $employer->id;
        $jobPost->job_type_id = $request->jobType;
        $jobPost->category_id = $request->category;
        $jobPost->job_title = $request->title;
        $jobPost->job_description = $request->description;
        $jobPost->job_requirements = $request->requirements;
        $jobPost->expire_date = $request->expiration;
        $jobPost->salaryMin = $request->salaryMin;
        $jobPost->salaryMax = $request->salaryMax;
        $jobPost->street_address = $request->street;
        $jobPost->state = $request->state;
        $jobPost->city = $request->city;
        $jobPost->save();

         return response()->json([
            'success' => true,
            'message' => 'Jobpost updated successfully'
            ], 200);
        
    }

    public function updateForAdmin(Request $request, string $id)
    {
        $jobPost = JobPost::where('id', $id)->first();
        
        if(!$jobPost){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'JobPost not found'
                ],
                404

            );
        }

        $jobPost->job_post_status = $request->job_post_status;
        $jobPost->save();

         return response()->json([
            'success' => true,
            'message' => 'Jobpost updated successfully'
            ], 200);



    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employer = auth()->user()->employer;
        $jobPost = $employer->jobPosts()->where('id', $id)->first();

        if(!$jobPost){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'JobPost not found'
                ],
                404

            );
        }

        $jobPost->delete();

        return response()->json([
            'success' => true,
            'message' => 'JobPost deleted successfully'
            ], 200);

    }

    public function destroyForAdmin(string $id)
    {
        $jobPost = JobPost::where('id', $id)->first();

        if(!$jobPost){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'JobPost not found'
                ],
                404

            );
        }

        $jobPost->delete();

        return response()->json([
            'success' => true,
            'message' => 'JobPost deleted successfully'
            ], 200);


    }

    public function toggleHiddenJob(string $id)
    {
        $employer = auth()->user()->employer;
        $jobPost = $employer->jobPosts()->where('id', $id)->first();

        if (!$jobPost) {
            return response()->json([
                'success' => false,
                'message' => 'JobPost not found'
            ], 404);
        }

        $jobPost->job_post_status =  $jobPost->job_post_status == "hidden" ? "accepted" : "hidden";
        $jobPost->save();

        return response()->json([
            'success' => true,
            'message' => 'JobPost changed successfully'
            ], 200);
        




    }



    public function getJobs(Request $request)
    {
        $keyword = $request->query("keyword");
        $location = $request->query("location");
        $category = $request->query("category");
        $type = $request->query("type");
        $minSalary = $request->query("minSalary");
        $maxSalary = $request->query("maxSalary");
        $jobSeekerId = $request->query("jobSeekerId");

        $query = JobPost::where("job_post_status", "accepted");

        if($keyword){
            $query->where("job_title", "LIKE", "%". $keyword . "%");
        }

        if($location){
            $query->where("city", "LIKE", "%" .$location ."%");
        }

        if($category){
            $query->where("category_id", $category);
        }

        if($type){
            $query->where("job_type_id", $type);
        }

        if($minSalary){
            $query->where("salaryMax", ">=", intval($minSalary));
        }

        if($maxSalary){
            $query->where("salaryMin", "<=", intdiv($maxSalary));
        }

        // Fetch jobs with company info

        $jobs = $query->with(["employer", "employer.user"])->get();

        $savedJobIds = [];
        $applicationStatusMap = [];

        if($jobSeekerId){
            $savedJobIds = JobSeekerLog::where("job_seeker_id", $jobSeekerId)
                ->pluck('job_post_id')
                ->map(fn($id) => strval($id))
                ->toArray();

            $applications = JobPostActivity::where("job_seeker_id", $jobSeekerId)
                                            ->select("job_post_id", "apply_status")
                                            ->get();
            foreach ($applications as $app){
                $applicationStatusMap[strval($app->job_post_id)] = $app->apply_status;
            }
        }

        $jobsWihExtras = $jobs->map(function ($job) use($savedJobIds, $applicationStatusMap){
            $jobId = strval($job->id);

            return [
                ...$job->toArray(),
                "isSaved" => in_array($jobId, $savedJobIds),
                "applicationStatus" => $applicationStatusMap[$jobId] ?? null,
                
            ];
        });

        return response()->json($jobsWihExtras);
    }

    public function getJobById(Request $request, string $id )
    {
        $jobSeekerId = $request->query("jobSeekerId");
        $jobPost = JobPost::where("id", $id)
                            ->where("job_post_status", "accepted")
                            ->with(["employer", "employer.user"])->first();

        if(!$jobPost){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'JobPost not found'
                ],
                404
            );

        }

        $applicationStatus = null;

        if($jobSeekerId){
            $application = JobPostActivity::where("job_seeker_id", $jobSeekerId)
                                            ->where("job_post_id", $id)
                                            ->first();
            if($application){
                $applicationStatus = $application->apply_status;  
            }
                                           
        }

        return response()->json([
        'success' => true,
        'jobPost' => $jobPost,
        'applicationStatus' => $applicationStatus,
        ], 200);

    }

    public function indexForAdmin()
    {
        
        $jobPosts =  JobPost::withCount('activities')->with(["employer"])->get();

        if($jobPosts->isEmpty()){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'JobPost not found'
                ],
                404

            );
        }
       
        return response()->json([
            "success" => true,
            "data" => $jobPosts->map(function ($job){

                return [
                    "id" => $job->id,
                    "employer_id" => $job->employer->id,
                    "title" => $job->job_title,
                    "company" => $job->employer->company_name,
                    "status" => $job->job_post_status,
                    "applicants" => $job->activities_count,
                    "datePosted" => $job->created_at,
                    "logo" => $job->employer->logo,

                    "street" => $job->street_address,
                    "state" => $job->state,
                    "city" => $job->city,
                    "jobType" => $job->job_type_id,
                    "category" => $job->category_id,
                    "description" => $job->job_description,
                    "requirements" => $job->job_requirements,
                    "salaryMin" => $job->salaryMin,
                    "salaryMax" => $job->salaryMax,
                    "expiration" => $job->expire_date,

                ];
            }),

        ]);
    }

}
