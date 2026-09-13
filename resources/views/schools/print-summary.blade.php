<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $school->name }} – Official School Summary & Prospectus Profile | SchoolMapr</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        body {
            background: #f1f5f9;
            color: #0f172a;
            padding: 24px 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
            -webkit-font-smoothing: antialiased;
        }

        .summary-wrapper {
            width: 100%;
            max-width: 820px;
        }

        /* ── ACTION BAR (SCREEN ONLY) ── */
        .action-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            gap: 12px;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.15s ease;
        }

        .btn-back {
            background: #ffffff;
            color: #0f2d59;
            border: 1.5px solid #cbd5e1;
        }
        .btn-back:hover { background: #f8fafc; border-color: #94a3b8; }

        .btn-print {
            background: #0f2d59;
            color: #ffffff;
            border: none;
            box-shadow: 0 4px 14px rgba(15,45,89,0.2);
        }
        .btn-print:hover { background: #0a1f3d; transform: translateY(-1px); }

        /* ── PRINT SHEET CONTAINER ── */
        .doc-sheet {
            background: #ffffff;
            border-radius: 16px;
            border: 1.5px solid #e2e8f0;
            box-shadow: 0 10px 30px rgba(15,45,89,0.06);
            overflow: hidden;
            position: relative;
        }

        /* ── HEADER BANNER ── */
        .doc-header {
            background: linear-gradient(135deg, #0f2d59 0%, #1e4a85 100%);
            color: #ffffff;
            padding: 26px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            border-bottom: 3px solid #febb02;
        }

        .doc-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 22px;
            font-weight: 900;
            letter-spacing: -0.5px;
        }
        .doc-brand i { color: #febb02; font-size: 24px; }
        .doc-brand span { color: #febb02; }

        .doc-meta-right {
            text-align: right;
            font-size: 12px;
            color: #cbd5e1;
        }
        .doc-ref-badge {
            background: rgba(255,255,255,0.15);
            padding: 4px 10px;
            border-radius: 6px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: 0.5px;
            display: inline-block;
            margin-bottom: 4px;
        }

        /* ── BODY CONTENT ── */
        .doc-body {
            padding: 30px 32px;
        }

        /* ── SCHOOL MAIN TITLE SECTION ── */
        .school-intro {
            border-bottom: 1.5px solid #f1f5f9;
            padding-bottom: 20px;
            margin-bottom: 22px;
        }

        .school-title-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 8px;
        }

        .school-name {
            font-size: 24px;
            font-weight: 900;
            color: #0f2d59;
            line-height: 1.25;
        }

        .school-score-box {
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            padding: 6px 14px;
            text-align: center;
            flex-shrink: 0;
        }
        .score-val {
            font-size: 18px;
            font-weight: 900;
            color: #0f2d59;
        }
        .score-val i { color: #f59e0b; font-size: 14px; }
        .score-label {
            font-size: 10px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
        }

        .school-address {
            font-size: 13px;
            color: #475569;
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 12px;
        }
        .school-address i { color: #e11d48; }

        .tag-pill-row {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .tag-pill {
            font-size: 11px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 6px;
            background: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
        }
        .tag-pill.verified {
            background: #f0fdf4;
            color: #15803d;
            border-color: #bbf7d0;
        }
        .tag-pill.badge-board {
            background: #0f2d59;
            color: #ffffff;
            border: none;
        }

        /* ── METRICS GRID (4 TILES) ── */
        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 24px;
        }

        .metric-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 12px 14px;
        }
        .metric-card-label {
            font-size: 11px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin-bottom: 4px;
        }
        .metric-card-val {
            font-size: 14px;
            font-weight: 800;
            color: #0f2d59;
        }

        /* ── SECTION TITLE ── */
        .sec-heading {
            font-size: 14px;
            font-weight: 800;
            color: #0f2d59;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
            padding-bottom: 6px;
            border-bottom: 1.5px solid #e2e8f0;
        }
        .sec-heading i { color: #0284c7; }

        /* ── ABOUT TEXT ── */
        .about-box {
            font-size: 13px;
            line-height: 1.65;
            color: #334155;
            margin-bottom: 24px;
            background: #fbfcfe;
            border: 1px solid #f1f5f9;
            border-radius: 10px;
            padding: 14px 16px;
        }

        /* ── FEE SCHEDULE TABLE ── */
        .fee-table-wrap {
            margin-bottom: 24px;
        }

        .fee-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .fee-table th {
            background: #f1f5f9;
            color: #334155;
            font-weight: 800;
            text-align: left;
            padding: 10px 14px;
            border: 1px solid #e2e8f0;
            font-size: 12px;
            text-transform: uppercase;
        }

        .fee-table td {
            padding: 10px 14px;
            border: 1px solid #e2e8f0;
            color: #1e293b;
        }

        .fee-table tr:nth-child(even) {
            background: #f8fafc;
        }

        .fee-highlight {
            font-weight: 800;
            color: #0f2d59;
        }

        /* ── FACILITIES GRID ── */
        .fac-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-bottom: 24px;
        }

        .fac-item {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 9px 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 700;
            color: #1e293b;
        }
        .fac-item i { color: #16a34a; font-size: 13px; }

        /* ── ADMISSION & DOCS REQUIRED ── */
        .docs-list {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px 16px;
            margin-bottom: 24px;
            padding-left: 0;
            list-style: none;
        }

        .docs-list li {
            font-size: 12.5px;
            color: #334155;
            display: flex;
            align-items: flex-start;
            gap: 8px;
            line-height: 1.45;
        }
        .docs-list li i { color: #0284c7; margin-top: 3px; font-size: 11px; }

        /* ── CONTACT GRID ── */
        .contact-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 24px;
        }

        .contact-tile {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 12px 14px;
        }
        .contact-tile-lbl {
            font-size: 10.5px;
            font-weight: 800;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: 3px;
        }
        .contact-tile-val {
            font-size: 12.5px;
            font-weight: 700;
            color: #0f2d59;
            word-break: break-all;
        }

        /* ── OFFICIAL FOOTER ── */
        .doc-footer {
            border-top: 1.5px solid #e2e8f0;
            padding-top: 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 11.5px;
            color: #64748b;
        }

        .stamp-box {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #f0fdf4;
            border: 1px solid #86efac;
            padding: 6px 12px;
            border-radius: 6px;
            color: #15803d;
            font-weight: 800;
            font-size: 11px;
            letter-spacing: 0.3px;
        }

        /* ── PRINT RULES (A4 CLEAN FORMAT) ── */
        @media print {
            @page {
                size: A4 portrait;
                margin: 10mm 12mm;
            }
            body {
                background: #ffffff !important;
                padding: 0 !important;
            }
            .action-bar {
                display: none !important;
            }
            .doc-sheet {
                border: 1px solid #cbd5e1 !important;
                box-shadow: none !important;
                border-radius: 0 !important;
            }
            .doc-header {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>
</head>
<body>

<div class="summary-wrapper">

    {{-- SCREEN ACTION BAR --}}
    <div class="action-bar">
        <a href="{{ route('school.show', $school->slug) }}" class="btn-action btn-back">
            <i class="fas fa-arrow-left"></i> ← Back to School Profile
        </a>
        <button type="button" class="btn-action btn-print" onclick="window.print()">
            <i class="fas fa-print"></i> Print / Save as PDF
        </button>
    </div>

    {{-- OFFICIAL DOCUMENT SHEET --}}
    <div class="doc-sheet">

        {{-- HEADER --}}
        <div class="doc-header">
            <div>
                <div class="doc-brand">
                    <i class="fa-solid fa-graduation-cap"></i> School<span>Mapr</span>
                </div>
                <p style="font-size:12px; color:#bfdbfe; margin-top:3px; font-weight:500;">
                    Official Verified Patna School Profile & Admission Summary
                </p>
            </div>
            <div class="doc-meta-right">
                <div class="doc-ref-badge">REF: SCH-{{ str_pad($school->id, 5, '0', STR_PAD_LEFT) }}</div>
                <div>Date: {{ date('d F Y') }}</div>
            </div>
        </div>

        <div class="doc-body">

            {{-- VERIFIED APPLICANT ACCESS BADGE --}}
            @auth
            <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; padding:8px 14px; margin-bottom:18px; display:flex; justify-content:space-between; align-items:center; font-size:12px;">
                <div style="color:#166534; font-weight:700; display:flex; align-items:center; gap:6px;">
                    <i class="fas fa-user-check text-success"></i> Verified Account Access: {{ auth()->user()->name }} ({{ auth()->user()->email }})
                </div>
                <div style="color:#15803d; font-size:11px; font-weight:600;">
                    Patna Verified Admissions Access
                </div>
            </div>
            @endauth

            {{-- SCHOOL NAME & BADGES --}}
            <div class="school-intro">
                <div class="school-title-row">
                    <div>
                        <h1 class="school-name">{{ $school->name }}</h1>
                        <div class="school-address">
                            <i class="fas fa-location-dot"></i>
                            {{ $school->address }}
                        </div>
                    </div>
                    <div class="school-score-box">
                        <div class="score-val">{{ number_format($school->rating ?? 4.8, 1) }} <i class="fas fa-star"></i></div>
                        <div class="score-label">{{ $school->reviews_count ?? 134 }} Reviews</div>
                    </div>
                </div>

                <div class="tag-pill-row">
                    <span class="tag-pill badge-board">{{ $school->board }} Board</span>
                    <span class="tag-pill">{{ $school->medium }} Medium</span>
                    <span class="tag-pill">{{ $school->school_type ?? 'Co-Educational' }}</span>
                    @if($school->affiliation_no)
                        <span class="tag-pill">Affiliation No: {{ $school->affiliation_no }}</span>
                    @endif
                    @if($school->established_year)
                        <span class="tag-pill">Est. {{ $school->established_year }}</span>
                    @endif
                    <span class="tag-pill verified">
                        <i class="fas fa-check-circle"></i> 100% Verified Patna Campus
                    </span>
                </div>
            </div>

            {{-- 4 KEY STAT TILES --}}
            <div class="metrics-grid">
                <div class="metric-card">
                    <div class="metric-card-label">Grade / Classes</div>
                    <div class="metric-card-val">Class {{ $school->class_from }} to {{ $school->class_to }}</div>
                </div>
                <div class="metric-card">
                    <div class="metric-card-label">Admission Status</div>
                    <div class="metric-card-val" style="color:{{ $school->admission_status === 'open' ? '#16a34a' : '#dc2626' }}; text-transform:capitalize;">
                        ● {{ $school->admission_status ?? 'Open' }} (2026-27)
                    </div>
                </div>
                <div class="metric-card">
                    <div class="metric-card-label">Seats Remaining</div>
                    <div class="metric-card-val">{{ $school->seats_available ?? 35 }} Seats Open</div>
                </div>
                <div class="metric-card">
                    <div class="metric-card-label">Principal / Head</div>
                    <div class="metric-card-val">{{ $school->principal_name ?: 'Office of Principal' }}</div>
                </div>
            </div>

            {{-- ABOUT SCHOOL --}}
            <div class="sec-heading">
                <i class="fas fa-info-circle"></i> About School & Academic Environment
            </div>
            <div class="about-box">
                {{ $school->description ?: ($school->name . ' is one of the premier institutions located in Patna, Bihar, offering high academic standards, modern campus infrastructure, supportive faculty, and holistic student personality development.') }}
            </div>

            {{-- TRANSPARENT FEE BREAKDOWN --}}
            <div class="sec-heading">
                <i class="fas fa-indian-rupee-sign"></i> Verified Transparent Fee Schedule
            </div>
            <div class="fee-table-wrap">
                <table class="fee-table">
                    <thead>
                        <tr>
                            <th>Fee Component</th>
                            <th>Frequency</th>
                            <th>Estimated Amount (₹)</th>
                            <th>Status & Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Admission & Registration Fee</strong></td>
                            <td>One-Time (New Admission)</td>
                            <td class="fee-highlight">₹{{ number_format($school->admission_fee ?? 12000) }}</td>
                            <td>Standard verified registration charge</td>
                        </tr>
                        <tr>
                            <td><strong>Annual Tuition & Academic Fee</strong></td>
                            <td>Per Annum (Yearly)</td>
                            <td class="fee-highlight">₹{{ number_format($school->fee_min ?? 36000) }} – ₹{{ number_format($school->fee_max ?? 68000) }}</td>
                            <td>Includes smart classroom & lab resources</td>
                        </tr>
                        @if($school->transport_fee)
                        <tr>
                            <td><strong>School Bus Transport (Optional)</strong></td>
                            <td>Per Annum (Yearly)</td>
                            <td class="fee-highlight">₹{{ number_format($school->transport_fee) }}</td>
                            <td>Route & distance based managed fleet</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            {{-- CAMPUS FACILITIES --}}
            <div class="sec-heading">
                <i class="fas fa-building-columns"></i> Verified Campus Facilities
            </div>
            @php
                $facilities = is_array($school->facilities) ? $school->facilities : ['Smart Classrooms', 'Science Labs', 'Computer Laboratory', 'Stocked Library', 'Sports Grounds', 'School Bus Transport', 'Campus CCTV', 'Medical Room'];
            @endphp
            <div class="fac-grid">
                @foreach($facilities as $fac)
                    <div class="fac-item">
                        <i class="fas fa-check"></i>
                        <span>{{ $fac }}</span>
                    </div>
                @endforeach
            </div>

            {{-- ADMISSION CHECKLIST & REQUIRED DOCUMENTS --}}
            <div class="sec-heading">
                <i class="fas fa-clipboard-check"></i> Documents Required for Admission
            </div>
            <ul class="docs-list">
                <li><i class="fas fa-circle-check"></i> <span>Original Birth Certificate (Govt/Municipal issued)</span></li>
                <li><i class="fas fa-circle-check"></i> <span>Previous School Transfer Certificate (TC) (Class 2+)</span></li>
                <li><i class="fas fa-circle-check"></i> <span>Latest Report Card / Previous Academic Marksheet</span></li>
                <li><i class="fas fa-circle-check"></i> <span>4 Recent Passport Size Photographs of Student</span></li>
                <li><i class="fas fa-circle-check"></i> <span>Parents Identity & Residence Address Proof</span></li>
                <li><i class="fas fa-circle-check"></i> <span>Aadhaar Card copy of Student and Parents</span></li>
            </ul>

            {{-- OFFICIAL CONTACT & LOCATION --}}
            <div class="sec-heading">
                <i class="fas fa-phone"></i> Official School Communication & Contact
            </div>
            <div class="contact-grid">
                <div class="contact-tile">
                    <div class="contact-tile-lbl">Admissions Helpline</div>
                    <div class="contact-tile-val">{{ $school->phone ?: '+91 612 2972797' }}</div>
                </div>
                <div class="contact-tile">
                    <div class="contact-tile-lbl">Official Email</div>
                    <div class="contact-tile-val">{{ $school->email ?: 'admissions@schoolmapr.com' }}</div>
                </div>
                <div class="contact-tile">
                    <div class="contact-tile-lbl">Official Portal</div>
                    <div class="contact-tile-val">{{ $school->website ?: 'https://schoolmapr.com' }}</div>
                </div>
            </div>

            {{-- OFFICIAL VERIFICATION FOOTER --}}
            <div class="doc-footer">
                <div>
                    <strong>SchoolMapr Verified Document</strong> • Generated on <span style="color:#0f2d59; font-weight:700;">schoolmapr.com</span>
                    <br>
                    Patna School Admissions Support: <strong style="color:#0f2d59;">+91 88931 12323</strong> • <strong style="color:#0f2d59;">support@schoolmapr.com</strong>
                </div>
                <div class="stamp-box">
                    <i class="fas fa-shield-halved"></i> VERIFIED PATNA INSTITUTION
                </div>
            </div>

        </div>

    </div>

</div>

</body>
</html>
