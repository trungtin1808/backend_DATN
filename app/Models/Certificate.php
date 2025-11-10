<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use App\Models\JobSeeker;

class Certificate extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'certificate';

    protected $fillable = [
        'job_seeker_id',
        'certificate_name',
        'organization',
        'issue_date',
        'expire_date',
        'certificate_url',
        'score',
    ];

    public function jobSeeker()
    {
        return $this->belongsTo(JobSeeker::class, 'job_seeker_id', 'id');
    }
}
