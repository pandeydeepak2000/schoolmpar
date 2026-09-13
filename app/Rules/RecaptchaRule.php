<?php

namespace App\Rules;

use App\Models\SystemSetting;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class RecaptchaRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $enabled = SystemSetting::get('recaptcha_enabled', config('services.recaptcha.enabled', false));
        if (!$enabled || $enabled === '0' || $enabled === false) {
            return; // Captcha is disabled, bypass validation
        }

        $secret = SystemSetting::get('recaptcha_secret_key', config('services.recaptcha.secret_key'));
        if (!$secret) {
            return; // No secret key configured, bypass
        }

        if (empty($value)) {
            $fail('Please complete the security captcha verification to proceed.');
            return;
        }

        try {
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret'   => $secret,
                'response' => $value,
                'remoteip' => request()->ip(),
            ]);

            if (!$response->successful() || !$response->json('success')) {
                $fail('Captcha verification failed. Please try again.');
            }
        } catch (\Throwable $e) {
            // Fail safely if connection to Google Captcha API timed out
        }
    }
}
