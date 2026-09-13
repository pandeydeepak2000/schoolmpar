@extends('admin.layout')
@section('title', 'Executive Overview – SchoolMapr Admin')
@section('page-title', 'Executive Dashboard')
@section('page-sub', 'Live performance metrics, admission pipeline, and activity audit for Patna District')

@section('content')

{{-- ── 1. PRIMARY METRICS STRIP ── --}}
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(210px, 1fr)); gap:16px; margin-bottom:24px;">
    
    {{-- Schools --}}
    <div class="stat-card" style="border-top:3px solid #3b82f6;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
            <span style="font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.05em;">Partner Schools</span>
            <div style="width:34px; height:34px; background:#eff6ff; border-radius:9px; display:flex; align-items:center; justify-content:center;">
                <i class="fas fa-school" style="color:#3b82f6; font-size:13px;"></i>
            </div>
        </div>
        <div style="font-size:26px; font-weight:900; color:#0f172a;">{{ $stats['total_schools'] }}</div>
        <div style="font-size:11.5px; color:#10b981; margin-top:2px; font-weight:700;">
            {{ $stats['active_schools'] }} Live • {{ $stats['pending_schools'] }} Pending
        </div>
    </div>

    {{-- Admissions --}}
    <div class="stat-card" style="border-top:3px solid #f59e0b;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
            <span style="font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.05em;">Admissions</span>
            <div style="width:34px; height:34px; background:#fffbeb; border-radius:9px; display:flex; align-items:center; justify-content:center;">
                <i class="fas fa-user-graduate" style="color:#f59e0b; font-size:13px;"></i>
            </div>
        </div>
        <div style="font-size:26px; font-weight:900; color:#0f172a;">{{ $stats['total_admissions'] }}</div>
        <div style="font-size:11.5px; color:#d97706; margin-top:2px; font-weight:700;">
            {{ $stats['pending_adm'] }} Awaiting Review
        </div>
    </div>

    {{-- Visits --}}
    <div class="stat-card" style="border-top:3px solid #10b981;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
            <span style="font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.05em;">Campus Visits</span>
            <div style="width:34px; height:34px; background:#ecfdf5; border-radius:9px; display:flex; align-items:center; justify-content:center;">
                <i class="fas fa-calendar-check" style="color:#10b981; font-size:13px;"></i>
            </div>
        </div>
        <div style="font-size:26px; font-weight:900; color:#0f172a;">{{ $stats['total_visits'] }}</div>
        <div style="font-size:11.5px; color:#10b981; margin-top:2px; font-weight:700;">
            {{ $stats['pending_visits'] }} Scheduled Tours
        </div>
    </div>

    {{-- Revenue --}}
    <div class="stat-card" style="border-top:3px solid #8b5cf6;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
            <span style="font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.05em;">Revenue Volume</span>
            <div style="width:34px; height:34px; background:#f5f3ff; border-radius:9px; display:flex; align-items:center; justify-content:center;">
                <i class="fas fa-indian-rupee-sign" style="color:#8b5cf6; font-size:13px;"></i>
            </div>
        </div>
        <div style="font-size:26px; font-weight:900; color:#7c3aed;">₹{{ number_format($stats['total_revenue'], 2) }}</div>
        <div style="font-size:11.5px; color:#8b5cf6; margin-top:2px; font-weight:700;">Net Settlements</div>
    </div>

</div>

{{-- ── 2. MAIN DASHBOARD PANELS ── --}}
<div class="dashboard-panels-grid" style="display:grid; grid-template-columns:1fr 400px; gap:20px;">

    {{-- Left: Pending Approvals & Live Admissions --}}
    <div style="display:flex; flex-direction:column; gap:20px;">
        
        {{-- Pending School Approvals --}}
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title">
                    <i class="fas fa-hourglass-half" style="color:#f59e0b;"></i>
                    Pending School Approvals ({{ $stats['pending_schools'] }})
                </div>
                <a href="{{ route('admin.schools.pending') }}" style="font-size:12px; font-weight:700; color:#2563eb; text-decoration:none;">View all →</a>
            </div>

            @if($pending_schools->count() > 0)
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>School Details</th>
                            <th>Board</th>
                            <th>Locality</th>
                            <th>Submitted</th>
                            <th style="text-align:right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pending_schools as $school)
                        <tr>
                            <td>
                                <div style="font-weight:700; color:#0f172a; font-size:13px;">{{ $school->name }}</div>
                                <div style="font-size:11px; color:#94a3b8;">{{ $school->address }}</div>
                            </td>
                            <td><span class="badge badge-yellow">{{ $school->board }}</span></td>
                            <td style="color:#64748b; font-size:12.5px;">{{ $school->city ?? 'Patna' }}</td>
                            <td style="color:#94a3b8; font-size:11.5px;">{{ $school->created_at->diffForHumans() }}</td>
                            <td style="text-align:right;">
                                <div style="display:inline-flex; gap:6px;">
                                    <form action="{{ route('admin.schools.approve', $school->id) }}" method="POST" style="display:inline;">
                                        @csrf @method('PATCH')
                                        <button type="submit" style="background:#10b981; color:#fff; border:none; border-radius:6px; padding:5px 12px; font-size:11.5px; font-weight:700; cursor:pointer;">
                                            Approve
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.schools.crud.edit', $school->id) }}" style="background:#f1f5f9; color:#475569; border-radius:6px; padding:5px 9px; font-size:11.5px; font-weight:700; text-decoration:none;">
                                        Edit
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div style="padding:32px 20px; text-align:center;">
                <div style="font-size:28px; margin-bottom:6px;">✨</div>
                <div style="font-size:13.5px; font-weight:700; color:#334155;">No Pending Approvals</div>
                <div style="font-size:11.5px; color:#94a3b8;">All submitted school registrations have been reviewed.</div>
            </div>
            @endif
        </div>

        {{-- Recent Admissions Pipeline --}}
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title">
                    <i class="fas fa-file-signature" style="color:#0f2d59;"></i>
                    Recent Admission Applications ({{ $stats['total_admissions'] }})
                </div>
                <a href="{{ route('admin.admissions') }}" style="font-size:12px; font-weight:700; color:#2563eb; text-decoration:none;">View all →</a>
            </div>

            @if($recent_admissions->count() > 0)
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Applied School</th>
                            <th>Class</th>
                            <th>Status</th>
                            <th style="text-align:right;">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recent_admissions as $adm)
                        <tr>
                            <td>
                                <div style="font-weight:700; color:#0f172a; font-size:13px;">{{ $adm->student_name }}</div>
                                <div style="font-size:11px; color:#64748b;">Parent: {{ $adm->parent_name }}</div>
                            </td>
                            <td>
                                <span style="font-weight:600; color:#334155; font-size:12px;">{{ $adm->school->name ?? '—' }}</span>
                            </td>
                            <td>
                                <span style="font-size:11px; font-weight:800; background:#eff6ff; color:#2563eb; padding:2px 7px; border-radius:4px;">
                                    {{ $adm->class_applying }}
                                </span>
                            </td>
                            <td>
                                @if($adm->status === 'approved')
                                    <span class="badge badge-green">Approved</span>
                                @elseif($adm->status === 'pending')
                                    <span class="badge badge-yellow">Pending</span>
                                @else
                                    <span class="badge badge-blue">{{ ucfirst($adm->status) }}</span>
                                @endif
                            </td>
                            <td style="text-align:right; font-size:11.5px; color:#94a3b8;">
                                {{ $adm->created_at->diffForHumans() }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div style="padding:32px 20px; text-align:center;">
                <div style="font-size:28px; margin-bottom:6px;">🎓</div>
                <div style="font-size:13.5px; font-weight:700; color:#334155;">No Admissions Submitted Yet</div>
                <div style="font-size:11.5px; color:#94a3b8;">Student applications will appear here as parents apply.</div>
            </div>
            @endif
        </div>

    </div>

    {{-- Right: Live Activity Audit Feed --}}
    <div style="display:flex; flex-direction:column; gap:20px;">
        
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title">
                    <i class="fas fa-fingerprint" style="color:#6366f1;"></i>
                    Live Activity Audit Feed
                </div>
                <a href="{{ route('admin.logs') }}" style="font-size:12px; font-weight:700; color:#6366f1; text-decoration:none;">Full Log →</a>
            </div>

            <div style="padding:10px 0;">
                @forelse($recent_logs as $log)
                <div style="padding:11px 18px; border-bottom:1px solid #f8fafc; display:flex; align-items:flex-start; gap:10px;">
                    <div style="width:28px; height:28px; background:#eef2ff; color:#4f46e5; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:800; flex-shrink:0; margin-top:2px;">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <div style="flex:1; min-width:0;">
                        <div style="display:flex; align-items:center; justify-content:space-between; gap:6px;">
                            <strong style="font-size:12.5px; color:#0f172a;">{{ $log->action }}</strong>
                            <span style="font-size:10px; color:#94a3b8; white-space:nowrap;">{{ $log->created_at->diffForHumans() }}</span>
                        </div>
                        <div style="font-size:11.5px; color:#64748b; margin-top:2px; line-height:1.35;">
                            {{ $log->description }}
                        </div>
                        <div style="font-size:10px; color:#94a3b8; margin-top:4px;">
                            Actor: <strong style="color:#475569;">{{ $log->user_name }}</strong> ({{ $log->role }})
                        </div>
                    </div>
                </div>
                @empty
                <div style="padding:32px 20px; text-align:center;">
                    <div style="font-size:26px; margin-bottom:6px;">🛡️</div>
                    <div style="font-size:13px; font-weight:700; color:#334155;">No Recent Events</div>
                    <div style="font-size:11px; color:#94a3b8;">System activity is recorded automatically.</div>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Quick Admin Actions Card --}}
        <div style="background:linear-gradient(135deg, #0f2d59 0%, #1e40af 100%); border-radius:14px; padding:20px; color:#fff;">
            <div style="font-size:14px; font-weight:800; margin-bottom:4px;">⚡ Quick Management Actions</div>
            <p style="font-size:12px; color:rgba(255,255,255,0.75); margin:0 0 16px;">Direct shortcuts for daily Patna school administration</p>
            
            <div style="display:flex; flex-direction:column; gap:8px;">
                <a href="{{ route('admin.schools.crud.create') }}" style="background:#fff; color:#0f2d59; border-radius:8px; padding:10px 14px; font-size:12.5px; font-weight:800; text-decoration:none; display:flex; align-items:center; justify-content:space-between;">
                    <span>➕ Add New School Profile</span>
                    <i class="fas fa-chevron-right" style="font-size:11px;"></i>
                </a>
                <a href="{{ route('admin.enquiries') }}" style="background:rgba(255,255,255,0.12); color:#fff; border-radius:8px; padding:10px 14px; font-size:12.5px; font-weight:700; text-decoration:none; display:flex; align-items:center; justify-content:space-between;">
                    <span>📬 Review Parent Enquiries</span>
                    <i class="fas fa-chevron-right" style="font-size:11px;"></i>
                </a>
                <a href="{{ route('admin.logs') }}" style="background:rgba(255,255,255,0.12); color:#fff; border-radius:8px; padding:10px 14px; font-size:12.5px; font-weight:700; text-decoration:none; display:flex; align-items:center; justify-content:space-between;">
                    <span>🛡️ Security & Audit Logs</span>
                    <i class="fas fa-chevron-right" style="font-size:11px;"></i>
                </a>
            </div>
        </div>

    </div>

</div>

@endsection