<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'personal_phone',
        'description',
        'address',
        'business_phone',
        'home_phone',
        'nationality',
        'country_of_residence',
        'dob',
        'gender',
    ];
}
