@extends('layouts.public')
@section('title', 'Application Status – #' . str_pad($admission->id, 6, '0', STR_PAD_LEFT) . ' | SchoolMapr')

@section('content')
<style>
    @media print {
        body * { visibility: hidden; }
        #admissionPrintCard, #admissionPrintCard * { visibility: visible; }
        #admissionPrintCard { position: absolute; left: 0; top: 0; width: 100%; box-shadow: none; border: 1px solid #000; }
        .no-print { display: none !important; }
    }
    .track-step-wrap{
        display:flex;
        align-items:center;
        justify-content:space-between;
        position:relative;
        margin:24px 0 28px;
    }
    .track-step-wrap::before{
        content:'';
        position:absolute;
        top:20px;
        left:30px;
        right:30px;
        height:4px;
        background:#e2e8f0;
        z-index:1;
    }
    .track-step{
        position:relative;
        z-index:2;
        display:flex;
        flex-direction:column;
        align-items:center;
        gap:6px;
        flex:1;
    }
    .track-step-circle{
        width:40px;
        height:40px;
        border-radius:50%;
        background:#fff;
        border:3px solid #cbd5e1;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:15px;
        font-weight:900;
        color:#64748b;
        transition:all .2s;
    }
    .track-step.done .track-step-circle{
        background:#16a34a;
        border-color:#16a34a;
        color:#fff;
    }
    .track-step.active .track-step-circle{
        background:#0f2d59;
        border-color:#0f2d59;
        color:#fff;
        box-shadow:0 0 0 5px rgba(15,45,89,.15);
    }
    .track-step-label{
        font-size:11px;
        font-weight:800;
        color:#64748b;
        text-align:center;
    }
    .track-step.done .track-step-label,
    .track-step.active .track-step-label{
        color:#0f2d59;
    }
</style>

<div class="no-print" style="background:linear-gradient(135deg,#0f2d59,#1e3a64);padding:40px 0 32px;text-align:center;">
    <div class="container">
        <h1 style="color:#fff;font-size:clamp(20px,2.8vw,28px);font-weight:900;margin:0 0 6px;">Admission Application Tracker</h1>
        <p style="color:rgba(255,255,255,.8);font-size:13px;margin:0;">Real-time status tracking for <strong>{{ $admission->student_name }}</strong> at {{ $admission->school->name ?? 'Selected School' }}.</p>
    </div>
</div>

<div class="container" style="max-width:680px; margin:30px auto; padding:0 16px 60px;">

    @if(session('success'))
    <div class="no-print" style="background:linear-gradient(135deg,#16a34a,#22c55e); border-radius:14px; padding:18px 20px; text-align:center; margin-bottom:20px; color:#fff;">
        <div style="font-size:32px; margin-bottom:4px;">🎉</div>
        <h3 style="font-size:17px; font-weight:900; margin:0 0 4px;">{{ session('success') }}</h3>
    </div>
    @endif

    {{-- ADMISSION DOSSIER CARD --}}
    <div id="admissionPrintCard" style="background:#fff; border:2px solid #e2e8f0; border-radius:20px; overflow:hidden; box-shadow:0 10px 32px rgba(15,45,89,.08);">

        {{-- Header --}}
        <div style="background:#0f2d59; padding:20px 24px; color:#fff; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
            <div>
                <div style="font-size:11px; opacity:.75; font-weight:800; text-transform:uppercase; letter-spacing:.05em;">Student Admission File</div>
                <h2 style="font-size:19px; font-weight:900; margin:2px 0 0;">{{ $admission->student_name }}</h2>
                <div style="font-size:12.5px; opacity:.85; margin-top:2px;">🏫 {{ $admission->school->name ?? '' }}</div>
            </div>
            <div style="text-align:right;">
                <span style="font-size:11px; background:rgba(255,255,255,.15); border:1px solid rgba(255,255,255,.25); border-radius:6px; padding:3px 8px; font-weight:800; display:inline-block;">
                    App ID: #SMP-ADM-{{ str_pad($admission->id, 6, '0', STR_PAD_LEFT) }}
                </span>
            </div>
        </div>

        <div style="padding:24px;">

            @php
                $status = $admission->status ?? 'pending';
                // Calculate progress step (1 to 5)
                $stepIndex = match($status) {
                    'pending'   => 1,
                    'reviewing' => 2,
                    'approved'  => 4,
                    'enrolled'  => 5,
                    default     => 1,
                };
            @endphp

            {{-- 5-STAGE VISUAL TRACKER --}}
            <div class="track-step-wrap">
                <div class="track-step {{ $stepIndex >= 1 ? ($stepIndex > 1 ? 'done' : 'active') : '' }}">
                    <div class="track-step-circle">{{ $stepIndex > 1 ? '✓' : '1' }}</div>
                    <div class="track-step-label">Submitted</div>
                </div>
                <div class="track-step {{ $stepIndex >= 2 ? ($stepIndex > 2 ? 'done' : 'active') : '' }}">
                    <div class="track-step-circle">{{ $stepIndex > 2 ? '✓' : '2' }}</div>
                    <div class="track-step-label">Under Review</div>
                </div>
                <div class="track-step {{ $stepIndex >= 3 ? ($stepIndex > 3 ? 'done' : 'active') : '' }}">
                    <div class="track-step-circle">{{ $stepIndex > 3 ? '✓' : '3' }}</div>
                    <div class="track-step-label">Interaction</div>
                </div>
                <div class="track-step {{ $stepIndex >= 4 ? ($stepIndex > 4 ? 'done' : 'active') : '' }}">
                    <div class="track-step-circle">{{ $stepIndex > 4 ? '✓' : '4' }}</div>
                    <div class="track-step-label">Offer Letter</div>
                </div>
                <div class="track-step {{ $stepIndex >= 5 ? 'active' : '' }}">
                    <div class="track-step-circle">5</div>
                    <div class="track-step-label">Enrolled</div>
                </div>
            </div>

            {{-- CURRENT STATUS BANNER --}}
            @if($status === 'approved')
                <div style="background:#ecfdf5; border:1.5px solid #86efac; border-radius:14px; padding:16px; text-align:center; margin-bottom:20px;">
                    <div style="font-size:24px; margin-bottom:4px;">🎉</div>
                    <div style="font-size:16px; font-weight:900; color:#15803d;">Congratulations! Admission Seat Offered</div>
                    <p style="font-size:12.5px; color:#166534; margin:4px 0 0;">
                        The school has accepted the application for <strong>Class {{ $admission->class_applying }}</strong>. Contact administration to complete document submission.
                    </p>
                </div>
            @elseif($status === 'reviewing')
                <div style="background:#eff6ff; border:1.5px solid #bfdbfe; border-radius:14px; padding:14px 16px; margin-bottom:20px; text-align:center;">
                    <div style="font-size:15px; font-weight:900; color:#1e40af;">🔍 Academic Documents Under Verification</div>
                    <p style="font-size:12px; color:#1e3a8a; margin:4px 0 0;">
                        School admission committee is reviewing the submitted profile. Expect counselling call within 24–48 hours.
                    </p>
                </div>
            @elseif($status === 'rejected')
                <div style="background:#fef2f2; border:1.5px solid #fecaca; border-radius:14px; padding:14px 16px; margin-bottom:20px; text-align:center;">
                    <div style="font-size:15px; font-weight:900; color:#b91c1c;">❌ Application Not Accepted</div>
                    <p style="font-size:12px; color:#991b1b; margin:4px 0 0;">
                        Due to seat constraints or eligibility limits, this application could not be accommodated for this session.
                    </p>
                </div>
            @else
                <div style="background:#fffbeb; border:1.5px solid #fde68a; border-radius:14px; padding:14px 16px; margin-bottom:20px; text-align:center;">
                    <div style="font-size:15px; font-weight:900; color:#b45309;">⏳ Application Submitted to School</div>
                    <p style="font-size:12px; color:#92400e; margin:4px 0 0;">
                        Your dossier has been registered in the school's direct portal queue.
                    </p>
                </div>
            @endif

            {{-- DOSSIER SUMMARY TABLE --}}
            <div style="background:#f8fafc; border:1.5px solid #e2e8f0; border-radius:12px; padding:16px; margin-bottom:20px;">
                <div style="font-size:11px; text-transform:uppercase; font-weight:900; color:#94a3b8; letter-spacing:0.04em; margin-bottom:10px;">
                    Application Summary
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; font-size:13px;">
                    <div><span style="color:#64748b;">Target Grade:</span> <strong style="color:#0f2d59;">Class {{ $admission->class_applying }}</strong></div>
                    <div><span style="color:#64748b;">Date of Birth:</span> <strong style="color:#0f2d59;">{{ $admission->dob ? \Carbon\Carbon::parse($admission->dob)->format('d M Y') : 'On file' }}</strong></div>
                    <div><span style="color:#64748b;">Parent Name:</span> <strong style="color:#0f2d59;">{{ $admission->parent_name ?? auth()->user()->name }}</strong></div>
                    <div><span style="color:#64748b;">Parent Phone:</span> <strong style="color:#0f2d59;">{{ $admission->parent_phone }}</strong></div>
                    <div><span style="color:#64748b;">Date Applied:</span> <strong style="color:#0f2d59;">{{ $admission->created_at ? $admission->created_at->format('d M Y') : now()->format('d M Y') }}</strong></div>
                    <div>
                        <span style="color:#64748b;">Token Payment:</span> 
                        @if($admission->payment_id)
                            <span style="background:#ecfdf5; color:#15803d; font-size:11px; font-weight:800; padding:2px 8px; border-radius:999px;">✓ Paid</span>
                        @else
                            <span style="background:#f1f5f9; color:#64748b; font-size:11px; font-weight:800; padding:2px 8px; border-radius:999px;">No Fee</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ACTION BUTTONS --}}
            <div class="no-print" style="display:flex; gap:10px; flex-wrap:wrap;">
                <button type="button" onclick="window.print()" style="flex:1; background:#0f2d59; color:#fff; border:none; border-radius:10px; padding:12px; font-size:13px; font-weight:800; cursor:pointer; display:inline-flex; align-items:center; justify-content:center; gap:6px;">
                    <i class="fa-solid fa-print"></i> Print Slip
                </button>
                <a href="{{ route('parent.dashboard') }}" style="flex:1; background:#eff6ff; color:#2563eb; border:1.5px solid #bfdbfe; border-radius:10px; padding:12px; font-size:13px; font-weight:800; text-decoration:none; text-align:center;">
                    🏠 Parent Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection