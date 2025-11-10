<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use App\Models\JobSeeker;
use App\Models\Employer;

class Follow extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'follow';

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
        return $this->belongsTo(Employer::class, 'employer_id', 'id');
    }
    
}
