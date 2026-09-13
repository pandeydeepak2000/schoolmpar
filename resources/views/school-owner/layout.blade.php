<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="alternate icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <title>@yield('title', 'School Partner Portal') — SchoolMapr</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        * { font-family: 'Inter', sans-serif; box-sizing: border-box; }
        body { background: #f8fafc; margin: 0; min-height: 100vh; }

        .so-navbar {
            background: #fff;
            box-shadow: 0 2px 12px rgba(0,0,0,.04);
            border-bottom: 1.5px solid #edf1f7;
            height: 62px; display: flex; align-items: center;
            padding: 0 16px;
            position: sticky; top: 0;
            z-index: 100;
            flex-shrink: 0;
            width: 100%;
        }
        .so-brand {
            font-weight: 900; font-size: 19px; color: #0f2d59;
            text-decoration: none; letter-spacing: -.5px;
            display: flex; align-items: center; gap: 6px;
        }
        .so-brand span.hl { color: #febb02; }
        .so-user { font-size: 13px; color: #64748b; font-weight: 500; }

        .btn-logout-nav {
            background: #fff; border: 1.5px solid #e2e8f0;
            color: #64748b; border-radius: 8px; padding: 6px 14px;
            font-weight: 600; font-size: 12px; cursor: pointer; transition: all .2s;
            display: inline-flex; align-items: center; gap: 4px;
        }
        .btn-logout-nav:hover { border-color: #e63946; color: #e63946; }

        .so-wrap { display: flex; min-height: calc(100vh - 62px); width: 100%; position: relative; }

        .so-sidebar {
            background: #0f2040;
            width: 230px; flex-shrink: 0;
            min-height: calc(100vh - 62px);
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            transition: transform 0.25s ease;
            z-index: 150;
        }

        .sidebar-section-title {
            font-size: 10px; font-weight: 700;
            color: rgba(255,255,255,.35);
            text-transform: uppercase; letter-spacing: 1.2px;
            padding: 18px 20px 6px;
        }
        .sidebar-link {
            display: flex; align-items: center; gap: 10px;
            color: rgba(255,255,255,.65); font-size: 13.5px; font-weight: 500;
            padding: 10px 20px; text-decoration: none;
            transition: all .18s; border-left: 3px solid transparent;
        }
        .sidebar-link:hover {
            background: rgba(255,255,255,.07);
            color: #fff; border-left-color: rgba(230,57,70,.5);
            text-decoration: none;
        }
        .sidebar-link.active {
            background: rgba(255,255,255,.1);
            color: #fff; border-left-color: #3b82f6; font-weight: 700;
        }
        .sidebar-link i { width: 16px; text-align: center; font-size: 13px; }
        .sidebar-divider { border-color: rgba(255,255,255,.1); margin: 6px 0; }

        .enq-badge {
            margin-left: auto; background: #3b82f6; color: #fff;
            font-size: 10px; font-weight: 700; padding: 2px 7px;
            border-radius: 100px; min-width: 20px; text-align: center;
        }
        .enq-badge.zero { background: rgba(255,255,255,.15); color: rgba(255,255,255,.5); }

        .so-main { flex: 1; padding: 24px; min-width: 0; background: #f8fafc; overflow-x: hidden; }

        /* ── OVERLAY FOR MOBILE SIDEBAR ── */
        #so-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.5); z-index: 140;
            backdrop-filter: blur(2px);
        }
        #so-overlay.active { display: block; }

        @media (max-width: 768px) {
            .so-sidebar {
                position: fixed; top: 0; left: 0; bottom: 0; height: 100vh;
                width: 260px; transform: translateX(-100%);
                box-shadow: 4px 0 24px rgba(0,0,0,0.3);
            }
            .so-sidebar.open { transform: translateX(0); }
            .mobile-bottom-nav { display: flex; }
            .so-main { padding: 14px 10px 80px; }
            #so-menu-btn { display: flex !important; }
            #so-sidebar-close { display: flex !important; }
        }

        .mobile-bottom-nav {
            display: none;
            position: fixed; bottom: 0; left: 0; right: 0;
            background: #1d3557; z-index: 100;
            border-top: 1px solid rgba(255,255,255,.1);
            padding-bottom: env(safe-area-inset-bottom, 0);
        }
        .mobile-nav-item {
            flex: 1; display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            padding: 8px 4px; color: rgba(255,255,255,.55);
            text-decoration: none; font-size: 10px; font-weight: 600; gap: 3px;
            position: relative;
        }
        .mobile-nav-item.active { color: #febb02; }
        .mobile-nav-item i { font-size: 17px; }

        .so-panel {
            background: #fff; border: 1.5px solid #f0f0f0;
            border-radius: 14px; padding: 20px; margin-bottom: 20px;
        }
        .so-panel-title {
            font-size: 14px; font-weight: 700; color: #1d3557;
            margin-bottom: 16px; padding-bottom: 12px;
            border-bottom: 1.5px solid #f4f6f9;
            display: flex; align-items: center; gap: 8px;
        }

        .table-wrap { width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; }

        .so-label { font-size: 12px; font-weight: 600; color: #374151; display: block; margin-bottom: 5px; }
        .so-input {
            border: 1.5px solid #e2e8f0; border-radius: 10px;
            padding: 10px 14px; font-size: 13.5px; outline: none;
            font-family: inherit; transition: border .2s; width: 100%;
        }
        .so-input:focus { border-color: #e63946; box-shadow: 0 0 0 3px rgba(230,57,70,.06); }

        .badge-active   { background: #dcfce7; color: #16a34a; }
        .badge-approved { background: #dcfce7; color: #16a34a; }
        .badge-pending  { background: #fef9c3; color: #ca8a04; }
        .badge-rejected { background: #fee2e2; color: #dc2626; }
        .badge-inactive { background: #f1f5f9; color: #64748b; }
        .so-badge { padding: 4px 12px; border-radius: 99px; font-size: 11px; font-weight: 700; display: inline-block; }

        .btn-red {
            background: #e63946; color: #fff; border: none;
            border-radius: 10px; padding: 11px 24px;
            font-weight: 700; font-size: 14px; cursor: pointer;
            transition: all .2s; text-decoration: none;
            display: inline-flex; align-items: center; gap: 7px;
        }
        .btn-red:hover { background: #c1121f; color: #fff; text-decoration: none; }

        .btn-ghost {
            background: #f8fafc; color: #64748b;
            border: 1.5px solid #e2e8f0; border-radius: 10px;
            padding: 11px 20px; font-weight: 600; font-size: 13px;
            text-decoration: none; display: inline-flex; align-items: center; gap: 7px;
        }
        .btn-ghost:hover { border-color: #e63946; color: #e63946; text-decoration: none; }

        .alert-success {
            background: #f0fdf4; border: 1px solid #86efac;
            border-radius: 10px; padding: 12px 16px;
            font-size: 13px; color: #16a34a; font-weight: 600; margin-bottom: 18px;
        }
        .alert-error {
            background: #fff5f5; border: 1.5px solid #fca5a5;
            border-radius: 10px; padding: 14px 18px;
            margin-bottom: 18px; font-size: 13px; color: #dc2626;
        }
        .alert-warning {
            background: #fffbeb; border: 1px solid #fcd34d;
            border-radius: 10px; padding: 12px 16px;
            font-size: 13px; color: #92400e; margin-bottom: 18px;
        }

        .welcome-banner {
            background: linear-gradient(135deg,#1d3557,#457b9d);
            border-radius: 16px; padding: 22px 28px; margin-bottom: 24px;
            position: relative; overflow: hidden;
        }
        .welcome-banner::after {
            content: '🏫'; position: absolute; right: 20px; top: 50%;
            transform: translateY(-50%); font-size: 56px; opacity: .12;
        }
        .welcome-banner h4 { color: #fff; font-weight: 800; font-size: 18px; margin: 0 0 4px; }
        .welcome-banner p  { color: rgba(255,255,255,.7); font-size: 13px; margin: 0; }

        .stat-card {
            background: #fff; border-radius: 14px; padding: 20px;
            border: 1.5px solid #f0f0f0; transition: all .2s;
        }
        .stat-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,.08); transform: translateY(-2px); }
        .stat-icon {
            width: 44px; height: 44px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; margin-bottom: 12px;
        }
        .stat-num   { font-size: 30px; font-weight: 900; color: #1d3557; line-height: 1; }
        .stat-label { font-size: 12px; color: #888; margin-top: 4px; font-weight: 500; }

        .school-row {
            background: #fff; border-radius: 12px; padding: 16px 18px;
            border: 1.5px solid #f0f0f0; margin-bottom: 10px; transition: all .2s;
        }
        .school-row:hover { border-color: #e63946; box-shadow: 0 4px 16px rgba(230,57,70,.08); }
        .school-icon {
            width: 42px; height: 42px;
            background: linear-gradient(135deg,#e63946,#457b9d);
            border-radius: 10px; display: flex; align-items: center;
            justify-content: center; font-size: 18px; flex-shrink: 0;
        }
        .school-row-name { font-size: 14px; font-weight: 700; color: #1d3557; margin: 0 0 3px; }
        .school-row-meta { font-size: 12px; color: #94a3b8; margin: 0; }

        .empty-box {
            background: #fff; border: 2px dashed #e2e8f0;
            border-radius: 14px; padding: 48px 20px; text-align: center;
        }
        .empty-box h5 { font-size: 16px; color: #64748b; margin-bottom: 8px; }
        .empty-box p  { font-size: 13px; color: #94a3b8; margin-bottom: 20px; }

    </style>
    @stack('styles')
</head>
<body>

<!-- Mobile Overlay -->
<div id="so-overlay" onclick="closeSoSidebar()"></div>

<div class="so-navbar">
    <div class="d-flex align-items-center w-100 gap-2 gap-md-3">
        <!-- Hamburger (mobile only) -->
        <button id="so-menu-btn" onclick="openSoSidebar()"
            class="d-md-none"
            style="display:none; background:#f1f5f9; border:none; color:#0f2d59;
                   width:38px; height:38px; border-radius:8px; align-items:center;
                   justify-content:center; font-size:16px; cursor:pointer; flex-shrink:0;">
            <i class="fas fa-bars"></i>
        </button>

        <a href="{{ route('school-owner.dashboard') }}" class="so-brand me-auto">
            🎓 School<span class="hl">Mapr</span>
            <span style="font-size:10px;background:#e0f2fe;color:#0369a1;padding:2px 7px;border-radius:6px;font-weight:800;letter-spacing:0.3px;">PARTNER</span>
        </a>

        <a href="/" target="_blank" class="d-none d-lg-inline-flex align-items-center gap-1 text-muted fw-bold small text-decoration-none me-2">
            <i class="fas fa-external-link-alt" style="font-size:11px;"></i> View Site
        </a>

        <span class="so-user d-none d-md-inline">👤 {{ auth()->user()->name }}</span>
        <form action="{{ route('school-owner.logout') }}" method="POST" style="margin:0;">
            @csrf
            <button type="submit" class="btn-logout-nav">
                <i class="fas fa-sign-out-alt"></i> <span class="d-none d-sm-inline">Logout</span>
            </button>
        </form>
    </div>
</div>

<div class="so-wrap">

    <div class="so-sidebar" id="so-sidebar">
        <!-- Sidebar Header (Mobile close) -->
        <div class="d-flex d-md-none align-items-center justify-content-between p-3 border-bottom border-secondary border-opacity-25">
            <div style="font-weight:800; color:#fff; font-size:14px;">
                🎓 School<span style="color:#febb02;">Mapr</span> Portal
            </div>
            <button id="so-sidebar-close" onclick="closeSoSidebar()"
                style="display:none; background:rgba(255,255,255,0.1); border:none; color:#fff;
                       width:32px; height:32px; border-radius:6px; align-items:center;
                       justify-content:center; font-size:14px; cursor:pointer;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        @php
        $sidebarEnqCount = 0;
        $sidebarVisitCount = 0;
        $sidebarAdmCount = 0;

        if (auth()->check()) {
            $sidebarSchoolIds = \App\Models\School::where('owner_id', auth()->id())->pluck('id');

            $sidebarEnqCount = \App\Models\Enquiry::whereIn('school_id', $sidebarSchoolIds)
                ->where('status', 'new')
                ->count();

            $sidebarVisitCount = class_exists(\App\Models\VisitBooking::class)
                ? \App\Models\VisitBooking::whereIn('school_id', $sidebarSchoolIds)
                    ->where('status', 'pending')
                    ->count()
                : 0;

            $sidebarAdmCount = class_exists(\App\Models\Admission::class)
                ? \App\Models\Admission::whereIn('school_id', $sidebarSchoolIds)
                    ->where('status', 'pending')
                    ->count()
                : 0;
        }
        @endphp

        <div class="sidebar-section-title">Main</div>

        <a href="{{ route('school-owner.dashboard') }}"
           class="sidebar-link {{ request()->routeIs('school-owner.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>

        <a href="{{ route('school-owner.schools.index') }}"
           class="sidebar-link {{ request()->routeIs('school-owner.schools.*') ? 'active' : '' }}">
            <i class="fas fa-school"></i> My Schools
        </a>

        <a href="{{ route('school-owner.schools.create') }}"
           class="sidebar-link {{ request()->routeIs('school-owner.schools.create') ? 'active' : '' }}">
            <i class="fas fa-plus-circle"></i> Add New School
        </a>

        <hr class="sidebar-divider mx-3">

        <div class="sidebar-section-title">Manage</div>

        <a href="{{ route('school-owner.enquiries.index') }}"
           class="sidebar-link {{ request()->routeIs('school-owner.enquiries.*') ? 'active' : '' }}">
            <i class="fas fa-envelope"></i> Enquiries
            <span class="enq-badge {{ $sidebarEnqCount == 0 ? 'zero' : '' }}">
                {{ $sidebarEnqCount > 0 ? $sidebarEnqCount : '0' }}
            </span>
        </a>

        <a href="{{ route('school-owner.visits.index') }}"
           class="sidebar-link {{ request()->routeIs('school-owner.visits.*') ? 'active' : '' }}">
            <i class="fas fa-calendar-check"></i> Visit Requests
            <span class="enq-badge {{ $sidebarVisitCount == 0 ? 'zero' : '' }}" style="{{ $sidebarVisitCount > 0 ? 'background:#f59e0b;' : '' }}">
                {{ $sidebarVisitCount > 0 ? $sidebarVisitCount : '0' }}
            </span>
        </a>

        <a href="{{ route('school-owner.admissions.index') }}"
           class="sidebar-link {{ request()->routeIs('school-owner.admissions.*') ? 'active' : '' }}">
            <i class="fas fa-file-alt"></i> Admissions
            <span class="enq-badge {{ $sidebarAdmCount == 0 ? 'zero' : '' }}" style="{{ $sidebarAdmCount > 0 ? 'background:#16a34a;' : '' }}">
                {{ $sidebarAdmCount > 0 ? $sidebarAdmCount : '0' }}
            </span>
        </a>

        <a href="{{ route('school-owner.payments.index') }}"
           class="sidebar-link {{ request()->routeIs('school-owner.payments.*') ? 'active' : '' }}">
            <i class="fas fa-receipt"></i> Fee Collections
        </a>

        <a href="#" class="sidebar-link">
            <i class="fas fa-chart-bar"></i> Analytics
            <span style="margin-left:auto;font-size:9px;color:rgba(255,255,255,.3);font-weight:600;">Soon</span>
        </a>

        <a href="{{ route('school-owner.profile') }}"
           class="sidebar-link {{ request()->routeIs('school-owner.profile*') ? 'active' : '' }}">
            <i class="fas fa-user-shield"></i> Profile & 2FA
        </a>

        <hr class="sidebar-divider mx-3">

        <a href="/" class="sidebar-link" target="_blank" rel="noopener noreferrer">
            <i class="fas fa-external-link-alt"></i> View Live Site
        </a>

        <div style="padding:16px 20px;margin-top:auto;border-top:1px solid rgba(255,255,255,.08);">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:36px;height:36px;background:rgba(255,255,255,.12);
                            border-radius:50%;display:flex;align-items:center;
                            justify-content:center;font-size:16px;flex-shrink:0;">
                    👤
                </div>
                <div style="min-width:0;">
                    <div style="color:#fff;font-size:12px;font-weight:700;
                                white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        {{ auth()->user()->name }}
                    </div>
                    <div style="color:rgba(255,255,255,.45);font-size:10px;">School Partner</div>
                </div>
            </div>
        </div>
    </div>

    <div class="so-main">
        @if(session('success'))
        <div class="alert-success">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="alert-error">❌ {{ session('error') }}</div>
        @endif

        @yield('content')
    </div>
</div>

<nav class="mobile-bottom-nav">
    <a href="{{ route('school-owner.dashboard') }}"
       class="mobile-nav-item {{ request()->routeIs('school-owner.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i>
        <span>Home</span>
    </a>

    <a href="{{ route('school-owner.schools.index') }}"
       class="mobile-nav-item {{ request()->routeIs('school-owner.schools.*') ? 'active' : '' }}">
        <i class="fas fa-school"></i>
        <span>Schools</span>
    </a>

    <a href="{{ route('school-owner.schools.create') }}"
       class="mobile-nav-item">
        <i class="fas fa-plus-circle" style="color:#e63946;font-size:22px;"></i>
        <span>Add</span>
    </a>

    <a href="{{ route('school-owner.visits.index') }}"
       class="mobile-nav-item {{ request()->routeIs('school-owner.visits.*') ? 'active' : '' }}"
       style="position:relative;">
        <i class="fas fa-calendar-check"></i>
        @if($sidebarVisitCount > 0)
        <span style="position:absolute;top:6px;right:12px;background:#f59e0b;color:#fff;
                     font-size:9px;font-weight:700;padding:1px 5px;border-radius:100px;
                     min-width:16px;text-align:center;">
            {{ $sidebarVisitCount }}
        </span>
        @endif
        <span>Visits</span>
    </a>

    <a href="{{ route('school-owner.enquiries.index') }}"
       class="mobile-nav-item {{ request()->routeIs('school-owner.enquiries.*') ? 'active' : '' }}"
       style="position:relative;">
        <i class="fas fa-envelope"></i>
        @if($sidebarEnqCount > 0)
        <span style="position:absolute;top:6px;right:12px;background:#e63946;color:#fff;
                     font-size:9px;font-weight:700;padding:1px 5px;border-radius:100px;
                     min-width:16px;text-align:center;">
            {{ $sidebarEnqCount }}
        </span>
        @endif
        <span>Enquiries</span>
    </a>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function openSoSidebar() {
        const sidebar = document.getElementById('so-sidebar');
        const overlay = document.getElementById('so-overlay');
        if (sidebar) sidebar.classList.add('open');
        if (overlay) overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    function closeSoSidebar() {
        const sidebar = document.getElementById('so-sidebar');
        const overlay = document.getElementById('so-overlay');
        if (sidebar) sidebar.classList.remove('open');
        if (overlay) overlay.classList.remove('active');
        document.body.style.overflow = '';
    }
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeSoSidebar();
    });
</script>
@stack('scripts')
</body>
</html>