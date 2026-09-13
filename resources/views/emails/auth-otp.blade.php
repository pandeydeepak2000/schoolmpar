<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Your SchoolMapr Verification Code</title>
    <style>
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f4f6fa; color: #1e293b; margin: 0; padding: 30px 12px; }
        .container { max-width: 540px; margin: 0 auto; background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 20px rgba(15, 45, 89, 0.06); }
        .header { background: linear-gradient(135deg, #0f2d59 0%, #1a4277 100%); color: #ffffff; padding: 28px 24px; text-align: center; }
        .header h1 { margin: 0; font-size: 24px; font-weight: 900; letter-spacing: -0.5px; }
        .header h1 span { color: #febb02; }
        .body { padding: 32px 28px; line-height: 1.6; font-size: 14px; color: #334155; }
        .otp-box { background: #f8fafc; border: 2px dashed #0f2d59; border-radius: 12px; padding: 20px; text-align: center; margin: 24px 0; }
        .otp-code { font-size: 36px; font-weight: 900; letter-spacing: 10px; color: #0f2d59; font-family: monospace; }
        .otp-note { font-size: 12px; color: #64748b; margin-top: 8px; font-weight: 600; }
        .warning-box { background: #fffbeb; border-left: 4px solid #f59e0b; padding: 12px 16px; border-radius: 6px; font-size: 12.5px; color: #92400e; margin: 18px 0; }
        .footer { background: #f8fafc; padding: 20px 24px; text-align: center; font-size: 11.5px; color: #64748b; border-top: 1px solid #e2e8f0; line-height: 1.6; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>School<span>Mapr</span></h1>
            <p style="margin: 6px 0 0; color: #dbeafe; font-size: 12.5px; font-weight: 600;">Bihar's Premier Verified School Admissions Network</p>
        </div>
        <div class="body">
            <h2 style="font-size: 19px; font-weight: 800; color: #0f2d59; margin-top: 0; margin-bottom: 8px;">
                @if($name)
                    Hello {{ $name }},
                @else
                    Hello there,
                @endif
            </h2>
            <p style="margin-bottom: 0;">We received a request to verify your email address (<strong>{{ $email }}</strong>) for your <strong>SchoolMapr</strong> account creation.</p>
            
            <div class="otp-box">
                <div style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 6px;">Your 6-Digit Verification Code</div>
                <div class="otp-code">{{ $otp }}</div>
                <div class="otp-note">⏱️ Valid for 10 minutes only</div>
            </div>

            <p style="font-size: 13.5px; color: #475569;">
                Enter this code on the registration screen to verify your email and activate your account.
            </p>

            <div class="warning-box">
                🔒 <strong>Security Tip:</strong> Never share this OTP with anyone. SchoolMapr support staff will never ask for your verification code.
            </div>

            <p style="font-size: 12px; color: #94a3b8; margin-top: 24px; margin-bottom: 0;">
                If you did not initiate this request, please disregard this email or contact our support team at <a href="mailto:support@schoolmapr.com" style="color: #2563eb; text-decoration: none;">support@schoolmapr.com</a>.
            </p>
        </div>
        <div class="footer">
            <p style="margin: 0 0 4px; font-weight: 700; color: #0f2d59;">SchoolMapr Patna Network</p>
            <p style="margin: 0;">Helpline: +91 88931 12323 • support@schoolmapr.com • schoolmapr.com</p>
        </div>
    </div>
</body>
</html>
