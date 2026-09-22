<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Parent Account — SchoolMapr (schoolmapr.com)</title>
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
            max-width: 500px;
            border-radius: 16px;
            border: 1px solid var(--border);
            box-shadow: 0 12px 40px rgba(15, 45, 89, 0.08);
            padding: 36px 32px;
        }

        .auth-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
            padding: 4px 10px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 700;
            margin-bottom: 14px;
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
        .btn-google svg { width: 18px; height: 18px; }

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
            width: 34%;
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
            color: #16a34a;
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
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        @media (max-width: 480px) { .form-row { grid-template-columns: 1fr; } }

        .form-label {
            font-size: 12.5px;
            font-weight: 700;
            color: var(--text-main);
            display: block;
            margin-bottom: 5px;
        }
        .form-input {
            width: 100%;
            border: 1.5px solid #cbd5e1;
            border-radius: 10px;
            padding: 11px 14px;
            font-size: 14px;
            outline: none;
            color: var(--text-main);
            transition: all 0.2s;
            box-sizing: border-box;
        }
        .form-input:focus {
            border-color: var(--navy);
            box-shadow: 0 0 0 3.5px rgba(15, 45, 89, 0.12);
        }

        /* PASSWORD EYE TOGGLE */
        .password-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }
        .password-input-wrapper .form-input {
            padding-right: 42px !important;
        }
        .password-toggle-btn {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            color: #64748b;
            font-size: 15px;
            cursor: pointer;
            padding: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.15s;
        }
        .password-toggle-btn:hover {
            color: var(--navy);
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
            font-size: 13.5px;
            color: var(--text-muted);
            margin-bottom: 10px;
        }
        .btn-signin-link {
            display: inline-block;
            width: 100%;
            background: #eff6ff;
            color: #1d4ed8;
            border: 1.5px solid #bfdbfe;
            border-radius: 10px;
            padding: 11px;
            font-weight: 800;
            font-size: 14px;
            text-decoration: none;
            transition: all 0.2s;
            text-align: center;
        }
        .btn-signin-link:hover {
            background: #dbeafe;
            color: #1e40af;
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
                <i class="fa-solid fa-user-plus"></i> Join SchoolMapr Patna
            </div>
            
            <h1 class="auth-title">Create Parent Account</h1>
            <p class="auth-sub">Sign up to view transparent school fees, book campus visits, and submit direct admission enquiries in Patna.</p>

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

            <form id="registerForm" method="POST" action="{{ route('register') }}" style="margin-top: 14px;">
                @csrf
                <input type="hidden" name="role" value="parent">

                <div class="form-group">
                    <label class="form-label">Parent / Guardian Full Name <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="regName" name="name" class="form-input" placeholder="e.g. Ramesh Kumar" value="{{ old('name') }}" required autofocus>
                </div>

                <div class="form-group">
                    <label class="form-label">Email Address (Gmail / Email) <span style="color:#ef4444;">*</span></label>
                    <input type="email" id="regEmail" name="email" class="form-input" placeholder="e.g. ramesh@gmail.com" value="{{ old('email') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">10-Digit Mobile Number</label>
                    <input type="tel" id="regPhone" name="phone" class="form-input" placeholder="e.g. 9876543210" value="{{ old('phone') }}" maxlength="10">
                    <span style="font-size:11px; color:#64748b; margin-top:3px; display:block;">📱 Used for school enquiry updates and campus visit reminders.</span>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Password <span style="color:#ef4444;">*</span></label>
                        <div class="password-input-wrapper">
                            <input type="password" id="regPassword" name="password" class="form-input" placeholder="Min. 6 characters" required>
                            <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility('regPassword', this)" title="Show / Hide Password" tabindex="-1">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Confirm Password <span style="color:#ef4444;">*</span></label>
                        <div class="password-input-wrapper">
                            <input type="password" id="regPasswordConfirm" name="password_confirmation" class="form-input" placeholder="Repeat password" required>
                            <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility('regPasswordConfirm', this)" title="Show / Hide Password" tabindex="-1">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- OTP VERIFICATION CHANNEL SELECTOR --}}
                <input type="hidden" name="verify_channel" id="verifyChannel" value="email">

                <div class="otp-container" id="otpContainer">
                    <div style="font-size:12px; font-weight:700; color:#475569; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">
                        Choose Verification Method:
                    </div>

                    <div class="verify-channel-selector">
                        <div class="channel-tab active" id="tabEmail" onclick="setVerificationChannel('email')">
                            <i class="fa-solid fa-envelope" style="color:#2563eb;"></i>
                            <span>Email OTP</span>
                        </div>
                        <div class="channel-tab whatsapp-tab" id="tabWhatsapp" onclick="setVerificationChannel('whatsapp')">
                            <i class="fa-brands fa-whatsapp" style="color:#16a34a; font-size:16px;"></i>
                            <span>WhatsApp OTP</span>
                        </div>
                    </div>

                    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px; margin-top:12px;">
                        <div>
                            <div style="font-size:13px; font-weight:800; color:#0f2d59;" id="otpHeaderTitle">
                                <i class="fa-solid fa-shield-halved text-primary me-1"></i> Email Verification Code
                            </div>
                            <div style="font-size:11.5px; color:#64748b; margin-top:2px;" id="otpHeaderSubtitle">
                                A 6-digit OTP will be sent to your Gmail/Email inbox.
                            </div>
                        </div>

                        <button type="button" id="btnSendOtp" class="btn-otp-action" onclick="requestOtp()">
                            <i class="fa-solid fa-paper-plane"></i> <span id="btnSendOtpText">Get OTP</span>
                        </button>
                    </div>

                    <div id="otpInputRow" style="display:none; margin-top:14px;">
                        <label class="form-label" style="font-size:12px;">Enter 6-Digit Verification Code <span style="color:#ef4444;">*</span></label>
                        <div class="otp-input-group">
                            <input type="text" id="regOtp" name="otp" class="otp-code-input" placeholder="••••••" maxlength="6" autocomplete="one-time-code">
                        </div>
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-top:8px; font-size:11.5px;">
                            <span id="otpTimerText" style="color:#64748b;">⏱️ Code expires in 10 mins</span>
                            <a href="javascript:void(0)" id="btnResendOtp" onclick="requestOtp()" style="display:none; color:#2563eb; font-weight:700; text-decoration:none;">
                                🔄 Resend OTP
                            </a>
                        </div>
                    </div>
                </div>

                <p class="terms">
                    By clicking Create Account, you agree to SchoolMapr's 
                    <a href="{{ route('pages.terms') }}">Terms & Conditions</a> and <a href="{{ route('pages.privacy') }}">Privacy Policy</a>.
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

                <button type="submit" id="btnSubmitForm" class="btn-auth">
                    <i class="fa-solid fa-arrow-right"></i> Verify & Create Account
                </button>
            </form>

            <div class="signin-section">
                <p class="signin-text">Already have an account, or prefer 1-Click Google Login?</p>
                <a href="/login" class="btn-signin-link">
                    <i class="fa-solid fa-right-to-bracket me-1"></i> Sign In (Password / Continue with Google)
                </a>
            </div>

            <div style="margin-top:20px; padding:12px 14px; background:#f8fafc; border-radius:10px; border:1px solid #e2e8f0; display:flex; align-items:center; justify-content:space-around; text-align:center; font-size:11.5px; color:#475569; font-weight:600;">
                <div><i class="fas fa-check-circle text-success me-1"></i> 100% Free</div>
                <div style="width:1px; height:18px; background:#cbd5e1;"></div>
                <div><i class="fab fa-whatsapp text-success me-1"></i> Fast WhatsApp OTP</div>
                <div style="width:1px; height:18px; background:#cbd5e1;"></div>
                <div><i class="fas fa-shield-alt text-primary me-1"></i> Patna Schools</div>
            </div>
        </div>
    </div>

    <script>
        let countdownInterval = null;
        let activeChannel = 'email';

        function setVerificationChannel(channel) {
            activeChannel = channel;
            document.getElementById('verifyChannel').value = channel;

            const tabEmail = document.getElementById('tabEmail');
            const tabWhatsapp = document.getElementById('tabWhatsapp');
            const titleEl = document.getElementById('otpHeaderTitle');
            const subEl = document.getElementById('otpHeaderSubtitle');
            const btnText = document.getElementById('btnSendOtpText');
            const phoneInput = document.getElementById('regPhone');

            if (channel === 'whatsapp') {
                tabEmail.classList.remove('active');
                tabWhatsapp.classList.add('active');
                titleEl.innerHTML = '<i class="fa-brands fa-whatsapp text-success me-1"></i> WhatsApp Verification Code';
                subEl.innerText = 'A 6-digit OTP will be sent directly to your WhatsApp number.';
                btnText.innerText = 'Get WhatsApp OTP';
                phoneInput.setAttribute('required', 'required');
                phoneInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
            } else {
                tabWhatsapp.classList.remove('active');
                tabEmail.classList.add('active');
                titleEl.innerHTML = '<i class="fa-solid fa-shield-halved text-primary me-1"></i> Email Verification Code';
                subEl.innerText = 'A 6-digit OTP will be sent to your Gmail/Email inbox.';
                btnText.innerText = 'Get Email OTP';
                phoneInput.removeAttribute('required');
            }
        }

        function showError(msg) {
            const errEl = document.getElementById('dynamicErrorAlert');
            const succEl = document.getElementById('dynamicSuccessAlert');
            succEl.style.display = 'none';
            errEl.innerHTML = `<i class="fas fa-circle-exclamation"></i> ${msg}`;
            errEl.style.display = 'flex';
            errEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        function showSuccess(msg) {
            const errEl = document.getElementById('dynamicErrorAlert');
            const succEl = document.getElementById('dynamicSuccessAlert');
            errEl.style.display = 'none';
            succEl.innerHTML = `<i class="fas fa-circle-check"></i> ${msg}`;
            succEl.style.display = 'flex';
        }

        function hideAlerts() {
            document.getElementById('dynamicErrorAlert').style.display = 'none';
            document.getElementById('dynamicSuccessAlert').style.display = 'none';
        }

        async function requestOtp() {
            hideAlerts();
            const name = document.getElementById('regName').value.trim();
            const email = document.getElementById('regEmail').value.trim();
            const phone = document.getElementById('regPhone').value.trim();

            if (activeChannel === 'whatsapp') {
                if (!phone) {
                    showError('Please enter your 10-digit mobile number to receive the WhatsApp OTP.');
                    document.getElementById('regPhone').focus();
                    return;
                }
                const cleanedPhone = phone.replace(/[^0-9]/g, '');
                if (cleanedPhone.length < 10) {
                    showError('Please enter a valid 10-digit WhatsApp mobile number.');
                    document.getElementById('regPhone').focus();
                    return;
                }
            } else {
                if (!email) {
                    showError('Please enter your email address to receive the verification code.');
                    document.getElementById('regEmail').focus();
                    return;
                }
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(email)) {
                    showError('Please enter a valid email address (e.g. yourname@gmail.com).');
                    document.getElementById('regEmail').focus();
                    return;
                }
            }

            const btn = document.getElementById('btnSendOtp');
            const btnText = document.getElementById('btnSendOtpText');
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
                        channel: activeChannel,
                        email: email,
                        name: name,
                        phone: phone,
                        type: 'register'
                    })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    showSuccess(data.message || 'Verification code sent successfully!');
                    document.getElementById('otpContainer').classList.add('active');
                    document.getElementById('otpInputRow').style.display = 'block';
                    document.getElementById('regOtp').focus();

                    // Start 60s cooldown timer
                    startCooldownTimer(60);
                } else {
                    showError(data.message || 'Could not send verification code. Please check your details.');
                    btn.disabled = false;
                    btnText.innerText = activeChannel === 'whatsapp' ? 'Get WhatsApp OTP' : 'Get Email OTP';

                    // If WhatsApp OTP failed or number not reachable on WhatsApp, prompt & switch to Email OTP
                    if (activeChannel === 'whatsapp' || data.suggest_email) {
                        setTimeout(() => {
                            setVerificationChannel('email');
                            showError((data.message || '⚠️ WhatsApp OTP delivery is temporarily unavailable.') + '<br><span style="font-weight:700; color:#1d4ed8; display:block; margin-top:4px;">👉 We have switched you to Email OTP. Please click "Get Email OTP" below.</span>');
                            document.getElementById('regEmail').focus();
                        }, 1500);
                    }
                }
            } catch (err) {
                showError('Network error while requesting verification code. Please try again.');
                btn.disabled = false;
                btnText.innerText = activeChannel === 'whatsapp' ? 'Get WhatsApp OTP' : 'Get Email OTP';
            }
        }

        function startCooldownTimer(seconds) {
            const btn = document.getElementById('btnSendOtp');
            const btnText = document.getElementById('btnSendOtpText');
            const resendBtn = document.getElementById('btnResendOtp');
            const timerText = document.getElementById('otpTimerText');
            
            btn.style.display = 'none';
            resendBtn.style.display = 'none';

            let remaining = seconds;
            timerText.innerText = `⏱️ Resend code in ${remaining}s`;

            if (countdownInterval) clearInterval(countdownInterval);

            countdownInterval = setInterval(() => {
                remaining--;
                if (remaining <= 0) {
                    clearInterval(countdownInterval);
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

        // Handle Form Submit
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const otp = document.getElementById('regOtp').value.trim();
            if (!otp) {
                e.preventDefault();
                showError('Please click "Get OTP" and enter the 6-digit verification code.');
                requestOtp();
                return false;
            }

            if (otp.length !== 6) {
                e.preventDefault();
                showError('Verification code must be exactly 6 digits.');
                document.getElementById('regOtp').focus();
                return false;
            }

            const pwd = document.getElementById('regPassword').value;
            const pwdConf = document.getElementById('regPasswordConfirm').value;

            if (pwd.length < 6) {
                e.preventDefault();
                showError('Password must be at least 6 characters long.');
                document.getElementById('regPassword').focus();
                return false;
            }

            if (pwd !== pwdConf) {
                e.preventDefault();
                showError('Passwords do not match. Please re-enter your password.');
                document.getElementById('regPasswordConfirm').focus();
                return false;
            }

            const submitBtn = document.getElementById('btnSubmitForm');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Creating Your Account...';
        });

        function togglePasswordVisibility(inputId, btn) {
            const input = document.getElementById(inputId);
            if (!input) return;
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>

</body>
</html>