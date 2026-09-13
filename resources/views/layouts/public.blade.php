<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <title>@yield('title', 'SchoolMapr – Best Schools in Patna 2026 | Fees, Admissions & Reviews')</title>
    <meta name="description" content="@yield('metadesc', 'Discover & compare 100+ verified CBSE, ICSE, Bihar Board schools in Patna. Check fee structure, admission dates, campus photos, teacher ratio & book visits on SchoolMapr.')">
    <meta name="keywords" content="@yield('keywords', 'Best Schools in Patna, CBSE Schools in Patna, ICSE Schools Patna, Top Schools Bihar, School Admission Patna 2026-2027, School Fee Structure Patna, Boring Road Schools, Kankarbagh Schools, Bailey Road Schools, SchoolMapr, Patna School Reviews')">
    <meta name="author" content="SchoolMapr">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <meta name="googlebot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <link rel="canonical" href="{{ $canonicalUrl ?? url()->current() }}">

    <!-- Local SEO Geo Meta Tags (Patna & Bihar Ranking) -->
    <meta name="geo.region" content="IN-BR">
    <meta name="geo.placename" content="Patna, Bihar, India">
    <meta name="geo.position" content="25.5941;85.1376">
    <meta name="ICBM" content="25.5941, 85.1376">

    <!-- OpenGraph / Social Sharing Meta -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="SchoolMapr">
    <meta property="og:title" content="@yield('title', 'SchoolMapr – Best Schools in Patna 2026 | Fees, Admissions & Reviews')">
    <meta property="og:description" content="@yield('metadesc', 'Discover & compare 100+ verified CBSE, ICSE, Bihar Board schools in Patna. Check fee structure, admission dates, campus photos & book visits on SchoolMapr.')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('og_image', asset('favicon.png'))">
    <meta property="og:locale" content="en_IN">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'SchoolMapr – Best Schools in Patna 2026 | Fees, Admissions & Reviews')">
    <meta name="twitter:description" content="@yield('metadesc', 'Discover & compare 100+ verified CBSE, ICSE, Bihar Board schools in Patna. Check fee structure, admission dates & book visits on SchoolMapr.')">
    <meta name="twitter:image" content="@yield('og_image', asset('favicon.png'))">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="alternate icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Global Schema.org JSON-LD -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@graph": [
        {
          "@type": "WebSite",
          "@id": "{{ url('/') }}/#website",
          "url": "{{ url('/') }}",
          "name": "SchoolMapr",
          "description": "Patna's #1 School Discovery and Direct Admission Portal",
          "potentialAction": {
            "@type": "SearchAction",
            "target": {
              "@type": "EntryPoint",
              "urlTemplate": "{{ url('/') }}?search={search_term_string}"
            },
            "query-input": "required name=search_term_string"
          },
          "inLanguage": "en-IN"
        },
        {
          "@type": "Organization",
          "@id": "{{ url('/') }}/#organization",
          "name": "SchoolMapr",
          "url": "{{ url('/') }}",
          "logo": "{{ asset('favicon.png') }}",
          "description": "Bihar's leading education portal for verified school comparisons, fee structures, and transparent school admissions.",
          "address": {
            "@type": "PostalAddress",
            "addressLocality": "Patna",
            "addressRegion": "Bihar",
            "addressCountry": "IN"
          }
        }
      ]
    }
    </script>
    @stack('seo')
    <style>
        /* ── ROOT & STRICT OVERFLOW PREVENTION ── */
        *, *::before, *::after {
            box-sizing: border-box !important;
            margin: 0;
            padding: 0;
        }

        html, body {
            width: 100%;
            max-width: 100%;
            overflow-x: hidden !important;
            position: relative;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: #f4f6f9;
            color: #1f2937;
            -webkit-text-size-adjust: 100%;
        }

        a { text-decoration: none; }
        img { max-width: 100%; height: auto; display: block; }

        :root {
            --navy:   #0f2d59;
            --navy2:  #0b2b4d;
            --yellow: #febb02;
            --yellow2:#fbbf24;
            --red:    #e63946;
            --green:  #16a34a;
            --muted:  #6b7280;
            --border: #e5e7eb;
            --bg:     #f4f6f9;
            --white:  #ffffff;
        }

        /* ── EXPANSIVE CONTAINER SIZING ── */
        .container {
            width: 100% !important;
            max-width: 1440px !important;
            margin-left: auto;
            margin-right: auto;
            padding-left: 28px !important;
            padding-right: 28px !important;
            box-sizing: border-box !important;
        }
        .container-fluid {
            width: 100% !important;
            max-width: 100% !important;
            padding-left: 28px !important;
            padding-right: 28px !important;
            box-sizing: border-box !important;
        }
        @media (max-width: 991px) {
            .container, .container-fluid {
                padding-left: 18px !important;
                padding-right: 18px !important;
            }
        }
        @media (max-width: 575px) {
            .container, .container-fluid {
                padding-left: 12px !important;
                padding-right: 12px !important;
            }
            .row {
                margin-left: -6px !important;
                margin-right: -6px !important;
            }
            .row > * {
                padding-left: 6px !important;
                padding-right: 6px !important;
            }
        }

        /* ── NAVBAR ── */
        .sm-nav {
            background: #ffffff;
            box-shadow: 0 2px 10px rgba(15,45,89,0.06);
            position: sticky;
            top: 0;
            z-index: 1000;
            width: 100%;
        }
        .sm-nav .inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            min-height: 60px;
            padding: 8px 0;
        }
        .nav-brand {
            font-weight: 900;
            font-size: 20px;
            color: var(--navy) !important;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            gap: 7px;
            white-space: nowrap;
        }
        .nav-brand i { color: var(--yellow); }
        .nav-brand span { color: #0284c7; }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .nav-link-item {
            color: #374151;
            font-size: 13.5px;
            font-weight: 700;
            padding: 8px 14px;
            border-radius: 8px;
            transition: all .15s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .nav-link-item:hover, .nav-link-item.active {
            color: var(--navy);
            background: #eff6ff;
        }
        .nav-cmp-btn {
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #374151;
            font-size: 13.5px;
            font-weight: 700;
            padding: 8px 14px;
            border-radius: 8px;
            transition: all .15s;
        }
        .nav-cmp-btn:hover { color: var(--navy); background: #eff6ff; }
        #cmp-badge {
            display: none;
            background: var(--red);
            color: #fff;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 10px;
            font-weight: 800;
            align-items: center;
            justify-content: center;
        }
        #cmp-badge.show { display: inline-flex; }

        .btn-login {
            background: #eff6ff;
            color: var(--navy);
            border: 1.5px solid #bfdbfe;
            border-radius: 8px;
            padding: 7px 16px;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            transition: all .15s;
            display: inline-block;
        }
        .btn-login:hover { background: var(--navy); color: #fff; border-color: var(--navy); }
        .btn-signup {
            background: var(--yellow);
            color: #0f2d59;
            border: none;
            border-radius: 8px;
            padding: 8px 18px;
            font-weight: 800;
            font-size: 13px;
            cursor: pointer;
            transition: all .15s;
            display: inline-block;
        }
        .btn-signup:hover { background: #e5a700; }
        .btn-dashboard {
            font-size: 13px;
            font-weight: 700;
            color: var(--navy);
            border: 1.5px solid #cbd5e1;
            border-radius: 8px;
            padding: 7px 15px;
            background: #fff;
            transition: all .15s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
        }
        .btn-dashboard:hover { background: var(--navy); color: #fff; border-color: var(--navy); }
        .btn-logout-nav {
            background: #fff5f5;
            color: #dc2626;
            border: 1.5px solid #fecaca;
            border-radius: 8px;
            padding: 7px 14px;
            font-weight: 700;
            font-size: 13px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all .15s;
            cursor: pointer;
        }
        .btn-logout-nav:hover {
            background: #dc2626;
            color: #ffffff;
            border-color: #dc2626;
        }

        .nav-toggler {
            display: none;
            background: #f8fafc;
            border: 1.5px solid #cbd5e1;
            border-radius: 8px;
            width: 40px;
            height: 40px;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--navy);
            font-size: 16px;
        }

        /* ── MOBILE SLIDING DRAWER ── */
        .nav-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15,23,42,0.6);
            z-index: 9998;
            backdrop-filter: blur(2px);
        }
        .nav-overlay.open { display: block; }
        .nav-mobile-panel {
            position: fixed;
            top: 0;
            left: -320px;
            bottom: 0;
            width: 290px;
            max-width: 85vw;
            background: #fff;
            z-index: 9999;
            transition: left .28s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-y: auto;
            box-shadow: 4px 0 30px rgba(0,0,0,.25);
            display: flex;
            flex-direction: column;
        }
        .nav-mobile-panel.open { left: 0; }
        .nav-mobile-brand {
            padding: 18px 20px;
            font-size: 19px;
            font-weight: 900;
            color: var(--navy);
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .nav-mobile-close {
            background: none;
            border: none;
            font-size: 24px;
            color: #64748b;
            cursor: pointer;
            line-height: 1;
        }
        .nav-mobile-links {
            padding: 10px 0;
            flex-grow: 1;
        }
        .nav-mobile-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 13px 20px;
            font-size: 13.5px;
            font-weight: 700;
            color: #334155;
            border-bottom: 1px solid #f8fafc;
            transition: all .15s;
        }
        .nav-mobile-link:hover, .nav-mobile-link.active {
            background: #eff6ff;
            color: var(--navy);
        }
        .nav-mobile-auth {
            padding: 16px 20px;
            border-top: 1px solid #f1f5f9;
            background: #f8fafc;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        /* ── FOOTER ── */
        .sm-footer {
            background: var(--navy2);
            color: rgba(255,255,255,.65);
            border-top: 5px solid var(--yellow);
            width: 100%;
            overflow: hidden;
        }
        .sm-footer .inner { padding: 48px 0 24px; }
        .footer-brand { font-size: 21px; font-weight: 900; color: #fff; display: flex; align-items: center; gap: 8px; }
        .footer-brand i { color: var(--yellow); }
        .sm-footer p { font-size: 13px; line-height: 1.7; }
        .sm-footer h6 { color: #fff; font-weight: 800; font-size: 13px; text-transform: uppercase; letter-spacing: .06em; margin-bottom: 14px; }
        .sm-footer a { color: rgba(255,255,255,.6); font-size: 13px; display: block; margin-bottom: 8px; transition: color .15s; }
        .sm-footer a:hover { color: var(--yellow); }
        .footer-list-school { background: #0f345c; padding: 20px; border-radius: 12px; border: 1px solid #1b4372; }
        .footer-bottom { border-top: 1px solid rgba(255,255,255,.1); margin-top: 30px; padding-top: 18px; font-size: 12px; text-align: center; }

        /* ── FLASH MESSAGES ── */
        .sm-flash { position: fixed; top: 70px; right: 16px; z-index: 9998; padding: 12px 18px; border-radius: 10px; font-size: 13px; font-weight: 700; box-shadow: 0 8px 30px rgba(0,0,0,.15); max-width: 320px; }
        .sm-flash.success { background: #dcfce7; color: #15803d; border: 1.5px solid #86efac; }
        .sm-flash.error   { background: #fee2e2; color: #dc2626; border: 1.5px solid #fca5a5; }

        /* ── MEDIA QUERIES ── */
        @media (max-width: 991px) {
            .nav-toggler { display: flex; }
            .nav-links { display: none !important; }
            .nav-auth { display: none !important; }
            .sm-nav .inner { min-height: 56px; }
        }
    </style>
    @stack('styles')
</head>
<body>

@if(session('success'))
<div class="sm-flash success" id="smFlash">✅ {{ session('success') }}</div>
@elseif(session('error'))
<div class="sm-flash error" id="smFlash">❌ {{ session('error') }}</div>
@endif

<div class="nav-overlay" id="navOverlay" onclick="closeNav()"></div>
<div class="nav-mobile-panel" id="navMobilePanel">
    <div class="nav-mobile-brand">
        <div class="d-flex align-items-center gap-2">
            <i class="fa-solid fa-graduation-cap" style="color:var(--yellow);"></i> SchoolMapr
        </div>
        <button type="button" class="nav-mobile-close" onclick="closeNav()">&times;</button>
    </div>

    <div class="nav-mobile-links">
        <a href="{{ url('/') }}" class="nav-mobile-link {{ request()->is('/') ? 'active' : '' }}"><i class="fa-solid fa-location-arrow me-2" style="color:var(--navy);"></i> Find Schools</a>
        <a href="{{ url('/compare') }}" class="nav-mobile-link {{ request()->is('compare*') ? 'active' : '' }}"><i class="fa-solid fa-scale-balanced me-2" style="color:var(--navy);"></i> Compare Schools</a>
        <a href="{{ route('pages.about') }}" class="nav-mobile-link {{ request()->routeIs('pages.about') ? 'active' : '' }}"><i class="fa-solid fa-circle-info me-2" style="color:#0284c7;"></i> About Us</a>
        <a href="{{ route('pages.contact') }}" class="nav-mobile-link {{ request()->routeIs('pages.contact') ? 'active' : '' }}"><i class="fa-solid fa-envelope me-2" style="color:#16a34a;"></i> Contact Us</a>

        @auth
            @if(Auth::user()->hasRole('admin'))
                <a href="{{ route('admin.dashboard') }}" class="nav-mobile-link">🛠️ Admin Dashboard</a>
            @elseif(Auth::user()->hasRole('school_owner'))
                <a href="{{ route('school-owner.dashboard') }}" class="nav-mobile-link">🏫 School Partner Dashboard</a>
            @else
                <a href="{{ route('parent.dashboard') }}" class="nav-mobile-link">📊 Parent Dashboard</a>
                <a href="{{ route('parent.saved') }}" class="nav-mobile-link">❤️ Saved Schools</a>
                <a href="{{ route('parent.enquiries') }}" class="nav-mobile-link">📩 My Enquiries</a>
            @endif
        @endauth
    </div>

    @auth
        <div class="nav-mobile-auth">
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge bg-primary text-white" style="font-size:11px;">{{ Auth::user()->roles->pluck('name')->first() ?? 'User' }}</span>
                <strong style="font-size:13px;color:#0f2d59;">{{ Auth::user()->name }}</strong>
            </div>
            <div style="font-size:11.5px;color:#6b7280;margin-bottom:8px;">{{ Auth::user()->email }}</div>
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" style="width:100%;background:#dc2626;color:#fff;border:none;border-radius:8px;padding:10px;font-size:13px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:6px;">
                    <i class="fa-solid fa-right-from-bracket"></i> Sign Out
                </button>
            </form>
        </div>
    @else
        <div class="nav-mobile-auth">
            <a href="{{ route('login') }}" class="btn-login text-center w-100 mb-2">Login</a>
            <a href="{{ route('register') }}" class="btn-signup text-center w-100">Sign Up</a>
        </div>
    @endauth
</div>

<nav class="sm-nav">
    <div class="container">
        <div class="inner">
            <a href="{{ url('/') }}" class="nav-brand">
                <i class="fa-solid fa-graduation-cap"></i> School<span>Mapr</span>
            </a>

            <div class="nav-links" id="navLinks">
                <a href="{{ url('/') }}" class="nav-link-item {{ request()->is('/') ? 'active' : '' }}">
                    <i class="fa-solid fa-location-arrow"></i> Find Schools
                </a>
                <a href="{{ url('/compare') }}" class="nav-cmp-btn {{ request()->is('compare*') ? 'active' : '' }}">
                    <i class="fa-solid fa-scale-balanced"></i> Compare <span id="cmp-badge"></span>
                </a>
                <a href="{{ route('pages.about') }}" class="nav-link-item {{ request()->routeIs('pages.about') ? 'active' : '' }}">
                    <i class="fa-solid fa-circle-info"></i> About Us
                </a>
                <a href="{{ route('pages.contact') }}" class="nav-link-item {{ request()->routeIs('pages.contact') ? 'active' : '' }}">
                    <i class="fa-solid fa-envelope"></i> Contact
                </a>
            </div>

            <div class="nav-auth d-none d-md-flex align-items-center gap-2">
                @auth
                    @if(Auth::user()->hasRole('admin'))
                        <a href="{{ route('admin.dashboard') }}" class="btn-dashboard"><i class="fa-solid fa-gauge-high"></i> Admin Portal</a>
                    @elseif(Auth::user()->hasRole('school_owner'))
                        <a href="{{ route('school-owner.dashboard') }}" class="btn-dashboard"><i class="fa-solid fa-school"></i> School Portal</a>
                    @else
                        <a href="{{ route('parent.dashboard') }}" class="btn-dashboard"><i class="fa-solid fa-chart-pie"></i> My Dashboard</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="m-0 d-inline">
                        @csrf
                        <button type="submit" class="btn-logout-nav" title="Sign Out">
                            <i class="fa-solid fa-right-from-bracket"></i> Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-login">Login</a>
                    <a href="{{ route('register') }}" class="btn-signup">Sign Up</a>
                @endauth
            </div>

            <button class="nav-toggler" onclick="openNav()" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>
</nav>

@yield('content')

{{-- ══════════════════════════════════════════════════════════════ --}}
{{-- FOOTER                                                        --}}
{{-- ══════════════════════════════════════════════════════════════ --}}
<footer class="sm-footer">
    <div class="container inner">
        <div class="row g-4">
            {{-- COL 1: BRAND --}}
            <div class="col-12 col-lg-3">
                <div class="footer-brand mb-2">
                    <i class="fa-solid fa-graduation-cap"></i> SchoolMapr
                </div>
                <p class="mb-3">Bihar's #1 verified school discovery and transparent admissions ecosystem starting in Patna District. 100% free for all parents.</p>
                <div class="text-white small fw-bold">
                    🌐 <a href="https://schoolmapr.com" class="d-inline text-warning">schoolmapr.com</a>
                </div>
                <div class="text-white-50 small mt-1">
                    📞 Helpline: <a href="tel:+918893112323" class="text-white fw-bold text-decoration-none">+91 88931 12323</a>
                </div>
            </div>

            {{-- COL 2: COMPANY & LEGAL --}}
            <div class="col-6 col-sm-4 col-lg-2">
                <h6>Company & Legal</h6>
                <a href="{{ route('pages.about') }}">About Us</a>
                <a href="{{ route('pages.contact') }}">Contact Us</a>
                <a href="{{ route('pages.faq') }}">Parent FAQs</a>
                <a href="{{ route('pages.privacy') }}">Privacy Policy</a>
                <a href="{{ route('pages.terms') }}">Terms & Conditions</a>
            </div>

            {{-- COL 3: PATNA LOCALITIES --}}
            <div class="col-6 col-sm-4 col-lg-2">
                <h6>Patna Localities</h6>
                <a href="{{ route('home', ['q' => 'Boring Road']) }}">Boring Road</a>
                <a href="{{ route('home', ['q' => 'Kankarbagh']) }}">Kankarbagh</a>
                <a href="{{ route('home', ['q' => 'Bailey Road']) }}">Bailey Road</a>
                <a href="{{ route('home', ['q' => 'Patliputra']) }}">Patliputra</a>
                <a href="{{ route('home', ['q' => 'Raja Bazar']) }}">Raja Bazar</a>
                <a href="{{ route('home', ['q' => 'Kurji']) }}">Kurji / Digha</a>
            </div>

            {{-- COL 4: BOARDS & TOOLS --}}
            <div class="col-6 col-sm-4 col-lg-2">
                <h6>Boards & Tools</h6>
                <a href="{{ route('home', ['board' => 'CBSE']) }}">CBSE Schools</a>
                <a href="{{ route('home', ['board' => 'ICSE']) }}">ICSE Schools</a>
                <a href="{{ route('home', ['board' => 'State Board']) }}">State Board</a>
                <a href="{{ url('/compare') }}">Compare Tool</a>
                <a href="{{ route('home', ['sort' => 'featured']) }}">Top Rated Schools</a>
            </div>

            {{-- COL 5: LIST YOUR SCHOOL CTA (SINGLE FOOTER POSITION) --}}
            <div class="col-12 col-lg-3">
                <div class="footer-list-school">
                    <h6 class="text-warning mb-2"><i class="fa-solid fa-school me-1"></i> List Your School for Free</h6>
                    <p class="small text-white-50 mb-3">Are you a school principal or administrator in Patna? Claim your verified profile to connect with thousands of parents.</p>
                    <a href="{{ route('school-owner.register') }}" class="btn btn-sm btn-warning fw-bold px-3 py-2 w-100">
                        Register School Partner →
                    </a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p class="mb-0">© 2026 <strong>SchoolMapr</strong> (schoolmapr.com). All rights reserved. Built with pride for educational transparency in Bihar.</p>
        </div>
    </div>
</footer>

<script>
function openNav() {
    document.getElementById('navMobilePanel').classList.add('open');
    document.getElementById('navOverlay').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeNav() {
    document.getElementById('navMobilePanel').classList.remove('open');
    document.getElementById('navOverlay').classList.remove('open');
    document.body.style.overflow = '';
}

document.addEventListener('DOMContentLoaded', function() {
    const flash = document.getElementById('smFlash');
    if (flash) {
        setTimeout(() => {
            flash.style.transition = 'opacity .5s';
            flash.style.opacity = '0';
            setTimeout(() => flash.remove(), 500);
        }, 4000);
    }
});
</script>
@stack('scripts')
</body>
</html>