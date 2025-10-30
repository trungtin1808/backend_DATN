<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class JobSeeker extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'job_seeker';

    protected $fillable = [
        'user_id',
        'name',
        'gender',
        'email',
        'phone',
        'date_of_birth',
        'image'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    
}
