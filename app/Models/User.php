<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'google_id', 'avatar',
        'two_factor_enabled', 'two_factor_code', 'two_factor_expires_at',
    ];

    protected $hidden = [
        'password', 'remember_token', 'two_factor_code',
    ];

    protected $casts = [
        'email_verified_at'   => 'datetime',
        'password'            => 'hashed',
        'two_factor_enabled'  => 'boolean',
        'two_factor_expires_at' => 'datetime',
    ];

    // ── Role Helpers ────────────────────────────────
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isSchoolOwner(): bool
    {
        return $this->hasRole('school_owner');
    }

    // ── Existing Relations ──────────────────────────
    public function schools()
    {
        return $this->hasMany(School::class, 'owner_id');
    }

    public function savedSchools()
    {
        return $this->hasMany(SavedSchool::class);
    }

    public function enquiries()
    {
        return $this->hasMany(Enquiry::class);
    }

    // ── New Relations ───────────────────────────────
    public function visitBookings()
    {
        return $this->hasMany(VisitBooking::class);
    }

    public function admissions()
    {
        return $this->hasMany(Admission::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}