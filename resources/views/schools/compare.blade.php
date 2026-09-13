@extends('layouts.public')

@section('title', 'Compare Schools in Patna – SchoolMapr')
@section('metadesc', 'Compare CBSE, ICSE, and top schools in Patna side-by-side. Compare fee structures, facilities, student ratings, and admission status on SchoolMapr.')

@push('styles')
<style>
:root{
    --cmp-blue:#003b95;
    --cmp-blue-dark:#0f2d59;
    --cmp-yellow:#febb02;
    --cmp-bg:#f5f7fb;
    --cmp-line:#e5edf6;
    --cmp-text:#1f2937;
    --cmp-muted:#6b7280;
    --cmp-danger:#e63946;
    --cmp-success:#16a34a;
}

body{ background:var(--cmp-bg); }

@media print {
    .cmp-hero, .cmp-toolbar-right, .cmp-scroll-hint, .cmp-hint, footer, nav, header, .nav-main { display: none !important; }
    .cmp-summary { position: static; box-shadow: none; border: 1px solid #000; }
    .cmp-table-outer { border: 1px solid #000; box-shadow: none; }
    .cmp-table thead th { background: #0f2d59 !important; color: #fff !important; -webkit-print-color-adjust: exact; }
    body { background: #fff !important; }
}

.cmp-hero{
    background:linear-gradient(180deg,#0f2d59 0%, #163b73 100%);
    padding:52px 0 42px;
    position:relative;
    overflow:hidden;
}
.cmp-hero::before{
    content:'';
    position:absolute;
    inset:0;
    background:
        radial-gradient(circle at 15% 15%, rgba(255,255,255,.12), transparent 24%),
        radial-gradient(circle at 85% 25%, rgba(255,255,255,.10), transparent 22%);
    pointer-events:none;
}
.cmp-hero .container{ position:relative; z-index:2; }
.cmp-hero-badge{
    display:inline-flex;
    align-items:center;
    gap:7px;
    background:rgba(255,255,255,.14);
    color:#fff;
    border:1px solid rgba(255,255,255,.22);
    border-radius:999px;
    padding:7px 15px;
    font-size:12px;
    font-weight:800;
    margin-bottom:16px;
}
.cmp-hero h1{
    color:#fff;
    font-size:clamp(28px,4vw,44px);
    font-weight:900;
    letter-spacing:-.5px;
    line-height:1.12;
    margin:0 0 10px;
}
.cmp-hero p{
    color:rgba(255,255,255,.78);
    font-size:15px;
    margin:0;
}

.cmp-wrap{
    padding:34px 0 60px;
}
.cmp-loading-wrap{
    text-align:center;
    padding:80px 20px;
}
.cmp-spinner{
    width:52px;
    height:52px;
    border:4px solid #e5edf6;
    border-top-color:var(--cmp-blue);
    border-radius:50%;
    animation:cmp-spin .8s linear infinite;
    margin:0 auto 18px;
}
@keyframes cmp-spin{ to{ transform:rotate(360deg); } }

.cmp-state-card{
    background:#fff;
    border:1.5px solid #edf1f5;
    box-shadow:0 10px 35px rgba(20,32,60,.07);
    border-radius:24px;
    padding:72px 36px;
    text-align:center;
    max-width:560px;
    margin:0 auto;
}
.cmp-state-icon{
    font-size:56px;
    display:block;
    margin-bottom:18px;
}
.cmp-state-card h4{
    color:#1d3557;
    font-size:24px;
    font-weight:900;
    margin-bottom:10px;
}
.cmp-state-card p{
    color:#7b8794;
    font-size:14px;
    line-height:1.75;
    margin-bottom:28px;
}

.cmp-summary{
    position:sticky;
    top:70px;
    z-index:20;
    background:#fff;
    border:1.5px solid #edf1f5;
    border-radius:18px;
    padding:16px 18px;
    margin-bottom:22px;
    box-shadow:0 8px 22px rgba(20,32,60,.06);
}
.cmp-toolbar{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:14px;
    flex-wrap:wrap;
}
.cmp-toolbar-left h2{
    font-size:22px;
    color:#1d3557;
    font-weight:900;
    margin:0 0 4px;
}
.cmp-toolbar-left p{
    margin:0;
    font-size:13px;
    color:#8a8f98;
}
.cmp-count-badge{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-width:32px;
    height:32px;
    padding:0 10px;
    border-radius:999px;
    background:var(--cmp-blue);
    color:#fff;
    font-size:13px;
    font-weight:900;
    margin:0 6px;
}
.cmp-toolbar-right{
    display:flex;
    gap:10px;
    flex-wrap:wrap;
}
.cmp-btn-add,
.cmp-btn-clear{
    border:none;
    border-radius:12px;
    padding:11px 18px;
    font-size:13px;
    font-weight:900;
    text-decoration:none;
    transition:.2s ease;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:7px;
}
.cmp-btn-add{
    background:#0f2d59;
    color:#fff;
}
.cmp-btn-add:hover{
    background:#003b95;
    color:#fff;
}
.cmp-btn-clear{
    background:#fff5f5;
    color:#e63946;
    border:1px solid #ffd2d6;
    cursor:pointer;
}
.cmp-btn-clear:hover{
    background:#ffe9eb;
}

.cmp-scroll-hint{
    text-align:center;
    font-size:12px;
    color:#9aa1aa;
    margin-bottom:10px;
    display:none;
}

.cmp-table-outer{
    background:#fff;
    border:1.5px solid #edf1f5;
    border-radius:22px;
    overflow:hidden;
    box-shadow:0 8px 28px rgba(20,32,60,.06);
}
.cmp-table-scroll{
    overflow-x:auto;
    -webkit-overflow-scrolling:touch;
}
.cmp-table{
    width:100%;
    min-width:1060px;
    border-collapse:collapse;
}
.cmp-table thead th{
    background:#0f2d59;
    color:#fff;
    vertical-align:top;
    border-right:1px solid rgba(255,255,255,.08);
}
.cmp-table thead th:last-child{ border-right:none; }

.cmp-table .feat-col{
    position:sticky;
    left:0;
    z-index:5;
    width:200px;
    min-width:180px;
}
.cmp-table thead .feat-col{
    background:#0a2342;
    padding:20px 16px;
    text-align:left;
    font-size:12px;
    font-weight:900;
    letter-spacing:.5px;
    text-transform:uppercase;
    color:rgba(255,255,255,.8);
}

.sch-head-card{
    padding:18px 16px 18px;
    text-align:center;
    position:relative;
}
.sch-remove-btn{
    position:absolute;
    top:10px;
    right:10px;
    width:28px;
    height:28px;
    border:none;
    border-radius:50%;
    background:rgba(255,255,255,.14);
    color:#fff;
    font-size:13px;
    font-weight:900;
}
.sch-remove-btn:hover{
    background:rgba(255,255,255,.24);
}
.sch-thumb{
    width:72px;
    height:72px;
    border-radius:14px;
    overflow:hidden;
    margin:0 auto 12px;
    border:2px solid rgba(255,255,255,.18);
    background:rgba(255,255,255,.08);
}
.sch-thumb img{
    width:100%;
    height:100%;
    object-fit:cover;
    display:block;
}
.sch-head-card .sch-name{
    color:#fff;
    font-size:15px;
    font-weight:900;
    line-height:1.35;
    margin-bottom:5px;
}
.sch-head-card .sch-city{
    color:rgba(255,255,255,.68);
    font-size:11px;
    margin-bottom:10px;
}
.sch-head-card .sch-board-badge{
    display:inline-block;
    background:rgba(255,255,255,.14);
    color:#fff;
    border:1px solid rgba(255,255,255,.25);
    border-radius:999px;
    padding:4px 12px;
    font-size:11px;
    font-weight:800;
    margin-bottom:12px;
}
.sch-head-card .sch-view-btn{
    display:inline-block;
    background:var(--cmp-yellow);
    color:#111827;
    border-radius:10px;
    padding:8px 16px;
    font-size:12px;
    font-weight:900;
    text-decoration:none;
}
.sch-head-card .sch-view-btn:hover{
    color:#111827;
    filter:brightness(.96);
}

.cmp-table tbody tr{
    border-bottom:1px solid #eef2f6;
}
.cmp-table tbody tr:last-child{
    border-bottom:none;
}
.cmp-table tbody tr:nth-child(even) td:not(.feat-col){
    background:#fbfcfd;
}
.cmp-table tbody td{
    padding:15px 16px;
    text-align:center;
    vertical-align:middle;
    font-size:13px;
    color:#404854;
    border-right:1px solid #eef2f6;
}
.cmp-table tbody td:last-child{ border-right:none; }
.cmp-table tbody td.feat-col{
    background:#f5f8fc !important;
    color:#1d3557;
    font-weight:900;
    text-align:left;
    font-size:12px;
    border-right:2px solid #e7edf5;
    white-space:nowrap;
}
.cmp-best-cell{
    background:#ecfdf3 !important;
    color:#166534;
    font-weight:800;
    position:relative;
}
.best-note{
    display:inline-block;
    margin-top:6px;
    font-size:10px;
    font-weight:900;
    padding:3px 8px;
    border-radius:999px;
    background:#166534;
    color:#fff;
}

.cmp-action-row td{
    background:#f9fafb !important;
    padding:18px 16px !important;
}
.cmp-action-row td.feat-col{
    background:#f5f8fc !important;
}

.cmp-chip{
    display:inline-block;
    padding:4px 12px;
    border-radius:999px;
    font-size:11px;
    font-weight:800;
}
.cmp-chip-blue{ background:#eff6ff; color:#1d4ed8; border:1px solid #dbeafe; }
.cmp-chip-green{ background:#dcfce7; color:#15803d; }
.cmp-chip-red{ background:#fee2e2; color:#dc2626; }
.cmp-chip-yellow{ background:#fef9c3; color:#a16207; }
.cmp-chip-gray{ background:#f3f4f6; color:#6b7280; }

.cmp-mobile{ display:none; }

.mob-school-card{
    background:#fff;
    border-radius:20px;
    border:1.5px solid #edf1f5;
    box-shadow:0 8px 22px rgba(20,32,60,.05);
    margin-bottom:18px;
    overflow:hidden;
}
.mob-school-head{
    background:linear-gradient(135deg,#0f2d59,#1f4f96);
    padding:18px 16px;
    text-align:center;
    position:relative;
}
.mob-remove{
    position:absolute;
    top:12px;
    right:12px;
    width:28px;
    height:28px;
    border:none;
    border-radius:50%;
    background:rgba(255,255,255,.14);
    color:#fff;
    font-size:13px;
    font-weight:900;
}
.mob-thumb{
    width:68px;
    height:68px;
    border-radius:14px;
    overflow:hidden;
    margin:0 auto 10px;
    border:2px solid rgba(255,255,255,.18);
}
.mob-thumb img{
    width:100%;
    height:100%;
    object-fit:cover;
}
.mob-school-head .mob-name{
    color:#fff;
    font-size:16px;
    font-weight:900;
    line-height:1.35;
}
.mob-school-head .mob-city{
    color:rgba(255,255,255,.72);
    font-size:12px;
    margin-top:4px;
}
.mob-school-head .mob-board{
    display:inline-block;
    margin-top:9px;
    padding:4px 12px;
    border-radius:999px;
    background:rgba(255,255,255,.14);
    color:#fff;
    border:1px solid rgba(255,255,255,.22);
    font-size:11px;
    font-weight:800;
}
.mob-row{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:10px;
    padding:12px 16px;
    border-bottom:1px solid #f2f4f7;
}
.mob-row:last-of-type{ border-bottom:none; }
.mob-label{
    font-size:12px;
    color:#1d3557;
    font-weight:900;
    white-space:nowrap;
}
.mob-val{
    font-size:13px;
    color:#444;
    text-align:right;
    flex:1;
}
.mob-action{
    padding:16px;
    background:#f8fafc;
    display:grid;
    gap:8px;
}
.mob-view-btn{
    display:block;
    width:100%;
    text-align:center;
    background:var(--cmp-yellow);
    color:#111827;
    border-radius:12px;
    padding:12px;
    font-size:14px;
    font-weight:900;
    text-decoration:none;
}
.mob-view-btn:hover{
    color:#111827;
}
.mob-enquire-btn{
    display:block;
    width:100%;
    text-align:center;
    background:#fff;
    color:#0f2d59;
    border:1.5px solid #0f2d59;
    border-radius:12px;
    padding:12px;
    font-size:14px;
    font-weight:900;
    text-decoration:none;
}

.cmp-hint{
    text-align:center;
    font-size:12px;
    color:#9aa1aa;
    margin-top:16px;
    padding:8px 10px;
}
.cmp-hint code{
    background:#f4f6f9;
    color:#667085;
    border-radius:6px;
    padding:3px 8px;
    font-size:11px;
}

@media (max-width: 900px){
    .cmp-scroll-hint{ display:block; }
}
@media (max-width: 640px){
    .cmp-hero{ padding:42px 0 34px; }
    .cmp-summary{
        position:static;
    }
    .cmp-toolbar{
        flex-direction:column;
        align-items:stretch;
    }
    .cmp-toolbar-right{
        width:100%;
    }
    .cmp-btn-add,
    .cmp-btn-clear{
        flex:1;
    }
    .cmp-table-outer{
        display:none;
    }
    .cmp-mobile{
        display:block;
    }
}
@media (min-width: 641px){
    .cmp-mobile{
        display:none !important;
    }
}
</style>
@endpush

@section('content')

<div class="cmp-hero">
    <div class="container text-center">
        <div class="cmp-hero-badge">⚖️ School Compare Tool</div>
        <h1>Compare Schools Side by Side</h1>
        <p>Board • Fees • Principal • Affiliation • Facilities • Admission</p>
    </div>
</div>

<div class="container cmp-wrap">

    <div id="compare-loading">
        <div class="cmp-loading-wrap">
            <div class="cmp-spinner"></div>
            <p style="color:#8a8f98;font-size:14px;margin:0;">Fetching school data...</p>
        </div>
    </div>

    <div id="compare-empty" style="display:none;">
        <div class="cmp-state-card">
            <span class="cmp-state-icon">⚖️</span>
            <h4>No Schools Selected</h4>
            <p>Go back and click <strong>Compare</strong> on school cards to add them here and see a side-by-side comparison.</p>
            <a href="/" style="display:inline-block;background:#0f2d59;color:#fff;border-radius:12px;padding:13px 32px;font-weight:900;font-size:14px;text-decoration:none;">
                ← Browse Schools
            </a>
        </div>
    </div>

    <div id="compare-error" style="display:none;">
        <div class="cmp-state-card">
            <span class="cmp-state-icon">⚠️</span>
            <h4>Unable to Load Compare Data</h4>
            <p>We couldn’t fetch the selected schools right now. Please refresh or try again after a moment.</p>
            <a href="/" style="display:inline-block;background:#0f2d59;color:#fff;border-radius:12px;padding:13px 32px;font-weight:900;font-size:14px;text-decoration:none;">
                ← Back to Home
            </a>
        </div>
    </div>

    <div id="compare-content" style="display:none;">
        <div class="cmp-summary">
            <div class="cmp-toolbar">
                <div class="cmp-toolbar-left">
                    <h2>Comparing <span class="cmp-count-badge" id="cmp-count">0</span> Schools</h2>
                    <p>Pick the best school for your child with one clean view</p>
                </div>
                <div class="cmp-toolbar-right">
                    <button type="button" onclick="window.print()" class="cmp-btn-add" style="background:#059669;cursor:pointer;">
                        <i class="fa-solid fa-print me-1"></i> Print / PDF Summary
                    </button>
                    <a href="/" class="cmp-btn-add">+ Add More Schools</a>
                    <button class="cmp-btn-clear" onclick="clearAllAndRedirect()">🗑️ Clear All</button>
                </div>
            </div>
        </div>

        <p class="cmp-scroll-hint">← Scroll horizontally to view all school columns →</p>

        <div class="cmp-table-outer">
            <div class="cmp-table-scroll">
                <table class="cmp-table" id="cmp-table">
                    <thead id="cmp-thead"></thead>
                    <tbody id="cmp-tbody"></tbody>
                </table>
            </div>
        </div>

        <div class="cmp-mobile" id="cmp-mobile-cards"></div>

        <div class="cmp-hint">
            💡 Lowest fee is highlighted in green &nbsp;|&nbsp;
            Share compare link: <code>/compare?ids=1,2,3</code>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
(function () {
    const KEY = 'sm_compare_v3';

    const defaultImages = [
        'https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&w=800&q=80',
        'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=800&q=80',
        'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=800&q=80',
        'https://images.unsplash.com/photo-1513258496099-48168024aec0?auto=format&fit=crop&w=800&q=80'
    ];

    const Store = {
        get() {
            try {
                return JSON.parse(localStorage.getItem(KEY) || '[]');
            } catch (e) {
                return [];
            }
        },
        set(arr) {
            localStorage.setItem(KEY, JSON.stringify(arr));
        },
        clear() {
            localStorage.removeItem(KEY);
        }
    };

    function getUrlIds() {
        // Fix: Changed from 'schools' to 'ids' to match the index page
        const raw = new URLSearchParams(window.location.search).get('ids') || '';
        return raw.split(',').map(s => parseInt(s.trim())).filter(n => !isNaN(n) && n > 0);
    }

    const ROWS = [
        { key: 'board', label: '📋 Board' },
        { key: 'medium', label: '🗣️ Medium' },
        { key: 'city', label: '📍 City' },
        { key: 'classes', label: '🎓 Classes' },
        { key: 'school_type', label: '🏫 School Type' },
        { key: 'principal_name', label: '👨‍🏫 Principal' },
        { key: 'affiliation_no', label: '🆔 Affiliation No.' },
        { key: 'fee_range', label: '💰 Annual Fees' },
        { key: 'admission_fee', label: '🏷️ Admission Fee' },
        { key: 'transport_fee', label: '🚌 Transport Fee' },
        { key: 'admission_status', label: '📝 Admission' },
        { key: 'seats_available', label: '💺 Seats Available' },
        { key: 'total_students', label: '👨‍🎓 Total Students' },
        { key: 'is_verified', label: '✅ Verified' },
        { key: 'facilities', label: '🏗️ Facilities' },
        { key: 'phone', label: '📞 Phone' },
    ];

    function esc(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function badge(bg, color, text) {
        return `<span class="cmp-chip" style="background:${bg};color:${color};">${text}</span>`;
    }

    function getSchoolImage(school, index) {
        return school.image_url || school.banner_image || defaultImages[index % defaultImages.length];
    }

    function getVal(school, key) {
        switch (key) {
            case 'classes':
                return `Class ${esc(String(school.class_from ?? '?'))} – ${esc(String(school.class_to ?? '?'))}`;

            case 'school_type':
                return school.school_type ? `<strong>${esc(school.school_type)}</strong>` : '<span style="color:#aaa;">—</span>';

            case 'principal_name':
                return school.principal_name ? `<strong style="color:#1d3557;">${esc(school.principal_name)}</strong>` : '<span style="color:#aaa;">Not Provided</span>';

            case 'affiliation_no':
                return school.affiliation_no ? `<span style="font-family:monospace;font-weight:800;color:#334155;">${esc(school.affiliation_no)}</span>` : '<span style="color:#aaa;">Not Available</span>';

            case 'fee_range':
                if (!@json(auth()->check())) {
                    return '<a href="/login" style="background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;text-decoration:none;padding:5px 10px;border-radius:6px;font-size:11.5px;font-weight:800;display:inline-flex;align-items:center;gap:5px;"><i class="fa-solid fa-lock"></i> Login to View Fees</a>';
                }
                if (school.fee_min && school.fee_max) {
                    return `<strong>₹${Number(school.fee_min).toLocaleString('en-IN')}</strong>
                            <span style="color:#98a2b3;font-size:11px;"> – </span>
                            <strong>₹${Number(school.fee_max).toLocaleString('en-IN')}</strong>`;
                }
                if (school.fee_min) {
                    return `<strong>₹${Number(school.fee_min).toLocaleString('en-IN')}+</strong>`;
                }
                return '<span style="color:#aaa;">Contact School</span>';

            case 'admission_fee':
                if (!@json(auth()->check())) {
                    return '<a href="/login" style="color:#1d4ed8;font-size:11px;font-weight:700;text-decoration:none;">🔒 Login to View</a>';
                }
                return school.admission_fee ? `₹${Number(school.admission_fee).toLocaleString('en-IN')}` : '<span style="color:#aaa;">—</span>';

            case 'transport_fee':
                if (!@json(auth()->check())) {
                    return '<a href="/login" style="color:#1d4ed8;font-size:11px;font-weight:700;text-decoration:none;">🔒 Login to View</a>';
                }
                return school.transport_fee ? `₹${Number(school.transport_fee).toLocaleString('en-IN')}<span style="font-size:11px;color:#98a2b3;">/yr</span>` : '<span style="color:#aaa;">Not Available</span>';

            case 'is_verified':
                return school.is_verified ? badge('#dcfce7', '#15803d', '✅ Verified') : '<span style="color:#aaa;font-size:12px;">Not Verified</span>';

            case 'admission_status': {
                const map = {
                    open: ['#dcfce7', '#15803d', '🟢 Open'],
                    closed: ['#fee2e2', '#dc2626', '🔴 Closed'],
                    coming_soon: ['#fef9c3', '#a16207', '🟡 Coming Soon'],
                };
                const s = map[school.admission_status] || map.open;
                return badge(s[0], s[1], s[2]);
            }

            case 'seats_available':
                return school.seats_available
                    ? `<strong style="color:#e63946;font-size:16px;">${esc(String(school.seats_available))}</strong><br><span style="font-size:11px;color:#98a2b3;">available</span>`
                    : '<span style="color:#aaa;">—</span>';

            case 'total_students':
                return school.total_students
                    ? `<strong>${Number(school.total_students).toLocaleString('en-IN')}</strong>`
                    : '<span style="color:#aaa;">—</span>';

            case 'facilities': {
                const facs = school.facilities
                    ? (Array.isArray(school.facilities) ? school.facilities : school.facilities.toString().split(','))
                    : [];
                if (!facs.length) return '<span style="color:#aaa;">Not Provided</span>';

                const tags = facs.slice(0, 4).map(f =>
                    `<span class="cmp-chip cmp-chip-blue" style="margin:2px;">${esc(f.trim())}</span>`
                ).join('');

                const more = facs.length > 4
                    ? `<div style="margin-top:5px;font-size:10px;color:#98a2b3;font-weight:700;">+${facs.length - 4} more</div>`
                    : '';

                return tags + more;
            }

            case 'phone':
                return school.phone
                    ? `<a href="tel:${esc(school.phone)}" style="color:#0f2d59;font-weight:900;font-size:13px;text-decoration:none;">${esc(school.phone)}</a>`
                    : '<span style="color:#aaa;">—</span>';

            default:
                return school[key] ? `<span>${esc(String(school[key]))}</span>` : '<span style="color:#aaa;">—</span>';
        }
    }

    function showSection(id) {
        ['compare-loading', 'compare-empty', 'compare-content', 'compare-error'].forEach(sid => {
            const el = document.getElementById(sid);
            if (el) el.style.display = 'none';
        });
        const target = document.getElementById(id);
        if (target) target.style.display = 'block';
    }

    function getBestNumeric(schools, key) {
        const vals = schools.map(s => parseFloat(s[key])).filter(v => !isNaN(v));
        return vals.length ? Math.min(...vals) : null;
    }

    function removeFromCompare(id) {
        const filtered = Store.get().filter(item => String(item.id) !== String(id));
        Store.set(filtered);

        const ids = filtered.map(x => x.id);
        if (!ids.length) {
            window.location.href = '/compare';
            return;
        }
        // Fix: Changed from 'schools=' to 'ids='
        window.location.href = `/compare?ids=${ids.join(',')}`;
    }

    window.clearAllAndRedirect = function () {
        Store.clear();
        window.location.href = '/';
    };

    window.removeCompareOne = function (id) {
        removeFromCompare(id);
    };

    async function loadCompare() {
        showSection('compare-loading');

        let ids = getUrlIds();
        if (!ids.length) {
            ids = Store.get().map(s => parseInt(s.id)).filter(Boolean);
        }

        if (!ids.length) {
            showSection('compare-empty');
            return;
        }

        let schools = [];

        try {
            const results = await Promise.allSettled(
                ids.map(id =>
                    fetch(`/school-data/${id}`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    }).then(r => {
                        if (!r.ok) throw new Error(`HTTP ${r.status}`);
                        return r.json();
                    })
                )
            );

            schools = results
                .filter(r => r.status === 'fulfilled')
                .map(r => r.value);

            if (!schools.length) throw new Error('No data');

            const newStore = schools.map(s => ({
                id: s.id,
                name: s.name,
                slug: s.slug,
                board: s.board,
                city: s.city || s.address
            }));
            Store.set(newStore);

        } catch (err) {
            console.error('Compare error:', err);
            showSection('compare-error');
            return;
        }

        showSection('compare-content');
        document.getElementById('cmp-count').textContent = schools.length;

        const bestFeeMin = getBestNumeric(schools, 'fee_min');

        document.getElementById('cmp-thead').innerHTML = `
            <tr>
                <th class="feat-col">🏫 Feature</th>
                ${schools.map((s, index) => `
                    <th>
                        <div class="sch-head-card">
                            <button class="sch-remove-btn" onclick="removeCompareOne(${esc(s.id)})">×</button>
                            <div class="sch-thumb">
                                <img src="${esc(getSchoolImage(s, index))}" alt="${esc(s.name)}">
                            </div>
                            <div class="sch-name">${esc(s.name)}</div>
                            <div class="sch-city">📍 ${esc(s.city || s.address || '')}</div>
                            <div class="sch-board-badge">${esc(s.board || 'School')}</div><br>
                            <a href="/schools/${esc(s.slug)}" class="sch-view-btn">View Details →</a>
                        </div>
                    </th>
                `).join('')}
            </tr>
        `;

        let tbodyHtml = ROWS.map(row => {
            return `
                <tr>
                    <td class="feat-col">${row.label}</td>
                    ${schools.map(s => {
                        let content = getVal(s, row.key);
                        let isBest = false;

                        if (row.key === 'fee_range' && bestFeeMin !== null) {
                            isBest = parseFloat(s.fee_min) === bestFeeMin;
                            if (isBest) {
                                content += `<div class="best-note">Lowest Fee</div>`;
                            }
                        }

                        return `<td class="${isBest ? 'cmp-best-cell' : ''}">${content}</td>`;
                    }).join('')}
                </tr>
            `;
        }).join('');

        tbodyHtml += `
            <tr class="cmp-action-row">
                <td class="feat-col">📩 Enquire</td>
                ${schools.map(s => `
                    <td>
                        <a href="/schools/${esc(s.slug)}#enquiry-form"
                           style="display:inline-block;background:#0f2d59;color:#fff;border-radius:12px;padding:10px 20px;font-size:13px;font-weight:900;text-decoration:none;">
                           📩 Enquire Now
                        </a>
                    </td>
                `).join('')}
            </tr>
        `;

        document.getElementById('cmp-tbody').innerHTML = tbodyHtml;

        const mobileHtml = schools.map((s, index) => {
            const admMap = {
                open: ['#dcfce7', '#15803d', '🟢 Open'],
                closed: ['#fee2e2', '#dc2626', '🔴 Closed'],
                coming_soon: ['#fef9c3', '#a16207', '🟡 Coming Soon'],
            };
            const adm = admMap[s.admission_status] || admMap.open;

            let mobileFacilities = '';
            if (s.facilities) {
                const facs = Array.isArray(s.facilities) ? s.facilities : s.facilities.toString().split(',');
                mobileFacilities = facs.slice(0, 3).map(f =>
                    `<span class="cmp-chip cmp-chip-blue" style="margin:2px 0 0 4px;">${esc(f.trim())}</span>`
                ).join('');
            }

            return `
                <div class="mob-school-card">
                    <div class="mob-school-head">
                        <button class="mob-remove" onclick="removeCompareOne(${esc(s.id)})">×</button>
                        <div class="mob-thumb">
                            <img src="${esc(getSchoolImage(s, index))}" alt="${esc(s.name)}">
                        </div>
                        <div class="mob-name">${esc(s.name)}</div>
                        <div class="mob-city">📍 ${esc(s.city || s.address || '')}</div>
                        <span class="mob-board">${esc(s.board || 'School')}</span>
                    </div>

                    <div class="mob-row"><span class="mob-label">🗣️ Medium</span><span class="mob-val">${esc(s.medium || '—')}</span></div>
                    <div class="mob-row"><span class="mob-label">🎓 Classes</span><span class="mob-val">Class ${esc(String(s.class_from ?? '?'))} – ${esc(String(s.class_to ?? '?'))}</span></div>
                    <div class="mob-row"><span class="mob-label">🏫 Type</span><span class="mob-val">${esc(s.school_type || '—')}</span></div>
                    <div class="mob-row"><span class="mob-label">👨‍🏫 Principal</span><span class="mob-val">${esc(s.principal_name || '—')}</span></div>
                    <div class="mob-row"><span class="mob-label">🆔 Affiliation</span><span class="mob-val">${esc(s.affiliation_no || '—')}</span></div>
                    <div class="mob-row"><span class="mob-label">💰 Min Fee</span><span class="mob-val"><strong>₹${Number(s.fee_min || 0).toLocaleString('en-IN')}</strong></span></div>
                    <div class="mob-row"><span class="mob-label">💸 Max Fee</span><span class="mob-val"><strong>₹${Number(s.fee_max || 0).toLocaleString('en-IN')}</strong></span></div>
                    <div class="mob-row"><span class="mob-label">🚌 Transport</span><span class="mob-val">${s.transport_fee ? '₹' + Number(s.transport_fee).toLocaleString('en-IN') + '/yr' : '—'}</span></div>
                    <div class="mob-row"><span class="mob-label">📝 Admission</span><span class="mob-val">${badge(adm[0], adm[1], adm[2])}</span></div>
                    <div class="mob-row"><span class="mob-label">💺 Seats</span><span class="mob-val">${s.seats_available ? '<strong style="color:#e63946;">' + esc(String(s.seats_available)) + '</strong>' : '—'}</span></div>
                    <div class="mob-row"><span class="mob-label">✅ Verified</span><span class="mob-val">${s.is_verified ? badge('#dcfce7', '#15803d', 'Yes') : 'No'}</span></div>
                    <div class="mob-row"><span class="mob-label">📞 Phone</span><span class="mob-val">${s.phone ? '<a href="tel:' + esc(s.phone) + '" style="color:#0f2d59;font-weight:900;text-decoration:none;">' + esc(s.phone) + '</a>' : '—'}</span></div>
                    <div class="mob-row"><span class="mob-label">🏗️ Facilities</span><span class="mob-val">${mobileFacilities || '—'}</span></div>

                    <div class="mob-action">
                        <a href="/schools/${esc(s.slug)}" class="mob-view-btn">View Details →</a>
                        <a href="/schools/${esc(s.slug)}#enquiry-form" class="mob-enquire-btn">📩 Enquire Now</a>
                    </div>
                </div>
            `;
        }).join('');

        document.getElementById('cmp-mobile-cards').innerHTML = mobileHtml;
    }

    document.addEventListener('DOMContentLoaded', loadCompare);
})();
</script>
@endpush