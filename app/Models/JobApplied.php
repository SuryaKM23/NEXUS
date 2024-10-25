<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplied extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'job_applied';

    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'name',
        'email',
        'phone',
        'degree',
        'skills',
        'experience',
        'resume',
    ];
}
