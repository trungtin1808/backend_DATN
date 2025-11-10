<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use App\Models\Employer;
use App\Models\JobType;
use App\Models\Category;
use App\Models\JobLocation;
use App\Models\JobPostActivity;
use App\Models\JobSeekerLog;
use App\Models\PotentialStorage;

class JobPost extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'job_post';

    protected $fillable = [
        'employer_id',
        'job_type_id',
        'category_id',
        'job_title',
        'job_description',
        'job_post_status',
        'post_date',
        'expire_date',
        'salary',
        'approve_at',
        'street_address',
        'state',
        'city',
    ];

    public function employer()
    {
        return $this->belongsTo(Employer::class, 'employer_id', 'id');

    }

    public function jobType()
    {
        return $this->belongsTo(JobType::class, 'job_type_id', 'id');
        
    }

      public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
        
    }

    public function activities()
    {
        return $this->hasMany(JobPostActivity::class, 'job_post_id', 'id');
    }

    public function logs()
    {
        return $this->hasMany(JobSeekerLog::class, 'job_post_id', 'id');
    }

    public function potentialStorages()
    {
        return $this->hasMany(PotentialStorage::class, 'job_post_id', 'id');
    }
    
}
