<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class UserProfile extends Model
{
    use HasFactory;
    protected $table = 'user_profiles';

    // Define the fillable attributes (fields that can be mass-assigned)
    protected $fillable = [
        'user_id',
        'username',
        'email',
        'headline',
        'website',
        'linkedin_id',
        'description',
        'experience',
        'education',
        'skills',
        'file',
        'profile_pic'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
