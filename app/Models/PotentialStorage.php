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
        'employer_id',
        'job_seeker_id',
    ];

    public function jobSeeker()
    {
        return $this->belongsTo(JobSeeker::class, 'job_seeker_id', 'id');
    }

    public function employer()
    {
        return $this->belongsTo(JobPost::class, 'employer_id', 'id');
    }

    



}
