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
     * Fetch approved templates from Vextro (cached for 2 minutes)
     */
    public static function getApprovedTemplate(): ?array
    {
        $apiKey = self::getApiKey();
        $waNumberId = self::getWaNumberId();
        $wabaId = self::getWabaId();

        if (empty($apiKey) || empty($waNumberId) || empty($wabaId)) {
            return null;
        }

        try {
            return \Illuminate\Support\Facades\Cache::remember('vextro_approved_otp_template', 120, function () use ($apiKey, $waNumberId, $wabaId) {
                $response = Http::timeout(6)
                    ->withHeaders([
                        'Authorization' => 'Bearer ' . $apiKey,
                        'Content-Type'  => 'application/json',
                    ])
                    ->post('https://api.vextro.net/public/v1/api/sync-templates', [
                        'waNumberId' => $waNumberId,
                        'wabaId'     => $wabaId,
                    ]);

                if ($response->successful()) {
                    $data = $response->json();
                    $templates = $data['templates'] ?? [];

                    foreach ($templates as $tmpl) {
                        if (($tmpl['status'] ?? '') === 'APPROVED') {
                            return [
                                'name'       => $tmpl['name'],
                                'language'   => $tmpl['language'] ?? 'en_US',
                                'components' => $tmpl['components'] ?? [],
                            ];
                        }
                    }
                }
                return null;
            });
        } catch (\Throwable $e) {
            Log::warning('Error fetching Vextro templates: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Send OTP via Vextro WhatsApp API
     */
    public static function sendOtp(string $phone, string $otp, string $purpose = 'Registration'): array
    {
        $formattedPhone = self::formatPhone($phone);
        $apiKey = self::getApiKey();
        $whatsappId = self::getWhatsappId();

        if (empty($apiKey) || empty($whatsappId)) {
            Log::warning('Vextro WhatsApp configuration missing.');
            return [
                'success'         => false,
                'suggest_email'   => true,
                'message'         => '⚠️ WhatsApp OTP service abhi configure nahi hai. Kripya Email OTP ka upyog karein.',
            ];
        }

        // Check for an approved template in Vextro / Meta
        $approvedTemplate = self::getApprovedTemplate();

        // Default template fallback if configured in env
        $templateName = $approvedTemplate['name'] ?? env('VEXTRO_OTP_TEMPLATE', 'otp');
        $templateLang = $approvedTemplate['language'] ?? 'en_US';

        // If we know all templates are rejected / not approved, inform user to use Email OTP
        if (!$approvedTemplate && !env('VEXTRO_FORCE_TEMPLATE')) {
            Log::warning("No APPROVED template found on Vextro. Current templates might be pending or rejected by Meta.");
            return [
                'success'         => false,
                'not_on_whatsapp' => true,
                'suggest_email'   => true,
                'message'         => '⚠️ WhatsApp OTP abhi deliver nahi ho sakta (Template Meta se approved nahi hai). Kripya Email OTP se verify karein.',
            ];
        }

        // Try sending via Meta Template Message (Standard WhatsApp Business OTP)
        try {
            $idempotencyKey = 'otp-' . $formattedPhone . '-' . time();
            $params = [
                'body' => [(string)$otp],
            ];

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
                        'language' => $templateLang,
                    ],
                    'params'     => $params,
                ]);

            if ($response->successful() || $response->status() === 202) {
                Log::info("WhatsApp OTP sent successfully to {$formattedPhone} via Vextro template.");
                return [
                    'success' => true,
                    'message' => "✅ 6-digit OTP sent to WhatsApp number (+{$formattedPhone})! Please check your WhatsApp messages.",
                    'data'    => $response->json(),
                ];
            }

            $body = $response->body();
            Log::warning("Vextro template send failed (Status {$response->status()}): " . $body);

            // Check if rejected/not on WhatsApp
            return [
                'success'         => false,
                'not_on_whatsapp' => true,
                'suggest_email'   => true,
                'message'         => '⚠️ Yeh number WhatsApp par active nahi hai ya WhatsApp OTP deliver nahi ho saka. Kripya Email OTP ka upyog karke verify karein.',
            ];
        } catch (\Throwable $e) {
            Log::error('Vextro template send exception: ' . $e->getMessage());

            return [
                'success'         => false,
                'not_on_whatsapp' => true,
                'suggest_email'   => true,
                'message'         => '⚠️ WhatsApp service temporarily unreachable. Kripya Email OTP ka upyog karein.',
            ];
        }
    }
}
