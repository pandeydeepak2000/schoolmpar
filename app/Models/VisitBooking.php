<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitBooking extends Model
{
    protected $fillable = [
        'user_id',
        'school_id',
        'visit_date',
        'visit_time',
        'visitor_name',
        'visitor_phone',
        'notes',
        'status',
        'cancel_reason',
    ];

    protected $casts = [
        'visit_date' => 'date',
    ];

    // ── Relations ──
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    // ── Status Helpers ──
    public function isPending()    { return $this->status === 'pending'; }
    public function isConfirmed()  { return $this->status === 'confirmed'; }
    public function isCancelled()  { return $this->status === 'cancelled'; }
    public function isCompleted()  { return $this->status === 'completed'; }
}