@extends('admin.layout')

@section('title', 'Admission Applications – SchoolMapr Admin')
@section('page-title', 'Admission Applications')
@section('page-sub', 'Manage student applications, review verification documents and enrollment workflow')

@section('content')

{{-- ── 1. KPI STAT CARDS ── --}}
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(210px, 1fr)); gap:16px; margin-bottom:24px;">
    
    <div class="stat-card" style="border-top:3px solid #3b82f6;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
            <span style="font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.05em;">Total Applications</span>
            <div style="width:34px; height:34px; background:#eff6ff; border-radius:9px; display:flex; align-items:center; justify-content:center;">
                <i class="fas fa-file-signature" style="color:#3b82f6; font-size:14px;"></i>
            </div>
        </div>
        <div style="font-size:26px; font-weight:900; color:#0f172a;">{{ number_format($stats['total']) }}</div>
        <div style="font-size:11.5px; color:#64748b; margin-top:2px;">Across all partner schools</div>
    </div>

    <div class="stat-card" style="border-top:3px solid #f59e0b;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
            <span style="font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.05em;">Pending Review</span>
            <div style="width:34px; height:34px; background:#fffbeb; border-radius:9px; display:flex; align-items:center; justify-content:center;">
                <i class="fas fa-clock" style="color:#f59e0b; font-size:14px;"></i>
            </div>
        </div>
        <div style="font-size:26px; font-weight:900; color:#0f172a;">{{ number_format($stats['pending']) }}</div>
        <div style="font-size:11.5px; color:#d97706; margin-top:2px; font-weight:700;">Awaiting verification</div>
    </div>

    <div class="stat-card" style="border-top:3px solid #10b981;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
            <span style="font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.05em;">Approved Students</span>
            <div style="width:34px; height:34px; background:#ecfdf5; border-radius:9px; display:flex; align-items:center; justify-content:center;">
                <i class="fas fa-check-circle" style="color:#10b981; font-size:14px;"></i>
            </div>
        </div>
        <div style="font-size:26px; font-weight:900; color:#0f172a;">{{ number_format($stats['approved']) }}</div>
        <div style="font-size:11.5px; color:#10b981; margin-top:2px;">Offer letters issued</div>
    </div>

    <div class="stat-card" style="border-top:3px solid #ef4444;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
            <span style="font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.05em;">Rejected / Withdrawn</span>
            <div style="width:34px; height:34px; background:#fef2f2; border-radius:9px; display:flex; align-items:center; justify-content:center;">
                <i class="fas fa-times-circle" style="color:#ef4444; font-size:14px;"></i>
            </div>
        </div>
        <div style="font-size:26px; font-weight:900; color:#0f172a;">{{ number_format($stats['rejected']) }}</div>
        <div style="font-size:11.5px; color:#ef4444; margin-top:2px;">Seats declined / closed</div>
    </div>

</div>

{{-- ── 2. FILTER BAR ── --}}
<div class="panel" style="margin-bottom:18px;">
    <div style="padding:14px 18px;">
        <form method="GET" action="{{ route('admin.admissions') }}">
            <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
                
                {{-- Search --}}
                <div style="position:relative; flex:1; min-width:220px;">
                    <i class="fas fa-search" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:12px;"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search by student name, parent, or phone..."
                           style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:8px 12px 8px 34px; font-size:13px; outline:none; color:#1e293b; box-sizing:border-box;">
                </div>

                {{-- Status --}}
                <div style="min-width:140px;">
                    <select name="status" style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:8px 12px; font-size:13px; outline:none; color:#334155; background:#fff; box-sizing:border-box;">
                        <option value="">All Statuses</option>
                        <option value="pending"   {{ request('status')==='pending'   ? 'selected':'' }}>⏳ Pending Review</option>
                        <option value="reviewing" {{ request('status')==='reviewing' ? 'selected':'' }}>🔍 In Verification</option>
                        <option value="approved"  {{ request('status')==='approved'  ? 'selected':'' }}>✅ Approved</option>
                        <option value="rejected"  {{ request('status')==='rejected'  ? 'selected':'' }}>❌ Rejected</option>
                    </select>
                </div>

                {{-- School --}}
                <div style="min-width:180px;">
                    <select name="school_id" style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:8px 12px; font-size:13px; outline:none; color:#334155; background:#fff; box-sizing:border-box;">
                        <option value="">All Schools</option>
                        @foreach($schools as $id => $name)
                            <option value="{{ $id }}" {{ request('school_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" style="background:#0f2d59; color:#fff; border:none; border-radius:8px; padding:9px 18px; font-size:13px; font-weight:700; cursor:pointer;">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>

                @if(request()->hasAny(['search','status','school_id']))
                <a href="{{ route('admin.admissions') }}" style="font-size:12.5px; color:#ef4444; font-weight:700; text-decoration:none; margin-left:4px;">
                    <i class="fas fa-times me-1"></i> Clear
                </a>
                @endif

            </div>
        </form>
    </div>
</div>

{{-- ── 3. ADMISSION APPLICATIONS TABLE ── --}}
<div class="panel">
    <div class="panel-header">
        <div class="panel-title">
            <i class="fas fa-graduation-cap" style="color:#0f2d59;"></i>
            Admission Records ({{ $admissions->total() }})
        </div>
        <span style="font-size:11.5px; color:#64748b;">
            @if($admissions->total() > 0)
                Showing {{ $admissions->firstItem() }}–{{ $admissions->lastItem() }} of {{ $admissions->total() }}
            @endif
        </span>
    </div>

    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width:40px;">#</th>
                    <th>Student Details</th>
                    <th>School Campus</th>
                    <th>Parent / Contact</th>
                    <th>Applied Class</th>
                    <th>Registration Token</th>
                    <th>Status</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admissions as $i => $adm)
                <tr>
                    <td style="color:#94a3b8; font-size:12px;">{{ $admissions->firstItem() + $i }}</td>
                    
                    {{-- Student --}}
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div style="width:36px; height:36px; background:linear-gradient(135deg,#0f2d59,#1e40af); color:#fff; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:13px; flex-shrink:0;">
                                {{ strtoupper(substr($adm->student_name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight:800; color:#0f172a; font-size:13.5px;">{{ $adm->student_name }}</div>
                                <div style="font-size:11px; color:#64748b;">
                                    {{ ucfirst($adm->student_gender) }} • DOB: {{ \Carbon\Carbon::parse($adm->student_dob)->format('d M Y') }}
                                </div>
                            </div>
                        </div>
                    </td>

                    {{-- School --}}
                    <td>
                        @if($adm->school)
                            <a href="{{ route('school.show', $adm->school->slug) }}" target="_blank" style="font-weight:700; color:#2563eb; text-decoration:none; font-size:13px;">
                                {{ $adm->school->name }}
                            </a>
                            <div style="font-size:11px; color:#94a3b8;">{{ $adm->school->city ?? 'Patna' }}</div>
                        @else
                            <span style="color:#94a3b8;">—</span>
                        @endif
                    </td>

                    {{-- Parent --}}
                    <td>
                        <div style="font-weight:700; color:#1e293b; font-size:13px;">{{ $adm->parent_name }}</div>
                        <div style="font-size:11.5px; color:#64748b; display:flex; align-items:center; gap:4px; margin-top:2px;">
                            <i class="fas fa-phone-alt" style="font-size:10px; color:#10b981;"></i>
                            <a href="tel:{{ $adm->parent_phone }}" style="color:#334155; text-decoration:none;">{{ $adm->parent_phone }}</a>
                        </div>
                    </td>

                    {{-- Class --}}
                    <td>
                        <span style="font-size:11px; font-weight:800; background:#eff6ff; color:#2563eb; padding:3px 9px; border-radius:6px; border:1px solid #bfdbfe;">
                            {{ $adm->class_applying }}
                        </span>
                    </td>

                    {{-- Payment --}}
                    <td>
                        @if($adm->payment_id || ($adm->payment && $adm->payment->status === 'success'))
                            <span style="display:inline-flex; align-items:center; gap:4px; font-size:11px; font-weight:800; color:#059669; background:#ecfdf5; padding:3px 8px; border-radius:6px; border:1px solid #a7f3d0;">
                                <i class="fas fa-check-circle" style="font-size:10px;"></i> Paid ₹{{ number_format($adm->payment->amount ?? 1500) }}
                            </span>
                        @else
                            <span style="font-size:11px; font-weight:700; color:#94a3b8; background:#f1f5f9; padding:3px 8px; border-radius:6px;">
                                Direct Registration
                            </span>
                        @endif
                    </td>

                    {{-- Status --}}
                    <td>
                        @if($adm->status === 'approved')
                            <span style="display:inline-block; font-size:11px; font-weight:800; background:#ecfdf5; color:#059669; border:1px solid #a7f3d0; padding:3px 10px; border-radius:999px;">
                                ● Approved
                            </span>
                        @elseif($adm->status === 'pending')
                            <span style="display:inline-block; font-size:11px; font-weight:800; background:#fffbeb; color:#d97706; border:1px solid #fde68a; padding:3px 10px; border-radius:999px;">
                                ● Pending Review
                            </span>
                        @elseif($adm->status === 'reviewing')
                            <span style="display:inline-block; font-size:11px; font-weight:800; background:#eff6ff; color:#2563eb; border:1px solid #bfdbfe; padding:3px 10px; border-radius:999px;">
                                ● In Verification
                            </span>
                        @else
                            <span style="display:inline-block; font-size:11px; font-weight:800; background:#fef2f2; color:#dc2626; border:1px solid #fecaca; padding:3px 10px; border-radius:999px;">
                                ● Rejected
                            </span>
                        @endif
                    </td>

                    {{-- Actions --}}
                    <td style="text-align:right;">
                        <div style="display:inline-flex; gap:6px;">
                            @if($adm->status === 'pending' || $adm->status === 'reviewing')
                                <form action="{{ route('admin.schools.admissions.approve', [$adm->school_id, $adm->id]) }}" method="POST" style="display:inline;">
                                    @csrf @method('PATCH')
                                    <button type="submit" title="Approve Student"
                                            style="background:#10b981; color:#fff; border:none; border-radius:6px; padding:6px 10px; font-size:11.5px; font-weight:700; cursor:pointer;">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.schools.admissions.reject', [$adm->school_id, $adm->id]) }}" method="POST" style="display:inline;">
                                    @csrf @method('PATCH')
                                    <button type="submit" title="Reject Application" onclick="return confirm('Reject this admission application?')"
                                            style="background:#fee2e2; color:#dc2626; border:none; border-radius:6px; padding:6px 10px; font-size:11.5px; font-weight:700; cursor:pointer;">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            @else
                                <span style="font-size:11px; color:#94a3b8; font-weight:600;">Processed</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center; padding:50px 20px;">
                        <div style="font-size:36px; margin-bottom:8px;">📋</div>
                        <div style="font-size:14px; font-weight:700; color:#334155;">No Admission Applications Found</div>
                        <div style="font-size:12px; color:#94a3b8; margin-top:2px;">Applications submitted by parents will appear here automatically.</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($admissions->hasPages())
    <div style="padding:14px 20px; border-top:1px solid #f1f5f9;">
        {{ $admissions->links() }}
    </div>
    @endif
</div>

@endsection