<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisputeCategory extends Model
{
    use HasFactory;

    public $table = 'dispute_categories';

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $fillable = [
        'name',
        'slug',
        'is_active',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function disputes()
    {
        return $this->hasMany(Dispute::class, 'dispute_category_id');
    }
}

