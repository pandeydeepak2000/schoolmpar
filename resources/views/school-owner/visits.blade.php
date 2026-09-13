@extends('school-owner.layout')

@section('title', 'Campus Visit Appointments – SchoolMapr Partner')

@section('content')

{{-- Header --}}
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:12px;">
    <div>
        <h4 style="font-size:20px; font-weight:800; color:#0f2d59; margin:0;">
            <i class="fas fa-calendar-check me-2 text-primary"></i>Campus Visit Appointments
        </h4>
        <p style="font-size:13px; color:#64748b; margin:4px 0 0;">
            Manage on-campus parent tours, confirm visiting time slots, and track completed appointments
        </p>
    </div>
</div>

{{-- Stats --}}
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(160px, 1fr)); gap:14px; margin-bottom:24px;">
    <div style="background:#fff; border:1.5px solid #e8ecf4; border-radius:12px; padding:16px; border-top:3px solid #3b82f6;">
        <div style="font-size:24px; font-weight:900; color:#0f2d59;">{{ $stats['total'] }}</div>
        <div style="font-size:11.5px; color:#64748b; font-weight:700; margin-top:2px;">Total Bookings</div>
    </div>
    <div style="background:#fff; border:1.5px solid #e8ecf4; border-radius:12px; padding:16px; border-top:3px solid #f59e0b;">
        <div style="font-size:24px; font-weight:900; color:#d97706;">{{ $stats['pending'] }}</div>
        <div style="font-size:11.5px; color:#d97706; font-weight:700; margin-top:2px;">Pending Slot</div>
    </div>
    <div style="background:#fff; border:1.5px solid #e8ecf4; border-radius:12px; padding:16px; border-top:3px solid #10b981;">
        <div style="font-size:24px; font-weight:900; color:#059669;">{{ $stats['confirmed'] }}</div>
        <div style="font-size:11.5px; color:#059669; font-weight:700; margin-top:2px;">Confirmed Slots</div>
    </div>
    <div style="background:#fff; border:1.5px solid #e8ecf4; border-radius:12px; padding:16px; border-top:3px solid #8b5cf6;">
        <div style="font-size:24px; font-weight:900; color:#7c3aed;">{{ $stats['completed'] }}</div>
        <div style="font-size:11.5px; color:#7c3aed; font-weight:700; margin-top:2px;">Concluded Tours</div>
    </div>
</div>

{{-- Filters Panel --}}
<div style="background:#fff; border:1.5px solid #e8ecf4; border-radius:14px; padding:14px 18px; margin-bottom:20px;">
    <form method="GET" action="{{ route('school-owner.visits.index') }}"
          style="display:flex; gap:12px; flex-wrap:wrap; align-items:center;">
        <div>
            <select name="status" style="border:1.5px solid #e2e8f0; border-radius:8px; padding:8px 12px; font-size:13px; outline:none; color:#334155; background:#fff;">
                <option value="">All Statuses</option>
                @foreach(['pending','confirmed','completed','cancelled'] as $st)
                <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>
                    {{ ucfirst($st) }}
                </option>
                @endforeach
            </select>
        </div>
        <div>
            <input type="date" name="date" style="border:1.5px solid #e2e8f0; border-radius:8px; padding:8px 12px; font-size:13px; outline:none; color:#334155; background:#fff;"
                   value="{{ request('date') }}">
        </div>
        <button type="submit" style="background:#0f2d59; color:#fff; border:none; border-radius:8px; padding:8px 18px; font-size:13px; font-weight:700; cursor:pointer;">
            <i class="fas fa-filter me-1"></i> Filter
        </button>
        @if(request('status') || request('date'))
        <a href="{{ route('school-owner.visits.index') }}"
           style="font-size:12.5px; color:#ef4444; text-decoration:none; font-weight:700; margin-left:4px;">
            <i class="fas fa-times me-1"></i> Clear
        </a>
        @endif
    </form>
</div>

@if(session('success'))
<div style="background:#ecfdf5; border:1px solid #a7f3d0; border-radius:10px; padding:12px 16px; color:#059669; font-weight:700; font-size:13px; margin-bottom:18px;">
    ✅ {{ session('success') }}
</div>
@endif

{{-- Visits List --}}
@if($visits->isEmpty())
<div style="background:#fff; border:2px dashed #e2e8f0; border-radius:16px; padding:60px 20px; text-align:center;">
    <div style="font-size:48px; margin-bottom:12px;">📅</div>
    <h5 style="font-size:16px; font-weight:800; color:#0f2d59;">No Campus Visits Scheduled Yet</h5>
    <p style="font-size:13px; color:#64748b; max-width:340px; margin:4px auto 0;">
        When parents book a campus tour to inspect your school facilities, they will appear here.
    </p>
</div>

@else

<div style="background:#fff; border:1.5px solid #e8ecf4; border-radius:14px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.02);">
    <div style="padding:16px 20px; border-bottom:1px solid #f1f5f9; display:flex; justify-content:space-between; align-items:center;">
        <strong style="font-size:14px; color:#0f2d59;">Scheduled Appointments ({{ $visits->total() }})</strong>
        <span style="font-size:12px; color:#64748b;">Showing {{ $visits->firstItem() }}–{{ $visits->lastItem() }}</span>
    </div>

    <div style="overflow-x:auto;">
        <table style="width:100%; border-collapse:collapse; text-align:left;">
            <thead>
                <tr style="background:#f8fafc; border-bottom:1.5px solid #eef2f6;">
                    <th style="padding:12px 16px; font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase;">#</th>
                    <th style="padding:12px 16px; font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase;">Visitor Contact</th>
                    <th style="padding:12px 16px; font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase;">Campus</th>
                    <th style="padding:12px 16px; font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase;">Scheduled Date & Slot</th>
                    <th style="padding:12px 16px; font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase;">Status</th>
                    <th style="padding:12px 16px; font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase; text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($visits as $i => $visit)
            @php
            $statusMap = [
                'pending'   => ['#fffbeb','#d97706','#fde68a','⏳ Pending Slot'],
                'confirmed' => ['#ecfdf5','#059669','#a7f3d0','✅ Confirmed'],
                'completed' => ['#f5f3ff','#7c3aed','#ddd6fe','🏁 Completed'],
                'cancelled' => ['#fef2f2','#dc2626','#fecaca','❌ Cancelled'],
            ];
            $s = $statusMap[$visit->status] ?? ['#f1f5f9','#64748b','#e2e8f0','— Unknown'];
            @endphp

            <tr style="border-bottom:1px solid #f1f5f9;">
                <td style="padding:14px 16px; font-size:12px; color:#94a3b8;">
                    {{ $visits->firstItem() + $i }}
                </td>
                <td style="padding:14px 16px;">
                    <div style="font-size:14px; font-weight:800; color:#0f2d59;">{{ $visit->visitor_name }}</div>
                    <div style="font-size:11.5px; color:#64748b; margin-top:2px; display:flex; align-items:center; gap:6px;">
                        <a href="tel:{{ $visit->visitor_phone }}" style="color:#334155; text-decoration:none; font-weight:700;">📞 {{ $visit->visitor_phone }}</a>
                        @php
                            $cleanPhone = preg_replace('/[^0-9]/', '', $visit->visitor_phone);
                            if (strlen($cleanPhone) == 10) $cleanPhone = '91' . $cleanPhone;
                            $waMsg = urlencode("Hello {$visit->visitor_name}, thank you for scheduling a campus visit to " . ($visit->school->name ?? 'our school') . " on " . \Carbon\Carbon::parse($visit->visit_date)->format('d M Y') . " at " . \Carbon\Carbon::parse($visit->visit_time)->format('h:i A') . ". We look forward to welcoming you!");
                        @endphp
                        <a href="https://wa.me/{{ $cleanPhone }}?text={{ $waMsg }}" target="_blank"
                           style="background:#25d366; color:#fff; border-radius:4px; padding:2px 6px; font-size:10px; font-weight:800; text-decoration:none; display:inline-flex; align-items:center; gap:3px;">
                            <i class="fab fa-whatsapp"></i> Chat
                        </a>
                    </div>
                </td>
                <td style="padding:14px 16px; font-size:13px; color:#334155; font-weight:600;">
                    {{ $visit->school->name ?? '—' }}
                </td>
                <td style="padding:14px 16px;">
                    <div style="font-size:13px; font-weight:800; color:#0f2d59;">
                        📅 {{ \Carbon\Carbon::parse($visit->visit_date)->format('D, d M Y') }}
                    </div>
                    <div style="font-size:11.5px; color:#64748b; margin-top:2px;">
                        ⏰ {{ \Carbon\Carbon::parse($visit->visit_time)->format('h:i A') }}
                    </div>
                </td>
                <td style="padding:14px 16px;">
                    <span style="display:inline-block; font-size:11px; font-weight:800; background:{{ $s[0] }}; color:{{ $s[1] }}; border:1px solid {{ $s[2] }}; padding:3px 10px; border-radius:999px;">
                        {{ $s[3] }}
                    </span>
                </td>
                <td style="padding:14px 16px; text-align:right;">
                    <div style="display:inline-flex; gap:6px;">
                        @if($visit->status === 'pending')
                        <form method="POST" action="{{ route('school-owner.visits.confirm', $visit->id) }}" style="display:inline;">
                            @csrf
                            <button type="submit" style="background:#10b981; color:#fff; border:none; border-radius:6px; padding:6px 11px; font-size:11.5px; font-weight:700; cursor:pointer;">
                                <i class="fas fa-check me-1"></i> Confirm
                            </button>
                        </form>
                        <form method="POST" action="{{ route('school-owner.visits.reject', $visit->id) }}" style="display:inline;" onsubmit="return confirm('Cancel this visit appointment?')">
                            @csrf
                            <button type="submit" style="background:#fee2e2; color:#dc2626; border:none; border-radius:6px; padding:6px 11px; font-size:11.5px; font-weight:700; cursor:pointer;">
                                <i class="fas fa-times me-1"></i> Cancel
                            </button>
                        </form>
                        @elseif($visit->status === 'confirmed')
                        <form method="POST" action="{{ route('school-owner.visits.complete', $visit->id) }}" style="display:inline;">
                            @csrf
                            <button type="submit" style="background:#7c3aed; color:#fff; border:none; border-radius:6px; padding:6px 11px; font-size:11.5px; font-weight:700; cursor:pointer;">
                                <i class="fas fa-flag-checkered me-1"></i> Mark Complete
                            </button>
                        </form>
                        @else
                        <span style="font-size:11.5px; color:#94a3b8; font-weight:600;">Concluded</span>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    @if($visits->hasPages())
    <div style="padding:14px 20px; border-top:1px solid #f1f5f9;">
        {{ $visits->links() }}
    </div>
    @endif
</div>

@endif

@endsection