<?php

namespace App\Services;

use App\Models\SystemSetting;
use Illuminate\Support\Facades\Config;

class DynamicMailConfig
{
    public static function apply(): void
    {
        $mailer = SystemSetting::get('mail_mailer');
        if ($mailer) {
            Config::set('mail.default', $mailer);
        }

        $host = SystemSetting::get('mail_host');
        if ($host) {
            Config::set('mail.mailers.smtp.host', $host);
        }

        $port = SystemSetting::get('mail_port');
        if ($port) {
            Config::set('mail.mailers.smtp.port', (int)$port);
        }

        $username = SystemSetting::get('mail_username');
        if ($username) {
            Config::set('mail.mailers.smtp.username', $username);
        }

        $password = SystemSetting::get('mail_password');
        if ($password) {
            Config::set('mail.mailers.smtp.password', $password);
        }

        $encryption = SystemSetting::get('mail_encryption');
        if ($encryption) {
            Config::set('mail.mailers.smtp.encryption', $encryption === 'none' ? null : $encryption);
        }

        $fromAddress = SystemSetting::get('mail_from_address');
        if ($fromAddress) {
            Config::set('mail.from.address', $fromAddress);
        }

        $fromName = SystemSetting::get('mail_from_name');
        if ($fromName) {
            Config::set('mail.from.name', $fromName);
        }

        // Purge cached mailer instances so Laravel uses the new SMTP config
        try {
            if (class_exists(\Illuminate\Support\Facades\Mail::class)) {
                \Illuminate\Support\Facades\Mail::purge();
                \Illuminate\Support\Facades\Mail::purge('smtp');
            }
        } catch (\Throwable $e) {
            // Ignore during early bootstrap
        }
    }
}
