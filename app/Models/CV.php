<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use App\Models\JobSeeker;

class CV extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'cv';

    protected $fillable = [
        'job_seeker_id',
        'link_cv',
    ];

    public function jobSeeker()
    {
        return $this->belongsTo(JobSeeker::class, 'job_seeker_id', 'id');
    }
}
