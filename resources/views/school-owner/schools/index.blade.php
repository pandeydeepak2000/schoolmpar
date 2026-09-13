@extends('school-owner.layout')
@section('title', 'My School Campuses – SchoolMapr Partner')

@section('content')

@if(session('success'))
<div class="alert-success">✅ {{ session('success') }}</div>
@endif

@if(session('error'))
<div class="alert-error">❌ {{ session('error') }}</div>
@endif

{{-- Header --}}
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:12px;">
    <div>
        <h4 style="font-size:20px; font-weight:800; color:#0f2d59; margin:0;">
            <i class="fas fa-school me-2 text-primary"></i>My School Campuses
        </h4>
        <p style="font-size:13px; color:#64748b; margin:4px 0 0;">
            Total {{ $schools->total() }} school profile{{ $schools->total() != 1 ? 's' : '' }} managed under your account
        </p>
    </div>
    <a href="{{ route('school-owner.schools.create') }}" style="background:#0f2d59; color:#fff; font-weight:800; font-size:13px; text-decoration:none; padding:10px 18px; border-radius:8px; display:inline-flex; align-items:center; gap:6px;">
        <i class="fas fa-plus"></i> Add New Campus
    </a>
</div>

{{-- Stats Row --}}
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(180px, 1fr)); gap:14px; margin-bottom:24px;">
    <div style="background:#fff; border:1.5px solid #e8ecf4; border-radius:12px; padding:16px; border-top:3px solid #3b82f6;">
        <div style="font-size:24px; font-weight:900; color:#0f2d59;">{{ $stats['total'] }}</div>
        <div style="font-size:11.5px; color:#64748b; font-weight:700; margin-top:2px;">Total Campuses</div>
    </div>
    <div style="background:#fff; border:1.5px solid #e8ecf4; border-radius:12px; padding:16px; border-top:3px solid #10b981;">
        <div style="font-size:24px; font-weight:900; color:#059669;">{{ $stats['approved'] }}</div>
        <div style="font-size:11.5px; color:#059669; font-weight:700; margin-top:2px;">Active & Live</div>
    </div>
    <div style="background:#fff; border:1.5px solid #e8ecf4; border-radius:12px; padding:16px; border-top:3px solid #f59e0b;">
        <div style="font-size:24px; font-weight:900; color:#d97706;">{{ $stats['pending'] }}</div>
        <div style="font-size:11.5px; color:#d97706; font-weight:700; margin-top:2px;">Pending Review</div>
    </div>
    <div style="background:#fff; border:1.5px solid #e8ecf4; border-radius:12px; padding:16px; border-top:3px solid #ef4444;">
        <div style="font-size:24px; font-weight:900; color:#dc2626;">{{ $stats['rejected'] }}</div>
        <div style="font-size:11.5px; color:#dc2626; font-weight:700; margin-top:2px;">Rejected / Inactive</div>
    </div>
</div>

{{-- Schools List --}}
<div style="display:flex; flex-direction:column; gap:12px;">
@forelse($schools as $school)
<div style="background:#fff; border-radius:14px; border:1.5px solid #e8ecf4; padding:18px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:14px;">

    <div style="display:flex; align-items:center; gap:14px; min-width:280px; flex:1;">
        <div style="width:54px; height:54px; border-radius:10px; overflow:hidden; background:#f1f5f9; flex-shrink:0;">
            <img src="{{ $school->featured_image_url }}" alt="{{ $school->name }}" style="width:100%; height:100%; object-fit:cover;">
        </div>

        <div style="min-width:0;">
            <h5 style="font-size:15px; font-weight:800; color:#0f2d59; margin:0 0 2px;">
                {{ $school->name }}
            </h5>
            <div style="font-size:12px; color:#64748b; display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                <span>📍 {{ $school->city }}{{ $school->state ? ', '.$school->state : '' }}</span>
                <span>•</span>
                <span style="background:#eff6ff; color:#2563eb; padding:1px 6px; border-radius:4px; font-weight:700; font-size:11px;">{{ $school->board }}</span>
                @if($school->fee_min && $school->fee_max)
                <span>•</span>
                <span>₹{{ number_format($school->fee_min) }} – ₹{{ number_format($school->fee_max) }}</span>
                @endif
            </div>
        </div>
    </div>

    <div style="display:flex; align-items:center; gap:10px; flex-shrink:0;">
        {{-- Admission Status --}}
        @if(($school->admission_status ?? 'open') === 'open')
            <span style="background:#ecfdf5; color:#15803d; border:1px solid #86efac; padding:4px 10px; border-radius:999px; font-size:11px; font-weight:800; display:inline-flex; align-items:center; gap:4px;">
                <span style="width:6px; height:6px; border-radius:50%; background:#22c55e; display:inline-block;"></span> 🟢 Open 2026-27
            </span>
        @elseif($school->admission_status === 'coming_soon')
            <span style="background:#fffbeb; color:#b45309; border:1px solid #fde68a; padding:4px 10px; border-radius:999px; font-size:11px; font-weight:800; display:inline-flex; align-items:center; gap:4px;">
                <span style="width:6px; height:6px; border-radius:50%; background:#eab308; display:inline-block;"></span> 🟡 Opening Soon
            </span>
        @else
            <span style="background:#fef2f2; color:#b91c1c; border:1px solid #fecaca; padding:4px 10px; border-radius:999px; font-size:11px; font-weight:800; display:inline-flex; align-items:center; gap:4px;">
                <span style="width:6px; height:6px; border-radius:50%; background:#ef4444; display:inline-block;"></span> 🔴 Closed
            </span>
        @endif

        @if($school->status === 'approved')
            <span style="background:#ecfdf5; color:#059669; border:1px solid #a7f3d0; padding:4px 10px; border-radius:999px; font-size:11px; font-weight:800;">
                ● Live
            </span>
        @elseif($school->status === 'pending')
            <span style="background:#fffbeb; color:#d97706; border:1px solid #fde68a; padding:4px 10px; border-radius:999px; font-size:11px; font-weight:800;">
                ⏳ Pending Review
            </span>
        @else
            <span style="background:#fef2f2; color:#dc2626; border:1px solid #fecaca; padding:4px 10px; border-radius:999px; font-size:11px; font-weight:800;">
                ● Inactive
            </span>
        @endif

        <a href="{{ route('school.show', $school->slug) }}" target="_blank"
           style="background:#eff6ff; color:#2563eb; font-size:12px; font-weight:700; text-decoration:none; padding:7px 12px; border-radius:6px;">
            <i class="fas fa-eye me-1"></i> Preview
        </a>

        <a href="{{ route('school-owner.schools.edit', $school->id) }}"
           style="background:#0f2d59; color:#fff; font-size:12px; font-weight:700; text-decoration:none; padding:7px 14px; border-radius:6px;">
            <i class="fas fa-pen me-1"></i> Edit Profile & Gallery
        </a>
    </div>

</div>
@empty
<div style="background:#fff; border:2px dashed #e2e8f0; border-radius:16px; padding:60px 20px; text-align:center;">
    <div style="font-size:48px; margin-bottom:12px;">🏫</div>
    <h5 style="font-size:16px; font-weight:800; color:#0f2d59;">No Schools Listed Yet</h5>
    <p style="font-size:13px; color:#64748b; max-width:320px; margin:4px auto 16px;">
        Add your school campus to connect with parents across Patna for direct admissions.
    </p>
    <a href="{{ route('school-owner.schools.create') }}" style="background:#0f2d59; color:#fff; font-size:13px; font-weight:800; text-decoration:none; padding:10px 22px; border-radius:8px; display:inline-block;">
        <i class="fas fa-plus me-1"></i> Add Your First Campus
    </a>
</div>
@endforelse
</div>

@if($schools->hasPages())
<div style="margin-top:24px;">
    {{ $schools->links() }}
</div>
@endif

@endsection