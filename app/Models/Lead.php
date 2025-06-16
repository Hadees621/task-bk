<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'email',
        'phone_number',
        'source',
        'status',
        'assigned_to',
        'company_name',
        'lead_score',
        'notes',
    ];

    public static function newFactory()
    {
        return \Database\Factories\LeadFactory::new();
    }
}
