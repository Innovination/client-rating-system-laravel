<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use SoftDeletes, Notifiable, Auditable, HasFactory, HasApiTokens;

    public const ROLE_ADMIN = 'admin';
    public const ROLE_AGENCY = 'agency';

    public const STATUS_ACTIVE = 'active';
    public const STATUS_SUSPENDED = 'suspended';

    public $table = 'users';

    protected $hidden = [
        'remember_token',
        'password',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'mobile',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'user_type',
        'role',
        'status',
        'verification_status',
        'company_name',
        'profile_picture',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'verification_status' => 'boolean',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getIsAdminAttribute()
    {
        return $this->role === self::ROLE_ADMIN
            || $this->user_type === self::ROLE_ADMIN
            || $this->roles()->where('id', 1)->exists()
            || $this->roles()->whereIn('title', ['Admin', 'admin'])->exists();
    }

    public function getIsSuspendedAttribute(): bool
    {
        return $this->status === self::STATUS_SUSPENDED;
    }

    public static function boot()
    {
        parent::boot();
        self::observe(new \App\Observers\UserActionObserver);
    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    // === Relationships ===

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'client_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'client_id');
    }

    public function clients()
    {
        return $this->hasMany(Client::class, 'created_by');
    }

    public function agencyProfile()
    {
        return $this->hasOne(AgencyProfile::class);
    }

    public function reportedDisputes()
    {
        return $this->hasMany(Dispute::class, 'agency_user_id');
    }

    public function submittedFeedback()
    {
        return $this->hasMany(ClientFeedback::class, 'agency_user_id');
    }

    public function hasRole($role)
    {
        return in_array($role, $this->roles->pluck('title')->toArray());
    }
}
