<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="alternate icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <title>@yield('title', 'My Dashboard') — SchoolMapr</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        *, *::before, *::after {
            box-sizing: border-box !important;
            margin: 0;
            padding: 0;
        }

        html, body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #f8fafc;
            color: #1f2937;
        }

        /* ── NAVBAR ── */
        .pd-navbar {
            background: #ffffff;
            border-bottom: 1.5px solid #edf1f7;
            box-shadow: 0 2px 10px rgba(15,45,89,.04);
            height: 60px;
            display: flex;
            align-items: center;
            padding: 0 20px;
            position: relative;
            z-index: 100;
            flex-shrink: 0;
        }
        .pd-brand {
            font-weight: 900;
            font-size: 20px;
            color: #0f2d59;
            text-decoration: none;
            letter-spacing: -.5px;
            display: flex;
            align-items: center;
            gap: 7px;
        }
        .pd-brand span { color: #0284c7; }

        /* ── LAYOUT WRAPPER ── */
        .pd-wrap {
            display: flex;
            height: calc(100vh - 60px);
            width: 100%;
            overflow: hidden;
        }

        /* ── SIDEBAR ── */
        .pd-sidebar {
            width: 240px;
            background: #ffffff;
            border-right: 1.5px solid #edf1f7;
            box-shadow: 2px 0 12px rgba(20,32,60,.03);
            height: 100%;
            overflow-y: auto;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
        }

        .pd-user-card {
            padding: 18px 16px;
            border-bottom: 1.5px solid #f1f5f9;
            background: linear-gradient(135deg, #f8fafc, #edf4ff);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .pd-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #0f2d59, #2563eb);
            color: #fff;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            font-weight: 900;
            flex-shrink: 0;
        }
        .pd-username {
            font-size: 13.5px;
            font-weight: 800;
            color: #0f2d59;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .pd-role { font-size: 11px; color: #64748b; font-weight: 600; margin-top: 1px; }

        .pd-nav { padding: 12px; flex: 1; }
        .pd-nav-label {
            font-size: 9.5px;
            font-weight: 800;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: .08em;
            padding: 0 8px;
            margin: 14px 0 6px;
        }
        .pd-nav-label:first-child { margin-top: 2px; }

        .pd-nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            color: #475569;
            text-decoration: none;
            transition: all .15s;
            margin-bottom: 3px;
        }
        .pd-nav-link:hover { background: #f1f5f9; color: #0f2d59; }
        .pd-nav-link.active {
            background: #0f2d59;
            color: #fff;
            font-weight: 700;
        }
        .pd-nav-icon { font-size: 14px; width: 16px; text-align: center; flex-shrink: 0; }

        .pd-sidebar-footer {
            padding: 14px 16px;
            border-top: 1.5px solid #f1f5f9;
        }
        .pd-logout-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 10px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            color: #dc2626;
            background: #fee2e2;
            border: none;
            width: 100%;
            cursor: pointer;
            transition: background .15s;
            justify-content: center;
        }
        .pd-logout-btn:hover { background: #fca5a5; }

        /* ── MAIN ── */
        .pd-main {
            flex: 1;
            padding: 24px 28px;
            height: 100%;
            overflow-y: auto;
            min-width: 0;
            background: #f8fafc;
        }

        /* ── MOBILE BOTTOM NAV ── */
        .pd-mobile-nav {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #ffffff;
            border-top: 1.5px solid #e2e8f0;
            box-shadow: 0 -4px 16px rgba(0,0,0,.08);
            z-index: 9998;
            padding: 6px 0;
        }
        .pd-mobile-nav a {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2px;
            font-size: 10.5px;
            color: #64748b;
            text-decoration: none;
            padding: 5px 4px;
            font-weight: 700;
        }
        .pd-mobile-nav a span.mn-icon { font-size: 18px; }
        .pd-mobile-nav a.active { color: #0f2d59; }

        /* ── RESPONSIVE RULES ── */
        #pd-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.5); z-index: 10000;
            backdrop-filter: blur(2px);
        }
        #pd-overlay.active { display: block; }

        @media (max-width: 768px) {
            html, body { overflow: auto; height: auto; }
            .pd-wrap { height: auto; overflow: visible; display: block; }
            .pd-sidebar {
                position: fixed; top: 0; left: 0; bottom: 0; height: 100vh;
                width: 270px; z-index: 10001; transform: translateX(-100%);
                transition: transform 0.25s ease;
                box-shadow: 4px 0 24px rgba(0,0,0,0.25);
            }
            .pd-sidebar.open { transform: translateX(0); }
            #pd-menu-btn { display: flex !important; }
            #pd-sidebar-close { display: flex !important; }
            .pd-mobile-nav { display: flex; }
            .pd-main { padding: 14px 10px 80px; height: auto; overflow: visible; }
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- Mobile Overlay -->
<div id="pd-overlay" onclick="closePdSidebar()"></div>

{{-- ══ NAVBAR ══ --}}
<nav class="pd-navbar">
    <div class="d-flex align-items-center w-100 justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <!-- Hamburger (mobile only) -->
            <button id="pd-menu-btn" onclick="openPdSidebar()"
                class="d-md-none"
                style="display:none; background:#f1f5f9; border:none; color:#0f2d59;
                       width:36px; height:36px; border-radius:8px; align-items:center;
                       justify-content:center; font-size:16px; cursor:pointer; flex-shrink:0;">
                <i class="fa-solid fa-bars"></i>
            </button>

            <a href="/" class="pd-brand">
                <i class="fa-solid fa-graduation-cap" style="color:#febb02;"></i> School<span>Mapr</span>
            </a>
        </div>

        <div class="d-flex align-items-center gap-2">
            <a href="/" class="btn btn-sm btn-outline-primary fw-bold" style="font-size:12px;border-radius:8px;">
                <i class="fa-solid fa-location-arrow me-1"></i> <span class="d-none d-sm-inline">Find Schools</span>
            </a>
            <form action="/logout" method="POST" class="d-inline m-0">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-danger fw-bold" style="font-size:12px;border-radius:8px;" title="Logout">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
            </form>
        </div>
    </div>
</nav>

{{-- ══ BODY WRAPPER ══ --}}
<div class="pd-wrap">

    {{-- SIDEBAR --}}
    <aside class="pd-sidebar" id="pd-sidebar">
        <!-- Mobile Sidebar Close Header -->
        <div class="d-flex d-md-none align-items-center justify-content-between p-3 border-bottom bg-light">
            <div style="font-weight:800; color:#0f2d59; font-size:14px;">
                <i class="fa-solid fa-graduation-cap" style="color:#febb02;"></i> SchoolMapr Parent
            </div>
            <button id="pd-sidebar-close" onclick="closePdSidebar()"
                style="display:none; background:#e2e8f0; border:none; color:#334155;
                       width:30px; height:30px; border-radius:6px; align-items:center;
                       justify-content:center; font-size:14px; cursor:pointer;">
                <i class="fa-solid fa-times"></i>
            </button>
        </div>

        <div class="pd-user-card">
            <div class="pd-avatar">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div style="min-width:0;">
                <div class="pd-username">{{ Auth::user()->name }}</div>
                <div class="pd-role">Parent Account</div>
            </div>
        </div>

        <div class="pd-nav">
            <div class="pd-nav-label">Main Navigation</div>

            <a href="{{ route('parent.dashboard') }}"
               class="pd-nav-link {{ request()->routeIs('parent.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-pie pd-nav-icon"></i> Overview
            </a>

            <a href="{{ route('parent.saved') }}"
               class="pd-nav-link {{ request()->routeIs('parent.saved') ? 'active' : '' }}">
                <i class="fa-solid fa-heart pd-nav-icon text-danger"></i> Saved Schools
            </a>

            <a href="{{ route('parent.enquiries') }}"
               class="pd-nav-link {{ request()->routeIs('parent.enquiries') ? 'active' : '' }}">
                <i class="fa-solid fa-paper-plane pd-nav-icon text-primary"></i> My Enquiries
            </a>

            <a href="{{ route('dashboard.admissions') }}"
               class="pd-nav-link {{ request()->routeIs('dashboard.admissions') ? 'active' : '' }}">
                <i class="fa-solid fa-graduation-cap pd-nav-icon text-warning"></i> My Admissions
            </a>

            <a href="{{ route('dashboard.visits') }}"
               class="pd-nav-link {{ request()->routeIs('dashboard.visits') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-check pd-nav-icon text-success"></i> Campus Visits
            </a>

            <a href="{{ route('parent.payments') }}"
               class="pd-nav-link {{ request()->routeIs('parent.payments') ? 'active' : '' }}">
                <i class="fa-solid fa-receipt pd-nav-icon text-info"></i> Payments & Receipts
            </a>

            <div class="pd-nav-label">Account & Security</div>

            <a href="{{ route('parent.profile') }}"
               class="pd-nav-link {{ request()->routeIs('parent.profile') ? 'active' : '' }}">
                <i class="fa-solid fa-user-shield pd-nav-icon text-secondary"></i> Profile & 2FA
            </a>

            <div class="pd-nav-label">School Discovery</div>

            <a href="{{ url('/') }}" class="pd-nav-link">
                <i class="fa-solid fa-magnifying-glass pd-nav-icon"></i> Explore Patna Schools
            </a>

            <a href="{{ url('/compare') }}" class="pd-nav-link">
                <i class="fa-solid fa-scale-balanced pd-nav-icon"></i> Compare Schools
            </a>
        </div>

        <div class="pd-sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="pd-logout-btn">
                    <i class="fa-solid fa-power-off"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <main class="pd-main">
        @yield('content')
    </main>

</div>

{{-- ══ MOBILE BOTTOM NAV ══ --}}
<nav class="pd-mobile-nav">
    <a href="{{ route('parent.dashboard') }}" class="{{ request()->routeIs('parent.dashboard') ? 'active' : '' }}">
        <span class="mn-icon"><i class="fa-solid fa-chart-pie"></i></span>
        Dashboard
    </a>
    <a href="{{ route('parent.saved') }}" class="{{ request()->routeIs('parent.saved') ? 'active' : '' }}">
        <span class="mn-icon"><i class="fa-solid fa-heart"></i></span>
        Saved
    </a>
    <a href="{{ route('parent.enquiries') }}" class="{{ request()->routeIs('parent.enquiries') ? 'active' : '' }}">
        <span class="mn-icon"><i class="fa-solid fa-paper-plane"></i></span>
        Enquiries
    </a>
    <a href="{{ route('dashboard.visits') }}" class="{{ request()->routeIs('dashboard.visits') ? 'active' : '' }}">
        <span class="mn-icon"><i class="fa-solid fa-calendar-check"></i></span>
        Visits
    </a>
    <a href="{{ url('/') }}">
        <span class="mn-icon"><i class="fa-solid fa-compass"></i></span>
        Find
    </a>
</nav>

<script>
    function openPdSidebar() {
        const sidebar = document.getElementById('pd-sidebar');
        const overlay = document.getElementById('pd-overlay');
        if (sidebar) sidebar.classList.add('open');
        if (overlay) overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    function closePdSidebar() {
        const sidebar = document.getElementById('pd-sidebar');
        const overlay = document.getElementById('pd-overlay');
        if (sidebar) sidebar.classList.remove('open');
        if (overlay) overlay.classList.remove('active');
        document.body.style.overflow = '';
    }
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closePdSidebar();
    });
</script>
@stack('scripts')
</body>
</html>
