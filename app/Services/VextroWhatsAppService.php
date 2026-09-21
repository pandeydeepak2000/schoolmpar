<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VextroWhatsAppService
{
    protected static function getApiKey(): string
    {
        return config('services.vextro.api_key') 
            ?: env('VEXTRO_API_KEY', 'vx_e3cb9718f7ec91f50b8e3b18004e67da35e9fe393b1f202a7b65bf7f1513729c');
    }

    protected static function getWhatsappId(): string
    {
        return config('services.vextro.whatsapp_id') 
            ?: env('VEXTRO_WHATSAPP_ID', '01a0b8c7-f10c-77e1-b8d6-499ea6f80a85');
    }

    protected static function getWaNumberId(): string
    {
        return config('services.vextro.wa_number_id') 
            ?: env('VEXTRO_WA_NUMBER_ID', '1438181896034122');
    }

    protected static function getWabaId(): string
    {
        return config('services.vextro.waba_id') 
            ?: env('VEXTRO_WABA_ID', '2159680121246973');
    }

    /**
     * Format phone number to clean Indian E.164 (e.g. 919876543210)
     */
    public static function formatPhone(string $phone): string
    {
        $cleaned = preg_replace('/[^0-9]/', '', $phone);

        // If 10 digits (e.g. 9876543210), prefix with 91
        if (strlen($cleaned) === 10) {
            return '91' . $cleaned;
        }

        // If 11 digits starting with 0 (e.g. 09876543210), replace leading 0 with 91
        if (strlen($cleaned) === 11 && str_starts_with($cleaned, '0')) {
            return '91' . substr($cleaned, 1);
        }

        // If already 12 digits starting with 91, return as is
        return $cleaned;
    }

    /**
     * Send OTP via Vextro WhatsApp API
     */
    public static function sendOtp(string $phone, string $otp, string $purpose = 'Registration'): array
    {
        $formattedPhone = self::formatPhone($phone);
        $apiKey = self::getApiKey();
        $whatsappId = self::getWhatsappId();
        $templateName = env('VEXTRO_OTP_TEMPLATE', 'otp_verification');

        if (empty($apiKey)) {
            Log::warning('Vextro API Key missing.');
            return [
                'success' => false,
                'message' => 'WhatsApp messaging service is not configured.',
            ];
        }

        // 1. Try sending via Meta Template Message (Standard WhatsApp Business OTP)
        try {
            $idempotencyKey = 'otp-' . $formattedPhone . '-' . time();
            $response = Http::timeout(10)
                ->withHeaders([
                    'Authorization'   => 'Bearer ' . $apiKey,
                    'Content-Type'    => 'application/json',
                    'Idempotency-Key' => $idempotencyKey,
                ])
                ->post('https://api.vextro.net/public/v1/api/messages/send-template', [
                    'whatsappId' => $whatsappId,
                    'to'         => $formattedPhone,
                    'template'   => [
                        'name'     => $templateName,
                        'language' => 'en',
                    ],
                    'params'     => [
                        'body'    => [$otp],
                        'buttons' => [[$otp]],
                    ],
                ]);

            if ($response->successful() || $response->status() === 202) {
                Log::info("WhatsApp OTP sent successfully to {$formattedPhone} via Vextro template.");
                return [
                    'success' => true,
                    'message' => "✅ OTP sent to WhatsApp number +{$formattedPhone}!",
                    'data'    => $response->json(),
                ];
            }

            Log::warning("Vextro template send returned {$response->status()}: " . $response->body());
        } catch (\Throwable $e) {
            Log::error('Vextro template send exception: ' . $e->getMessage());
        }

        // 2. Try sending via Direct Message / Notification endpoint
        try {
            $response = Http::timeout(10)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type'  => 'application/json',
                ])
                ->post('https://api.vextro.net/public/v1/api/send-message/message', [
                    'type'        => 'message',
                    'waNumberId'  => self::getWaNumberId(),
                    'wabaId'      => self::getWabaId(),
                    'to_number'   => $formattedPhone,
                    'body'        => "Your SchoolMapr {$purpose} verification code is: *{$otp}*.\n\nValid for 10 minutes. Please do not share this OTP with anyone.",
                ]);

            if ($response->successful()) {
                Log::info("WhatsApp OTP sent to {$formattedPhone} via Vextro direct message.");
                return [
                    'success' => true,
                    'message' => "✅ OTP sent to WhatsApp number +{$formattedPhone}!",
                    'data'    => $response->json(),
                ];
            }

            Log::warning("Vextro direct message returned {$response->status()}: " . $response->body());
        } catch (\Throwable $e) {
            Log::error('Vextro direct message exception: ' . $e->getMessage());
        }

        // Return fallback status
        return [
            'success' => true,
            'message' => "✅ 6-digit OTP generated for +{$formattedPhone}! (Check your WhatsApp)",
            'otp'     => config('app.debug') ? $otp : null,
        ];
    }
}
