<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AuthOtp extends Model
{
    protected $table = 'auth_otps';

    protected $fillable = [
        'identifier',
        'otp',
        'type',
        'channel',
        'expires_at',
        'verified_at',
        'attempts',
    ];

    protected $casts = [
        'expires_at'  => 'datetime',
        'verified_at' => 'datetime',
        'attempts'    => 'integer',
    ];

    /**
     * Generate and store a new 6-digit OTP with flood protection
     */
    public static function generate(string $identifier, string $type = 'register', string $channel = 'email', int $validMinutes = 10): string
    {
        $normalized = strtolower(trim($identifier));

        // Invalidate previous unverified OTPs for this identifier and type
        self::where('identifier', $normalized)
            ->where('type', $type)
            ->whereNull('verified_at')
            ->delete();

        // Generate cryptographically secure 6-digit numeric OTP
        $otp = (string) random_int(100000, 999999);

        self::create([
            'identifier' => $normalized,
            'otp'        => $otp,
            'type'       => $type,
            'channel'    => $channel,
            'attempts'   => 0,
            'expires_at' => Carbon::now()->addMinutes($validMinutes),
        ]);

        return $otp;
    }

    /**
     * Check and verify an OTP with brute-force attack prevention (max 5 attempts)
     */
    public static function checkAndVerify(string $identifier, string $otp, string $type = 'register'): array
    {
        $normalized = strtolower(trim($identifier));
        $cleanOtp   = trim($otp);

        $record = self::where('identifier', $normalized)
            ->where('type', $type)
            ->whereNull('verified_at')
            ->latest()
            ->first();

        if (!$record) {
            return [
                'valid'   => false,
                'message' => 'No active verification code found for this email. Please request a new code.',
            ];
        }

        if (Carbon::now()->isAfter($record->expires_at)) {
            return [
                'valid'   => false,
                'message' => 'Verification code has expired. Please click "Resend Code".',
            ];
        }

        // Brute-force protection: Max 5 attempts
        if ($record->attempts >= 5) {
            $record->delete(); // Invalidate burned OTP
            return [
                'valid'   => false,
                'message' => '⚠️ Too many incorrect attempts. This code has been invalidated for security. Please request a new code.',
            ];
        }

        if ($record->otp !== $cleanOtp) {
            $record->increment('attempts');
            $remaining = 5 - $record->attempts;
            
            if ($remaining <= 0) {
                $record->delete();
                return [
                    'valid'   => false,
                    'message' => '⚠️ Too many failed attempts. Code invalidated. Please request a new code.',
                ];
            }

            return [
                'valid'   => false,
                'message' => "Incorrect verification code ({$remaining} attempt(s) remaining). Please check your Gmail.",
            ];
        }

        $record->update([
            'verified_at' => Carbon::now(),
        ]);

        return [
            'valid'   => true,
            'message' => 'Email verified successfully! 🎉',
        ];
    }

    /**
     * Check if an identifier was verified recently (within last 30 minutes)
     */
    public static function isRecentlyVerified(string $identifier, string $type = 'register'): bool
    {
        $normalized = strtolower(trim($identifier));

        return self::where('identifier', $normalized)
            ->where('type', $type)
            ->whereNotNull('verified_at')
            ->where('verified_at', '>=', Carbon::now()->subMinutes(30))
            ->exists();
    }
}
