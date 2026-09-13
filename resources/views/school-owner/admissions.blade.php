@extends('school-owner.layout')

@section('title', 'Admission Applications – SchoolMapr Partner')

@section('content')

{{-- Header --}}
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:12px;">
    <div>
        <h4 style="font-size:20px; font-weight:800; color:#0f2d59; margin:0;">
            <i class="fas fa-user-graduate me-2 text-primary"></i>Admission Applications Desk
        </h4>
        <p style="font-size:13px; color:#64748b; margin:4px 0 0;">
            Manage and verify online student admissions submitted by parents across your school campuses
        </p>
    </div>
</div>

{{-- Stats --}}
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(160px, 1fr)); gap:14px; margin-bottom:24px;">
    <div style="background:#fff; border:1.5px solid #e8ecf4; border-radius:12px; padding:16px; border-top:3px solid #3b82f6;">
        <div style="font-size:24px; font-weight:900; color:#0f2d59;">{{ $stats['total'] }}</div>
        <div style="font-size:11.5px; color:#64748b; font-weight:700; margin-top:2px;">Total Received</div>
    </div>
    <div style="background:#fff; border:1.5px solid #e8ecf4; border-radius:12px; padding:16px; border-top:3px solid #f59e0b;">
        <div style="font-size:24px; font-weight:900; color:#d97706;">{{ $stats['pending'] }}</div>
        <div style="font-size:11.5px; color:#d97706; font-weight:700; margin-top:2px;">Pending Review</div>
    </div>
    <div style="background:#fff; border:1.5px solid #e8ecf4; border-radius:12px; padding:16px; border-top:3px solid #6366f1;">
        <div style="font-size:24px; font-weight:900; color:#4f46e5;">{{ $stats['reviewing'] }}</div>
        <div style="font-size:11.5px; color:#4f46e5; font-weight:700; margin-top:2px;">In Verification</div>
    </div>
    <div style="background:#fff; border:1.5px solid #e8ecf4; border-radius:12px; padding:16px; border-top:3px solid #10b981;">
        <div style="font-size:24px; font-weight:900; color:#059669;">{{ $stats['approved'] }}</div>
        <div style="font-size:11.5px; color:#059669; font-weight:700; margin-top:2px;">Approved Seats</div>
    </div>
    <div style="background:#fff; border:1.5px solid #e8ecf4; border-radius:12px; padding:16px; border-top:3px solid #ef4444;">
        <div style="font-size:24px; font-weight:900; color:#dc2626;">{{ $stats['rejected'] }}</div>
        <div style="font-size:11.5px; color:#dc2626; font-weight:700; margin-top:2px;">Declined</div>
    </div>
</div>

@if(session('success'))
<div style="background:#ecfdf5; border:1px solid #a7f3d0; border-radius:10px; padding:12px 16px; color:#059669; font-weight:700; font-size:13px; margin-bottom:18px;">
    ✅ {{ session('success') }}
</div>
@endif

@if($admissions->isEmpty())
<div style="background:#fff; border:2px dashed #e2e8f0; border-radius:16px; padding:60px 20px; text-align:center;">
    <div style="font-size:48px; margin-bottom:12px;">📝</div>
    <h5 style="font-size:16px; font-weight:800; color:#0f2d59;">No Admissions Submitted Yet</h5>
    <p style="font-size:13px; color:#64748b; max-width:340px; margin:4px auto 0;">
        When parents apply online for your school, applications will appear here for verification.
    </p>
</div>
@else

<div style="background:#fff; border:1.5px solid #e8ecf4; border-radius:14px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.02);">
    <div style="padding:16px 20px; border-bottom:1px solid #f1f5f9; display:flex; justify-content:space-between; align-items:center;">
        <strong style="font-size:14px; color:#0f2d59;">Student Applications ({{ $admissions->total() }})</strong>
        <span style="font-size:12px; color:#64748b;">Showing {{ $admissions->firstItem() }}–{{ $admissions->lastItem() }}</span>
    </div>

    <div style="overflow-x:auto;">
        <table style="width:100%; border-collapse:collapse; text-align:left;">
            <thead>
                <tr style="background:#f8fafc; border-bottom:1.5px solid #eef2f6;">
                    <th style="padding:12px 16px; font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase;">#</th>
                    <th style="padding:12px 16px; font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase;">Student Details</th>
                    <th style="padding:12px 16px; font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase;">Parent / Contact</th>
                    <th style="padding:12px 16px; font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase;">Campus</th>
                    <th style="padding:12px 16px; font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase;">Class</th>
                    <th style="padding:12px 16px; font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase;">Status</th>
                    <th style="padding:12px 16px; font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase; text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($admissions as $i => $adm)
            @php
            $statusMap = [
                'pending'   => ['#fffbeb','#d97706','#fde68a','⏳ Pending Review'],
                'reviewing' => ['#eff6ff','#2563eb','#bfdbfe','🔍 In Verification'],
                'approved'  => ['#ecfdf5','#059669','#a7f3d0','✅ Approved'],
                'rejected'  => ['#fef2f2','#dc2626','#fecaca','❌ Rejected'],
            ];
            $s = $statusMap[$adm->status] ?? ['#f1f5f9','#64748b','#e2e8f0','— Unknown'];
            @endphp

            <tr style="border-bottom:1px solid #f1f5f9;">
                <td style="padding:14px 16px; font-size:12px; color:#94a3b8;">
                    {{ $admissions->firstItem() + $i }}
                </td>
                <td style="padding:14px 16px;">
                    <div style="font-size:14px; font-weight:800; color:#0f2d59;">{{ $adm->student_name }}</div>
                    <div style="font-size:11px; color:#64748b; margin-top:2px;">
                        DOB: {{ \Carbon\Carbon::parse($adm->student_dob)->format('d M Y') }} • {{ ucfirst($adm->student_gender) }}
                    </div>
                </td>
                <td style="padding:14px 16px;">
                    <div style="font-size:13px; font-weight:700; color:#1e293b;">{{ $adm->parent_name }}</div>
                    <div style="font-size:11.5px; color:#64748b; margin-top:2px;">
                        <a href="tel:{{ $adm->parent_phone }}" style="color:#334155; text-decoration:none;">📞 {{ $adm->parent_phone }}</a>
                    </div>
                </td>
                <td style="padding:14px 16px; font-size:12.5px; color:#334155;">
                    {{ $adm->school->name ?? '—' }}
                </td>
                <td style="padding:14px 16px;">
                    <span style="font-size:11px; font-weight:800; background:#eff6ff; color:#2563eb; padding:3px 8px; border-radius:6px; border:1px solid #bfdbfe;">
                        {{ $adm->class_applying }}
                    </span>
                </td>
                <td style="padding:14px 16px;">
                    <span style="display:inline-block; font-size:11px; font-weight:800; background:{{ $s[0] }}; color:{{ $s[1] }}; border:1px solid {{ $s[2] }}; padding:3px 10px; border-radius:999px;">
                        {{ $s[3] }}
                    </span>
                </td>
                <td style="padding:14px 16px; text-align:right;">
                    <div style="display:inline-flex; gap:6px;">
                        @if($adm->status === 'pending' || $adm->status === 'reviewing')
                        <form method="POST" action="{{ route('school-owner.admissions.approve', $adm->id) }}" style="display:inline;">
                            @csrf @method('PATCH')
                            <button type="submit" title="Approve Student"
                                    style="background:#10b981; color:#fff; border:none; border-radius:6px; padding:6px 11px; font-size:11.5px; font-weight:700; cursor:pointer;">
                                <i class="fas fa-check me-1"></i> Approve
                            </button>
                        </form>
                        <form method="POST" action="{{ route('school-owner.admissions.reject', $adm->id) }}" style="display:inline;" onsubmit="return confirm('Reject this admission application?')">
                            @csrf @method('PATCH')
                            <button type="submit" title="Reject Student"
                                    style="background:#fee2e2; color:#dc2626; border:none; border-radius:6px; padding:6px 11px; font-size:11.5px; font-weight:700; cursor:pointer;">
                                <i class="fas fa-times me-1"></i> Reject
                            </button>
                        </form>
                        @else
                        <span style="font-size:11.5px; color:#94a3b8; font-weight:600;">Processed</span>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    @if($admissions->hasPages())
    <div style="padding:14px 20px; border-top:1px solid #f1f5f9;">
        {{ $admissions->links() }}
    </div>
    @endif
</div>

@endif

@endsection