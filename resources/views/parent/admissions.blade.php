@extends('layouts.parent')
@section('title', 'My Admission Applications – SchoolMapr')

@section('content')
<div class="container-fluid p-0">

    {{-- ── 1. HEADER BANNER ── --}}
    <div class="card border-0 rounded-4 shadow-sm mb-4" style="background:linear-gradient(135deg, #0f2d59 0%, #1e4a85 100%);color:#fff;">
        <div class="card-body p-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <span class="badge bg-warning text-dark fw-bold px-3 py-1 mb-2" style="font-size:11px;">Admission Pipeline</span>
                    <h3 class="fw-bold mb-1">My Admission Applications</h3>
                    <p class="mb-0 text-white-50 small">Track real-time verification, seat approval status, and offer letters across Patna schools.</p>
                </div>
                <a href="{{ url('/') }}" class="btn btn-warning fw-bold px-3 py-2" style="border-radius:8px;font-size:13px;color:#0f2d59;">
                    <i class="fa-solid fa-graduation-cap me-1"></i> Apply to Another School
                </a>
            </div>
        </div>
    </div>

    {{-- ── 2. STAT CARDS ── --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 rounded-4 shadow-sm p-3 h-100" style="background:#fff;border-top:3px solid #3b82f6 !important;">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="small fw-bold text-muted">Total Applications</span>
                    <div style="width:34px;height:34px;border-radius:8px;background:#eff6ff;color:#3b82f6;display:flex;align-items:center;justify-content:center;font-size:14px;">
                        <i class="fa-solid fa-file-signature"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-0">{{ $admissions->total() }}</h3>
                <span class="small text-muted">Submitted forms</span>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card border-0 rounded-4 shadow-sm p-3 h-100" style="background:#fff;border-top:3px solid #f59e0b !important;">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="small fw-bold text-muted">In Verification</span>
                    <div style="width:34px;height:34px;border-radius:8px;background:#fffbeb;color:#f59e0b;display:flex;align-items:center;justify-content:center;font-size:14px;">
                        <i class="fa-solid fa-hourglass-half"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-0">{{ $admissions->getCollection()->whereIn('status',['pending','reviewing'])->count() }}</h3>
                <span class="small text-warning fw-bold">Under review</span>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card border-0 rounded-4 shadow-sm p-3 h-100" style="background:#fff;border-top:3px solid #10b981 !important;">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="small fw-bold text-muted">Approved Seats</span>
                    <div style="width:34px;height:34px;border-radius:8px;background:#ecfdf5;color:#10b981;display:flex;align-items:center;justify-content:center;font-size:14px;">
                        <i class="fa-solid fa-check-circle"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-0">{{ $admissions->getCollection()->where('status','approved')->count() }}</h3>
                <span class="small text-success fw-bold">Seat confirmed</span>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card border-0 rounded-4 shadow-sm p-3 h-100" style="background:#fff;border-top:3px solid #ef4444 !important;">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="small fw-bold text-muted">Rejected</span>
                    <div style="width:34px;height:34px;border-radius:8px;background:#fef2f2;color:#ef4444;display:flex;align-items:center;justify-content:center;font-size:14px;">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-0">{{ $admissions->getCollection()->where('status','rejected')->count() }}</h3>
                <span class="small text-danger fw-bold">Closed</span>
            </div>
        </div>
    </div>

    {{-- Flash Alerts --}}
    @if(session('success'))
    <div class="alert alert-success border-0 rounded-3 shadow-sm py-2 px-3 small fw-bold mb-3">
        ✅ {{ session('success') }}
    </div>
    @endif

    {{-- ── 3. APPLICATIONS LIST ── --}}
    @if($admissions->isEmpty())
    <div class="card border-0 rounded-4 shadow-sm p-5 text-center bg-white">
        <div class="display-5 mb-3">📝</div>
        <h5 class="fw-bold text-dark mb-1">No Admission Applications Yet</h5>
        <p class="text-muted small mb-4 mx-auto" style="max-width:360px;">
            Find top CBSE / ICSE schools in Patna and apply for direct online admission in Class 1 to 12.
        </p>
        <div>
            <a href="{{ url('/') }}" class="btn btn-primary fw-bold px-4 py-2" style="background:#0f2d59;border:none;border-radius:8px;">
                <i class="fa-solid fa-magnifying-glass me-1"></i> Explore Patna Schools
            </a>
        </div>
    </div>

    @else

    <div class="d-flex flex-column gap-3">
    @foreach($admissions as $adm)
    <div class="card border-0 rounded-4 shadow-sm p-3 p-md-4 bg-white">
        <div class="d-flex align-items-start gap-3 flex-wrap">

            {{-- School Campus Thumbnail --}}
            <div style="width:64px;height:64px;border-radius:12px;overflow:hidden;background:#f1f5f9;flex-shrink:0;">
                <img src="{{ $adm->school->featured_image_url }}" alt="{{ $adm->school->name }}" style="width:100%;height:100%;object-fit:cover;">
            </div>

            {{-- Details --}}
            <div class="flex-grow-1" style="min-width:240px;">
                <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                    <h5 class="fw-bold text-dark mb-0" style="font-size:16px;">
                        <a href="{{ route('school.show', $adm->school->slug) }}" class="text-dark text-decoration-none hover-primary">
                            {{ $adm->school->name }}
                        </a>
                    </h5>

                    {{-- Status Badge --}}
                    @if($adm->status === 'approved')
                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill" style="font-size:11px;">
                            ● Approved & Enrolled
                        </span>
                    @elseif($adm->status === 'pending')
                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1 rounded-pill" style="font-size:11px;">
                            ⏳ Pending Document Review
                        </span>
                    @elseif($adm->status === 'reviewing')
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 rounded-pill" style="font-size:11px;">
                            🔍 In Verification
                        </span>
                    @else
                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 rounded-pill" style="font-size:11px;">
                            ❌ Application Declined
                        </span>
                    @endif
                </div>

                <div class="text-muted small mb-2">
                    <i class="fa-solid fa-location-dot text-danger me-1"></i> {{ $adm->school->address }}
                </div>

                {{-- Student Metadata Chips --}}
                <div class="d-flex gap-2 flex-wrap align-items-center small mt-2">
                    <span class="bg-light border px-2 py-1 rounded text-dark fw-bold">
                        👤 Student: {{ $adm->student_name }}
                    </span>
                    <span class="bg-light border px-2 py-1 rounded text-primary fw-bold">
                        🎓 Applied: {{ $adm->class_applying }}
                    </span>
                    <span class="bg-light border px-2 py-1 rounded text-dark">
                        🎂 DOB: {{ \Carbon\Carbon::parse($adm->student_dob)->format('d M Y') }}
                    </span>
                    @if($adm->payment_id || ($adm->payment && $adm->payment->status === 'success'))
                        <span class="bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded fw-bold">
                            <i class="fa-solid fa-check-circle me-1"></i> Fee Paid ₹{{ number_format($adm->payment->amount ?? 1500) }}
                        </span>
                    @endif
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="d-flex flex-column gap-2 flex-shrink-0 align-items-stretch" style="min-width:130px;">
                <a href="{{ route('school.show', $adm->school->slug) }}" target="_blank"
                   class="btn btn-sm btn-outline-primary fw-bold text-center" style="border-radius:8px;font-size:12px;">
                    <i class="fa-solid fa-eye me-1"></i> View School
                </a>

                @if($adm->payment_id)
                <a href="{{ route('admission.receipt', $adm->id) }}"
                   class="btn btn-sm btn-success fw-bold text-center" style="border-radius:8px;font-size:12px;">
                    <i class="fa-solid fa-receipt me-1"></i> Receipt
                </a>
                @endif
            </div>

        </div>
    </div>
    @endforeach
    </div>

    {{-- Pagination --}}
    @if($admissions->hasPages())
    <div class="mt-4">
        {{ $admissions->links() }}
    </div>
    @endif

    @endif

</div>
@endsection
