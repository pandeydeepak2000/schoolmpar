<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use App\Services\DynamicMailConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SettingsController extends Controller
{
    public function index()
    {
        // Razorpay Gateway
        $mode       = SystemSetting::get('razorpay_mode', config('services.razorpay.mode', 'test'));
        $keyId      = SystemSetting::get('razorpay_key', config('services.razorpay.key', ''));
        $keySecret  = SystemSetting::get('razorpay_secret', config('services.razorpay.secret', ''));
        $currency   = SystemSetting::get('payment_currency', 'INR');

        // Mail Server Settings
        $mailMailer       = SystemSetting::get('mail_mailer', config('mail.default', 'log'));
        $mailHost         = SystemSetting::get('mail_host', config('mail.mailers.smtp.host', '127.0.0.1'));
        $mailPort         = SystemSetting::get('mail_port', config('mail.mailers.smtp.port', '2525'));
        $mailUsername     = SystemSetting::get('mail_username', config('mail.mailers.smtp.username', ''));
        $mailPassword     = SystemSetting::get('mail_password', config('mail.mailers.smtp.password', ''));
        $mailEncryption   = SystemSetting::get('mail_encryption', config('mail.mailers.smtp.encryption', 'tls'));
        $mailFromAddress  = SystemSetting::get('mail_from_address', config('mail.from.address', 'support@schoolmapr.com'));
        $mailFromName     = SystemSetting::get('mail_from_name', config('mail.from.name', 'SchoolMapr Support'));
        $adminAlertEmail  = SystemSetting::get('admin_notification_email', 'admin@schoolmapr.com');

        // Google reCAPTCHA
        $recaptchaEnabled   = SystemSetting::get('recaptcha_enabled', config('services.recaptcha.enabled', false));
        $recaptchaSiteKey   = SystemSetting::get('recaptcha_site_key', config('services.recaptcha.site_key', ''));
        $recaptchaSecretKey = SystemSetting::get('recaptcha_secret_key', config('services.recaptcha.secret_key', ''));

        return view('admin.settings', compact(
            'mode', 'keyId', 'keySecret', 'currency',
            'mailMailer', 'mailHost', 'mailPort', 'mailUsername', 'mailPassword',
            'mailEncryption', 'mailFromAddress', 'mailFromName', 'adminAlertEmail',
            'recaptchaEnabled', 'recaptchaSiteKey', 'recaptchaSecretKey'
        ));
    }

    public function updateRecaptcha(Request $request)
    {
        if ($request->isMethod('get')) {
            return redirect()->route('admin.settings');
        }

        $enabled = $request->boolean('recaptcha_enabled');

        SystemSetting::set('recaptcha_enabled', $enabled ? '1' : '0');
        if ($request->filled('recaptcha_site_key')) {
            SystemSetting::set('recaptcha_site_key', trim($request->recaptcha_site_key));
        }
        if ($request->filled('recaptcha_secret_key')) {
            SystemSetting::set('recaptcha_secret_key', trim($request->recaptcha_secret_key));
        }

        $msg = $enabled 
            ? '✅ Google reCAPTCHA anti-bot protection has been ENABLED for login & register forms!'
            : '✅ Google reCAPTCHA is currently DISABLED.';

        return redirect()->route('admin.settings')->with('success', $msg);
    }

    public function updatePayments(Request $request)
    {
        if ($request->isMethod('get')) {
            return redirect()->route('admin.settings');
        }

        $request->validate([
            'razorpay_mode'   => 'required|in:test,live',
            'razorpay_key'    => 'required|string|max:255',
            'razorpay_secret' => 'required|string|max:255',
        ]);

        SystemSetting::set('razorpay_mode', $request->razorpay_mode);
        SystemSetting::set('razorpay_key', trim($request->razorpay_key));
        SystemSetting::set('razorpay_secret', trim($request->razorpay_secret));
        SystemSetting::set('payment_currency', $request->payment_currency ?? 'INR');

        return redirect()->route('admin.settings')->with('success', '✅ Razorpay Gateway settings updated successfully! Platform is operating in ' . strtoupper($request->razorpay_mode) . ' mode.');
    }

    public function updateMail(Request $request)
    {
        if ($request->isMethod('get')) {
            return redirect()->route('admin.settings');
        }

        $request->validate([
            'mail_mailer'              => 'required|string|in:smtp,log,sendmail',
            'mail_from_address'        => 'required|email|max:255',
            'mail_from_name'           => 'required|string|max:255',
            'admin_notification_email' => 'required|email|max:255',
        ]);

        SystemSetting::set('mail_mailer', $request->mail_mailer);
        SystemSetting::set('mail_host', trim($request->mail_host ?? ''));
        SystemSetting::set('mail_port', trim($request->mail_port ?? '2525'));
        SystemSetting::set('mail_username', trim($request->mail_username ?? ''));
        if ($request->filled('mail_password')) {
            SystemSetting::set('mail_password', trim($request->mail_password));
        }
        SystemSetting::set('mail_encryption', trim($request->mail_encryption ?? 'tls'));
        SystemSetting::set('mail_from_address', trim($request->mail_from_address));
        SystemSetting::set('mail_from_name', trim($request->mail_from_name));
        SystemSetting::set('admin_notification_email', trim($request->admin_notification_email));

        return redirect()->route('admin.settings')->with('success', '✅ Mail server & sender settings saved successfully! All emails will be sent from ' . $request->mail_from_address);
    }

    public function sendTestMail(Request $request)
    {
        $request->validate([
            'test_email' => 'required|email',
        ]);

        try {
            DynamicMailConfig::apply();
            $fromAddress = config('mail.from.address', 'support@schoolmapr.com');
            $fromName    = config('mail.from.name', 'SchoolMapr Support');

            Mail::raw("Hello! This is a test email sent from SchoolMapr Support Desk to verify your mail server configuration. Everything is working properly.", function ($message) use ($request, $fromAddress, $fromName) {
                $message->to($request->test_email)
                        ->from($fromAddress, $fromName)
                        ->subject('SchoolMapr Mail Server Verification');
            });

            return back()->with('success', '🎉 Test email sent successfully to ' . $request->test_email . ' from ' . $fromAddress . '!');
        } catch (\Throwable $e) {
            $errorMsg = $e->getMessage();
            if (str_contains(strtolower($errorMsg), 'sendmail')) {
                $errorMsg .= ' (Tip: On cPanel hosting, select "SMTP Server" as Mail Driver instead of "Sendmail", enter your password and click Save Mail Settings).';
            }
            return back()->with('error', '❌ Mail delivery failed: ' . $errorMsg);
        }
    }
}
