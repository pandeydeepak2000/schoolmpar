<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Welcome to SchoolMapr</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f8fafc; color: #1e293b; margin: 0; padding: 20px 0; }
        .container { max-width: 580px; margin: 0 auto; background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; }
        .header { background: #0f2d59; color: #ffffff; padding: 24px; text-align: center; }
        .header h1 { margin: 0; font-size: 22px; font-weight: 800; }
        .body { padding: 24px; line-height: 1.6; font-size: 14px; color: #334155; }
        .card { background: #eff6ff; border-left: 4px solid #2563eb; padding: 14px 18px; border-radius: 6px; margin: 18px 0; }
        .footer { background: #f1f5f9; padding: 16px 24px; text-align: center; font-size: 11.5px; color: #64748b; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>SchoolMapr</h1>
            <p style="margin: 4px 0 0; color: #93c5fd; font-size: 12px;">Patna's Premier School Discovery & Direct Admission Network</p>
        </div>
        <div class="body">
            <h2 style="font-size: 18px; color: #0f2d59; margin-top: 0;">Welcome, {{ $user->name }}! 👋</h2>
            <p>Thank you for creating an account on SchoolMapr. You can now explore verified schools across Patna, schedule campus visits, request official prospectuses, and apply for direct admissions.</p>
            
            <div class="card">
                <strong style="color: #1e40af;">Your Account Details:</strong><br>
                <span style="font-size: 13.5px; color: #1e3a8a;">• Registered Email: {{ $user->email }}</span><br>
                <span style="font-size: 13.5px; color: #1e3a8a;">• Account Role: Verified Applicant</span>
            </div>

            <p style="font-size: 13px; color: #64748b;">If you need assistance finding the right school in Patna, our admissions team is here to support you at support@schoolmapr.com.</p>
        </div>
        <div class="footer">
            <p style="margin: 0;">SchoolMapr Patna Network • Support Desk: support@schoolmapr.com</p>
        </div>
    </div>
</body>
</html>
