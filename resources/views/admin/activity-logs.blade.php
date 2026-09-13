@extends('admin.layout')
@section('title', 'Activity Logs & Audit Trail – SchoolMapr Admin')
@section('page-title', 'Activity Logs & Audit Trail')
@section('page-sub', 'Real-time security and operational events across SchoolMapr')

@section('content')

{{-- ── 1. AUDIT KPI STAT CARDS ── --}}
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:14px; margin-bottom:22px;">
    
    <div class="stat-card" style="border-top:3px solid #3b82f6;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
            <span style="font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.05em;">Total Events</span>
            <div style="width:32px; height:32px; background:#eff6ff; border-radius:8px; display:flex; align-items:center; justify-content:center;">
                <i class="fas fa-list-check" style="color:#3b82f6; font-size:13px;"></i>
            </div>
        </div>
        <div style="font-size:24px; font-weight:900; color:#0f172a;">{{ number_format($stats['total']) }}</div>
        <div style="font-size:11px; color:#94a3b8; margin-top:2px;">Logged System Events</div>
    </div>

    <div class="stat-card" style="border-top:3px solid #10b981;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
            <span style="font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.05em;">School Actions</span>
            <div style="width:32px; height:32px; background:#ecfdf5; border-radius:8px; display:flex; align-items:center; justify-content:center;">
                <i class="fas fa-school" style="color:#10b981; font-size:13px;"></i>
            </div>
        </div>
        <div style="font-size:24px; font-weight:900; color:#0f172a;">{{ number_format($stats['schools']) }}</div>
        <div style="font-size:11px; color:#10b981; margin-top:2px;">Updates & Verification</div>
    </div>

    <div class="stat-card" style="border-top:3px solid #f59e0b;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
            <span style="font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.05em;">Leads & Admissions</span>
            <div style="width:32px; height:32px; background:#fffbeb; border-radius:8px; display:flex; align-items:center; justify-content:center;">
                <i class="fas fa-user-graduate" style="color:#f59e0b; font-size:13px;"></i>
            </div>
        </div>
        <div style="font-size:24px; font-weight:900; color:#0f172a;">{{ number_format($stats['leads']) }}</div>
        <div style="font-size:11px; color:#f59e0b; margin-top:2px;">Parent Inquiries & Forms</div>
    </div>

    <div class="stat-card" style="border-top:3px solid #6366f1;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
            <span style="font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.05em;">Security & Auth</span>
            <div style="width:32px; height:32px; background:#eef2ff; border-radius:8px; display:flex; align-items:center; justify-content:center;">
                <i class="fas fa-shield-alt" style="color:#6366f1; font-size:13px;"></i>
            </div>
        </div>
        <div style="font-size:24px; font-weight:900; color:#0f172a;">{{ number_format($stats['security']) }}</div>
        <div style="font-size:11px; color:#6366f1; margin-top:2px;">Logins & Role Changes</div>
    </div>

</div>

{{-- ── 2. FILTER BAR ── --}}
<div class="panel" style="margin-bottom:18px;">
    <div style="padding:14px 18px;">
        <form method="GET" action="{{ route('admin.logs') }}">
            <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
                
                {{-- Search --}}
                <div style="position:relative; flex:1; min-width:220px;">
                    <i class="fas fa-search" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:12px;"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search action, description, IP, or user..."
                           style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:8px 12px 8px 34px; font-size:13px; outline:none; color:#1e293b; box-sizing:border-box;">
                </div>

                {{-- Action Filter --}}
                <div style="min-width:160px;">
                    <select name="action" style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:8px 12px; font-size:13px; outline:none; color:#334155; background:#fff; box-sizing:border-box;">
                        <option value="">All Action Types</option>
                        @foreach($actions as $act)
                            <option value="{{ $act }}" {{ request('action') === $act ? 'selected' : '' }}>{{ $act }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Role Filter --}}
                <div style="min-width:140px;">
                    <select name="role" style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:8px 12px; font-size:13px; outline:none; color:#334155; background:#fff; box-sizing:border-box;">
                        <option value="">All Roles</option>
                        @foreach($roles as $r)
                            <option value="{{ $r }}" {{ request('role') === $r ? 'selected' : '' }}>{{ ucfirst($r) }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" style="background:#0f2d59; color:#fff; border:none; border-radius:8px; padding:9px 18px; font-size:13px; font-weight:700; cursor:pointer;">
                    <i class="fas fa-filter me-1"></i> Filter Logs
                </button>

                @if(request()->hasAny(['search', 'action', 'role']))
                    <a href="{{ route('admin.logs') }}" style="font-size:12.5px; color:#ef4444; font-weight:700; text-decoration:none; margin-left:4px;">
                        <i class="fas fa-times me-1"></i> Clear
                    </a>
                @endif

            </div>
        </form>
    </div>
</div>

{{-- ── 3. ACTIVITY LOGS TIMELINE TABLE ── --}}
<div class="panel">
    <div class="panel-header">
        <div class="panel-title">
            <i class="fas fa-fingerprint" style="color:#0f2d59;"></i>
            Activity Audit Stream ({{ $logs->total() }})
        </div>
        <span style="font-size:11.5px; color:#64748b;">Live server timezone: IST (UTC+5:30)</span>
    </div>

    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width:50px;">#</th>
                    <th>Action</th>
                    <th>Actor / User</th>
                    <th>Role</th>
                    <th>Event Description</th>
                    <th>Target Entity</th>
                    <th>IP Address</th>
                    <th style="text-align:right;">Timestamp</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $i => $log)
                <tr>
                    <td style="color:#94a3b8; font-size:12px;">{{ $logs->firstItem() + $i }}</td>
                    
                    {{-- Action Tag --}}
                    <td>
                        @php
                            $act = strtolower($log->action);
                            $badgeStyle = 'background:#f1f5f9; color:#475569;';
                            if (str_contains($act, 'school') || str_contains($act, 'approved')) {
                                $badgeStyle = 'background:#ecfdf5; color:#059669; border:1px solid #a7f3d0;';
                            } elseif (str_contains($act, 'admission') || str_contains($act, 'visit')) {
                                $badgeStyle = 'background:#eff6ff; color:#2563eb; border:1px solid #bfdbfe;';
                            } elseif (str_contains($act, 'payment') || str_contains($act, 'paid')) {
                                $badgeStyle = 'background:#fef3c7; color:#d97706; border:1px solid #fde68a;';
                            } elseif (str_contains($act, 'login') || str_contains($act, 'auth')) {
                                $badgeStyle = 'background:#eef2ff; color:#4f46e5; border:1px solid #c7d2fe;';
                            } elseif (str_contains($act, 'reject') || str_contains($act, 'ban') || str_contains($act, 'delete')) {
                                $badgeStyle = 'background:#fef2f2; color:#dc2626; border:1px solid #fecaca;';
                            }
                        @endphp
                        <span style="display:inline-block; font-size:11px; font-weight:800; padding:3px 9px; border-radius:6px; white-space:nowrap; {{ $badgeStyle }}">
                            {{ $log->action }}
                        </span>
                    </td>

                    {{-- Actor --}}
                    <td>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <div style="width:26px; height:26px; background:#0f2d59; color:#fff; border-radius:50%; font-size:10px; font-weight:800; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                {{ strtoupper(substr($log->user_name, 0, 1)) }}
                            </div>
                            <span style="font-weight:700; color:#1e293b; font-size:12.5px;">{{ $log->user_name }}</span>
                        </div>
                    </td>

                    {{-- Role --}}
                    <td>
                        <span style="font-size:10.5px; font-weight:700; padding:2px 7px; border-radius:4px; background:#f8fafc; color:#64748b; border:1px solid #e2e8f0;">
                            {{ ucfirst($log->role) }}
                        </span>
                    </td>

                    {{-- Description --}}
                    <td style="max-width:320px;">
                        <div style="font-size:12.5px; color:#334155; line-height:1.4;">
                            {{ $log->description }}
                        </div>
                    </td>

                    {{-- Entity --}}
                    <td>
                        @if($log->entity_type)
                            <span style="font-size:11px; color:#64748b; font-weight:600;">
                                {{ class_basename($log->entity_type) }} #{{ $log->entity_id }}
                            </span>
                        @else
                            <span style="color:#cbd5e1; font-size:12px;">—</span>
                        @endif
                    </td>

                    {{-- IP Address --}}
                    <td>
                        <code style="font-size:11px; color:#64748b; background:#f1f5f9; padding:2px 6px; border-radius:4px;">
                            {{ $log->ip_address ?? '127.0.0.1' }}
                        </code>
                    </td>

                    {{-- Time --}}
                    <td style="text-align:right; white-space:nowrap;">
                        <div style="font-size:12px; font-weight:700; color:#0f172a;">{{ $log->created_at->diffForHumans() }}</div>
                        <div style="font-size:10px; color:#94a3b8;">{{ $log->created_at->format('d M Y, h:i A') }}</div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center; padding:45px 20px;">
                        <div style="font-size:32px; margin-bottom:8px;">🛡️</div>
                        <div style="font-size:14px; font-weight:700; color:#334155;">No Activity Logs recorded yet</div>
                        <div style="font-size:12px; color:#94a3b8; margin-top:2px;">Platform events, admin changes, and logins will appear here automatically.</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($logs->hasPages())
    <div style="padding:14px 20px; border-top:1px solid #f1f5f9;">
        {{ $logs->links() }}
    </div>
    @endif
</div>

@endsection
