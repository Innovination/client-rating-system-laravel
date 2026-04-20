<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'clients';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'website',
        'phone',
        'address',
        'country_id',
        'state_id',
        'city_id',
        'location',
        'notes',
        'created_by',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
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

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function disputes(): HasMany
    {
        return $this->hasMany(Dispute::class);
    }

    public function feedback(): HasMany
    {
        return $this->hasMany(ClientFeedback::class, 'client_id');
    }

    public function visibleDisputes(): HasMany
    {
        return $this->disputes()->where('status', Dispute::STATUS_VISIBLE);
    }

    public function visibleFeedback(): HasMany
    {
        return $this->feedback()->where('status', ClientFeedback::STATUS_VISIBLE);
    }
}
