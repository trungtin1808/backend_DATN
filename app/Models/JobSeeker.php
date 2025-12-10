<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use App\Models\EducationDetail;
use App\Models\User;
use App\Models\ExperienceDetail;
use App\Models\CV;
use App\Models\Certificate;
use App\Models\JobPostActivity;
use App\Models\JobSeekerLog;
use App\Models\Review;
use App\Models\Follow;
use App\Models\PotentialStorage;


class JobSeeker extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'job_seeker';

    protected $fillable = [
        'user_id',
        'gender',
        'date_of_birth',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function educationDetails()
    {
        return $this->hasMany(EducationDetail::class, 'job_seeker_id', 'id');
    }

    public function experienceDetails()
    {
        return $this->hasMany(ExperienceDetail::class, 'job_seeker_id', 'id');
    }

    public function CVs()
    {
        return $this->hasMany(CV::class, 'job_seeker_id', 'id');
    }

    public function Certificates()
    {
        return $this->hasMany(Certificate::class, 'job_seeker_id', 'id');
    }

    public function appliedJobs()
    {
        return $this->hasMany(JobPostActivity::class, 'job_seeker_id', 'id');
    }

    public function logs()
    {
        return $this->hasMany(JobSeekerLog::class, 'job_seeker_id', 'id');
    }

    public function reviewsForEmployers()
    {
        return $this->hasMany(Review::class, 'job_seeker_id', 'id');
    }

    public function follows()
    {
        return $this->hasMany(Follow::class, 'job_seeker_id', 'id');
    }

    


}
