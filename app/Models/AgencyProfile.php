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
        'alternate_phone',
        'whatsapp_number',
        'website',
        'address',
        'city',
        'country',
        'country_id',
        'state_id',
        'city_id',
        'pin_code',
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

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function cityRelation()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}

