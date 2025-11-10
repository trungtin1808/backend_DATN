<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use App\Models\JobPost;

class Category extends Model
{
    use HasFactory, Notifiable;

    protected $table= 'category';

    protected $fillable = [
        'category_name',
    ];

    public function jobPosts()
    {
        return $this->hasMany(JobPost::class, 'category_id', 'id');
    }
}
