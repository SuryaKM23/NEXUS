<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $table = 'jobs';

    // Specify the fields that are mass assignable
    protected $fillable = [
        'job_title',
        'company_name',
        'job_description',
        'job_location',
        'salary',
        'application_deadline',
        'job_type',
        'experience_level',
        'required_skills',
    ];
}
