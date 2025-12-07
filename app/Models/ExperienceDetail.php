<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use App\Models\JobSeeker;

class ExperienceDetail extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'experience_detail';

    protected $fillable = [
        'job_seeker_id',
        'start_date',
        'end_date',
        'job_title',//'Ky su phan mem', 'Chuyen vien Marketing',...
        'company_name',//'FPT Software', 'Viettel', 'VNG',...
        'job_location',//'Ha Noi', 'TP HCM',...
        'description',//'Mo ta cong viec da lam',...
    ];

    public function jobSeeker()
    {
        return $this->belongsTo(JobSeeker::class, 'job_seeker_id', 'id');
    }
}
