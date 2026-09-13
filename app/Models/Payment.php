<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'school_id',
        'razorpay_order_id',
        'razorpay_payment_id',
        'razorpay_signature',
        'amount',
        'type',
        'status',
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

    public function admission()
    {
        return $this->hasOne(Admission::class);
    }

    // ── Status Helpers ──
    public function isSuccess()  { return $this->status === 'success'; }
    public function isPending()  { return $this->status === 'pending'; }
    public function isFailed()   { return $this->status === 'failed'; }
}