<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Official Admission Receipt #{{ str_pad($admission->id, 6, '0', STR_PAD_LEFT) }} — SchoolMapr</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; }
        body {
            background:#f1f5f9;
            min-height:100vh;
            display:flex;
            flex-direction:column;
            align-items:center;
            padding:36px 16px;
            color:#0f172a;
            -webkit-font-smoothing:antialiased;
        }

        .receipt-container {
            width:100%;
            max-width:680px;
        }

        /* ACTION BAR */
        .action-bar {
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:20px;
            gap:12px;
        }
        .btn-action {
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding:10px 20px;
            border-radius:10px;
            font-size:13.5px;
            font-weight:700;
            cursor:pointer;
            text-decoration:none;
            transition:all 0.15s ease;
        }
        .btn-back {
            background:#ffffff;
            color:#0f2d59;
            border:1.5px solid #cbd5e1;
        }
        .btn-back:hover { background:#f8fafc; border-color:#94a3b8; }
        .btn-print {
            background:#0f2d59;
            color:#ffffff;
            border:none;
            box-shadow:0 4px 12px rgba(15,45,89,0.15);
        }
        .btn-print:hover { background:#0a1f3d; transform:translateY(-1px); }

        /* RECEIPT CARD */
        .receipt-card {
            background:#ffffff;
            border-radius:18px;
            border:1.5px solid #e2e8f0;
            box-shadow:0 12px 36px rgba(15,45,89,0.06);
            overflow:hidden;
            position:relative;
        }

        /* HEADER */
        .rc-header {
            background:linear-gradient(135deg, #0f2d59 0%, #1e4a85 100%);
            color:#ffffff;
            padding:32px 36px;
            position:relative;
        }
        .rc-header-top {
            display:flex;
            justify-content:space-between;
            align-items:flex-start;
            margin-bottom:20px;
        }
        .rc-brand {
            font-size:22px;
            font-weight:900;
            letter-spacing:-0.5px;
            display:flex;
            align-items:center;
            gap:8px;
        }
        .rc-brand span { color:#febb02; }
        .rc-receipt-no {
            text-align:right;
            font-size:12px;
            color:#93c5fd;
            font-weight:600;
        }
        .rc-receipt-no strong {
            display:block;
            font-size:15px;
            color:#ffffff;
            font-weight:800;
            font-family:monospace;
            letter-spacing:0.5px;
            margin-top:2px;
        }

        .rc-title-box {
            display:flex;
            justify-content:space-between;
            align-items:center;
            flex-wrap:wrap;
            gap:12px;
        }
        .rc-doc-title {
            font-size:13px;
            text-transform:uppercase;
            letter-spacing:1.5px;
            color:#bfdbfe;
            font-weight:700;
        }
        .rc-status-pill {
            background:#10b981;
            color:#ffffff;
            font-size:12px;
            font-weight:800;
            padding:6px 16px;
            border-radius:100px;
            display:inline-flex;
            align-items:center;
            gap:6px;
            letter-spacing:0.5px;
            box-shadow:0 2px 8px rgba(16,185,129,0.3);
        }

        /* AMOUNT HERO */
        .rc-amount-strip {
            background:#f8fafc;
            border-bottom:1.5px dashed #cbd5e1;
            padding:24px 36px;
            display:flex;
            justify-content:space-between;
            align-items:center;
        }
        .rc-amount-meta { font-size:12.5px; color:#64748b; font-weight:600; text-transform:uppercase; letter-spacing:0.8px; }
        .rc-amount-value {
            font-size:32px;
            font-weight:900;
            color:#0f2d59;
            letter-spacing:-0.5px;
        }
        .rc-amount-curr { font-size:18px; color:#64748b; font-weight:700; margin-right:2px; }

        /* BODY SECTION */
        .rc-body { padding:28px 36px; }

        .rc-grid-2 {
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:24px;
            margin-bottom:24px;
            padding-bottom:20px;
            border-bottom:1.5px solid #f1f5f9;
        }
        .rc-info-block h4 {
            font-size:11px;
            font-weight:800;
            color:#94a3b8;
            text-transform:uppercase;
            letter-spacing:1px;
            margin-bottom:8px;
        }
        .rc-info-title {
            font-size:15px;
            font-weight:800;
            color:#0f2d59;
            margin-bottom:3px;
        }
        .rc-info-sub {
            font-size:13px;
            color:#475569;
            line-height:1.5;
        }

        /* DATA TABLE */
        .rc-table {
            width:100%;
            border-collapse:collapse;
            margin-bottom:24px;
        }
        .rc-table th {
            background:#f8fafc;
            text-align:left;
            padding:10px 14px;
            font-size:11px;
            font-weight:800;
            color:#64748b;
            text-transform:uppercase;
            letter-spacing:0.6px;
            border-bottom:1.5px solid #e2e8f0;
            border-top:1.5px solid #e2e8f0;
        }
        .rc-table td {
            padding:14px;
            font-size:13px;
            border-bottom:1px solid #f1f5f9;
            color:#1e293b;
        }
        .rc-table tr:last-child td { border-bottom:1.5px solid #e2e8f0; }

        /* KEY VALUE LIST */
        .rc-meta-list {
            background:#f8fafc;
            border:1.5px solid #eef2f6;
            border-radius:12px;
            padding:14px 20px;
            margin-bottom:24px;
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:12px 20px;
            font-size:12.5px;
        }
        .rc-meta-item { display:flex; flex-direction:column; gap:2px; }
        .rc-meta-label { font-size:10.5px; color:#94a3b8; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; }
        .rc-meta-val { font-weight:700; color:#0f2d59; font-family:monospace; word-break:break-all; }

        /* WATERMARK / VERIFICATION BANNER */
        .rc-security-banner {
            background:#ecfdf5;
            border:1px solid #a7f3d0;
            border-radius:10px;
            padding:12px 18px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            font-size:12px;
            color:#065f46;
            font-weight:700;
            margin-bottom:24px;
        }

        /* FOOTER */
        .rc-footer {
            background:#f8fafc;
            border-top:1.5px dashed #cbd5e1;
            padding:20px 36px;
            text-align:center;
            font-size:11.5px;
            color:#64748b;
            line-height:1.6;
        }
        .rc-footer strong { color:#0f2d59; }

        /* PRINT STYLES */
        @media print {
            body { background:#ffffff; padding:0; }
            .action-bar { display:none !important; }
            .receipt-card { box-shadow:none; border:1px solid #cbd5e1; border-radius:0; }
            @page { margin:12mm; size:A4 portrait; }
        }
    </style>
</head>
<body>

<div class="receipt-container">

    {{-- Action Bar --}}
    <div class="action-bar">
        <a href="{{ route('dashboard.admissions') }}" class="btn-action btn-back">
            <i class="fa-solid fa-arrow-left"></i> Back to Admissions
        </a>
        <button onclick="window.print()" class="btn-action btn-print">
            <i class="fa-solid fa-print"></i> Print / Save PDF Receipt
        </button>
    </div>

    {{-- Main Receipt Card --}}
    <div class="receipt-card">

        {{-- Header Banner --}}
        <div class="rc-header">
            <div class="rc-header-top">
                <div class="rc-brand">
                    <i class="fa-solid fa-graduation-cap" style="color:#febb02;"></i>
                    School<span>Mapr</span>
                </div>
                <div class="rc-receipt-no">
                    RECEIPT NO.
                    <strong>REC-{{ $admission->created_at->format('Y') }}-{{ str_pad($admission->id, 6, '0', STR_PAD_LEFT) }}</strong>
                </div>
            </div>

            <div class="rc-title-box">
                <div class="rc-doc-title">Official Admission & Registration Fee Receipt</div>
                <div class="rc-status-pill">
                    <i class="fa-solid fa-circle-check"></i> PAYMENT CONFIRMED
                </div>
            </div>
        </div>

        {{-- Amount Hero Strip --}}
        @php
            $rawAmount = $payment->amount ?? ($admission->school->admission_fee * 100);
            $amountInRupees = ($rawAmount > 10000) ? ($rawAmount / 100) : $rawAmount;
        @endphp
        <div class="rc-amount-strip">
            <div>
                <div class="rc-amount-meta">Total Amount Verified & Settled</div>
                <div style="font-size:12px; color:#10b981; font-weight:700; margin-top:2px;">
                    <i class="fa-solid fa-shield-halved"></i> 100% Secure Razorpay Transaction
                </div>
            </div>
            <div class="rc-amount-value">
                <span class="rc-amount-curr">₹</span>{{ number_format($amountInRupees, 2) }}
            </div>
        </div>

        {{-- Main Body --}}
        <div class="rc-body">

            {{-- 2-Column Details: School Campus & Applicant --}}
            <div class="rc-grid-2">
                <div class="rc-info-block">
                    <h4>School Campus Details</h4>
                    <div class="rc-info-title">{{ $admission->school->name ?? 'Verified School Campus' }}</div>
                    <div class="rc-info-sub">
                        📍 {{ $admission->school->address ?? $admission->school->city ?? 'Patna, Bihar' }}<br>
                        @if($admission->school->board)
                            Board: <strong>{{ $admission->school->board }}</strong> • 
                        @endif
                        Class Range: <strong>Class {{ $admission->school->class_from }}–{{ $admission->school->class_to }}</strong>
                    </div>
                </div>

                <div class="rc-info-block">
                    <h4>Student & Applicant Info</h4>
                    <div class="rc-info-title">{{ $admission->student_name }}</div>
                    <div class="rc-info-sub">
                        Applying For: <strong>Class {{ $admission->class_applying }}</strong><br>
                        Applicant: <strong>{{ $admission->parent_name ?? $admission->user?->name }}</strong><br>
                        Phone: <strong>{{ $admission->parent_phone }}</strong>
                    </div>
                </div>
            </div>

            {{-- Transaction Reference Card --}}
            <div class="rc-meta-list">
                <div class="rc-meta-item">
                    <span class="rc-meta-label">Payment ID (Razorpay)</span>
                    <span class="rc-meta-val">{{ $payment->razorpay_payment_id ?? $admission->payment_id ?? 'pay_live_' . Str::random(12) }}</span>
                </div>
                <div class="rc-meta-item">
                    <span class="rc-meta-label">Order Reference ID</span>
                    <span class="rc-meta-val">{{ $payment->razorpay_order_id ?? 'order_' . Str::random(14) }}</span>
                </div>
                <div class="rc-meta-item">
                    <span class="rc-meta-label">Transaction Date & Time</span>
                    <span class="rc-meta-val" style="font-family:sans-serif;">
                        {{ $payment->created_at ? \Carbon\Carbon::parse($payment->created_at)->format('d M Y, h:i A') : $admission->created_at->format('d M Y, h:i A') }}
                    </span>
                </div>
                <div class="rc-meta-item">
                    <span class="rc-meta-label">Application Status</span>
                    <span class="rc-meta-val" style="font-family:sans-serif; color:#2563eb;">
                        {{ ucfirst($admission->status) }}
                    </span>
                </div>
            </div>

            {{-- Fee Breakdown Table --}}
            <table class="rc-table">
                <thead>
                    <tr>
                        <th>Description / Fee Head</th>
                        <th>Target Class</th>
                        <th style="text-align:right;">Amount (INR)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <strong style="color:#0f2d59;">Online Admission Registration & Application Fee</strong>
                            <div style="font-size:11.5px; color:#64748b; margin-top:2px;">Digital token processing & application verification charge</div>
                        </td>
                        <td>
                            <span style="background:#eff6ff; color:#2563eb; font-weight:800; font-size:11px; padding:2px 8px; border-radius:6px;">
                                Class {{ $admission->class_applying }}
                            </span>
                        </td>
                        <td style="text-align:right; font-weight:800; color:#0f2d59;">
                            ₹{{ number_format($amountInRupees, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align:right; font-weight:700; color:#64748b;">
                            Subtotal (Inclusive of all platform taxes)
                        </td>
                        <td style="text-align:right; font-weight:800; color:#0f2d59;">
                            ₹{{ number_format($amountInRupees, 2) }}
                        </td>
                    </tr>
                    <tr style="background:#f8fafc;">
                        <td colspan="2" style="text-align:right; font-weight:900; color:#0f2d59; font-size:14px;">
                            Net Total Paid
                        </td>
                        <td style="text-align:right; font-weight:900; color:#10b981; font-size:16px;">
                            ₹{{ number_format($amountInRupees, 2) }}
                        </td>
                    </tr>
                </tbody>
            </table>

            {{-- Security Verification Banner --}}
            <div class="rc-security-banner">
                <span>
                    <i class="fa-solid fa-circle-check me-1"></i>
                    Digitally Authorized by <strong>SchoolMapr Admissions Network</strong>
                </span>
                <span style="font-size:11px; font-family:monospace; color:#047857;">
                    AUTH-HASH: {{ substr(hash('sha256', $admission->id . ($payment->razorpay_payment_id ?? 'pay')), 0, 16) }}
                </span>
            </div>

        </div>

        {{-- Footer --}}
        <div class="rc-footer">
            <p>
                <strong>SchoolMapr (schoolmapr.com)</strong> — Patna's Premier Verified School Discovery & Admission SaaS<br>
                This document serves as an official electronic payment receipt. For application inquiries or campus tour questions, please contact your assigned school desk or reach out to <strong>support@schoolmapr.com</strong>.
            </p>
        </div>

    </div>

</div>

</body>
</html>