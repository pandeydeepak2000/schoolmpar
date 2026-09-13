<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SchoolMapr Inquiry Notification</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f8fafc; color: #1e293b; margin: 0; padding: 20px 0; }
        .container { max-width: 580px; margin: 0 auto; background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; }
        .header { background: #0f2d59; color: #ffffff; padding: 24px; text-align: center; }
        .header h1 { margin: 0; font-size: 22px; font-weight: 800; }
        .body { padding: 24px; line-height: 1.6; font-size: 14px; color: #334155; }
        .card { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 16px 20px; margin: 18px 0; }
        .row { margin-bottom: 8px; }
        .row:last-child { margin-bottom: 0; }
        .label { font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: .05em; }
        .value { font-size: 14px; font-weight: 600; color: #0f2d59; }
        .footer { background: #f1f5f9; padding: 16px 24px; text-align: center; font-size: 11.5px; color: #64748b; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>SchoolMapr</h1>
            <p style="margin: 4px 0 0; color: #93c5fd; font-size: 12px;">Verified Admission & Inquiry Desk</p>
        </div>
        <div class="body">
            @if($recipientRole === 'parent')
                <h3 style="font-size: 16px; color: #0f2d59; margin-top: 0;">Inquiry Submission Confirmation</h3>
                <p>Hello {{ $enquiry->parent_name }},</p>
                <p>Your inquiry / prospectus request for <strong>{{ $school->name }}</strong> has been successfully received by the school admissions desk.</p>
            @elseif($recipientRole === 'admin')
                <h3 style="font-size: 16px; color: #0f2d59; margin-top: 0;">Admin Alert: New Parent Lead</h3>
                <p>A new parent inquiry has been registered on SchoolMapr for <strong>{{ $school->name }}</strong>.</p>
            @else
                <h3 style="font-size: 16px; color: #0f2d59; margin-top: 0;">New Parent Inquiry Received</h3>
                <p>Respected Campus Administrator,</p>
                <p>You have received a new parent inquiry / prospectus request for <strong>{{ $school->name }}</strong>.</p>
            @endif

            <div class="card">
                <div class="row">
                    <div class="label">School Campus</div>
                    <div class="value">{{ $school->name }} ({{ $school->city }})</div>
                </div>
                <div class="row">
                    <div class="label">Parent / Guardian Name</div>
                    <div class="value">{{ $enquiry->parent_name }}</div>
                </div>
                <div class="row">
                    <div class="label">Contact Mobile / Phone</div>
                    <div class="value">{{ $enquiry->mobile }}</div>
                </div>
                <div class="row">
                    <div class="label">Target Student Class</div>
                    <div class="value">{{ $enquiry->child_class ?? 'General Admission' }}</div>
                </div>
                <div class="row">
                    <div class="label">Inquiry Message / Request</div>
                    <div class="value" style="font-size: 13px; color: #334155;">{{ $enquiry->message ?: 'Requested general prospectus and admission details.' }}</div>
                </div>
                <div class="row">
                    <div class="label">Timestamp</div>
                    <div class="value" style="font-size: 12.5px; color: #64748b;">{{ $enquiry->created_at ? \Carbon\Carbon::parse($enquiry->created_at)->format('d M Y, h:i A') : now()->format('d M Y, h:i A') }}</div>
                </div>
            </div>

            <p style="font-size: 12.5px; color: #64748b; margin-top: 15px;">
                Please contact the parent on the provided phone number to assist with admissions.
            </p>
        </div>
        <div class="footer">
            <p style="margin: 0;">SchoolMapr Patna Network • Support Desk: support@schoolmapr.com</p>
        </div>
    </div>
</body>
</html>
