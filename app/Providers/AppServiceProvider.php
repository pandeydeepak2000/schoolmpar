<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Schema::defaultStringLength(191);

        Paginator::useBootstrapFive();

        // ── Dynamic Mail Configuration from Database ────────────
        try {
            \App\Services\DynamicMailConfig::apply();
        } catch (\Throwable $e) {
            // Silently pass during early setup or migrations
        }

        // ── Security Rate Limiters ─────────────────────────────

        // 1. OTP Flood Protection (Max 5 requests per minute per email/IP)
        RateLimiter::for('otp', function (Request $request) {
            $identifier = $request->input('email') ? strtolower(trim($request->input('email'))) : $request->ip();
            return Limit::perMinute(5)->by($identifier)->response(function () {
                return response()->json([
                    'success' => false,
                    'message' => '⚠️ Too many OTP requests. Please wait 1 minute before requesting another code.',
                ], 429);
            });
        });

        // 2. Login Brute Force Protection (Max 5 attempts per minute)
        RateLimiter::for('login', function (Request $request) {
            $identifier = $request->input('email') ? strtolower(trim($request->input('email'))) : $request->ip();
            return Limit::perMinute(5)->by($identifier);
        });

        // 3. Register Flood Protection (Max 5 attempts per minute)
        RateLimiter::for('register', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        // 4. Enquiry Spam Protection (Max 15 enquiries per hour per IP)
        RateLimiter::for('enquiry', function (Request $request) {
            return Limit::perHour(15)->by($request->ip());
        });
    }
}