@extends('admin.layout')
@section('title', $school->name . ' — Parent Dossier & Campus Hub')

@section('content')

{{-- Back Button + Header --}}
<div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:22px; flex-wrap:wrap; gap:12px;">
    <div style="display:flex; align-items:center; gap:12px;">
        <a href="{{ route('admin.schools') }}"
           style="background:#fff; color:#0f2d59; border:1.5px solid #e2e8f0; border-radius:8px; padding:8px 14px; font-size:13px; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
            <i class="fas fa-arrow-left"></i> Back to Schools
        </a>
        <div>
            <h1 style="font-size:20px; font-weight:800; color:#0f2d59; margin:0;">
                🏫 {{ $school->name }}
            </h1>
            <p style="font-size:12.5px; color:#64748b; margin:4px 0 0; display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                <span>📍 {{ $school->city }}, {{ $school->state ?? 'Bihar' }} • {{ $school->board }} • Class {{ $school->class_from }}–{{ $school->class_to }}</span>
                @if(($school->admission_status ?? 'open') === 'open')
                    <span style="font-size:11px; background:#ecfdf5; color:#15803d; border:1px solid #86efac; padding:1px 8px; border-radius:999px; font-weight:800;">
                        🟢 Admission Open (2026-27)
                    </span>
                @elseif($school->admission_status === 'coming_soon')
                    <span style="font-size:11px; background:#fffbeb; color:#b45309; border:1px solid #fde68a; padding:1px 8px; border-radius:999px; font-weight:800;">
                        🟡 Admission Opening Soon
                    </span>
                @else
                    <span style="font-size:11px; background:#fef2f2; color:#b91c1c; border:1px solid #fecaca; padding:1px 8px; border-radius:999px; font-weight:800;">
                        🔴 Admission Closed
                    </span>
                @endif
            </p>
        </div>
    </div>
    <div style="display:flex; gap:8px; flex-wrap:wrap;">
        <a href="{{ route('admin.schools.export-parents', $school->id) }}"
           style="background:#0f2d59; color:#fff; border-radius:8px; padding:8px 16px; font-size:12.5px; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
            <i class="fas fa-file-csv"></i> 📥 Export All Parents CSV
        </a>
        <a href="{{ route('admin.schools.crud.edit', $school->id) }}"
           style="background:#eff6ff; color:#2563eb; border:1px solid #bfdbfe; border-radius:8px; padding:8px 14px; font-size:12.5px; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:5px;">
            <i class="fas fa-pen"></i> Edit Profile
        </a>
        @if($school->slug)
        <a href="{{ url('/schools/' . $school->slug) }}" target="_blank"
           style="background:#fff; color:#0f2d59; border:1.5px solid #e2e8f0; border-radius:8px; padding:8px 14px; font-size:12.5px; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:5px;">
            <i class="fas fa-external-link-alt"></i> Live Page
        </a>
        @endif
    </div>
</div>

{{-- Flash Messages --}}
@if(session('success'))
<div style="background:#ecfdf5; border:1px solid #a7f3d0; color:#059669; border-radius:10px; padding:12px 16px; margin-bottom:18px; font-size:13px; font-weight:700;">
    {{ session('success') }}
</div>
@endif
@if(session('error'))
<div style="background:#fef2f2; border:1px solid #fecaca; color:#dc2626; border-radius:10px; padding:12px 16px; margin-bottom:18px; font-size:13px; font-weight:700;">
    {{ session('error') }}
</div>
@endif

{{-- 4 KPI Stats Row --}}
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(180px, 1fr)); gap:14px; margin-bottom:22px;">
    <div style="background:#fff; border:1.5px solid #e8ecf4; border-radius:12px; padding:16px; border-top:3px solid #3b82f6;">
        <div style="font-size:24px; font-weight:900; color:#0f2d59;">{{ $stats['total_admissions'] }}</div>
        <div style="font-size:11.5px; color:#64748b; font-weight:700; margin-top:2px;">Student Admissions</div>
    </div>
    <div style="background:#fff; border:1.5px solid #e8ecf4; border-radius:12px; padding:16px; border-top:3px solid #10b981;">
        <div style="font-size:24px; font-weight:900; color:#059669;">{{ $stats['total_visits'] }}</div>
        <div style="font-size:11.5px; color:#059669; font-weight:700; margin-top:2px;">Campus Visit Bookings</div>
    </div>
    <div style="background:#fff; border:1.5px solid #e8ecf4; border-radius:12px; padding:16px; border-top:3px solid #f59e0b;">
        <div style="font-size:24px; font-weight:900; color:#d97706;">{{ $stats['total_enquiries'] }}</div>
        <div style="font-size:11.5px; color:#d97706; font-weight:700; margin-top:2px;">Enquiries & Prospectus</div>
    </div>
    <div style="background:#fff; border:1.5px solid #e8ecf4; border-radius:12px; padding:16px; border-top:3px solid #8b5cf6;">
        <div style="font-size:24px; font-weight:900; color:#7c3aed;">₹{{ number_format($stats['total_collections']) }}</div>
        <div style="font-size:11.5px; color:#7c3aed; font-weight:700; margin-top:2px;">Verified Fee Collections</div>
    </div>
</div>

{{-- Top Info Grid: Campus Details & Owner Partner --}}
<div style="display:grid; grid-template-columns:1.2fr 0.8fr; gap:16px; margin-bottom:24px;">

    {{-- Campus Details --}}
    <div style="background:#fff; border:1.5px solid #e8ecf4; border-radius:14px; padding:20px;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px; border-bottom:1px solid #f1f5f9; padding-bottom:10px;">
            <strong style="font-size:14px; color:#0f2d59;"><i class="fas fa-building me-2 text-primary"></i>Campus Profile Details</strong>
            <span style="font-size:11px; font-weight:800; background:#ecfdf5; color:#059669; border:1px solid #a7f3d0; padding:2px 8px; border-radius:999px;">
                ● {{ ucfirst($school->status) }}
            </span>
        </div>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; font-size:12.5px;">
            <div><span style="color:#64748b;">Principal:</span> <strong>{{ $school->principal_name ?? '—' }}</strong></div>
            <div><span style="color:#64748b;">Affiliation:</span> <strong>{{ $school->affiliation_no ?? '—' }}</strong></div>
            <div><span style="color:#64748b;">Phone:</span> <a href="tel:{{ $school->phone }}" style="color:#0f2d59; text-decoration:none; font-weight:700;">{{ $school->phone ?? '—' }}</a></div>
            <div><span style="color:#64748b;">Email:</span> <strong>{{ $school->email ?? '—' }}</strong></div>
            <div><span style="color:#64748b;">Prospectus:</span>
                @if($school->prospectus_path)
                    <a href="{{ $school->prospectus_url }}" target="_blank" style="color:#2563eb; font-weight:700;">📄 View PDF</a>
                @else
                    <span style="color:#94a3b8;">Not Uploaded</span>
                @endif
            </div>
            <div><span style="color:#64748b;">Address:</span> <strong>{{ $school->address }}</strong></div>
        </div>
    </div>

    {{-- School Partner Card --}}
    <div style="background:#fff; border:1.5px solid #e8ecf4; border-radius:14px; padding:20px;">
        <div style="margin-bottom:14px; border-bottom:1px solid #f1f5f9; padding-bottom:10px;">
            <strong style="font-size:14px; color:#0f2d59;"><i class="fas fa-user-shield me-2 text-primary"></i>Assigned School Partner</strong>
        </div>
        @if($school->owner)
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:12px;">
                <div style="width:40px; height:40px; border-radius:50%; background:#0f2d59; color:#fff; display:flex; align-items:center; justify-content:center; font-weight:900; font-size:15px;">
                    {{ strtoupper(substr($school->owner->name, 0, 1)) }}
                </div>
                <div>
                    <div style="font-weight:800; color:#0f2d59; font-size:14px;">{{ $school->owner->name }}</div>
                    <div style="font-size:12px; color:#64748b;">{{ $school->owner->email }}</div>
                </div>
            </div>
            <div style="font-size:11.5px; color:#059669; font-weight:700; background:#ecfdf5; padding:6px 10px; border-radius:6px;">
                ✅ Partner has direct portal access to verify admissions and inquiries.
            </div>
        @else
            <div style="background:#fffbeb; border:1px solid #fde68a; border-radius:8px; padding:12px; margin-bottom:12px; font-size:12px; color:#92400e;">
                ⚠️ No Partner claimed this school yet. Admin manages admissions and tours directly.
            </div>
        @endif
    </div>

</div>

{{-- ═══════════════════════════════════════════════════════
     TABLE 1: ADMISSIONS APPLICATIONS (PARENTS)
═══════════════════════════════════════════════════════ --}}
<div style="background:#fff; border:1.5px solid #e8ecf4; border-radius:14px; margin-bottom:24px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.02);">
    <div style="padding:16px 20px; border-bottom:1px solid #f1f5f9; display:flex; justify-content:space-between; align-items:center;">
        <strong style="font-size:14px; color:#0f2d59;"><i class="fas fa-user-graduate me-2 text-primary"></i>Parent Admission Applications ({{ $admissions->total() }})</strong>
        <span style="font-size:12px; color:#64748b;">Page {{ $admissions->currentPage() }} of {{ $admissions->lastPage() }}</span>
    </div>

    <div style="overflow-x:auto;">
        <table class="data-table" style="width:100%; border-collapse:collapse; text-align:left;">
            <thead>
                <tr style="background:#f8fafc; border-bottom:1.5px solid #eef2f6;">
                    <th style="padding:12px 16px; font-size:11px; font-weight:800; color:#64748b;">#</th>
                    <th style="padding:12px 16px; font-size:11px; font-weight:800; color:#64748b;">Student Details</th>
                    <th style="padding:12px 16px; font-size:11px; font-weight:800; color:#64748b;">Class</th>
                    <th style="padding:12px 16px; font-size:11px; font-weight:800; color:#64748b;">Parent Contact</th>
                    <th style="padding:12px 16px; font-size:11px; font-weight:800; color:#64748b;">Fee Status</th>
                    <th style="padding:12px 16px; font-size:11px; font-weight:800; color:#64748b;">Status</th>
                    <th style="padding:12px 16px; font-size:11px; font-weight:800; color:#64748b;">Applied Date</th>
                </tr>
            </thead>
            <tbody>
            @forelse($admissions as $i => $adm)
            @php
            $statusMap = [
                'pending'   => ['#fffbeb','#d97706','#fde68a','⏳ Pending'],
                'reviewing' => ['#eff6ff','#2563eb','#bfdbfe','🔍 In Review'],
                'approved'  => ['#ecfdf5','#059669','#a7f3d0','✅ Approved'],
                'rejected'  => ['#fef2f2','#dc2626','#fecaca','❌ Rejected'],
            ];
            $s = $statusMap[$adm->status] ?? ['#f1f5f9','#64748b','#e2e8f0','— Unknown'];
            @endphp
            <tr style="border-bottom:1px solid #f1f5f9;">
                <td style="padding:14px 16px; font-size:12px; color:#94a3b8;">{{ $admissions->firstItem() + $i }}</td>
                <td style="padding:14px 16px;">
                    <div style="font-size:13.5px; font-weight:800; color:#0f2d59;">{{ $adm->student_name }}</div>
                    <div style="font-size:11px; color:#64748b; margin-top:2px;">DOB: {{ \Carbon\Carbon::parse($adm->student_dob)->format('d M Y') }}</div>
                </td>
                <td style="padding:14px 16px;">
                    <span style="background:#eff6ff; color:#2563eb; border:1px solid #bfdbfe; font-size:11px; font-weight:800; padding:3px 8px; border-radius:6px;">
                        {{ $adm->class_applying }}
                    </span>
                </td>
                <td style="padding:14px 16px;">
                    <div style="font-size:13px; font-weight:700; color:#1e293b;">{{ $adm->parent_name }}</div>
                    <div style="font-size:11.5px; color:#64748b; margin-top:2px;"><a href="tel:{{ $adm->parent_phone }}" style="color:#334155; text-decoration:none;">📞 {{ $adm->parent_phone }}</a></div>
                </td>
                <td style="padding:14px 16px;">
                    @if($adm->payment_id)
                        <span style="background:#ecfdf5; color:#059669; font-size:11px; font-weight:800; padding:2px 8px; border-radius:999px;">✅ Paid Token</span>
                    @else
                        <span style="background:#f1f5f9; color:#64748b; font-size:11px; font-weight:600; padding:2px 8px; border-radius:999px;">Direct</span>
                    @endif
                </td>
                <td style="padding:14px 16px;">
                    <span style="display:inline-block; font-size:11px; font-weight:800; background:{{ $s[0] }}; color:{{ $s[1] }}; border:1px solid {{ $s[2] }}; padding:3px 10px; border-radius:999px;">
                        {{ $s[3] }}
                    </span>
                </td>
                <td style="padding:14px 16px; font-size:12.5px; color:#64748b;">
                    {{ $adm->created_at->format('d M Y') }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center; padding:32px 20px; color:#94a3b8;">
                    No admission applications submitted yet for this school.
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    @if($admissions->hasPages())
    <div style="padding:12px 18px; border-top:1px solid #f1f5f9;">
        {{ $admissions->appends(request()->except('adm_page'))->links() }}
    </div>
    @endif
</div>

{{-- ═══════════════════════════════════════════════════════
     TABLE 2: CAMPUS VISIT BOOKINGS (PARENTS)
═══════════════════════════════════════════════════════ --}}
<div style="background:#fff; border:1.5px solid #e8ecf4; border-radius:14px; margin-bottom:24px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.02);">
    <div style="padding:16px 20px; border-bottom:1px solid #f1f5f9; display:flex; justify-content:space-between; align-items:center;">
        <strong style="font-size:14px; color:#0f2d59;"><i class="fas fa-calendar-check me-2 text-primary"></i>Scheduled Campus Visits ({{ $visits->total() }})</strong>
        <span style="font-size:12px; color:#64748b;">Page {{ $visits->currentPage() }} of {{ $visits->lastPage() }}</span>
    </div>

    <div style="overflow-x:auto;">
        <table class="data-table" style="width:100%; border-collapse:collapse; text-align:left;">
            <thead>
                <tr style="background:#f8fafc; border-bottom:1.5px solid #eef2f6;">
                    <th style="padding:12px 16px; font-size:11px; font-weight:800; color:#64748b;">#</th>
                    <th style="padding:12px 16px; font-size:11px; font-weight:800; color:#64748b;">Parent / Visitor</th>
                    <th style="padding:12px 16px; font-size:11px; font-weight:800; color:#64748b;">Scheduled Slot</th>
                    <th style="padding:12px 16px; font-size:11px; font-weight:800; color:#64748b;">Status</th>
                    <th style="padding:12px 16px; font-size:11px; font-weight:800; color:#64748b;">Booked Date</th>
                </tr>
            </thead>
            <tbody>
            @forelse($visits as $i => $vis)
            @php
            $statusMap = [
                'pending'   => ['#fffbeb','#d97706','#fde68a','⏳ Pending Slot'],
                'confirmed' => ['#ecfdf5','#059669','#a7f3d0','✅ Confirmed'],
                'completed' => ['#f5f3ff','#7c3aed','#ddd6fe','🏁 Completed'],
                'cancelled' => ['#fef2f2','#dc2626','#fecaca','❌ Cancelled'],
            ];
            $s = $statusMap[$vis->status] ?? ['#f1f5f9','#64748b','#e2e8f0','— Unknown'];
            @endphp
            <tr style="border-bottom:1px solid #f1f5f9;">
                <td style="padding:14px 16px; font-size:12px; color:#94a3b8;">{{ $visits->firstItem() + $i }}</td>
                <td style="padding:14px 16px;">
                    <div style="font-size:13.5px; font-weight:800; color:#0f2d59;">{{ $vis->visitor_name }}</div>
                    <div style="font-size:11.5px; color:#64748b; margin-top:2px;"><a href="tel:{{ $vis->visitor_phone }}" style="color:#334155; text-decoration:none;">📞 {{ $vis->visitor_phone }}</a></div>
                </td>
                <td style="padding:14px 16px;">
                    <div style="font-size:13px; font-weight:800; color:#0f2d59;">📅 {{ \Carbon\Carbon::parse($vis->visit_date)->format('D, d M Y') }}</div>
                    <div style="font-size:11.5px; color:#64748b; margin-top:2px;">⏰ {{ \Carbon\Carbon::parse($vis->visit_time)->format('h:i A') }}</div>
                </td>
                <td style="padding:14px 16px;">
                    <span style="display:inline-block; font-size:11px; font-weight:800; background:{{ $s[0] }}; color:{{ $s[1] }}; border:1px solid {{ $s[2] }}; padding:3px 10px; border-radius:999px;">
                        {{ $s[3] }}
                    </span>
                </td>
                <td style="padding:14px 16px; font-size:12.5px; color:#64748b;">
                    {{ $vis->created_at->format('d M Y') }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center; padding:32px 20px; color:#94a3b8;">
                    No campus visit appointments booked yet for this school.
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    @if($visits->hasPages())
    <div style="padding:12px 18px; border-top:1px solid #f1f5f9;">
        {{ $visits->appends(request()->except('vis_page'))->links() }}
    </div>
    @endif
</div>

{{-- ═══════════════════════════════════════════════════════
     TABLE 3: ENQUIRIES & PROSPECTUS REQUESTS
═══════════════════════════════════════════════════════ --}}
<div style="background:#fff; border:1.5px solid #e8ecf4; border-radius:14px; margin-bottom:24px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.02);">
    <div style="padding:16px 20px; border-bottom:1px solid #f1f5f9; display:flex; justify-content:space-between; align-items:center;">
        <strong style="font-size:14px; color:#0f2d59;"><i class="fas fa-paper-plane me-2 text-primary"></i>Inquiries & Prospectus Leads ({{ $enquiries->total() }})</strong>
        <span style="font-size:12px; color:#64748b;">Page {{ $enquiries->currentPage() }} of {{ $enquiries->lastPage() }}</span>
    </div>

    <div style="overflow-x:auto;">
        <table class="data-table" style="width:100%; border-collapse:collapse; text-align:left;">
            <thead>
                <tr style="background:#f8fafc; border-bottom:1.5px solid #eef2f6;">
                    <th style="padding:12px 16px; font-size:11px; font-weight:800; color:#64748b;">#</th>
                    <th style="padding:12px 16px; font-size:11px; font-weight:800; color:#64748b;">Parent Details</th>
                    <th style="padding:12px 16px; font-size:11px; font-weight:800; color:#64748b;">Target Class</th>
                    <th style="padding:12px 16px; font-size:11px; font-weight:800; color:#64748b;">Inquiry / Request Query</th>
                    <th style="padding:12px 16px; font-size:11px; font-weight:800; color:#64748b;">Status</th>
                    <th style="padding:12px 16px; font-size:11px; font-weight:800; color:#64748b;">Received Date</th>
                </tr>
            </thead>
            <tbody>
            @forelse($enquiries as $i => $enq)
            <tr style="border-bottom:1px solid #f1f5f9;">
                <td style="padding:14px 16px; font-size:12px; color:#94a3b8;">{{ $enquiries->firstItem() + $i }}</td>
                <td style="padding:14px 16px;">
                    <div style="font-size:13.5px; font-weight:800; color:#0f2d59;">{{ $enq->parent_name }}</div>
                    <div style="font-size:11.5px; color:#64748b; margin-top:2px;"><a href="tel:{{ $enq->mobile }}" style="color:#334155; text-decoration:none;">📞 {{ $enq->mobile }}</a></div>
                </td>
                <td style="padding:14px 16px;">
                    <span style="background:#eff6ff; color:#2563eb; border:1px solid #bfdbfe; font-size:11px; font-weight:800; padding:3px 8px; border-radius:6px;">
                        {{ $enq->child_class ?? 'General' }}
                    </span>
                </td>
                <td style="padding:14px 16px; font-size:12.5px; color:#334155; max-width:320px;">
                    {{ $enq->message ?? 'Requested general admission details.' }}
                </td>
                <td style="padding:14px 16px;">
                    <span style="background:#eff6ff; color:#2563eb; border:1px solid #bfdbfe; font-size:11px; font-weight:800; padding:3px 10px; border-radius:999px; text-transform:capitalize;">
                        ● {{ $enq->status ?? 'New' }}
                    </span>
                </td>
                <td style="padding:14px 16px; font-size:12.5px; color:#64748b;">
                    {{ $enq->created_at->format('d M Y') }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center; padding:32px 20px; color:#94a3b8;">
                    No inquiries or prospectus requests received yet for this school.
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    @if($enquiries->hasPages())
    <div style="padding:12px 18px; border-top:1px solid #f1f5f9;">
        {{ $enquiries->appends(request()->except('enq_page'))->links() }}
    </div>
    @endif
</div>

@endsection