<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Admission extends Model
{
    protected $fillable = [
        'user_id',
        'school_id',
        'payment_id',
        'student_name',
        'student_dob',
        'student_gender',
        'class_applying',
        'parent_name',
        'parent_phone',
        'parent_email',
        'address',
        'previous_school',
        'previous_class',
        'previous_percentage',
        'document_path',
        'status',
        'rejection_reason',
    ];

    protected $casts = [
        'student_dob' => 'date',
        'previous_percentage' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

 public function payment()
{
    return $this->belongsTo(Payment::class, 'payment_id');
}

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isReviewing(): bool
    {
        return $this->status === 'reviewing';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function isWithdrawn(): bool
    {
        return $this->status === 'withdrawn';
    }

    public function statusBadge(): array
    {
        return match ($this->status) {
            'pending' => [
                'bg' => '#fef9c3',
                'color' => '#a16207',
                'text' => '⏳ Pending',
            ],
            'reviewing' => [
                'bg' => '#dbeafe',
                'color' => '#1d4ed8',
                'text' => '🔍 Reviewing',
            ],
            'approved' => [
                'bg' => '#dcfce7',
                'color' => '#15803d',
                'text' => '✅ Approved',
            ],
            'rejected' => [
                'bg' => '#fee2e2',
                'color' => '#dc2626',
                'text' => '❌ Rejected',
            ],
            'withdrawn' => [
                'bg' => '#f3f4f6',
                'color' => '#6b7280',
                'text' => '🗑️ Withdrawn',
            ],
            default => [
                'bg' => '#f3f4f6',
                'color' => '#6b7280',
                'text' => '— Unknown',
            ],
        };
    }
}