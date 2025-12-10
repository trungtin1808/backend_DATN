<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use App\Models\JobPost;
use App\Models\JobSeeker;
use App\Models\Employer;

class NotificationJobSeeker extends Model
{
    use HasFactory, Notifiable;

    protected $table= 'notification_jobseeker';

    protected $fillable = [
       'job_seeker_id',
       'employer_id',
       'job_post_id',
       'message',
       'is_read'
    ];

    public function jobPost(){
        return $this->belongsTo(JobPost::class, 'job_post_id', 'id');
    }

    public function employer(){
        return $this->belongsto(Employer::class, 'employer_id', 'id');
    }

    public function jobSeeker(){
        return $this->belongsto(JobSeeker::class, 'job_seeker_id', 'id');
    }

}
