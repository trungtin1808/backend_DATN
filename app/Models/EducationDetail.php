<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use App\Models\JobSeeker;


class EducationDetail extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'education_detail';

    
    protected $fillable = [
        'job_seeker_id',
        'education_level',//'secondary', 'high_school', 'college', 'university', 'master', 'doctor'
        'certificate_degree_name',//'cu nhan', 'thac si', 'tien si',...
        'institute_university_name',//'DH Bach Khoa', 'DH Quoc Gia',...
        'major',   //'CNTT', 'Marketing', 'Kinh Te',...
        'status',//'completed', 'in_progress'
        'start_date',
        'complete_date',
        'cgpa',
    ];

    
    public function jobSeeker()
    {
        return $this->belongsTo(JobSeeker::class, 'job_seeker_id', 'id');
    }

}
