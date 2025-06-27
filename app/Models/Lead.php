<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Lead extends Model
{
    use HasFactory, Searchable;

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

    public function toSearchableArray()
    {
        return [
            'full_name'    => $this->full_name,
            'email'        => $this->email,
            'phone_number' => $this->phone_number,
            'company_name' => $this->company_name,
            'notes'        => $this->notes,
        ];
    }

    public static function newFactory()
    {
        return \Database\Factories\LeadFactory::new ();
    }
}
