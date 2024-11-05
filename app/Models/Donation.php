<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;
    protected $table = 'donations';

    // Specify which attributes should be mass assignable
    protected $fillable = [
        'company_id',
        'company_name',
        'user_name',
        'user_email',
        'title',
        'donated_amount',
        'transaction_id',
        'total_amount', // Add this line
    ];

    // Optionally define relationships if necessary
    // Example: Relationship with Company model
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
