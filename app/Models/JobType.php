<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use App\Models\JobPost;

class JobType extends Model
{
    use HasFactory, Notifiable;

    protected $table= 'job_type';

    protected $fillable = [
        'job_type',
    ];

    public function jobPosts()
    {
        return $this->hasMany(JobPost::class, 'job_type_id', 'id');
    }

    
}
