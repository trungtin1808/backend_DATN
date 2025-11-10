<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use App\Models\JobPost;
use App\Models\JobSeeker;

class JobSeekerLog extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'job_seeker_log';

    protected $fillable = [
        'job_post_id',
        'job_seeker_id',
        'saved_at',
    ];

    public function jobPost()
    {
        return $this->belongsTo(JobPost::class, 'job_post_id', 'id');
    }

    public function jobSeeker()
    {
        return $this->belongsTo(JobSeeker::class, 'job_seeker_id', 'id');
    }
}
