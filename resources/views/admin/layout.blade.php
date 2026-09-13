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
        * { font-family: 'Inter', sans-serif; box-sizing: border-box; }
        body { background: #f1f4f9; margin: 0; }

        /* ── SIDEBAR ── */
        #sidebar {
            width: 220px;
            background: linear-gradient(180deg, #0f2040 0%, #162d56 100%);
            position: fixed; top: 0; left: 0; height: 100vh;
            display: flex; flex-direction: column;
            z-index: 100;
            transition: transform 0.25s ease;
        }
        @media (max-width: 767px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.open { transform: translateX(0); }
        }

        /* ── OVERLAY ── */
        #sidebar-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.45); z-index: 99;
        }
        #sidebar-overlay.active { display: block; }

        /* ── MAIN ── */
        #main-content { margin-left: 220px; min-height: 100vh; display: flex; flex-direction: column; }
        @media (max-width: 767px) { #main-content { margin-left: 0; } }

        /* ── NAV ITEMS ── */
        .nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 16px; margin: 1px 8px;
            color: rgba(255,255,255,0.55);
            font-size: 13px; font-weight: 500;
            text-decoration: none; border-radius: 8px;
            transition: all 0.15s ease; white-space: nowrap;
        }
        .nav-item:hover { background: rgba(255,255,255,0.08); color: #fff; }
        .nav-item.active { background: rgba(255,255,255,0.13); color: #fff; font-weight: 600; }
        .nav-item.active i { color: #f43f5e; }
        .nav-item i {
            width: 15px; font-size: 12px; text-align: center;
            color: rgba(255,255,255,0.35); flex-shrink: 0;
        }

        /* ── NAV BADGE ── */
        .nav-badge {
            margin-left: auto;
            background: #f43f5e; color: #fff;
            font-size: 9px; font-weight: 800;
            padding: 2px 6px; border-radius: 100px;
            min-width: 18px; text-align: center;
            line-height: 1.4;
        }

        /* ── NAV GROUP LABEL ── */
        .nav-group-label {
            padding: 14px 16px 4px 24px;
            font-size: 9.5px; font-weight: 700;
            letter-spacing: 0.1em; text-transform: uppercase;
            color: rgba(255,255,255,0.2);
        }

        /* ── STAT CARDS ── */
        .stat-card {
            background: #fff; border-radius: 12px;
            padding: 16px 18px; border: 1px solid #e8ecf4;
            transition: all 0.2s;
        }
        .stat-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,0.07); transform: translateY(-1px); }

        /* ── PANELS ── */
        .panel { background: #fff; border-radius: 14px; border: 1px solid #e8ecf4; overflow: hidden; }
        .panel-header {
            padding: 14px 20px; border-bottom: 1px solid #f0f4fb;
            display: flex; align-items: center; justify-content: space-between;
        }
        .panel-title { font-size: 13.5px; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 8px; }

        /* ── TABLES ── */
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table thead tr { background: #f8fafc; border-bottom: 1px solid #eef1f8; }
        .data-table thead th {
            padding: 10px 16px; font-size: 10.5px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.06em;
            color: #94a3b8; text-align: left; white-space: nowrap;
        }
        .data-table tbody tr { border-bottom: 1px solid #f4f6fb; transition: background 0.1s; }
        .data-table tbody tr:last-child { border-bottom: none; }
        .data-table tbody tr:hover { background: #fafbff; }
        .data-table td { padding: 12px 16px; font-size: 13px; color: #374151; }
        .table-wrap { width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; }

        /* ── BADGES ── */
        .badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 100px; font-size: 10.5px; font-weight: 700; white-space: nowrap; }
        .badge-blue   { background: #eff6ff; color: #2563eb; }
        .badge-green  { background: #f0fdf4; color: #16a34a; }
        .badge-yellow { background: #fefce8; color: #ca8a04; }
        .badge-red    { background: #fff1f2; color: #e11d48; }
        .badge-gray   { background: #f8fafc; color: #64748b; }
        .badge-purple { background: #f5f3ff; color: #7c3aed; }
        .badge-orange { background: #fff7ed; color: #ea580c; }

        /* ── ALERTS ── */
        .alert-success {
            background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d;
            border-radius: 10px; padding: 10px 16px; font-size: 13px;
            margin-bottom: 20px; display: flex; align-items: center; gap: 8px;
        }
        .alert-error {
            background: #fff1f2; border: 1px solid #fecdd3; color: #e11d48;
            border-radius: 10px; padding: 10px 16px; font-size: 13px;
            margin-bottom: 20px; display: flex; align-items: center; gap: 8px;
        }

        /* ── BUTTONS ── */
        .btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 16px; border-radius: 8px;
            font-size: 13px; font-weight: 600;
            border: none; cursor: pointer;
            text-decoration: none; transition: all 0.15s;
        }
        .btn-sm { padding: 5px 10px; font-size: 12px; }
        .btn-primary { background: #1e3a5f; color: #fff; }
        .btn-primary:hover { background: #162d56; color: #fff; }
        .btn-green  { background: #f0fdf4; color: #16a34a; }
        .btn-green:hover  { background: #dcfce7; }
        .btn-red    { background: #fff1f2; color: #e11d48; }
        .btn-red:hover    { background: #ffe4e6; }
        .btn-blue   { background: #eff6ff; color: #2563eb; }
        .btn-blue:hover   { background: #dbeafe; }
        .btn-yellow { background: #fefce8; color: #ca8a04; }
        .btn-yellow:hover { background: #fef9c3; }

        /* ── FILTER BAR ── */
        .filter-bar {
            background: #fff; border: 1px solid #e8ecf4;
            border-radius: 12px; padding: 14px 18px;
            margin-bottom: 18px;
            display: flex; gap: 10px; flex-wrap: wrap; align-items: flex-end;
        }
        .filter-group { display: flex; flex-direction: column; gap: 4px; }
        .filter-group label {
            font-size: 11px; font-weight: 700; color: #64748b;
            text-transform: uppercase; letter-spacing: 0.05em;
        }
        .filter-group input,
        .filter-group select {
            border: 1.5px solid #e2e8f0; border-radius: 8px;
            padding: 7px 11px; font-size: 13px; color: #374151;
            outline: none; background: #fff;
        }
        .filter-group input:focus,
        .filter-group select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
        }

        /* ── PAGE HEADER ── */
        .page-header {
            display: flex; align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap; gap: 12px; margin-bottom: 20px;
        }
        .page-header h1 { font-size: 20px; font-weight: 900; color: #0f2040; margin: 0; }
        .page-header p  { font-size: 12px; color: #94a3b8; margin: 3px 0 0; }

        /* ── PAGINATION COMPONENT ── */
        .pagination {
            display: inline-flex !important;
            list-style: none !important;
            padding-left: 0 !important;
            border-radius: 8px;
            gap: 4px;
            margin: 0 !important;
            align-items: center;
        }
        .page-item {
            display: inline-block !important;
        }
        .page-item.disabled .page-link {
            color: #94a3b8 !important;
            pointer-events: none;
            background-color: #f8fafc !important;
            border-color: #e2e8f0 !important;
        }
        .page-item.active .page-link {
            z-index: 3;
            color: #fff !important;
            background-color: #0f2d59 !important;
            border-color: #0f2d59 !important;
            font-weight: 700;
        }
        .page-link {
            position: relative;
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            min-width: 32px;
            height: 32px;
            padding: 4px 10px !important;
            font-size: 12px !important;
            color: #334155 !important;
            text-decoration: none !important;
            background-color: #fff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 6px !important;
            transition: all .15s ease-in-out;
            font-weight: 600;
            line-height: 1;
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
            gap: 12px !important;
            width: 100% !important;
        }
        nav[role="navigation"] > div:first-child {
            font-size: 12px !important;
            color: #64748b !important;
        }
        nav[role="navigation"] svg {
            width: 14px !important;
            height: 14px !important;
            display: inline-block !important;
            vertical-align: middle;
        }

        /* ── SCROLLBAR ── */
        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.12); border-radius: 10px; }

        /* ── RESPONSIVE DASHBOARD ── */
        .admin-content-wrap { padding: 24px; flex: 1; min-width: 0; width: 100%; box-sizing: border-box; }
        
        @media (max-width: 1200px) {
            .stat-grid-6 { grid-template-columns: repeat(3, 1fr) !important; }
            .dashboard-panels-grid { grid-template-columns: 1fr !important; }
        }
        @media (max-width: 767px) {
            .admin-content-wrap { padding: 14px 10px !important; }
            #sidebar { width: 260px; box-shadow: 4px 0 24px rgba(0,0,0,0.3); }
            #menu-btn     { display: flex !important; align-items: center; justify-content: center; width: 36px; height: 36px; background: #f1f5f9; border-radius: 8px; }
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
            .stat-card { padding: 12px 14px; }
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

        <!-- Logo -->
        <div style="padding:18px 20px 14px; border-bottom:1px solid rgba(255,255,255,0.06);
                    display:flex; align-items:center; justify-content:space-between; flex-shrink:0;">
            <div>
                <div style="font-size:16px; font-weight:900; color:#fff; letter-spacing:-0.3px;">
                    🎓 School<span style="color:#febb02;">Mapr</span>
                </div>
                <div style="font-size:10px; color:rgba(255,255,255,0.4); margin-top:2px; font-weight:700;">
                    Patna Admin Console
                </div>
            </div>
            <button onclick="closeSidebar()" id="sidebar-close"
                style="display:none; background:rgba(255,255,255,0.08); border:none;
                       color:rgba(255,255,255,0.6); width:28px; height:28px;
                       border-radius:6px; cursor:pointer; font-size:13px;">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Nav -->
        <nav style="flex:1; padding:8px 0; overflow-y:auto;">

            {{-- MAIN --}}
            <div class="nav-group-label">Main</div>
            <a href="{{ route('admin.dashboard') }}"
               class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
               onclick="closeSidebar()">
                <i class="fas fa-chart-line"></i>
                <span>Dashboard</span>
            </a>

            {{-- SCHOOLS --}}
            <div class="nav-group-label">Schools</div>
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
                <span style="flex:1;">Pending</span>
                @php $pendingSchoolsCount = \App\Models\School::where('status','pending')->count(); @endphp
                @if($pendingSchoolsCount > 0)
                    <span class="nav-badge">{{ $pendingSchoolsCount }}</span>
                @endif
            </a>

            {{-- ENQUIRIES --}}
            <div class="nav-group-label">Enquiries</div>
            <a href="{{ route('admin.enquiries') }}"
               class="nav-item {{ request()->routeIs('admin.enquiries') ? 'active' : '' }}"
               onclick="closeSidebar()">
                <i class="fas fa-inbox"></i>
                <span style="flex:1;">All Enquiries</span>
                @php $unreadEnqCount = \App\Models\Enquiry::where('status','new')->count(); @endphp
                @if($unreadEnqCount > 0)
                    <span class="nav-badge">{{ $unreadEnqCount }}</span>
                @endif
            </a>

            {{-- ADMISSIONS --}}
            <div class="nav-group-label">Admissions</div>
            <a href="{{ route('admin.admissions') }}"
               class="nav-item {{ request()->routeIs('admin.admissions') ? 'active' : '' }}"
               onclick="closeSidebar()">
                <i class="fas fa-file-alt"></i>
                <span style="flex:1;">All Admissions</span>
                @php $pendingAdmCount = \App\Models\Admission::where('status','pending')->count(); @endphp
                @if($pendingAdmCount > 0)
                    <span class="nav-badge">{{ $pendingAdmCount }}</span>
                @endif
            </a>
            {{-- PAYMENTS --}}
            <div class="nav-group-label">Payments</div>
            <a href="{{ route('admin.payments') }}"
               class="nav-item {{ request()->routeIs('admin.payments') ? 'active' : '' }}"
               onclick="closeSidebar()">
                <i class="fas fa-credit-card"></i>
                <span style="flex:1;">Payments</span>
                @php $payCount = \App\Models\Payment::where('status','success')->count(); @endphp
                @if($payCount > 0)
                    <span class="nav-badge" style="background:#10b981;">{{ $payCount }}</span>
                @endif
            </a>
            {{-- VISITS --}}
            <div class="nav-group-label">Visits</div>
            <a href="{{ route('admin.visits') }}"
               class="nav-item {{ request()->routeIs('admin.visits') ? 'active' : '' }}"
               onclick="closeSidebar()">
                <i class="fas fa-calendar-check"></i>
                <span style="flex:1;">All Visits</span>
                @php $pendingVisitCount = \App\Models\VisitBooking::where('status','pending')->count(); @endphp
                @if($pendingVisitCount > 0)
                    <span class="nav-badge">{{ $pendingVisitCount }}</span>
                @endif
            </a>

            {{-- USERS --}}
            <div class="nav-group-label">Users & Access</div>
            <a href="{{ route('admin.users') }}"
               class="nav-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}"
               onclick="closeSidebar()">
                <i class="fas fa-users"></i>
                <span>All Users</span>
            </a>

            {{-- AUDIT & LOGS & SETTINGS --}}
            <div class="nav-group-label">System</div>
            <a href="{{ route('admin.settings') }}"
               class="nav-item {{ request()->routeIs('admin.settings*') ? 'active' : '' }}"
               onclick="closeSidebar()">
                <i class="fas fa-sliders-h"></i>
                <span style="flex:1;">Platform Settings</span>
            </a>
            <a href="{{ route('admin.logs') }}"
               class="nav-item {{ request()->routeIs('admin.logs*') ? 'active' : '' }}"
               onclick="closeSidebar()">
                <i class="fas fa-fingerprint"></i>
                <span style="flex:1;">Activity Logs</span>
                @php $logCount = \App\Models\ActivityLog::count(); @endphp
                @if($logCount > 0)
                    <span class="nav-badge" style="background:#6366f1;">{{ $logCount }}</span>
                @endif
            </a>

        </nav>

        <!-- User Footer -->
        <div style="padding:12px; border-top:1px solid rgba(255,255,255,0.06); flex-shrink:0;">
            <div style="display:flex; align-items:center; gap:10px; padding:8px 10px;
                        border-radius:10px; background:rgba(255,255,255,0.06);">
                <div style="width:32px; height:32px; background:#f43f5e; border-radius:50%;
                            display:flex; align-items:center; justify-content:center;
                            color:#fff; font-weight:800; font-size:12px; flex-shrink:0;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div style="flex:1; min-width:0;">
                    <div style="font-size:12px; font-weight:700; color:#fff;
                                overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                        {{ Auth::user()->name }}
                    </div>
                    <div style="font-size:10px; color:rgba(255,255,255,0.35);">Super Admin</div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" title="Logout"
                        style="color:rgba(255,255,255,0.35); font-size:13px;
                               background:none; border:none; cursor:pointer; padding:4px;
                               transition: color 0.15s;"
                        onmouseover="this.style.color='#f43f5e'"
                        onmouseout="this.style.color='rgba(255,255,255,0.35)'">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>

    </aside>

    <!-- ════ MAIN ════ -->
    <main id="main-content">

        <!-- Top Bar -->
        <header style="background:#fff; border-bottom:1px solid #edf0f7;
                       padding:0 20px; height:56px;
                       display:flex; align-items:center; justify-content:space-between;
                       position:sticky; top:0; z-index:40; gap:12px;">

            <!-- Hamburger (mobile) -->
            <button id="menu-btn" onclick="openSidebar()"
                style="display:none; background:none; border:none; color:#374151;
                       font-size:18px; cursor:pointer; padding:4px 6px;
                       border-radius:6px; flex-shrink:0;">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Breadcrumb -->
            <div style="display:flex; align-items:center; gap:6px; min-width:0; flex:1;">
                <h1 style="font-size:15px; font-weight:800; color:#0f1729;
                           letter-spacing:-0.3px; white-space:nowrap; margin:0;">
                    @yield('page-title', 'Dashboard')
                </h1>
                <span style="color:#cbd5e1; font-size:13px; flex-shrink:0;">/</span>
                <span style="font-size:12px; color:#94a3b8; font-weight:400;
                             overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                    @yield('page-sub', 'Welcome back, Super Admin 👋')
                </span>
            </div>

            <!-- Right -->
            <div style="display:flex; align-items:center; gap:12px; flex-shrink:0;">
                <a href="/" target="_blank"
                   style="font-size:11.5px; color:#94a3b8; text-decoration:none;
                          font-weight:500; display:flex; align-items:center; gap:4px; white-space:nowrap;">
                    <i class="fas fa-external-link-alt" style="font-size:10px;"></i>
                    <span class="hide-xs">View Site</span>
                </a>
                <div style="width:1px; height:20px; background:#e2e8f0;"></div>
                <div style="width:34px; height:34px;
                            background:linear-gradient(135deg,#f43f5e,#fb923c);
                            border-radius:50%; display:flex; align-items:center;
                            justify-content:center; color:#fff; font-weight:800;
                            font-size:13px; flex-shrink:0;
                            box-shadow:0 2px 8px rgba(244,63,94,0.3);">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <div class="admin-content-wrap">

            @if(session('success'))
            <div class="alert-success">
                <i class="fas fa-check-circle" style="color:#22c55e; flex-shrink:0;"></i>
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
                <i class="fas fa-exclamation-circle" style="color:#e11d48; flex-shrink:0; margin-top:1px;"></i>
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
    // ESC key se sidebar band karo
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeSidebar();
    });
</script>

</body>
</html>