<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use App\Models\User;
use App\Models\JobPost;
use App\Models\Review;
use App\Models\Follow;
use App\Models\JobPostActivity;

class Employer extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'company';

    protected $fillable = [
        'user_id',
        'company_name',
        'profile_description',
        'establishment_date',
        'company_website_url',
        'logo'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function jobPosts()
    {
        return $this->hasMany(JobPost::class, 'employer_id', 'id');
    }

    public function reviewsByJobSeekers()
    {
        return $this->hasMany(Review::class, 'employer_id', 'id');
    }

    public function followers()
    {
        return $this->hasMany(Follow::class, 'employer_id', 'id');
    }

    public function activities()
    {
        return $this->hasManyThrough(
            JobPostActivity::class,
            JobPost::class,
            'employer_id',   // JobPost.employer_id
            'job_post_id',   // JobApplication.job_post_id
            'id',            // Employer.id
            'id'             // JobPost.id
        );
    }
    
}
