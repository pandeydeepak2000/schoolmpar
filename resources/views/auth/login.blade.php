<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In — SchoolMapr (schoolmapr.com)</title>
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
            --yellow-hover: #e5a700;
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
            max-width: 440px;
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
            margin-bottom: 24px;
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
            margin-bottom: 20px;
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
            margin: 20px 0;
            position: relative;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }
        .divider::before, .divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 36%;
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
            margin-bottom: 20px;
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
            margin-bottom: 20px;
        }

        /* FORM */
        .form-group { margin-bottom: 18px; }
        .form-label {
            font-size: 13px;
            font-weight: 700;
            color: var(--text-main);
            display: block;
            margin-bottom: 6px;
        }
        .form-input {
            width: 100%;
            border: 1.5px solid #cbd5e1;
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 14px;
            outline: none;
            color: var(--text-main);
            transition: all 0.2s;
        }
        .form-input:focus {
            border-color: var(--navy);
            box-shadow: 0 0 0 3.5px rgba(15, 45, 89, 0.12);
        }

        .remember-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 22px;
        }
        .remember-row label {
            font-size: 13px;
            color: var(--text-muted);
            cursor: pointer;
            user-select: none;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .remember-row a {
            font-size: 13px;
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
        }
        .remember-row a:hover { text-decoration: underline; }

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
        }
        .btn-auth:hover { background: var(--navy-dark); transform: translateY(-1px); }

        .signup-section {
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
            text-align: center;
        }
        .signup-text {
            font-size: 13.5px;
            color: var(--text-muted);
            margin-bottom: 12px;
        }
        .btn-create-account {
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
        .btn-create-account:hover {
            background: #dbeafe;
            color: #1e40af;
        }

        .auth-footer-note {
            text-align: center;
            font-size: 11.5px;
            color: #94a3b8;
            margin-top: 20px;
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
                <i class="fa-solid fa-shield-halved"></i> Verified School Discovery
            </div>
            
            <h1 class="auth-title">Welcome Back</h1>
            <p class="auth-sub">Sign in to access school fee breakdowns, track admission enquiries, and compare schools in Patna.</p>

            @if($errors->any())
            <div class="alert-error">
                <i class="fas fa-circle-exclamation"></i> {{ $errors->first() }}
            </div>
            @endif

            @if(session('success'))
            <div class="alert-success">✅ {{ session('success') }}</div>
            @endif

            @if(session('status'))
            <div class="alert-success">{{ session('status') }}</div>
            @endif

            {{-- GOOGLE SIGN IN --}}
            <a href="{{ route('auth.google') }}" class="btn-google">
                <svg viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                </svg>
                Continue with Google
            </a>

            <div class="divider">or sign in with email</div>

            <form method="POST" action="/login">
                @csrf
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-input" placeholder="e.g. parent@schoolmapr.com" value="{{ old('email') }}" required autofocus>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-input" placeholder="Enter your password" required>
                </div>

                <div class="remember-row">
                    <label for="remember">
                        <input type="checkbox" name="remember" id="remember" checked style="width:16px; height:16px; accent-color:var(--navy);">
                        Remember me
                    </label>
                    <a href="/forgot-password">Forgot password?</a>
                </div>

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

                <button type="submit" class="btn-auth">Sign In to Account</button>
            </form>

            <div class="signup-section">
                <p class="signup-text">New to SchoolMapr?</p>
                <a href="/register" class="btn-create-account">
                    <i class="fa-solid fa-user-plus me-1"></i> Create New Account
                </a>
            </div>

            <div class="auth-footer-note">
                🔒 Safe & SSL Secured • 100% Free for Parents in Patna
            </div>
        </div>
    </div>

</body>
</html>