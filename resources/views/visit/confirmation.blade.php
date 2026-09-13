@extends('layouts.public')
@section('title', 'Visit Confirmed – Digital Campus Pass | SchoolMapr')

@section('content')
<style>
    @media print {
        body * { visibility: hidden; }
        #digitalPassCard, #digitalPassCard * { visibility: visible; }
        #digitalPassCard { position: absolute; left: 0; top: 0; width: 100%; box-shadow: none; border: 1px solid #000; }
        .no-print { display: none !important; }
    }
</style>

<div class="no-print" style="background:linear-gradient(135deg,#0f2d59,#1e3a64);padding:44px 0 36px;text-align:center;">
    <div class="container">
        <div style="font-size:48px;margin-bottom:8px;">🎉</div>
        <h1 style="color:#fff;font-size:clamp(22px,3vw,30px);font-weight:900;margin:0 0 6px;">Campus Tour Booking Confirmed!</h1>
        <p style="color:rgba(255,255,255,.8);font-size:13.5px;margin:0;">Here is your official digital entry pass for <strong>{{ $booking->school->name }}</strong>.</p>
    </div>
</div>

<div class="container" style="padding:32px 16px 60px;max-width:720px;">

    {{-- DIGITAL CAMPUS TOUR PASS CARD (PRINTABLE) --}}
    <div id="digitalPassCard" style="background:#fff;border-radius:20px;border:2px solid #e2e8f0;box-shadow:0 12px 36px rgba(15,45,89,.09);overflow:hidden;margin-bottom:24px;">

        {{-- Pass Header --}}
        <div style="background:#0f2d59;color:#fff;padding:20px 24px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
            <div style="display:flex;align-items:center;gap:12px;">
                <div style="width:42px;height:42px;background:rgba(255,255,255,.15);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:20px;">
                    🏛️
                </div>
                <div>
                    <div style="font-size:16px;font-weight:900;letter-spacing:-0.2px;">Official Campus Tour Pass</div>
                    <div style="font-size:11.5px;color:#94a3b8;margin-top:2px;">Pass ID: #SMP-{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</div>
                </div>
            </div>
            <div>
                <span style="background:#ecfdf5;color:#15803d;border:1px solid #86efac;border-radius:999px;padding:4px 12px;font-size:11px;font-weight:800;">
                    ✓ Booking Active
                </span>
            </div>
        </div>

        {{-- Pass Body with QR Code --}}
        <div style="padding:24px;">
            <div class="row g-3 align-items-center">
                
                {{-- QR CODE COLUMN --}}
                <div class="col-sm-4 text-center border-end-sm">
                    <div style="background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:14px;padding:12px;display:inline-block;">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=140x140&data=SCHOOLMAPR-PASS-{{ $booking->id }}-{{ urlencode($booking->visitor_name) }}" alt="Campus Pass QR Code" style="width:130px;height:130px;display:block;">
                    </div>
                    <div style="font-size:10.5px;font-weight:800;color:#64748b;margin-top:6px;text-transform:uppercase;letter-spacing:0.04em;">
                        Scan at School Reception
                    </div>
                </div>

                {{-- DETAILS COLUMN --}}
                <div class="col-sm-8">
                    <div style="font-size:17px;font-weight:900;color:#0f2d59;margin-bottom:4px;">
                        {{ $booking->school->name }}
                    </div>
                    <div style="font-size:12px;color:#64748b;margin-bottom:14px;">
                        📍 {{ $booking->school->address }}
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                        <div style="background:#eff6ff;border-radius:10px;padding:10px 12px;">
                            <div style="font-size:10px;text-transform:uppercase;font-weight:800;color:#3b82f6;">Date Scheduled</div>
                            <div style="font-size:14px;font-weight:900;color:#1e3a8a;margin-top:2px;">
                                {{ $booking->visit_date->format('D, d M Y') }}
                            </div>
                        </div>

                        <div style="background:#fef3c7;border-radius:10px;padding:10px 12px;">
                            <div style="font-size:10px;text-transform:uppercase;font-weight:800;color:#d97706;">Time Slot</div>
                            <div style="font-size:14px;font-weight:900;color:#92400e;margin-top:2px;">
                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $booking->visit_time)->format('h:i A') }}
                            </div>
                        </div>

                        <div style="background:#f8fafc;border-radius:10px;padding:10px 12px;">
                            <div style="font-size:10px;text-transform:uppercase;font-weight:800;color:#64748b;">Visitor Name</div>
                            <div style="font-size:13px;font-weight:800;color:#0f172a;margin-top:2px;">
                                {{ $booking->visitor_name }}
                            </div>
                        </div>

                        <div style="background:#f8fafc;border-radius:10px;padding:10px 12px;">
                            <div style="font-size:10px;text-transform:uppercase;font-weight:800;color:#64748b;">Phone Number</div>
                            <div style="font-size:13px;font-weight:800;color:#0f172a;margin-top:2px;">
                                {{ $booking->visitor_phone }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($booking->notes)
            <div style="background:#fffbeb;border:1px solid #fde68a;border-radius:10px;padding:10px 14px;margin-top:16px;font-size:12px;color:#92400e;">
                <strong>Special Request / Notes:</strong> {{ $booking->notes }}
            </div>
            @endif
        </div>

        {{-- Pass Footer --}}
        <div style="background:#f8fafc;border-top:1px solid #e2e8f0;padding:12px 24px;display:flex;align-items:center;justify-content:space-between;font-size:11.5px;color:#64748b;">
            <span>🛡️ Verified Booking by SchoolMapr Patna</span>
            <span>Bring a valid Government ID</span>
        </div>
    </div>

    @php
        // Google Calendar Link Calculation
        $visitDateTime = \Carbon\Carbon::parse($booking->visit_date->format('Y-m-d') . ' ' . $booking->visit_time);
        $calStart = $visitDateTime->format('Ymd\THis');
        $calEnd = $visitDateTime->copy()->addHours(2)->format('Ymd\THis');
        $calTitle = urlencode('Campus Tour: ' . $booking->school->name);
        $calDetails = urlencode('SchoolMapr Campus Visit for ' . $booking->visitor_name . '. Pass ID: #SMP-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT));
        $calLocation = urlencode($booking->school->name . ', ' . $booking->school->address);
        $googleCalUrl = "https://calendar.google.com/calendar/render?action=TEMPLATE&text={$calTitle}&dates={$calStart}/{$calEnd}&details={$calDetails}&location={$calLocation}";
        $mapsUrl = "https://www.google.com/maps/search/?api=1&query=" . urlencode($booking->school->name . ' ' . $booking->school->address);
    @endphp

    {{-- ACTION SHORTCUTS (CALENDAR / MAPS / PRINT) --}}
    <div class="no-print" style="display:grid;grid-template-columns:repeat(auto-fit, minmax(180px, 1fr));gap:10px;margin-bottom:24px;">
        <a href="{{ $googleCalUrl }}" target="_blank" style="background:#fff;border:1.5px solid #cbd5e1;color:#0f2d59;padding:12px 14px;border-radius:10px;font-size:13px;font-weight:800;text-decoration:none;display:inline-flex;align-items:center;justify-content:center;gap:6px;">
            <i class="fa-solid fa-calendar-plus text-primary"></i> Add to Google Calendar
        </a>
        <a href="{{ $mapsUrl }}" target="_blank" style="background:#fff;border:1.5px solid #cbd5e1;color:#0f2d59;padding:12px 14px;border-radius:10px;font-size:13px;font-weight:800;text-decoration:none;display:inline-flex;align-items:center;justify-content:center;gap:6px;">
            <i class="fa-solid fa-location-arrow text-danger"></i> Google Maps Directions
        </a>
        <button type="button" onclick="window.print()" style="background:#0f2d59;color:#fff;border:none;padding:12px 14px;border-radius:10px;font-size:13px;font-weight:800;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;gap:6px;">
            <i class="fa-solid fa-print"></i> Print / Save PDF Pass
        </button>
    </div>

    {{-- WHAT HAPPENS NEXT --}}
    <div class="no-print" style="background:#fff;border-radius:16px;border:1.5px solid #e8ecf4;padding:20px;margin-bottom:20px;">
        <h4 style="font-size:14px;font-weight:800;color:#0f2d59;margin:0 0 12px;display:flex;align-items:center;gap:8px;">
            ⚡ What to Expect on Visit Day
        </h4>
        <div style="display:flex;flex-direction:column;gap:8px;font-size:12.5px;color:#475569;">
            <div style="display:flex;gap:8px;">
                <span>1.</span> <span>Show your <strong>Digital QR Pass</strong> at the main reception desk.</span>
            </div>
            <div style="display:flex;gap:8px;">
                <span>2.</span> <span>An admission counsellor will guide you through the classrooms, science labs, and sports grounds.</span>
            </div>
            <div style="display:flex;gap:8px;">
                <span>3.</span> <span>You can discuss specific fee installment plans and transport routes directly with the school administration.</span>
            </div>
        </div>
    </div>

    {{-- NAVIGATION BUTTONS --}}
    <div class="no-print" style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
        <a href="{{ route('dashboard.visits') }}" style="background:#eff6ff;color:#2563eb;border:1.5px solid #bfdbfe;border-radius:10px;padding:12px;font-size:13px;font-weight:800;text-decoration:none;text-align:center;">
            📋 My Visits Hub
        </a>
        <a href="{{ route('school.show', $booking->school->slug) }}" style="background:#fff;color:#0f2d59;border:1.5px solid #cbd5e1;border-radius:10px;padding:12px;font-size:13px;font-weight:800;text-decoration:none;text-align:center;">
            🏫 View School Profile
        </a>
    </div>

</div>
@endsection