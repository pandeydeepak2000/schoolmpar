<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Official Admission Brochure – {{ $school->name }}</title>
    <style>
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f4f6fa; color: #1e293b; margin: 0; padding: 30px 12px; }
        .container { max-width: 580px; margin: 0 auto; background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 20px rgba(15, 45, 89, 0.06); }
        .header { background: linear-gradient(135deg, #0f2d59 0%, #1a4277 100%); color: #ffffff; padding: 28px 24px; text-align: center; }
        .header h1 { margin: 0; font-size: 24px; font-weight: 900; letter-spacing: -0.5px; }
        .header h1 span { color: #febb02; }
        .school-hero { background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 18px 24px; display: flex; align-items: center; justify-content: space-between; }
        .body { padding: 28px 24px; line-height: 1.6; font-size: 14px; color: #334155; }
        .fee-card { background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; padding: 16px 20px; margin: 18px 0; }
        .fee-row { display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px dashed #bbf7d0; font-size: 13.5px; }
        .fee-row:last-child { border-bottom: none; }
        .btn-download { display: inline-block; background: #0f2d59; color: #ffffff !important; text-decoration: none; padding: 13px 26px; border-radius: 10px; font-weight: 800; font-size: 14px; margin-top: 14px; text-align: center; }
        .btn-secondary { display: inline-block; background: #febb02; color: #0f2d59 !important; text-decoration: none; padding: 13px 26px; border-radius: 10px; font-weight: 800; font-size: 14px; margin-top: 14px; text-align: center; }
        .custom-msg-box { background: #fffbeb; border-left: 4px solid #f59e0b; padding: 14px 18px; border-radius: 8px; font-size: 13px; color: #92400e; margin: 18px 0; }
        .footer { background: #f8fafc; padding: 20px 24px; text-align: center; font-size: 11.5px; color: #64748b; border-top: 1px solid #e2e8f0; line-height: 1.6; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>School<span>Mapr</span></h1>
            <p style="margin: 6px 0 0; color: #dbeafe; font-size: 12.5px; font-weight: 600;">Verified Admission & Prospectus Desk</p>
        </div>

        <div class="school-hero">
            <div>
                <h2 style="margin: 0; font-size: 17px; font-weight: 900; color: #0f2d59;">{{ $school->name }}</h2>
                <div style="font-size: 12px; color: #64748b; margin-top: 3px;">
                    📍 {{ $school->address }} • {{ $school->board }} Board • {{ $school->medium ?? 'English' }}
                </div>
            </div>
            <span style="background: #e0f2fe; color: #0369a1; font-weight: 800; font-size: 11px; padding: 4px 10px; border-radius: 20px;">
                Session {{ date('Y') }}–{{ date('Y')+1 }}
            </span>
        </div>

        <div class="body">
            <h3 style="font-size: 17px; font-weight: 800; color: #0f2d59; margin-top: 0; margin-bottom: 8px;">
                Hello {{ $parentName }},
            </h3>
            <p style="margin-bottom: 0;">
                Thank you for your interest in <strong>{{ $school->name }}</strong>. As requested on <strong>SchoolMapr</strong>, here is the official admission brochure and fee structure details:
            </p>

            @if($customMessage)
                <div class="custom-msg-box">
                    <strong>Message from Admissions Desk:</strong><br>
                    {{ $customMessage }}
                </div>
            @endif

            <div class="fee-card">
                <div style="font-size: 12px; font-weight: 800; color: #166534; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">
                    💳 Verified Fee Structure
                </div>
                <div class="fee-row">
                    <span style="color: #475569;">Annual Tuition Fee:</span>
                    <strong style="color: #0f2d59;">₹{{ number_format($school->fee_min) }} – ₹{{ number_format($school->fee_max) }} / year</strong>
                </div>
                @if($school->admission_fee)
                <div class="fee-row">
                    <span style="color: #475569;">One-time Admission Fee:</span>
                    <strong style="color: #0f2d59;">₹{{ number_format($school->admission_fee) }}</strong>
                </div>
                @endif
                @if($school->transport_fee)
                <div class="fee-row">
                    <span style="color: #475569;">Annual Transport (Optional):</span>
                    <strong style="color: #0f2d59;">₹{{ number_format($school->transport_fee) }} / year</strong>
                </div>
                @endif
                <div class="fee-row">
                    <span style="color: #475569;">Classes Offered:</span>
                    <strong style="color: #0f2d59;">Class {{ $school->class_from }} to Class {{ $school->class_to }}</strong>
                </div>
            </div>

            <div style="text-align: center; margin: 24px 0 10px;">
                @if($school->prospectus_path)
                    <a href="{{ $school->prospectus_url }}" target="_blank" class="btn-download">
                        📥 Download Official Brochure (PDF)
                    </a>
                @endif
                <a href="{{ url('/schools/' . $school->slug) }}" target="_blank" class="btn-secondary" style="margin-left: 8px;">
                    🏫 View Full School Profile & Apply
                </a>
            </div>

            @if($school->phone || $school->email)
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px 18px; margin-top: 20px;">
                <div style="font-size: 12px; font-weight: 800; color: #0f2d59; margin-bottom: 4px;">📞 Direct School Helpdesk:</div>
                <div style="font-size: 13px; color: #475569;">
                    @if($school->phone) Phone: <strong>{{ $school->phone }}</strong> &nbsp;|&nbsp; @endif
                    @if($school->email) Email: <strong>{{ $school->email }}</strong> @endif
                </div>
            </div>
            @endif

            <p style="font-size: 12px; color: #94a3b8; margin-top: 24px; margin-bottom: 0;">
                If you have further questions or wish to book a campus visit, you can directly connect with the school on SchoolMapr or call our helpline.
            </p>
        </div>

        <div class="footer">
            <p style="margin: 0 0 4px; font-weight: 700; color: #0f2d59;">SchoolMapr Patna Network</p>
            <p style="margin: 0;">Helpline: +91 88931 12323 • support@schoolmapr.com • schoolmapr.com</p>
        </div>
    </div>
</body>
</html>
