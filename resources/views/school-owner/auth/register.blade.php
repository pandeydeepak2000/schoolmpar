<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register School Partner — SchoolMapr (schoolmapr.com)</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="alternate icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --navy: #0f2d59;
            --navy-dark: #0a1f3d;
            --yellow: #febb02;
            --bg: #f4f6fa;
            --border: #e2e8f0;
            --text-main: #0f172a;
            --text-muted: #64748b;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Inter', sans-serif; }
        body { min-height: 100vh; background: var(--bg); display: flex; flex-direction: column; color: var(--text-main); }

        /* HEADER */
        .sm-header {
            background: var(--navy);
            padding: 16px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
        .sm-brand {
            color: #fff;
            font-size: 22px;
            font-weight: 900;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            letter-spacing: -0.5px;
        }
        .sm-brand span { color: var(--yellow); }
        .sm-back {
            color: rgba(255,255,255,0.8);
            font-size: 13px;
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: color 0.2s;
        }
        .sm-back:hover { color: #fff; }

        /* WRAPPER */
        .auth-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 16px;
        }

        .auth-card {
            background: #ffffff;
            width: 100%;
            max-width: 540px;
            border-radius: 16px;
            border: 1px solid var(--border);
            box-shadow: 0 12px 40px rgba(15, 45, 89, 0.08);
            padding: 36px 32px;
        }

        .auth-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
            padding: 4px 10px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 700;
            margin-bottom: 14px;
        }
        .badge-free {
            background: #16a34a;
            color: #fff;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 9.5px;
            font-weight: 800;
            margin-left: 4px;
        }

        .auth-title {
            font-size: 24px;
            font-weight: 900;
            color: var(--navy);
            letter-spacing: -0.5px;
            margin-bottom: 6px;
        }
        .auth-sub {
            font-size: 13.5px;
            color: var(--text-muted);
            margin-bottom: 20px;
            line-height: 1.5;
        }

        /* BENEFITS BOX */
        .benefits-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 14px 16px;
            margin-bottom: 20px;
        }
        .benefits-title {
            font-size: 12px;
            font-weight: 800;
            color: var(--navy);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .benefits-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .benefits-list li {
            font-size: 12px;
            color: #475569;
            display: flex;
            align-items: flex-start;
            gap: 8px;
            line-height: 1.4;
        }
        .benefits-list li i {
            color: #16a34a;
            margin-top: 2px;
            font-size: 12px;
        }

        /* GOOGLE BUTTON */
        .btn-google {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            width: 100%;
            background: #ffffff;
            color: #1e293b;
            border: 1.5px solid #cbd5e1;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            margin-bottom: 18px;
        }
        .btn-google:hover {
            background: #f8fafc;
            border-color: #94a3b8;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
            color: #0f172a;
        }
        .btn-google svg { width: 18px; height: 18px; flex-shrink: 0; }

        /* DIVIDER */
        .divider {
            text-align: center;
            color: #94a3b8;
            font-size: 11px;
            font-weight: 700;
            margin: 18px 0;
            position: relative;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }
        .divider::before, .divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 32%;
            height: 1px;
            background: #e2e8f0;
        }
        .divider::before { left: 0; }
        .divider::after  { right: 0; }

        /* ALERTS */
        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            border-radius: 8px;
            padding: 12px 14px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .alert-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #166534;
            border-radius: 8px;
            padding: 12px 14px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* FORM */
        .form-group { margin-bottom: 16px; }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        @media (max-width: 480px) {
            .form-row { grid-template-columns: 1fr; gap: 0; }
        }

        .form-label {
            display: block;
            font-size: 12.5px;
            font-weight: 700;
            color: #334155;
            margin-bottom: 6px;
        }
        .form-input {
            width: 100%;
            border: 1.5px solid #cbd5e1;
            border-radius: 10px;
            padding: 11px 14px;
            font-size: 14px;
            outline: none;
            color: #0f172a;
            transition: all 0.2s;
            box-sizing: border-box;
        }
        .form-input:focus {
            border-color: var(--navy);
            box-shadow: 0 0 0 3.5px rgba(15, 45, 89, 0.12);
        }

        /* OTP SECTION STYLING */
        .verify-channel-selector {
            display: flex;
            gap: 10px;
            margin-bottom: 14px;
        }
        .channel-tab {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 12px;
            border: 1.5px solid #cbd5e1;
            border-radius: 10px;
            background: #ffffff;
            color: #475569;
            font-size: 12.5px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            user-select: none;
        }
        .channel-tab:hover {
            background: #f8fafc;
            border-color: #94a3b8;
        }
        .channel-tab.active {
            background: #eff6ff;
            border-color: #2563eb;
            color: #1d4ed8;
            box-shadow: 0 2px 8px rgba(37,99,235,0.12);
        }
        .channel-tab.active.whatsapp-tab {
            background: #f0fdf4;
            border-color: #16a34a;
            color: #15803d;
            box-shadow: 0 2px 8px rgba(22,163,74,0.12);
        }
        .otp-container {
            background: #f8fafc;
            border: 1.5px solid #cbd5e1;
            border-radius: 12px;
            padding: 16px;
            margin: 18px 0;
            transition: all 0.2s;
        }
        .otp-container.active {
            border-color: #3b82f6;
            background: #eff6ff;
        }
        .otp-input-group {
            display: flex;
            gap: 8px;
            align-items: center;
            margin-top: 10px;
        }
        .otp-code-input {
            flex: 1;
            font-family: monospace;
            font-size: 20px;
            font-weight: 800;
            letter-spacing: 6px;
            text-align: center;
            padding: 10px 14px;
            border: 2px solid #3b82f6;
            border-radius: 10px;
            outline: none;
            background: #fff;
            color: #0f2d59;
        }
        .btn-otp-action {
            background: var(--navy);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 16px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.15s;
        }
        .btn-otp-action:hover {
            background: var(--navy-dark);
        }
        .btn-otp-action:disabled {
            background: #94a3b8;
            cursor: not-allowed;
        }

        .terms {
            font-size: 11.5px;
            color: #64748b;
            margin: 14px 0 18px;
            line-height: 1.5;
            text-align: center;
        }
        .terms a { color: #2563eb; text-decoration: none; font-weight: 600; }

        /* BUTTONS */
        .btn-auth {
            width: 100%;
            background: var(--navy);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 13px;
            font-weight: 800;
            font-size: 15px;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-auth:hover { background: var(--navy-dark); transform: translateY(-1px); }
        .btn-auth:disabled { background: #94a3b8; cursor: not-allowed; transform: none; }

        .signin-section {
            margin-top: 22px;
            padding-top: 18px;
            border-top: 1px solid var(--border);
            text-align: center;
        }
        .signin-text {
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 8px;
        }
        .btn-signin-link {
            color: var(--navy);
            font-size: 13.5px;
            font-weight: 700;
            text-decoration: none;
            transition: color 0.15s;
        }
        .btn-signin-link:hover { text-decoration: underline; }

        .auth-footer-note {
            margin-top: 20px;
            text-align: center;
            font-size: 11.5px;
            color: #94a3b8;
        }
    </style>
</head>
<body>

    <header class="sm-header">
        <a href="/" class="sm-brand">
            <i class="fa-solid fa-graduation-cap" style="color:var(--yellow);"></i> School<span>Mapr</span>
        </a>
        <a href="/" class="sm-back">
            <i class="fa-solid fa-arrow-left"></i> Back to Patna Schools
        </a>
    </header>

    <div class="auth-wrapper">
        <div class="auth-card">
            
            <div class="auth-badge">
                <i class="fa-solid fa-school"></i> School Partner Portal <span class="badge-free">100% Free</span>
            </div>
            
            <h1 class="auth-title">List Your School</h1>
            <p class="auth-sub">Create a verified administrator account to connect with thousands of active parents in Patna and manage admissions online.</p>

            <div class="benefits-box">
                <div class="benefits-title">
                    <i class="fas fa-shield-check"></i> Why Partner with SchoolMapr?
                </div>
                <ul class="benefits-list">
                    <li><i class="fas fa-circle-check"></i> Reach 50,000+ parents actively searching for schools in Patna.</li>
                    <li><i class="fas fa-circle-check"></i> Receive direct admission inquiries & schedule campus visits.</li>
                    <li><i class="fas fa-circle-check"></i> Claim, manage and update your official school profile anytime.</li>
                </ul>
            </div>

            <div id="dynamicErrorAlert" class="alert-error" style="display:none;"></div>
            <div id="dynamicSuccessAlert" class="alert-success" style="display:none;"></div>

            @if($errors->any())
            <div class="alert-error">
                <i class="fas fa-circle-exclamation"></i> {{ $errors->first() }}
            </div>
            @endif

            @if(session('success'))
            <div class="alert-success">
                <i class="fas fa-circle-check"></i> {{ session('success') }}
            </div>
            @endif

            {{-- GOOGLE SIGN IN FOR SCHOOL OWNER --}}
            <a href="{{ route('auth.google', ['role' => 'school_owner']) }}" class="btn-google">
                <svg viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                </svg>
                Continue with Google
            </a>

            <div class="divider">or register with official email</div>

            <form id="partnerRegisterForm" action="{{ route('school-owner.register.post') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label">Principal / Administrator Full Name <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="partnerName" name="name" class="form-input" placeholder="e.g. Dr. Rajesh Sharma" value="{{ old('name') }}" required autofocus>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Official Email Address <span style="color:#ef4444;">*</span></label>
                        <input type="email" id="partnerEmail" name="email" class="form-input" placeholder="e.g. principal@school.edu.in" value="{{ old('email') }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Contact / Mobile Number <span style="color:#ef4444;">*</span></label>
                        <input type="tel" id="partnerPhone" name="phone" class="form-input" placeholder="10-digit mobile number" value="{{ old('phone') }}" maxlength="10" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Password <span style="color:#ef4444;">*</span></label>
                        <input type="password" id="partnerPassword" name="password" class="form-input" placeholder="Min. 6 characters" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Confirm Password <span style="color:#ef4444;">*</span></label>
                        <input type="password" id="partnerPasswordConfirm" name="password_confirmation" class="form-input" placeholder="Repeat password" required>
                    </div>
                </div>

                {{-- OTP VERIFICATION CHANNEL SELECTOR --}}
                <input type="hidden" name="verify_channel" id="partnerVerifyChannel" value="email">

                <div class="otp-container" id="partnerOtpContainer">
                    <div style="font-size:12px; font-weight:700; color:#475569; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">
                        Choose Verification Method:
                    </div>

                    <div class="verify-channel-selector">
                        <div class="channel-tab active" id="partnerTabEmail" onclick="setPartnerVerificationChannel('email')">
                            <i class="fa-solid fa-envelope" style="color:#2563eb;"></i>
                            <span>Official Email OTP</span>
                        </div>
                        <div class="channel-tab whatsapp-tab" id="partnerTabWhatsapp" onclick="setPartnerVerificationChannel('whatsapp')">
                            <i class="fa-brands fa-whatsapp" style="color:#16a34a; font-size:16px;"></i>
                            <span>WhatsApp OTP</span>
                        </div>
                    </div>

                    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px; margin-top:12px;">
                        <div>
                            <div style="font-size:13px; font-weight:800; color:#0f2d59;" id="partnerOtpTitle">
                                <i class="fa-solid fa-shield-halved text-primary me-1"></i> Official Email Verification Code
                            </div>
                            <div style="font-size:11.5px; color:#64748b; margin-top:2px;" id="partnerOtpSubtitle">
                                A 6-digit OTP will be sent to your official email.
                            </div>
                        </div>

                        <button type="button" id="btnSendPartnerOtp" class="btn-otp-action" onclick="requestPartnerOtp()">
                            <i class="fa-solid fa-paper-plane"></i> <span id="btnSendPartnerOtpText">Get OTP</span>
                        </button>
                    </div>

                    <div id="partnerOtpInputRow" style="display:none; margin-top:14px;">
                        <label class="form-label" style="font-size:12px;">Enter 6-Digit Verification Code <span style="color:#ef4444;">*</span></label>
                        <div class="otp-input-group">
                            <input type="text" id="partnerOtp" name="otp" class="otp-code-input" placeholder="••••••" maxlength="6" autocomplete="one-time-code">
                        </div>
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-top:8px; font-size:11.5px;">
                            <span id="partnerOtpTimerText" style="color:#64748b;">⏱️ Code expires in 10 mins</span>
                            <a href="javascript:void(0)" id="btnResendPartnerOtp" onclick="requestPartnerOtp()" style="display:none; color:#2563eb; font-weight:700; text-decoration:none;">
                                🔄 Resend OTP
                            </a>
                        </div>
                    </div>
                </div>

                <p class="terms">
                    By registering your institution, you agree to SchoolMapr's 
                    <a href="{{ route('pages.terms') }}">Partner Terms</a> and <a href="{{ route('pages.privacy') }}">Privacy Policy</a>.
                </p>

                @php
                    $recaptchaEnabled = \App\Models\SystemSetting::get('recaptcha_enabled', config('services.recaptcha.enabled', false));
                    $recaptchaSiteKey = \App\Models\SystemSetting::get('recaptcha_site_key', config('services.recaptcha.site_key'));
                @endphp

                @if($recaptchaEnabled && $recaptchaSiteKey)
                    <div style="margin-bottom: 18px; display: flex; justify-content: center;">
                        <div class="g-recaptcha" data-sitekey="{{ $recaptchaSiteKey }}"></div>
                    </div>
                    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                @endif

                <button type="submit" id="btnSubmitPartnerForm" class="btn-auth">
                    <i class="fa-solid fa-school-flag"></i> Verify & Create Partner Account
                </button>
            </form>

            <div class="signin-section">
                <p class="signin-text">Already registered your school?</p>
                <a href="/login" class="btn-signin-link">
                    <i class="fa-solid fa-right-to-bracket me-1"></i> Sign In to Existing Account
                </a>
            </div>

            <div class="auth-footer-note">
                🔒 Verified Patna Educational Network • Partner Support: <strong style="color:var(--navy);">partner@schoolmapr.com</strong>
            </div>

        </div>
    </div>

    <script>
        let partnerCountdownInterval = null;
        let partnerActiveChannel = 'email';

        function setPartnerVerificationChannel(channel) {
            partnerActiveChannel = channel;
            document.getElementById('partnerVerifyChannel').value = channel;

            const tabEmail = document.getElementById('partnerTabEmail');
            const tabWhatsapp = document.getElementById('partnerTabWhatsapp');
            const titleEl = document.getElementById('partnerOtpTitle');
            const subEl = document.getElementById('partnerOtpSubtitle');
            const btnText = document.getElementById('btnSendPartnerOtpText');
            const phoneInput = document.getElementById('partnerPhone');

            if (channel === 'whatsapp') {
                tabEmail.classList.remove('active');
                tabWhatsapp.classList.add('active');
                titleEl.innerHTML = '<i class="fa-brands fa-whatsapp text-success me-1"></i> WhatsApp Verification Code';
                subEl.innerText = 'A 6-digit OTP will be sent directly to your administrator WhatsApp number.';
                btnText.innerText = 'Get WhatsApp OTP';
                phoneInput.focus();
            } else {
                tabWhatsapp.classList.remove('active');
                tabEmail.classList.add('active');
                titleEl.innerHTML = '<i class="fa-solid fa-shield-halved text-primary me-1"></i> Official Email Verification Code';
                subEl.innerText = 'A 6-digit OTP will be sent to your official email inbox.';
                btnText.innerText = 'Get Email OTP';
            }
        }

        function showPartnerError(msg) {
            const errEl = document.getElementById('dynamicErrorAlert');
            const succEl = document.getElementById('dynamicSuccessAlert');
            succEl.style.display = 'none';
            errEl.innerHTML = `<i class="fas fa-circle-exclamation"></i> ${msg}`;
            errEl.style.display = 'flex';
            errEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        function showPartnerSuccess(msg) {
            const errEl = document.getElementById('dynamicErrorAlert');
            const succEl = document.getElementById('dynamicSuccessAlert');
            errEl.style.display = 'none';
            succEl.innerHTML = `<i class="fas fa-circle-check"></i> ${msg}`;
            succEl.style.display = 'flex';
        }

        function hidePartnerAlerts() {
            document.getElementById('dynamicErrorAlert').style.display = 'none';
            document.getElementById('dynamicSuccessAlert').style.display = 'none';
        }

        async function requestPartnerOtp() {
            hidePartnerAlerts();
            const name = document.getElementById('partnerName').value.trim();
            const email = document.getElementById('partnerEmail').value.trim();
            const phone = document.getElementById('partnerPhone').value.trim();

            if (partnerActiveChannel === 'whatsapp') {
                if (!phone) {
                    showPartnerError('Please enter your 10-digit mobile number to receive the WhatsApp OTP.');
                    document.getElementById('partnerPhone').focus();
                    return;
                }
                const cleanedPhone = phone.replace(/[^0-9]/g, '');
                if (cleanedPhone.length < 10) {
                    showPartnerError('Please enter a valid 10-digit administrator WhatsApp mobile number.');
                    document.getElementById('partnerPhone').focus();
                    return;
                }
            } else {
                if (!email) {
                    showPartnerError('Please enter your official email address to receive the verification code.');
                    document.getElementById('partnerEmail').focus();
                    return;
                }

                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(email)) {
                    showPartnerError('Please enter a valid email address (e.g. principal@school.edu.in).');
                    document.getElementById('partnerEmail').focus();
                    return;
                }
            }

            const btn = document.getElementById('btnSendPartnerOtp');
            const btnText = document.getElementById('btnSendPartnerOtpText');
            btn.disabled = true;
            btnText.innerText = 'Sending OTP...';

            try {
                const response = await fetch("{{ route('auth.sendOtp') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        channel: partnerActiveChannel,
                        email: email,
                        name: name,
                        phone: phone,
                        type: 'register'
                    })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    showPartnerSuccess(data.message || 'Verification code sent successfully!');
                    document.getElementById('partnerOtpContainer').classList.add('active');
                    document.getElementById('partnerOtpInputRow').style.display = 'block';
                    document.getElementById('partnerOtp').focus();

                    startPartnerCooldownTimer(60);
                } else {
                    showPartnerError(data.message || 'Could not send verification code. Please check your details.');
                    btn.disabled = false;
                    btnText.innerText = partnerActiveChannel === 'whatsapp' ? 'Get WhatsApp OTP' : 'Get Email OTP';
                }
            } catch (err) {
                showPartnerError('Network error while requesting verification code. Please try again.');
                btn.disabled = false;
                btnText.innerText = partnerActiveChannel === 'whatsapp' ? 'Get WhatsApp OTP' : 'Get Email OTP';
            }
        }

        function startPartnerCooldownTimer(seconds) {
            const btn = document.getElementById('btnSendPartnerOtp');
            const btnText = document.getElementById('btnSendPartnerOtpText');
            const resendBtn = document.getElementById('btnResendPartnerOtp');
            const timerText = document.getElementById('partnerOtpTimerText');
            
            btn.style.display = 'none';
            resendBtn.style.display = 'none';

            let remaining = seconds;
            timerText.innerText = `⏱️ Resend code in ${remaining}s`;

            if (partnerCountdownInterval) clearInterval(partnerCountdownInterval);

            partnerCountdownInterval = setInterval(() => {
                remaining--;
                if (remaining <= 0) {
                    clearInterval(partnerCountdownInterval);
                    timerText.innerText = '⏱️ Code expires in 10 mins';
                    resendBtn.style.display = 'inline';
                    btn.style.display = 'inline-flex';
                    btn.disabled = false;
                    btnText.innerText = 'Resend OTP';
                } else {
                    timerText.innerText = `⏱️ Resend code in ${remaining}s`;
                }
            }, 1000);
        }

        document.getElementById('partnerRegisterForm').addEventListener('submit', function(e) {
            const otp = document.getElementById('partnerOtp').value.trim();
            if (!otp) {
                e.preventDefault();
                showPartnerError('Please click "Get OTP" and enter the 6-digit verification code.');
                requestPartnerOtp();
                return false;
            }

            if (otp.length !== 6) {
                e.preventDefault();
                showPartnerError('Verification code must be exactly 6 digits.');
                document.getElementById('partnerOtp').focus();
                return false;
            }

            const pwd = document.getElementById('partnerPassword').value;
            const pwdConf = document.getElementById('partnerPasswordConfirm').value;

            if (pwd.length < 6) {
                e.preventDefault();
                showPartnerError('Password must be at least 6 characters long.');
                document.getElementById('partnerPassword').focus();
                return false;
            }

            if (pwd !== pwdConf) {
                e.preventDefault();
                showPartnerError('Passwords do not match. Please re-enter your password.');
                document.getElementById('partnerPasswordConfirm').focus();
                return false;
            }

            const submitBtn = document.getElementById('btnSubmitPartnerForm');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Creating Partner Account...';
        });
    </script>

</body>
</html>