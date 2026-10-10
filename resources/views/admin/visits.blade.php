@extends('admin.layout')

@section('title', 'Campus Visit Appointments – SchoolMapr Admin')
@section('page-title', 'Campus Visit Appointments')
@section('page-sub', 'Schedule, track, filter by date range, and export parent guided tour appointments')

@section('content')

{{-- ── 1. VISITS KPI STAT CARDS ── --}}
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(210px, 1fr)); gap:16px; margin-bottom:20px;">
    
    <div class="stat-card" style="border-top:3px solid #2563eb;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
            <span style="font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.05em;">Total Appointments</span>
            <div style="width:34px; height:34px; background:#eff6ff; border-radius:9px; display:flex; align-items:center; justify-content:center;">
                <i class="fas fa-calendar-check" style="color:#2563eb; font-size:14px;"></i>
            </div>
        </div>
        <div style="font-size:26px; font-weight:900; color:#0f172a;">{{ number_format($stats['total'] ?? $visits->total()) }}</div>
        <div style="font-size:11.5px; color:#64748b; margin-top:2px;">All recorded campus tours</div>
    </div>

    <div class="stat-card" style="border-top:3px solid #f59e0b;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
            <span style="font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.05em;">Pending Confirmation</span>
            <div style="width:34px; height:34px; background:#fffbeb; border-radius:9px; display:flex; align-items:center; justify-content:center;">
                <i class="fas fa-clock" style="color:#f59e0b; font-size:14px;"></i>
            </div>
        </div>
        <div style="font-size:26px; font-weight:900; color:#0f172a;">{{ number_format($stats['pending'] ?? 0) }}</div>
        <div style="font-size:11.5px; color:#d97706; margin-top:2px; font-weight:700;">Awaiting slot approval</div>
    </div>

    <div class="stat-card" style="border-top:3px solid #10b981;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
            <span style="font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.05em;">Confirmed Visits</span>
            <div style="width:34px; height:34px; background:#ecfdf5; border-radius:9px; display:flex; align-items:center; justify-content:center;">
                <i class="fas fa-calendar-alt" style="color:#10b981; font-size:14px;"></i>
            </div>
        </div>
        <div style="font-size:26px; font-weight:900; color:#0f172a;">{{ number_format($stats['confirmed'] ?? 0) }}</div>
        <div style="font-size:11.5px; color:#10b981; margin-top:2px;">Slots locked with parents</div>
    </div>

    <div class="stat-card" style="border-top:3px solid #8b5cf6;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
            <span style="font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.05em;">Completed Tours</span>
            <div style="width:34px; height:34px; background:#f5f3ff; border-radius:9px; display:flex; align-items:center; justify-content:center;">
                <i class="fas fa-flag-checkered" style="color:#8b5cf6; font-size:14px;"></i>
            </div>
        </div>
        <div style="font-size:26px; font-weight:900; color:#0f172a;">{{ number_format($stats['completed'] ?? 0) }}</div>
        <div style="font-size:11.5px; color:#8b5cf6; margin-top:2px;">Campus tour concluded</div>
    </div>

</div>

{{-- ── 2. ADVANCED DATE RANGE FILTER & EXPORT STRIP ── --}}
<div class="panel" style="margin-bottom:18px;">
    <div style="padding:16px 20px;">
        <form method="GET" action="{{ route('admin.visits') }}">
            <div style="display:flex; gap:12px; align-items:flex-end; flex-wrap:wrap;">
                
                {{-- Search --}}
                <div style="flex:1; min-width:210px;">
                    <label style="display:block; font-size:11px; font-weight:700; color:#475569; text-transform:uppercase; letter-spacing:0.04em; margin-bottom:5px;">
                        <i class="fas fa-search me-1 text-slate-400"></i> Search Visitor / School
                    </label>
                    <div style="position:relative;">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Visitor name, phone, school..."
                               style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:8px 12px; font-size:13px; outline:none; color:#1e293b; box-sizing:border-box; background:#fff;">
                    </div>
                </div>

                {{-- Status --}}
                <div style="min-width:140px;">
                    <label style="display:block; font-size:11px; font-weight:700; color:#475569; text-transform:uppercase; letter-spacing:0.04em; margin-bottom:5px;">
                        <i class="fas fa-sliders-h me-1 text-slate-400"></i> Status
                    </label>
                    <select name="status" style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:8px 12px; font-size:13px; outline:none; color:#334155; background:#fff; box-sizing:border-box;">
                        <option value="">All Statuses</option>
                        <option value="pending"   {{ request('status')==='pending'   ? 'selected':'' }}>⏳ Pending</option>
                        <option value="confirmed" {{ request('status')==='confirmed' ? 'selected':'' }}>✅ Confirmed</option>
                        <option value="completed" {{ request('status')==='completed' ? 'selected':'' }}>🏁 Completed</option>
                        <option value="cancelled" {{ request('status')==='cancelled' ? 'selected':'' }}>❌ Cancelled</option>
                    </select>
                </div>

                {{-- From Date --}}
                <div style="min-width:150px;">
                    <label style="display:block; font-size:11px; font-weight:700; color:#475569; text-transform:uppercase; letter-spacing:0.04em; margin-bottom:5px;">
                        <i class="far fa-calendar-alt me-1 text-slate-400"></i> From Date
                    </label>
                    <input type="date" name="from_date" value="{{ request('from_date') }}"
                           style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:8px 12px; font-size:13px; outline:none; color:#334155; background:#fff; box-sizing:border-box;">
                </div>

                {{-- To Date --}}
                <div style="min-width:150px;">
                    <label style="display:block; font-size:11px; font-weight:700; color:#475569; text-transform:uppercase; letter-spacing:0.04em; margin-bottom:5px;">
                        <i class="far fa-calendar-check me-1 text-slate-400"></i> To Date
                    </label>
                    <input type="date" name="to_date" value="{{ request('to_date') }}"
                           style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:8px 12px; font-size:13px; outline:none; color:#334155; background:#fff; box-sizing:border-box;">
                </div>

                {{-- Action Buttons --}}
                <div style="display:flex; gap:8px; align-items:center;">
                    <button type="submit" style="background:#0f2d59; color:#fff; border:none; border-radius:8px; padding:9px 18px; font-size:13px; font-weight:700; cursor:pointer; display:inline-flex; align-items:center; gap:6px;">
                        <i class="fas fa-filter"></i> Apply
                    </button>

                    @if(request()->hasAny(['search','status','from_date','to_date','date']))
                    <a href="{{ route('admin.visits') }}" style="font-size:12.5px; color:#ef4444; font-weight:700; text-decoration:none; padding:8px 10px;">
                        <i class="fas fa-times me-1"></i> Clear
                    </a>
                    @endif

                    {{-- Export To Excel Button with Current Filter Query --}}
                    <a href="{{ route('admin.visits.export', request()->query()) }}"
                       style="background:linear-gradient(135deg, #059669 0%, #10b981 100%); color:#fff; border:none; border-radius:8px; padding:9px 16px; font-size:13px; font-weight:800; text-decoration:none; display:inline-flex; align-items:center; gap:7px; box-shadow:0 2px 6px rgba(16,185,129,0.25); white-space:nowrap;"
                       title="Export filtered records directly to an Excel sheet (.csv)">
                        <i class="fas fa-file-excel"></i> Export to Excel
                    </a>
                </div>

            </div>
        </form>
    </div>
</div>

{{-- ── 3. BULK ACTION BAR (Dynamically shown when rows selected) ── --}}
<form id="bulkDeleteForm" action="{{ route('admin.visits.bulk-delete') }}" method="POST">
    @csrf

    <div id="bulkActionBar" style="display:none; background:#0f2d59; color:#fff; border-radius:10px; padding:12px 20px; margin-bottom:14px; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; box-shadow:0 4px 12px rgba(15,45,89,0.18);">
        <div style="display:flex; align-items:center; gap:10px;">
            <i class="fas fa-check-circle" style="color:#38bdf8; font-size:16px;"></i>
            <span style="font-size:13.5px; font-weight:700;">
                <span id="selectedCount">0</span> visit appointment(s) selected
            </span>
        </div>
        <div style="display:flex; align-items:center; gap:8px;">
            <button type="button" onclick="confirmBulkDelete()"
                    style="background:#ef4444; color:#fff; border:none; border-radius:7px; padding:7px 14px; font-size:12.5px; font-weight:800; cursor:pointer; display:inline-flex; align-items:center; gap:6px;">
                <i class="fas fa-trash-alt"></i> Delete Selected
            </button>
            <button type="button" onclick="clearAllSelections()"
                    style="background:rgba(255,255,255,0.15); color:#fff; border:none; border-radius:7px; padding:7px 12px; font-size:12px; font-weight:600; cursor:pointer;">
                Deselect All
            </button>
        </div>
    </div>

    {{-- ── 4. VISITS DATA TABLE ── --}}
    <div class="panel">
        <div class="panel-header">
            <div class="panel-title">
                <i class="fas fa-calendar-days" style="color:#0f2d59;"></i>
                Scheduled Campus Appointments ({{ $visits->total() }})
            </div>
            <div style="display:flex; align-items:center; gap:12px;">
                <span style="font-size:11.5px; color:#64748b;">
                    @if($visits->total() > 0)
                        Showing {{ $visits->firstItem() }}–{{ $visits->lastItem() }} of {{ $visits->total() }}
                    @endif
                </span>
            </div>
        </div>

        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width:36px; text-align:center;">
                            <input type="checkbox" id="selectAllCheckbox" style="cursor:pointer; width:15px; height:15px; accent-color:#0f2d59;">
                        </th>
                        <th style="width:40px;">#</th>
                        <th>Visitor Details</th>
                        <th>Destination Campus</th>
                        <th>Tour Date</th>
                        <th>Time Slot</th>
                        <th>Notes / Inquiries</th>
                        <th>Status</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($visits as $i => $visit)
                    <tr>
                        {{-- Row Selection Checkbox --}}
                        <td style="text-align:center;">
                            <input type="checkbox" name="ids[]" value="{{ $visit->id }}" class="visit-item-checkbox" style="cursor:pointer; width:15px; height:15px; accent-color:#0f2d59;" onchange="updateBulkBar()">
                        </td>

                        <td style="color:#94a3b8; font-size:12px;">{{ $visits->firstItem() + $i }}</td>
                        
                        {{-- Visitor Profile --}}
                        <td>
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div style="width:34px; height:34px; background:linear-gradient(135deg,#0f2d59,#2563eb); color:#fff; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:12.5px; flex-shrink:0;">
                                    {{ strtoupper(substr($visit->visitor_name, 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-weight:700; color:#0f172a; font-size:13px;">{{ $visit->visitor_name }}</div>
                                    <div style="font-size:11.5px; color:#64748b; display:flex; align-items:center; gap:4px; margin-top:1px;">
                                        <i class="fas fa-phone-alt" style="font-size:10px; color:#10b981;"></i>
                                        <a href="tel:{{ $visit->visitor_phone }}" style="color:#334155; text-decoration:none; font-weight:600;">{{ $visit->visitor_phone }}</a>
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
                        <td style="white-space:nowrap;">
                            <span style="font-size:12px; font-weight:800; color:#0f172a; background:#f8fafc; padding:4px 9px; border-radius:6px; border:1px solid #e2e8f0; display:inline-block;">
                                📅 {{ \Carbon\Carbon::parse($visit->visit_date)->format('D, d M Y') }}
                            </span>
                        </td>

                        {{-- Time Slot --}}
                        <td style="white-space:nowrap;">
                            <span style="font-size:11.5px; font-weight:700; color:#475569; background:#f1f5f9; padding:3px 8px; border-radius:5px;">
                                ⏰ {{ \Carbon\Carbon::parse($visit->visit_time)->format('h:i A') }}
                            </span>
                        </td>

                        {{-- Notes --}}
                        <td style="max-width:220px;">
                            <div style="font-size:12px; color:#475569; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="{{ $visit->notes }}">
                                {{ $visit->notes ?: 'General campus counselling' }}
                            </div>
                            @if($visit->cancel_reason)
                                <div style="font-size:10.5px; color:#ef4444; font-weight:600; margin-top:2px;">
                                    Reason: {{ $visit->cancel_reason }}
                                </div>
                            @endif
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
                                    ● Pending
                                </span>
                            @else
                                <span style="display:inline-block; font-size:11px; font-weight:800; background:#fef2f2; color:#dc2626; border:1px solid #fecaca; padding:3px 10px; border-radius:999px;">
                                    ● Cancelled
                                </span>
                            @endif
                        </td>

                        {{-- Actions --}}
                        <td style="text-align:right;">
                            <div style="display:inline-flex; gap:6px; align-items:center;">
                                @if($visit->status === 'pending')
                                    <form action="{{ route('admin.schools.visits.confirm', [$visit->school_id, $visit->id]) }}" method="POST" style="display:inline;">
                                        @csrf @method('PATCH')
                                        <button type="submit" title="Confirm Slot"
                                                style="background:#10b981; color:#fff; border:none; border-radius:6px; padding:6px 10px; font-size:11.5px; font-weight:700; cursor:pointer;">
                                            <i class="fas fa-check"></i> Confirm
                                        </button>
                                    </form>
                                @elseif($visit->status === 'confirmed')
                                    <form action="{{ route('admin.schools.visits.complete', [$visit->school_id, $visit->id]) }}" method="POST" style="display:inline;">
                                        @csrf @method('PATCH')
                                        <button type="submit" title="Mark Completed"
                                                style="background:#7c3aed; color:#fff; border:none; border-radius:6px; padding:6px 10px; font-size:11.5px; font-weight:700; cursor:pointer;">
                                            <i class="fas fa-flag-checkered"></i> Conclude
                                        </button>
                                    </form>
                                @endif

                                {{-- Single Row Delete Action --}}
                                <button type="button" onclick="singleDeleteVisit('{{ $visit->id }}', '{{ addslashes($visit->visitor_name) }}')"
                                        style="background:#fff1f2; color:#e11d48; border:1px solid #fecdd3; border-radius:6px; padding:6px 8px; font-size:11.5px; cursor:pointer;"
                                        title="Delete this visit booking">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" style="text-align:center; padding:60px 20px;">
                            <div style="font-size:36px; margin-bottom:8px;">📅</div>
                            <div style="font-size:14px; font-weight:700; color:#334155;">No Campus Visits Found</div>
                            <div style="font-size:12px; color:#94a3b8; margin-top:3px;">No visit appointments match your selected date range or status filter.</div>
                            <a href="{{ route('admin.visits') }}" style="display:inline-block; margin-top:12px; background:#0f2d59; color:#fff; border-radius:6px; padding:7px 16px; font-size:12px; font-weight:700; text-decoration:none;">
                                Reset All Filters
                            </a>
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
</form>

{{-- Single Delete Form Helper --}}
<form id="singleDeleteVisitForm" action="{{ route('admin.visits.bulk-delete') }}" method="POST" style="display:none;">
    @csrf
    <input type="hidden" name="ids[]" id="singleDeleteVisitId">
</form>

<script>
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    const bulkActionBar = document.getElementById('bulkActionBar');
    const selectedCountSpan = document.getElementById('selectedCount');

    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.visit-item-checkbox');
            checkboxes.forEach(cb => cb.checked = this.checked);
            updateBulkBar();
        });
    }

    function updateBulkBar() {
        const checked = document.querySelectorAll('.visit-item-checkbox:checked');
        const count = checked.length;
        if (count > 0) {
            bulkActionBar.style.display = 'flex';
            selectedCountSpan.textContent = count;
        } else {
            bulkActionBar.style.display = 'none';
            if (selectAllCheckbox) selectAllCheckbox.checked = false;
        }
    }

    function clearAllSelections() {
        document.querySelectorAll('.visit-item-checkbox').forEach(cb => cb.checked = false);
        if (selectAllCheckbox) selectAllCheckbox.checked = false;
        updateBulkBar();
    }

    function confirmBulkDelete() {
        const count = document.querySelectorAll('.visit-item-checkbox:checked').length;
        if (count === 0) return;
        if (confirm(`⚠️ Are you sure you want to permanently delete the ${count} selected campus visit booking(s)?`)) {
            document.getElementById('bulkDeleteForm').submit();
        }
    }

    function singleDeleteVisit(id, name) {
        if (confirm(`⚠️ Delete campus visit appointment for "${name}"?`)) {
            document.getElementById('singleDeleteVisitId').value = id;
            document.getElementById('singleDeleteVisitForm').submit();
        }
    }
</script>

@endsection