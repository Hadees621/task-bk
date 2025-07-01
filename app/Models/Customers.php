<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Customers extends Model
{
    use HasFactory, Searchable;

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

    public function toSearchableArray()
    {
        return $this->only(['first_name', 'last_name', 'nationality']);
    }
}

