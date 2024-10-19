<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Startup extends Model
{
    use HasFactory;

    // Specify the table name if it doesn't follow Laravel's naming convention
    // protected $table = 'startups';

    // Define the fillable fields
    protected $fillable = [
        'company_name',
        'title',
        'description',
        'estimated_amount',
        'estimated_turn_over',
        'date_of_posting',
        'investment',
        'document',
        'bank_name',
        'ifsc_code',
        'swift_code',
        'account_holder_name',
        'account_number',
        'upi_id'
        
    ];
}
