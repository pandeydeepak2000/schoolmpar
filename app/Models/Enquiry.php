<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    protected $fillable = [
        'school_id',
        'user_id',
        'parent_name',
        'mobile',
        'phone',
        'child_class',
        'message',
        'status',
    ];

    public function getPhoneAttribute()
    {
        return $this->attributes['mobile'] ?? null;
    }

    public function setPhoneAttribute($value)
    {
        $this->attributes['mobile'] = $value;
    }

    public function getIsBrochureRequestAttribute(): bool
    {
        $raw = strtolower((string)($this->child_class ?? '') . ' ' . (string)($this->message ?? ''));
        return str_contains($raw, 'brochure') || str_contains($raw, 'prospectus');
    }

    public function getFormattedClassAttribute(): string
    {
        if ($this->is_brochure_request) {
            return 'Brochure Request';
        }

        $class = trim((string)($this->child_class ?? ''));
        if (empty($class) || strtolower($class) === 'general admission') {
            return 'General Admission';
        }

        return str_starts_with(strtolower($class), 'class') ? $class : 'Class ' . $class;
    }

    public function getParentEmailAttribute(): ?string
    {
        return $this->user?->email;
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}