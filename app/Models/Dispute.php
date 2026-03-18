<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dispute extends Model
{
    use SoftDeletes, HasFactory;

    public const STATUS_VISIBLE = 'visible';
    public const STATUS_HIDDEN = 'hidden';

    public $table = 'disputes';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'moderated_at',
    ];

    protected $fillable = [
        'client_id',
        'agency_user_id',
        'dispute_category_id',
        'project_type',
        'dispute_type',
        'issue_description',
        'supporting_notes',
        'status',
        'moderated_by',
        'moderated_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function agency()
    {
        return $this->belongsTo(User::class, 'agency_user_id');
    }

    public function category()
    {
        return $this->belongsTo(DisputeCategory::class, 'dispute_category_id');
    }

    public function moderator()
    {
        return $this->belongsTo(User::class, 'moderated_by');
    }
}

