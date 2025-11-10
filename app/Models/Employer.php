<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use App\Models\User;
use App\Models\JobPost;
use App\Models\Review;
use App\Models\Follow;

class Employer extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'company';

    protected $fillable = [
        'user_id',
        'company_name',
        'profile_description',
        'establishment_date',
        'company_email',
        'company_phone',
        'company_website_url',
        'company_image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function jobPosts()
    {
        return $this->hasMany(JobPost::class, 'employer_id', 'id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'employer_id', 'id');
    }

    public function followers()
    {
        return $this->hasMany(Follow::class, 'employer_id', 'id');
    }
    
}
