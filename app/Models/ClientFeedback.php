<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientFeedback extends Model
{
    use SoftDeletes, HasFactory;

    public const STATUS_VISIBLE = 'visible';
    public const STATUS_HIDDEN = 'hidden';

    public $table = 'client_feedback';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'moderated_at',
    ];

    protected $fillable = [
        'client_id',
        'agency_user_id',
        'rating',
        'feedback_text',
        'status',
        'moderated_by',
        'moderated_at',
    ];

    protected $casts = [
        'rating' => 'integer',
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

    public function moderator()
    {
        return $this->belongsTo(User::class, 'moderated_by');
    }
}

