@extends('admin.layout')

@section('title', 'Campus Visit Bookings – SchoolMapr Admin')
@section('page-title', 'Campus Visit Appointments')
@section('page-sub', 'Schedule and manage parent campus counselling visits and guided tours')

@section('content')

{{-- ── 1. VISITS KPI STAT CARDS ── --}}
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(210px, 1fr)); gap:16px; margin-bottom:24px;">
    
    <div class="stat-card" style="border-top:3px solid #3b82f6;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
            <span style="font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.05em;">Total Appointments</span>
            <div style="width:34px; height:34px; background:#eff6ff; border-radius:9px; display:flex; align-items:center; justify-content:center;">
                <i class="fas fa-calendar-check" style="color:#3b82f6; font-size:14px;"></i>
            </div>
        </div>
        <div style="font-size:26px; font-weight:900; color:#0f172a;">{{ number_format($stats['total']) }}</div>
        <div style="font-size:11.5px; color:#64748b; margin-top:2px;">All recorded tours</div>
    </div>

    <div class="stat-card" style="border-top:3px solid #f59e0b;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
            <span style="font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.05em;">Pending Confirmation</span>
            <div style="width:34px; height:34px; background:#fffbeb; border-radius:9px; display:flex; align-items:center; justify-content:center;">
                <i class="fas fa-clock" style="color:#f59e0b; font-size:14px;"></i>
            </div>
        </div>
        <div style="font-size:26px; font-weight:900; color:#0f172a;">{{ number_format($stats['pending']) }}</div>
        <div style="font-size:11.5px; color:#d97706; margin-top:2px; font-weight:700;">Needs slot confirmation</div>
    </div>

    <div class="stat-card" style="border-top:3px solid #10b981;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
            <span style="font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.05em;">Confirmed Visits</span>
            <div style="width:34px; height:34px; background:#ecfdf5; border-radius:9px; display:flex; align-items:center; justify-content:center;">
                <i class="fas fa-calendar-alt" style="color:#10b981; font-size:14px;"></i>
            </div>
        </div>
        <div style="font-size:26px; font-weight:900; color:#0f172a;">{{ number_format($stats['confirmed']) }}</div>
        <div style="font-size:11.5px; color:#10b981; margin-top:2px;">Slots locked with parents</div>
    </div>

    <div class="stat-card" style="border-top:3px solid #8b5cf6;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
            <span style="font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.05em;">Completed Tours</span>
            <div style="width:34px; height:34px; background:#f5f3ff; border-radius:9px; display:flex; align-items:center; justify-content:center;">
                <i class="fas fa-flag-checkered" style="color:#8b5cf6; font-size:14px;"></i>
            </div>
        </div>
        <div style="font-size:26px; font-weight:900; color:#0f172a;">{{ number_format($stats['completed']) }}</div>
        <div style="font-size:11.5px; color:#8b5cf6; margin-top:2px;">Campus tour concluded</div>
    </div>

</div>

{{-- ── 2. FILTER BAR ── --}}
<div class="panel" style="margin-bottom:18px;">
    <div style="padding:14px 18px;">
        <form method="GET" action="{{ route('admin.visits') }}">
            <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
                
                {{-- Search --}}
                <div style="position:relative; flex:1; min-width:220px;">
                    <i class="fas fa-search" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:12px;"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search visitor name or phone number..."
                           style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:8px 12px 8px 34px; font-size:13px; outline:none; color:#1e293b; box-sizing:border-box;">
                </div>

                {{-- Status --}}
                <div style="min-width:140px;">
                    <select name="status" style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:8px 12px; font-size:13px; outline:none; color:#334155; background:#fff; box-sizing:border-box;">
                        <option value="">All Statuses</option>
                        <option value="pending"   {{ request('status')==='pending'   ? 'selected':'' }}>⏳ Pending</option>
                        <option value="confirmed" {{ request('status')==='confirmed' ? 'selected':'' }}>✅ Confirmed</option>
                        <option value="completed" {{ request('status')==='completed' ? 'selected':'' }}>🏁 Completed</option>
                        <option value="cancelled" {{ request('status')==='cancelled' ? 'selected':'' }}>❌ Cancelled</option>
                    </select>
                </div>

                {{-- Date Picker --}}
                <div style="min-width:160px;">
                    <input type="date" name="date" value="{{ request('date') }}"
                           style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:8px 12px; font-size:13px; outline:none; color:#334155; background:#fff; box-sizing:border-box;">
                </div>

                <button type="submit" style="background:#0f2d59; color:#fff; border:none; border-radius:8px; padding:9px 18px; font-size:13px; font-weight:700; cursor:pointer;">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>

                @if(request()->hasAny(['search','status','date']))
                <a href="{{ route('admin.visits') }}" style="font-size:12.5px; color:#ef4444; font-weight:700; text-decoration:none; margin-left:4px;">
                    <i class="fas fa-times me-1"></i> Clear
                </a>
                @endif

            </div>
        </form>
    </div>
</div>

{{-- ── 3. VISITS TABLE ── --}}
<div class="panel">
    <div class="panel-header">
        <div class="panel-title">
            <i class="fas fa-calendar-days" style="color:#0f2d59;"></i>
            Scheduled Campus Appointments ({{ $visits->total() }})
        </div>
        <span style="font-size:11.5px; color:#64748b;">
            @if($visits->total() > 0)
                Showing {{ $visits->firstItem() }}–{{ $visits->lastItem() }} of {{ $visits->total() }}
            @endif
        </span>
    </div>

    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width:40px;">#</th>
                    <th>Visitor Contact</th>
                    <th>School Destination</th>
                    <th>Scheduled Date</th>
                    <th>Time Slot</th>
                    <th>Parent Notes / Query</th>
                    <th>Status</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($visits as $i => $visit)
                <tr>
                    <td style="color:#94a3b8; font-size:12px;">{{ $visits->firstItem() + $i }}</td>
                    
                    {{-- Visitor --}}
                    <td>
                        <div style="display:flex; align-items:center; gap:9px;">
                            <div style="width:34px; height:34px; background:linear-gradient(135deg,#0f2d59,#3b82f6); color:#fff; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:12.5px; flex-shrink:0;">
                                {{ strtoupper(substr($visit->visitor_name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight:700; color:#0f172a; font-size:13px;">{{ $visit->visitor_name }}</div>
                                <div style="font-size:11.5px; color:#64748b; display:flex; align-items:center; gap:4px;">
                                    <i class="fas fa-phone-alt" style="font-size:10px; color:#10b981;"></i>
                                    <a href="tel:{{ $visit->visitor_phone }}" style="color:#334155; text-decoration:none;">{{ $visit->visitor_phone }}</a>
                                </div>
                            </div>
                        </div>
                    </td>

                    {{-- School --}}
                    <td>
                        @if($visit->school)
                            <a href="{{ route('school.show', $visit->school->slug) }}" target="_blank" style="font-weight:700; color:#2563eb; text-decoration:none; font-size:12.5px;">
                                {{ $visit->school->name }}
                            </a>
                            <div style="font-size:10.5px; color:#94a3b8;">{{ $visit->school->city ?? 'Patna' }}</div>
                        @else
                            <span style="color:#94a3b8;">—</span>
                        @endif
                    </td>

                    {{-- Date --}}
                    <td>
                        <span style="font-size:12px; font-weight:800; color:#0f172a; background:#f8fafc; padding:3px 8px; border-radius:6px; border:1px solid #e2e8f0;">
                            📅 {{ \Carbon\Carbon::parse($visit->visit_date)->format('D, d M Y') }}
                        </span>
                    </td>

                    {{-- Time Slot --}}
                    <td>
                        <span style="font-size:11px; font-weight:700; color:#475569; background:#f1f5f9; padding:2px 7px; border-radius:4px;">
                            ⏰ {{ \Carbon\Carbon::parse($visit->visit_time)->format('h:i A') }}
                        </span>
                    </td>

                    {{-- Notes --}}
                    <td style="max-width:240px;">
                        <div style="font-size:12px; color:#475569; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="{{ $visit->notes }}">
                            {{ $visit->notes ?: 'General campus counselling' }}
                        </div>
                    </td>

                    {{-- Status --}}
                    <td>
                        @if($visit->status === 'confirmed')
                            <span style="display:inline-block; font-size:11px; font-weight:800; background:#ecfdf5; color:#059669; border:1px solid #a7f3d0; padding:3px 10px; border-radius:999px;">
                                ● Confirmed
                            </span>
                        @elseif($visit->status === 'completed')
                            <span style="display:inline-block; font-size:11px; font-weight:800; background:#f5f3ff; color:#7c3aed; border:1px solid #ddd6fe; padding:3px 10px; border-radius:999px;">
                                ● Completed
                            </span>
                        @elseif($visit->status === 'pending')
                            <span style="display:inline-block; font-size:11px; font-weight:800; background:#fffbeb; color:#d97706; border:1px solid #fde68a; padding:3px 10px; border-radius:999px;">
                                ● Pending Slot
                            </span>
                        @else
                            <span style="display:inline-block; font-size:11px; font-weight:800; background:#fef2f2; color:#dc2626; border:1px solid #fecaca; padding:3px 10px; border-radius:999px;">
                                ● Cancelled
                            </span>
                        @endif
                    </td>

                    {{-- Actions --}}
                    <td style="text-align:right;">
                        <div style="display:inline-flex; gap:6px;">
                            @if($visit->status === 'pending')
                                <form action="{{ route('admin.schools.visits.confirm', [$visit->school_id, $visit->id]) }}" method="POST" style="display:inline;">
                                    @csrf @method('PATCH')
                                    <button type="submit" title="Confirm Slot"
                                            style="background:#10b981; color:#fff; border:none; border-radius:6px; padding:6px 10px; font-size:11.5px; font-weight:700; cursor:pointer;">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                            @elseif($visit->status === 'confirmed')
                                <form action="{{ route('admin.schools.visits.complete', [$visit->school_id, $visit->id]) }}" method="POST" style="display:inline;">
                                    @csrf @method('PATCH')
                                    <button type="submit" title="Mark Completed"
                                            style="background:#7c3aed; color:#fff; border:none; border-radius:6px; padding:6px 10px; font-size:11.5px; font-weight:700; cursor:pointer;">
                                        <i class="fas fa-flag-checkered"></i>
                                    </button>
                                </form>
                            @else
                                <span style="font-size:11px; color:#94a3b8; font-weight:600;">Concluded</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center; padding:50px 20px;">
                        <div style="font-size:36px; margin-bottom:8px;">📅</div>
                        <div style="font-size:14px; font-weight:700; color:#334155;">No Campus Visits Scheduled</div>
                        <div style="font-size:12px; color:#94a3b8; margin-top:2px;">Campus visit appointments requested by parents will appear here automatically.</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($visits->hasPages())
    <div style="padding:14px 20px; border-top:1px solid #f1f5f9;">
        {{ $visits->links() }}
    </div>
    @endif
</div>

@endsection