@extends('admin.layout')
@section('title', 'Platform Settings – Gateway & Mail Server')
@section('page-title', 'System & Integration Settings')
@section('page-sub', 'Configure Razorpay payment gateway parameters, email sender identity, and SMTP delivery servers')

@section('content')

@if(session('success'))
<div class="alert-success">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert-error">
    {{ session('error') }}
</div>
@endif

@if(isset($errors) && $errors->any())
<div class="alert-error">
    <ul style="margin:0; padding-left:16px;">
        @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
        @endforeach
    </ul>
</div>
@endif

<div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">

    {{-- SECTION 1: MAIL SERVER & SENDER IDENTITY --}}
    <div class="panel">
        <div class="panel-header">
            <div class="panel-title">
                <i class="fas fa-envelope-open-text" style="color:#0f2d59;"></i>
                Email Server & Sender Identity
            </div>
            <span style="font-size:11px; font-weight:800; background:#eff6ff; color:#2563eb; border:1px solid #bfdbfe; padding:2px 8px; border-radius:999px;">
                {{ $mailFromAddress }}
            </span>
        </div>

        <form action="{{ route('admin.settings.mail.update') }}" method="POST" style="padding:22px;">
            @csrf

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:14px;">
                <div>
                    <label style="font-size:12px; font-weight:700; color:#334155; display:block; margin-bottom:4px;">
                        Sender Email (From Address) *
                    </label>
                    <input type="email" name="mail_from_address" value="{{ old('mail_from_address', $mailFromAddress) }}" required
                           style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:8px 12px; font-size:13px; outline:none; box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:12px; font-weight:700; color:#334155; display:block; margin-bottom:4px;">
                        Sender Name (From Name) *
                    </label>
                    <input type="text" name="mail_from_name" value="{{ old('mail_from_name', $mailFromName) }}" required
                           style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:8px 12px; font-size:13px; outline:none; box-sizing:border-box;">
                </div>
            </div>

            <div style="margin-bottom:14px;">
                <label style="font-size:12px; font-weight:700; color:#334155; display:block; margin-bottom:4px;">
                    Admin Notification Email (Receives all lead alerts) *
                </label>
                <input type="email" name="admin_notification_email" value="{{ old('admin_notification_email', $adminAlertEmail) }}" required
                       style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:8px 12px; font-size:13px; outline:none; box-sizing:border-box;">
            </div>

            <div style="margin-bottom:14px;">
                <label style="font-size:12px; font-weight:700; color:#334155; display:block; margin-bottom:4px;">
                    Mail Driver *
                </label>
                <select name="mail_mailer" style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:8px 12px; font-size:13px; outline:none; box-sizing:border-box; background:#fff;">
                    <option value="smtp" {{ ($mailMailer === 'smtp' || empty($mailMailer)) ? 'selected' : '' }}>🌐 SMTP Server (Recommended for cPanel / Webmail / Gmail / Production)</option>
                    <option value="log" {{ $mailMailer === 'log' ? 'selected' : '' }}>📄 Log Driver (Local Testing - writes to storage/logs/laravel.log)</option>
                    <option value="sendmail" {{ $mailMailer === 'sendmail' ? 'selected' : '' }}>⚠️ Sendmail (CLI Only - Do NOT use on Shared cPanel)</option>
                </select>
                <div style="background:#eff6ff; border:1px solid #bfdbfe; border-radius:8px; padding:8px 12px; margin-top:8px; font-size:11.5px; color:#1e40af; line-height:1.45;">
                    <i class="fas fa-info-circle me-1"></i> <strong>cPanel Shared Hosting Note:</strong> Please select <strong>SMTP Server</strong> above. Shared hosting environments block background <code>sendmail</code> processes. Your SMTP Host (<code>{{ $mailHost ?: 'lu-shared02.cpanelplatform.com' }}</code>) and Port 465 (SSL) will only be used when <strong>SMTP Server</strong> is selected.
                </div>
            </div>

            <div style="display:grid; grid-template-columns:2fr 1fr; gap:12px; margin-bottom:14px;">
                <div>
                    <label style="font-size:12px; font-weight:700; color:#334155; display:block; margin-bottom:4px;">SMTP Host</label>
                    <input type="text" name="mail_host" value="{{ old('mail_host', $mailHost) }}" placeholder="e.g. smtp.gmail.com"
                           style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:8px 12px; font-size:13px; outline:none; box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:12px; font-weight:700; color:#334155; display:block; margin-bottom:4px;">Port</label>
                    <input type="text" name="mail_port" value="{{ old('mail_port', $mailPort) }}" placeholder="587 / 465"
                           style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:8px 12px; font-size:13px; outline:none; box-sizing:border-box;">
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:14px;">
                <div>
                    <label style="font-size:12px; font-weight:700; color:#334155; display:block; margin-bottom:4px;">SMTP Username</label>
                    <input type="text" name="mail_username" value="{{ old('mail_username', $mailUsername) }}" placeholder="Username / Email"
                           style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:8px 12px; font-size:13px; outline:none; box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:12px; font-weight:700; color:#334155; display:block; margin-bottom:4px;">SMTP Password</label>
                    <input type="password" name="mail_password" placeholder="Leave empty to keep existing"
                           style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:8px 12px; font-size:13px; outline:none; box-sizing:border-box;">
                </div>
            </div>

            <div style="margin-bottom:20px;">
                <label style="font-size:12px; font-weight:700; color:#334155; display:block; margin-bottom:4px;">Encryption</label>
                <select name="mail_encryption" style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:8px 12px; font-size:13px; outline:none; box-sizing:border-box; background:#fff;">
                    <option value="tls" {{ $mailEncryption === 'tls' ? 'selected' : '' }}>TLS (Recommended for Port 587)</option>
                    <option value="ssl" {{ $mailEncryption === 'ssl' ? 'selected' : '' }}>SSL (Recommended for Port 465)</option>
                    <option value="none" {{ $mailEncryption === 'none' ? 'selected' : '' }}>None</option>
                </select>
            </div>

            <button type="submit" style="background:#0f2d59; color:#fff; border:none; border-radius:8px; padding:10px 24px; font-weight:800; font-size:13.5px; cursor:pointer;">
                💾 Save Mail Settings
            </button>
        </form>

        {{-- Test Email Form --}}
        <div style="border-top:1.5px solid #f1f5f9; padding:18px 22px; background:#f8fafc;">
            <strong style="font-size:12.5px; color:#0f2d59; display:block; margin-bottom:6px;">
                🧪 Test Mail Server Delivery
            </strong>
            <form action="{{ route('admin.settings.mail.test') }}" method="POST" style="display:flex; gap:10px;">
                @csrf
                <input type="email" name="test_email" required placeholder="Enter recipient email address..."
                       style="flex:1; border:1.5px solid #cbd5e1; border-radius:8px; padding:8px 12px; font-size:13px; outline:none; background:#fff;">
                <button type="submit" style="background:#059669; color:#fff; border:none; border-radius:8px; padding:8px 18px; font-weight:800; font-size:12.5px; cursor:pointer; white-space:nowrap;">
                    🚀 Send Test Email
                </button>
            </form>
        </div>
    </div>

    {{-- SECTION 2: RAZORPAY PAYMENT GATEWAY --}}
    <div class="panel">
        <div class="panel-header">
            <div class="panel-title">
                <i class="fas fa-credit-card" style="color:#0f2d59;"></i>
                Razorpay Payment Gateway
            </div>
            <span style="font-size:11.5px; font-weight:800; background:{{ $mode === 'live' ? '#ecfdf5' : '#fffbeb' }}; color:{{ $mode === 'live' ? '#059669' : '#d97706' }}; border:1px solid {{ $mode === 'live' ? '#a7f3d0' : '#fde68a' }}; padding:3px 10px; border-radius:999px; text-transform:uppercase;">
                ● {{ $mode }} Mode Active
            </span>
        </div>

        <form action="{{ route('admin.settings.payments.update') }}" method="POST" style="padding:22px;">
            @csrf

            {{-- Mode Selector --}}
            <div style="margin-bottom:18px;">
                <label style="font-size:12px; font-weight:700; color:#334155; display:block; margin-bottom:6px;">
                    Gateway Environment Mode *
                </label>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                    <label style="display:flex; align-items:center; gap:10px; border:1.5px solid {{ $mode === 'test' ? '#3b82f6' : '#e2e8f0' }}; background:{{ $mode === 'test' ? '#eff6ff' : '#fff' }}; border-radius:10px; padding:12px; cursor:pointer;">
                        <input type="radio" name="razorpay_mode" value="test" {{ $mode === 'test' ? 'checked' : '' }} style="accent-color:#2563eb;">
                        <div>
                            <strong style="font-size:13px; color:#1e293b; display:block;">🟡 Sandbox / Test</strong>
                            <span style="font-size:11px; color:#64748b;">rzp_test_...</span>
                        </div>
                    </label>

                    <label style="display:flex; align-items:center; gap:10px; border:1.5px solid {{ $mode === 'live' ? '#10b981' : '#e2e8f0' }}; background:{{ $mode === 'live' ? '#ecfdf5' : '#fff' }}; border-radius:10px; padding:12px; cursor:pointer;">
                        <input type="radio" name="razorpay_mode" value="live" {{ $mode === 'live' ? 'checked' : '' }} style="accent-color:#10b981;">
                        <div>
                            <strong style="font-size:13px; color:#1e293b; display:block;">🟢 Production / Live</strong>
                            <span style="font-size:11px; color:#64748b;">rzp_live_...</span>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Key ID --}}
            <div style="margin-bottom:14px;">
                <label style="font-size:12px; font-weight:700; color:#334155; display:block; margin-bottom:4px;">
                    Razorpay Key ID (Client Key) *
                </label>
                <input type="text" name="razorpay_key" value="{{ old('razorpay_key', $keyId) }}" required
                       placeholder="rzp_test_... or rzp_live_..."
                       style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:8px 12px; font-size:13px; outline:none; box-sizing:border-box; font-family:monospace;">
            </div>

            {{-- Key Secret --}}
            <div style="margin-bottom:14px;">
                <label style="font-size:12px; font-weight:700; color:#334155; display:block; margin-bottom:4px;">
                    Razorpay Key Secret (Server Secret) *
                </label>
                <input type="password" name="razorpay_secret" value="{{ old('razorpay_secret', $keySecret) }}" required
                       placeholder="Enter secret key..."
                       style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:8px 12px; font-size:13px; outline:none; box-sizing:border-box;">
            </div>

            {{-- Currency --}}
            <div style="margin-bottom:20px;">
                <label style="font-size:12px; font-weight:700; color:#334155; display:block; margin-bottom:4px;">
                    Default Currency
                </label>
                <input type="text" name="payment_currency" value="{{ old('payment_currency', $currency) }}" readonly
                       style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:8px 12px; font-size:13px; background:#f8fafc; color:#64748b; outline:none; box-sizing:border-box;">
            </div>

            <button type="submit" style="background:#0f2d59; color:#fff; border:none; border-radius:8px; padding:10px 24px; font-weight:800; font-size:13.5px; cursor:pointer;">
                💾 Save Gateway Settings
            </button>
        </form>

        <div style="border-top:1.5px solid #f1f5f9; padding:18px 22px; background:#f8fafc;">
            <strong style="font-size:12px; color:#1e40af; display:block; margin-bottom:4px;">
                🔒 Payment Security & Encryption
            </strong>
            <p style="font-size:11.5px; color:#64748b; margin:0; line-height:1.5;">
                All credentials are saved securely in the system registry. When switched to Live mode, parents will make real payments for tokens and admissions.
            </p>
        </div>
    </div>

</div>

{{-- SECTION 3: GOOGLE reCAPTCHA (ANTI-BOT PROTECTION) --}}
<div class="panel" style="margin-top:20px;">
    <div class="panel-header">
        <div class="panel-title">
            <i class="fas fa-robot" style="color:#0f2d59;"></i>
            Google reCAPTCHA v2 (Anti-Bot & Brute Force Defense)
        </div>
        <span style="font-size:11.5px; font-weight:800; background:{{ $recaptchaEnabled ? '#ecfdf5' : '#f1f5f9' }}; color:{{ $recaptchaEnabled ? '#059669' : '#64748b' }}; border:1px solid {{ $recaptchaEnabled ? '#a7f3d0' : '#e2e8f0' }}; padding:3px 10px; border-radius:999px;">
            ● {{ $recaptchaEnabled ? 'ACTIVE & PROTECTING' : 'DISABLED' }}
        </span>
    </div>

    <form action="{{ route('admin.settings.recaptcha.update') }}" method="POST" style="padding:22px;">
        @csrf

        <div style="margin-bottom:18px;">
            <label style="display:flex; align-items:center; gap:10px; cursor:pointer; background:#f8fafc; border:1.5px solid #e2e8f0; border-radius:10px; padding:14px 18px;">
                <input type="checkbox" name="recaptcha_enabled" value="1" {{ $recaptchaEnabled ? 'checked' : '' }} style="width:18px; height:18px; accent-color:#0f2d59;">
                <div>
                    <strong style="font-size:13.5px; color:#1e293b; display:block;">Enable Google reCAPTCHA on Login & Registration</strong>
                    <span style="font-size:12px; color:#64748b;">Prevents automated scripts, dictionary attacks, and credential stuffing on admission forms.</span>
                </div>
            </label>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:18px;">
            <div>
                <label style="font-size:12px; font-weight:700; color:#334155; display:block; margin-bottom:4px;">
                    Google reCAPTCHA Site Key (Client Key)
                </label>
                <input type="text" name="recaptcha_site_key" value="{{ old('recaptcha_site_key', $recaptchaSiteKey) }}"
                       placeholder="6Ld... (Leave empty to use .env)"
                       style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:8px 12px; font-size:13px; outline:none; box-sizing:border-box; font-family:monospace;">
            </div>
            <div>
                <label style="font-size:12px; font-weight:700; color:#334155; display:block; margin-bottom:4px;">
                    Google reCAPTCHA Secret Key (Server Secret)
                </label>
                <input type="password" name="recaptcha_secret_key" value="{{ old('recaptcha_secret_key', $recaptchaSecretKey) }}"
                       placeholder="6Ld... (Leave empty to use .env)"
                       style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:8px 12px; font-size:13px; outline:none; box-sizing:border-box;">
            </div>
        </div>

        <button type="submit" style="background:#0f2d59; color:#fff; border:none; border-radius:8px; padding:10px 24px; font-weight:800; font-size:13.5px; cursor:pointer;">
            💾 Save Captcha Security Settings
        </button>
    </form>
</div>

@endsection
