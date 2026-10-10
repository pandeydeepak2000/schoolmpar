<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Portal') – SchoolMapr</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="alternate icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * { font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; box-sizing: border-box; }
        body { background: #f8fafc; color: #0f172a; margin: 0; min-height: 100vh; }

        /* ── SIDEBAR (Executive Navy & Blue Accent) ── */
        #sidebar {
            width: 236px;
            background: #0f172a;
            border-right: 1px solid rgba(255, 255, 255, 0.08);
            position: fixed; top: 0; left: 0; height: 100vh;
            display: flex; flex-direction: column;
            z-index: 100;
            transition: transform 0.25s ease;
        }
        @media (max-width: 767px) {
            #sidebar { transform: translateX(-100%); width: 260px; box-shadow: 4px 0 24px rgba(0,0,0,0.4); }
            #sidebar.open { transform: translateX(0); }
        }

        /* ── OVERLAY ── */
        #sidebar-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(15,23,42,0.6); z-index: 99;
            backdrop-filter: blur(2px);
        }
        #sidebar-overlay.active { display: block; }

        /* ── MAIN CONTENT ── */
        #main-content { margin-left: 236px; min-height: 100vh; display: flex; flex-direction: column; background: #f8fafc; }
        @media (max-width: 767px) { #main-content { margin-left: 0; } }

        /* ── NAV ITEMS ── */
        .nav-item {
            display: flex; align-items: center; gap: 11px;
            padding: 9px 14px; margin: 2px 10px;
            color: rgba(255,255,255,0.65);
            font-size: 13px; font-weight: 500;
            text-decoration: none; border-radius: 8px;
            transition: all 0.15s ease; white-space: nowrap;
            position: relative;
        }
        .nav-item:hover {
            background: rgba(255,255,255,0.07);
            color: #ffffff;
        }
        .nav-item.active {
            background: rgba(37, 99, 235, 0.18);
            color: #ffffff;
            font-weight: 600;
            border-left: 3px solid #3b82f6;
        }
        .nav-item i {
            width: 16px; font-size: 13px; text-align: center;
            color: rgba(255,255,255,0.4); flex-shrink: 0;
            transition: color 0.15s ease;
        }
        .nav-item:hover i { color: #93c5fd; }
        .nav-item.active i { color: #60a5fa !important; }

        /* ── NAV BADGE ── */
        .nav-badge {
            margin-left: auto;
            background: #2563eb; color: #ffffff;
            font-size: 9.5px; font-weight: 800;
            padding: 2px 7px; border-radius: 100px;
            min-width: 18px; text-align: center;
            line-height: 1.4;
        }

        /* ── NAV GROUP LABEL ── */
        .nav-group-label {
            padding: 16px 16px 5px 22px;
            font-size: 10px; font-weight: 800;
            letter-spacing: 0.08em; text-transform: uppercase;
            color: rgba(255,255,255,0.35);
        }

        /* ── STAT CARDS ── */
        .stat-card {
            background: #ffffff; border-radius: 12px;
            padding: 18px 20px; border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
            transition: all 0.2s ease;
        }
        .stat-card:hover {
            box-shadow: 0 6px 18px rgba(15, 23, 42, 0.07);
            transform: translateY(-1px);
        }

        /* ── PANELS ── */
        .panel {
            background: #ffffff; border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
            overflow: hidden;
        }
        .panel-header {
            padding: 15px 20px; border-bottom: 1px solid #f1f5f9;
            background: #ffffff;
            display: flex; align-items: center; justify-content: space-between;
        }
        .panel-title {
            font-size: 13.5px; font-weight: 800; color: #0f172a;
            display: flex; align-items: center; gap: 8px;
        }

        /* ── TABLES ── */
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table thead tr { background: #f8fafc; border-bottom: 1px solid #e2e8f0; }
        .data-table thead th {
            padding: 11px 16px; font-size: 11px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.05em;
            color: #64748b; text-align: left; white-space: nowrap;
        }
        .data-table tbody tr { border-bottom: 1px solid #f1f5f9; transition: background 0.15s ease; }
        .data-table tbody tr:last-child { border-bottom: none; }
        .data-table tbody tr:hover { background: #f8fafc; }
        .data-table td { padding: 13px 16px; font-size: 13px; color: #334155; }
        .table-wrap { width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; }

        /* ── BADGES ── */
        .badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 3px 9px; border-radius: 100px;
            font-size: 11px; font-weight: 700; white-space: nowrap;
        }
        .badge-blue   { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
        .badge-green  { background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
        .badge-yellow { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
        .badge-red    { background: #fff1f2; color: #be123c; border: 1px solid #fecdd3; }
        .badge-gray   { background: #f8fafc; color: #475569; border: 1px solid #e2e8f0; }
        .badge-purple { background: #f5f3ff; color: #6d28d9; border: 1px solid #ddd6fe; }
        .badge-orange { background: #fff7ed; color: #c2410c; border: 1px solid #fed7aa; }

        /* ── ALERTS ── */
        .alert-success {
            background: #ecfdf5; border: 1px solid #a7f3d0; color: #047857;
            border-radius: 10px; padding: 11px 16px; font-size: 13px; font-weight: 600;
            margin-bottom: 20px; display: flex; align-items: center; gap: 9px;
        }
        .alert-error {
            background: #fff1f2; border: 1px solid #fecdd3; color: #be123c;
            border-radius: 10px; padding: 11px 16px; font-size: 13px; font-weight: 600;
            margin-bottom: 20px; display: flex; align-items: center; gap: 9px;
        }

        /* ── BUTTONS ── */
        .btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 16px; border-radius: 8px;
            font-size: 13px; font-weight: 700;
            border: none; cursor: pointer;
            text-decoration: none; transition: all 0.15s ease;
        }
        .btn-sm { padding: 5px 10px; font-size: 12px; }
        .btn-primary {
            background: linear-gradient(135deg, #0f2d59 0%, #1d4ed8 100%);
            color: #fff; box-shadow: 0 2px 4px rgba(15,45,89,0.18);
        }
        .btn-primary:hover { background: #1e40af; color: #fff; }
        .btn-green  { background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
        .btn-green:hover  { background: #d1fae5; }
        .btn-red    { background: #fff1f2; color: #be123c; border: 1px solid #fecdd3; }
        .btn-red:hover    { background: #ffe4e6; }
        .btn-blue   { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
        .btn-blue:hover   { background: #dbeafe; }
        .btn-yellow { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
        .btn-yellow:hover { background: #fef3c7; }

        /* ── FILTER BAR ── */
        .filter-bar {
            background: #fff; border: 1px solid #e2e8f0;
            border-radius: 12px; padding: 14px 18px;
            margin-bottom: 18px;
            display: flex; gap: 10px; flex-wrap: wrap; align-items: flex-end;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
        }
        .filter-group { display: flex; flex-direction: column; gap: 4px; }
        .filter-group label {
            font-size: 11px; font-weight: 700; color: #64748b;
            text-transform: uppercase; letter-spacing: 0.05em;
        }
        .filter-group input,
        .filter-group select {
            border: 1.5px solid #e2e8f0; border-radius: 8px;
            padding: 8px 12px; font-size: 13px; color: #1e293b;
            outline: none; background: #fff; transition: all 0.15s;
        }
        .filter-group input:focus,
        .filter-group select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37,99,235,0.12);
        }

        /* ── PAGE HEADER ── */
        .page-header {
            display: flex; align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap; gap: 12px; margin-bottom: 20px;
        }
        .page-header h1 { font-size: 20px; font-weight: 900; color: #0f172a; margin: 0; }
        .page-header p  { font-size: 12.5px; color: #64748b; margin: 3px 0 0; }

        /* ── PAGINATION COMPONENT ── */
        .pagination {
            display: inline-flex !important;
            list-style: none !important;
            padding-left: 0 !important;
            border-radius: 8px;
            gap: 4px; margin: 0 !important;
            align-items: center;
        }
        .page-item { display: inline-block !important; }
        .page-item.disabled .page-link {
            color: #94a3b8 !important; pointer-events: none;
            background-color: #f8fafc !important;
            border-color: #e2e8f0 !important;
        }
        .page-item.active .page-link {
            z-index: 3; color: #fff !important;
            background-color: #0f2d59 !important;
            border-color: #0f2d59 !important;
            font-weight: 700;
        }
        .page-link {
            position: relative;
            display: inline-flex !important;
            align-items: center; justify-content: center;
            min-width: 32px; height: 32px;
            padding: 4px 10px !important;
            font-size: 12px !important; color: #334155 !important;
            text-decoration: none !important;
            background-color: #fff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 6px !important;
            transition: all .15s ease-in-out;
            font-weight: 600; line-height: 1;
        }
        .page-link:hover {
            color: #0f2d59 !important;
            background-color: #f1f5f9 !important;
            border-color: #cbd5e1 !important;
        }
        nav[role="navigation"] {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            flex-wrap: wrap !important;
            gap: 12px !important; width: 100% !important;
        }
        nav[role="navigation"] > div:first-child {
            font-size: 12px !important; color: #64748b !important;
        }
        nav[role="navigation"] svg {
            width: 14px !important; height: 14px !important;
            display: inline-block !important; vertical-align: middle;
        }

        /* ── SCROLLBAR ── */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(148,163,184,0.4); border-radius: 10px; }

        /* ── CONTENT WRAPPER ── */
        .admin-content-wrap { padding: 24px; flex: 1; min-width: 0; width: 100%; box-sizing: border-box; }
        
        @media (max-width: 1200px) {
            .stat-grid-6 { grid-template-columns: repeat(3, 1fr) !important; }
            .dashboard-panels-grid { grid-template-columns: 1fr !important; }
        }
        @media (max-width: 767px) {
            .admin-content-wrap { padding: 16px 12px !important; }
            #menu-btn     { display: flex !important; align-items: center; justify-content: center; width: 36px; height: 36px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; }
            #sidebar-close { display: flex !important; align-items: center; justify-content: center; }
            .hide-xs      { display: none !important; }
            .page-header  { flex-direction: column; align-items: flex-start; gap: 8px; }
            .filter-bar   { flex-direction: column; padding: 12px; }
            .filter-group { width: 100%; }
            .filter-group input,
            .filter-group select { width: 100%; }
            .data-table th, .data-table td { padding: 10px 12px; font-size: 12px; }
        }
        @media (max-width: 640px) {
            .stat-grid-6 { grid-template-columns: repeat(2, 1fr) !important; }
            .stat-card { padding: 14px 16px; }
        }
        @media (max-width: 480px) {
            .stat-grid-6 { grid-template-columns: 1fr !important; }
        }
    </style>
</head>
<body>

<!-- Overlay (mobile) -->
<div id="sidebar-overlay" onclick="closeSidebar()"></div>

<div style="min-height:100vh;">

    <!-- ════ SIDEBAR ════ -->
    <aside id="sidebar">

        <!-- Logo Area -->
        <div style="padding:18px 20px 16px; border-bottom:1px solid rgba(255,255,255,0.08);
                    display:flex; align-items:center; justify-content:space-between; flex-shrink:0;">
            <div>
                <div style="font-size:16.5px; font-weight:900; color:#fff; letter-spacing:-0.3px; display:flex; align-items:center; gap:6px;">
                    🎓 School<span style="color:#38bdf8;">Mapr</span>
                </div>
                <div style="font-size:10.5px; color:rgba(255,255,255,0.45); margin-top:2px; font-weight:700; letter-spacing:0.04em; text-transform:uppercase;">
                    Executive Admin Suite
                </div>
            </div>
            <button onclick="closeSidebar()" id="sidebar-close"
                style="display:none; background:rgba(255,255,255,0.08); border:none;
                       color:rgba(255,255,255,0.7); width:30px; height:30px;
                       border-radius:6px; cursor:pointer; font-size:14px;">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Navigation Links -->
        <nav style="flex:1; padding:10px 0; overflow-y:auto;">

            {{-- MAIN --}}
            <div class="nav-group-label">Overview</div>
            <a href="{{ route('admin.dashboard') }}"
               class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
               onclick="closeSidebar()">
                <i class="fas fa-chart-line"></i>
                <span>Executive Dashboard</span>
            </a>

            {{-- INSTITUTIONS --}}
            <div class="nav-group-label">Institutions</div>
            <a href="{{ route('admin.schools') }}"
               class="nav-item {{ request()->routeIs('admin.schools') && !request()->routeIs('admin.schools.pending') ? 'active' : '' }}"
               onclick="closeSidebar()">
                <i class="fas fa-school"></i>
                <span>All Schools</span>
            </a>
            <a href="{{ route('admin.schools.pending') }}"
               class="nav-item {{ request()->routeIs('admin.schools.pending') ? 'active' : '' }}"
               onclick="closeSidebar()">
                <i class="fas fa-hourglass-half"></i>
                <span style="flex:1;">Pending Approvals</span>
                @php $pendingSchoolsCount = \App\Models\School::where('status','pending')->count(); @endphp
                @if($pendingSchoolsCount > 0)
                    <span class="nav-badge" style="background:#f59e0b;">{{ $pendingSchoolsCount }}</span>
                @endif
            </a>

            {{-- LEADS & PARENT CRM --}}
            <div class="nav-group-label">Parent CRM & Leads</div>
            <a href="{{ route('admin.enquiries') }}"
               class="nav-item {{ request()->routeIs('admin.enquiries*') ? 'active' : '' }}"
               onclick="closeSidebar()">
                <i class="fas fa-headset"></i>
                <span style="flex:1;">Parent Inquiries & CRM</span>
                @php $unreadEnqCount = \App\Models\Enquiry::where('status','new')->count(); @endphp
                @if($unreadEnqCount > 0)
                    <span class="nav-badge">{{ $unreadEnqCount }}</span>
                @endif
            </a>
            <a href="{{ route('admin.visits') }}"
               class="nav-item {{ request()->routeIs('admin.visits*') ? 'active' : '' }}"
               onclick="closeSidebar()">
                <i class="fas fa-calendar-check"></i>
                <span style="flex:1;">Campus Visits</span>
                @php $pendingVisitCount = \App\Models\VisitBooking::where('status','pending')->count(); @endphp
                @if($pendingVisitCount > 0)
                    <span class="nav-badge" style="background:#0ea5e9;">{{ $pendingVisitCount }}</span>
                @endif
            </a>
            <a href="{{ route('admin.admissions') }}"
               class="nav-item {{ request()->routeIs('admin.admissions*') ? 'active' : '' }}"
               onclick="closeSidebar()">
                <i class="fas fa-file-alt"></i>
                <span style="flex:1;">Admissions Pipeline</span>
                @php $pendingAdmCount = \App\Models\Admission::where('status','pending')->count(); @endphp
                @if($pendingAdmCount > 0)
                    <span class="nav-badge" style="background:#10b981;">{{ $pendingAdmCount }}</span>
                @endif
            </a>

            {{-- FINANCE --}}
            <div class="nav-group-label">Finance</div>
            <a href="{{ route('admin.payments') }}"
               class="nav-item {{ request()->routeIs('admin.payments*') ? 'active' : '' }}"
               onclick="closeSidebar()">
                <i class="fas fa-credit-card"></i>
                <span style="flex:1;">Payments & Revenue</span>
                @php $payCount = \App\Models\Payment::where('status','success')->count(); @endphp
                @if($payCount > 0)
                    <span class="nav-badge" style="background:#10b981;">{{ $payCount }}</span>
                @endif
            </a>

            {{-- USERS & ACCESS --}}
            <div class="nav-group-label">Users & Privileges</div>
            <a href="{{ route('admin.users') }}"
               class="nav-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}"
               onclick="closeSidebar()">
                <i class="fas fa-users-cog"></i>
                <span>User Directory</span>
            </a>

            {{-- SYSTEM --}}
            <div class="nav-group-label">System & Settings</div>
            <a href="{{ route('admin.settings') }}"
               class="nav-item {{ request()->routeIs('admin.settings*') ? 'active' : '' }}"
               onclick="closeSidebar()">
                <i class="fas fa-sliders-h"></i>
                <span style="flex:1;">Platform Settings</span>
            </a>
            <a href="{{ route('admin.logs') }}"
               class="nav-item {{ request()->routeIs('admin.logs*') ? 'active' : '' }}"
               onclick="closeSidebar()">
                <i class="fas fa-shield-alt"></i>
                <span style="flex:1;">Security Audit Trail</span>
                @php $logCount = \App\Models\ActivityLog::count(); @endphp
                @if($logCount > 0)
                    <span class="nav-badge" style="background:#6366f1;">{{ $logCount }}</span>
                @endif
            </a>

        </nav>

        <!-- Sidebar User Footer -->
        <div style="padding:12px; border-top:1px solid rgba(255,255,255,0.08); flex-shrink:0;">
            <div style="display:flex; align-items:center; gap:10px; padding:8px 10px;
                        border-radius:10px; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.05);">
                <div style="width:32px; height:32px; background:linear-gradient(135deg,#0f2d59,#2563eb); border-radius:50%;
                            display:flex; align-items:center; justify-content:center;
                            color:#fff; font-weight:800; font-size:12.5px; flex-shrink:0;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div style="flex:1; min-width:0;">
                    <div style="font-size:12px; font-weight:700; color:#fff;
                                overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                        {{ Auth::user()->name }}
                    </div>
                    <div style="font-size:10.5px; color:rgba(255,255,255,0.4); font-weight:500;">Super Administrator</div>
                </div>
                <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                    @csrf
                    <button type="submit" title="Logout"
                        style="color:rgba(255,255,255,0.4); font-size:13px;
                               background:none; border:none; cursor:pointer; padding:5px;
                               transition: color 0.15s;"
                        onmouseover="this.style.color='#ef4444'"
                        onmouseout="this.style.color='rgba(255,255,255,0.4)'">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>

    </aside>

    <!-- ════ MAIN ════ -->
    <main id="main-content">

        <!-- Top Header Bar -->
        <header style="background:#ffffff; border-bottom:1px solid #e2e8f0;
                       padding:0 24px; height:58px;
                       display:flex; align-items:center; justify-content:space-between;
                       position:sticky; top:0; z-index:40; gap:14px;
                       box-shadow:0 1px 3px rgba(15,23,42,0.03);">

            <!-- Mobile Hamburger -->
            <button id="menu-btn" onclick="openSidebar()"
                style="display:none; background:none; border:none; color:#334155;
                       font-size:18px; cursor:pointer; padding:6px;
                       border-radius:6px; flex-shrink:0;">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Page Title & Breadcrumb -->
            <div style="display:flex; align-items:center; gap:8px; min-width:0; flex:1;">
                <h1 style="font-size:15px; font-weight:800; color:#0f172a;
                           letter-spacing:-0.2px; white-space:nowrap; margin:0;">
                    @yield('page-title', 'Dashboard')
                </h1>
                <span style="color:#cbd5e1; font-size:13px; flex-shrink:0;">/</span>
                <span style="font-size:12.5px; color:#64748b; font-weight:500;
                             overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                    @yield('page-sub', 'Live performance metrics & control desk')
                </span>
            </div>

            <!-- Right Profile & Quick Actions -->
            <div style="display:flex; align-items:center; gap:10px; flex-shrink:0;">
                <form action="{{ route('admin.cache.clear') }}" method="POST" style="margin:0;" onsubmit="return confirm('Purge compiled views, routes, and application cache now?');">
                    @csrf
                    <button type="submit"
                       title="Purge compiled views, route cache, and application cache"
                       style="font-size:12px; color:#0f766e; background:#f0fdf4; border:1px solid #bbf7d0;
                              font-weight:700; display:flex; align-items:center; gap:6px; white-space:nowrap;
                              border-radius:7px; padding:5px 12px; cursor:pointer; transition:all 0.15s;">
                        <i class="fas fa-bolt" style="font-size:11px; color:#16a34a;"></i>
                        <span class="hide-xs">Purge Cache</span>
                    </button>
                </form>
                <a href="/" target="_blank"
                   style="font-size:12px; color:#475569; text-decoration:none;
                          font-weight:600; display:flex; align-items:center; gap:6px; white-space:nowrap;
                          background:#f8fafc; border:1px solid #e2e8f0; border-radius:7px; padding:5px 11px;
                          transition:all 0.15s;">
                    <i class="fas fa-globe" style="font-size:11px; color:#2563eb;"></i>
                    <span class="hide-xs">Live Portal</span>
                </a>
                <div style="width:1px; height:20px; background:#e2e8f0;"></div>
                <div style="width:34px; height:34px;
                            background:linear-gradient(135deg,#0f172a 0%, #2563eb 100%);
                            border-radius:50%; display:flex; align-items:center;
                            justify-content:center; color:#fff; font-weight:800;
                            font-size:13px; flex-shrink:0;
                            box-shadow:0 2px 6px rgba(15,23,42,0.18);">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            </div>
        </header>

        <!-- Page Content Viewport -->
        <div class="admin-content-wrap">

            @if(session('success'))
            <div class="alert-success">
                <i class="fas fa-check-circle" style="color:#10b981; flex-shrink:0;"></i>
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="alert-error">
                <i class="fas fa-exclamation-circle" style="color:#e11d48; flex-shrink:0;"></i>
                {{ session('error') }}
            </div>
            @endif

            @if(isset($errors) && $errors->any())
            <div class="alert-error" style="align-items:flex-start;">
                <i class="fas fa-exclamation-circle" style="color:#e11d48; flex-shrink:0; margin-top:2px;"></i>
                <ul style="margin:0; padding:0; list-style:none;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @yield('content')

        </div>

    </main>
</div>

<script>
    function openSidebar() {
        document.getElementById('sidebar').classList.add('open');
        document.getElementById('sidebar-overlay').classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('sidebar-overlay').classList.remove('active');
        document.body.style.overflow = '';
    }
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeSidebar();
    });
</script>

</body>
</html>