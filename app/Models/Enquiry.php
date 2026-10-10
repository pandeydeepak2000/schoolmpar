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
        'admin_notes',
    ];

    protected $casts = [
        'admin_notes' => 'array',
    ];

    public function getNotesListAttribute(): array
    {
        $raw = $this->admin_notes;
        if (empty($raw)) {
            return [];
        }
        if (is_string($raw)) {
            $decoded = json_decode($raw, true);
            return is_array($decoded) ? $decoded : [];
        }
        return is_array($raw) ? $raw : [];
    }

    public function addAdminNote(string $noteText, ?string $followupDate = null, ?string $author = null): array
    {
        $list = $this->notes_list;
        $newEntry = [
            'id'               => (string) \Illuminate\Support\Str::uuid(),
            'note'             => trim($noteText),
            'followup_date'    => $followupDate ?: null,
            'author'           => $author ?: (auth()->user()?->name ?? 'Admin'),
            'created_at'       => now()->format('Y-m-d H:i:s'),
            'created_at_human' => now()->format('d M Y, h:i A'),
        ];
        array_unshift($list, $newEntry); // newest first
        $this->admin_notes = $list;
        $this->save();
        return $newEntry;
    }


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