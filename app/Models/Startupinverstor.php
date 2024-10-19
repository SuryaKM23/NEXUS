<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Startupinverstor extends Model
{
    use HasFactory;

    // Define the table name if it's not the plural form of the model name
    protected $table = 'startupinverstors';

    // Define fillable fields
    protected $fillable = [
        'name', 'company_name', 'email', 'phone', 'address', 'country', 'license_no', 'usertype', 'password', 'website', 'profile_picture', 'status'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'startup_investor_id');
    }
}
