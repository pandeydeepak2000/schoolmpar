@extends('school-owner.layout')
@section('title', 'Institution Partner Console – SchoolMapr')

@section('content')

{{-- ── 1. WELCOME BANNER ── --}}
<div style="background:linear-gradient(135deg, #0f2d59 0%, #1e4a85 100%); border-radius:14px; padding:24px; color:#fff; margin-bottom:24px;">
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:14px;">
        <div>
            <span style="background:rgba(255,255,255,0.15); font-size:11px; font-weight:800; padding:3px 10px; border-radius:999px; text-transform:uppercase; letter-spacing:0.5px;">
                School Partner Console
            </span>
            <h2 style="font-size:22px; font-weight:900; margin:8px 0 2px; color:#fff;">Welcome, {{ auth()->user()->name }} 👋</h2>
            <p style="font-size:13px; color:rgba(255,255,255,0.75); margin:0;">
                Manage your Patna school profiles, admissions, campus visit schedules, and parent enquiries.
            </p>
        </div>
        <div style="display:flex; gap:10px; flex-wrap:wrap;">
            <a href="{{ route('school-owner.schools.create') }}" style="background:#fff; color:#0f2d59; font-weight:800; font-size:13px; text-decoration:none; padding:10px 18px; border-radius:8px; display:inline-flex; align-items:center; gap:6px;">
                <i class="fas fa-plus"></i> Add New Campus
            </a>
            <a href="/" target="_blank" style="background:rgba(255,255,255,0.12); color:#fff; font-weight:700; font-size:13px; text-decoration:none; padding:10px 16px; border-radius:8px; display:inline-flex; align-items:center; gap:6px;">
                <i class="fas fa-external-link-alt"></i> Live Directory
            </a>
        </div>
    </div>
</div>

{{-- ── 2. KPI METRICS STRIP ── --}}
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(210px, 1fr)); gap:16px; margin-bottom:24px;">
    
    <div style="background:#fff; border:1.5px solid #e8ecf4; border-radius:12px; padding:18px; border-top:3px solid #3b82f6;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
            <span style="font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase;">My Campuses</span>
            <div style="width:32px; height:32px; background:#eff6ff; color:#3b82f6; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:13px;">
                <i class="fas fa-school"></i>
            </div>
        </div>
        <div style="font-size:24px; font-weight:900; color:#0f172a;">{{ $schools->count() }}</div>
        <div style="font-size:11.5px; color:#10b981; font-weight:700; margin-top:2px;">{{ $active }} Active Live</div>
    </div>

    <div style="background:#fff; border:1.5px solid #e8ecf4; border-radius:12px; padding:18px; border-top:3px solid #f59e0b;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
            <span style="font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase;">Pending Review</span>
            <div style="width:32px; height:32px; background:#fffbeb; color:#f59e0b; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:13px;">
                <i class="fas fa-hourglass-half"></i>
            </div>
        </div>
        <div style="font-size:24px; font-weight:900; color:#0f172a;">{{ $pending }}</div>
        <div style="font-size:11.5px; color:#d97706; margin-top:2px;">Under admin verification</div>
    </div>

    <div style="background:#fff; border:1.5px solid #e8ecf4; border-radius:12px; padding:18px; border-top:3px solid #10b981;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
            <span style="font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase;">Parent Enquiries</span>
            <div style="width:32px; height:32px; background:#ecfdf5; color:#10b981; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:13px;">
                <i class="fas fa-envelope-open-text"></i>
            </div>
        </div>
        <div style="font-size:24px; font-weight:900; color:#0f172a;">{{ $enquiriesTotal }}</div>
        <div style="font-size:11.5px; color:#10b981; font-weight:700; margin-top:2px;">{{ $enquiriesNew }} New Unread</div>
    </div>

    <div style="background:#fff; border:1.5px solid #e8ecf4; border-radius:12px; padding:18px; border-top:3px solid #8b5cf6;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
            <span style="font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase;">Quick Actions</span>
            <div style="width:32px; height:32px; background:#f5f3ff; color:#8b5cf6; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:13px;">
                <i class="fas fa-bolt"></i>
            </div>
        </div>
        <div style="font-size:13px; font-weight:800; color:#0f2d59; margin-top:4px;">
            <a href="{{ route('school-owner.visits.index') }}" style="color:#2563eb; text-decoration:none;">Campus Visits →</a>
        </div>
        <div style="font-size:11.5px; color:#64748b; margin-top:2px;">
            <a href="{{ route('school-owner.admissions.index') }}" style="color:#7c3aed; text-decoration:none;">Admissions Desk →</a>
        </div>
    </div>

</div>

{{-- ── 3. MANAGED CAMPUSES ── --}}
<div style="background:#fff; border:1.5px solid #e8ecf4; border-radius:14px; overflow:hidden; margin-bottom:24px; box-shadow:0 2px 8px rgba(0,0,0,0.02);">
    <div style="padding:16px 20px; border-bottom:1px solid #f1f5f9; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
        <strong style="font-size:15px; color:#0f2d59;">
            <i class="fas fa-school me-2 text-primary"></i>Managed School Profiles ({{ $schools->count() }})
        </strong>
        <a href="{{ route('school-owner.schools.create') }}" style="background:#0f2d59; color:#fff; font-size:12px; font-weight:800; text-decoration:none; padding:7px 14px; border-radius:6px; display:inline-flex; align-items:center; gap:5px;">
            <i class="fas fa-plus" style="font-size:10px;"></i> Add Campus
        </a>
    </div>

    @forelse($schools as $school)
    <div style="padding:16px 20px; border-bottom:1px solid #f8fafc; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:14px;">
        <div style="display:flex; align-items:center; gap:14px; min-width:280px; flex:1;">
            <div style="width:52px; height:52px; border-radius:10px; overflow:hidden; background:#f1f5f9; flex-shrink:0;">
                <img src="{{ $school->featured_image_url }}" alt="{{ $school->name }}" style="width:100%; height:100%; object-fit:cover;">
            </div>
            <div>
                <h5 style="font-size:15px; font-weight:800; color:#0f2d59; margin:0 0 2px;">{{ $school->name }}</h5>
                <div style="font-size:12px; color:#64748b; display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                    <span>📍 {{ $school->city ?? 'Patna' }}</span>
                    <span>•</span>
                    <span style="background:#eff6ff; color:#2563eb; padding:1px 7px; border-radius:4px; font-weight:700; font-size:11px;">{{ $school->board }}</span>
                    @if($school->fee_min && $school->fee_max)
                    <span>•</span>
                    <span>₹{{ number_format($school->fee_min) }} – ₹{{ number_format($school->fee_max) }}</span>
                    @endif
                </div>
            </div>
        </div>

        <div style="display:flex; align-items:center; gap:10px; flex-shrink:0;">
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
               style="background:#f1f5f9; color:#334155; font-size:12px; font-weight:700; text-decoration:none; padding:7px 14px; border-radius:6px;">
                <i class="fas fa-pen me-1"></i> Edit Profile & Gallery
            </a>
        </div>
    </div>
    @empty
    <div style="padding:50px 20px; text-align:center;">
        <div style="font-size:36px; margin-bottom:10px;">🏫</div>
        <h5 style="font-size:15px; font-weight:800; color:#0f2d59;">No School Campuses Listed Yet</h5>
        <p style="font-size:13px; color:#64748b; max-width:340px; margin:4px auto 16px;">
            List your Patna school for free to receive online admission forms and campus guided tours.
        </p>
        <a href="{{ route('school-owner.schools.create') }}" style="background:#0f2d59; color:#fff; font-size:13px; font-weight:800; text-decoration:none; padding:9px 20px; border-radius:8px; display:inline-block;">
            <i class="fas fa-plus me-1"></i> Add Your First Campus
        </a>
    </div>
    @endforelse
</div>

@endsection