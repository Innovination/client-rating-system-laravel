<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgencyProfile extends Model
{
    use HasFactory;

    public $table = 'agency_profiles';

    protected $fillable = [
        'user_id',
        'company_name',
        'contact_person',
        'phone',
        'website',
        'address',
        'city',
        'country',
        'company_info',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

