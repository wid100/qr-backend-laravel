<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail

{

    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'image',
        'city',
        'country',
        'phone',
        'address',
        'country_code',
        'gender',
        'password',
        'email_verified_at',
        'verify_code',
        'verify_code_expires_at',
        'role',
    ];
    public function subscriptions()
    {
        return $this->hasMany(\App\Models\Subscription::class);
    }

    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verify_code',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'verify_code_expires_at' => 'datetime',
        'role' => 'string',
    ];

    public function sendEmailVerificationNotification()
    {
        app(\App\Services\EmailVerificationCodeService::class)->sendVerificationEmail(
            $this,
            'Smart Card Generator'
        );
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function scheduleAreas()
    {
        return $this->hasMany(ScheduleArea::class);
    }

    // Health Card System Relationships
    public function healthCards()
    {
        return $this->hasMany(\App\Modules\HealthCard\Models\HealthCard::class);
    }

    public function patient()
    {
        return $this->hasOne(Patient::class);
    }

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    // Helper methods
    public function isPatient(): bool
    {
        return $this->role === 'patient';
    }

    public function isDoctor(): bool
    {
        return $this->role === 'doctor';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
