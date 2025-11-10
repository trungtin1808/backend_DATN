<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use App\Models\JobSeeker;
use App\Models\JobPost;

class PotentialStorage extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'potential_storage';
    protected $fillable = [
        'job_post_id',
        'job_seeker_id',
    ];

    public function jobSeeker()
    {
        return $this->belongsTo(JobSeeker::class, 'job_seeker_id', 'id');
    }

    public function jobPost()
    {
        return $this->belongsTo(JobPost::class, 'job_post_id', 'id');
    }

    



}
