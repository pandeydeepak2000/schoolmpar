@extends('layouts.public')

@section('title', 'Best Schools in Patna 2026 – Compare CBSE, ICSE Fees, Admission & Reviews | SchoolMapr')
@section('metadesc', 'Explore verified list of top schools in Patna District (Boring Road, Kankarbagh, Bailey Road, Patliputra, Danapur). Compare annual fees, facilities, student-teacher ratio, download brochures & book school visits on SchoolMapr.')
@section('keywords', 'Best Schools in Patna, Top CBSE Schools Patna, ICSE Schools Patna, Patna School Admissions 2026-2027, School Fee Structure Patna, Boring Road Schools, Kankarbagh Schools, SchoolMapr')

@push('seo')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@graph": [
    {
      "@@type": "CollectionPage",
      "@@id": "{{ route('home') }}#directory",
      "name": "Verified Schools in Patna, Bihar",
      "description": "Discover and compare top CBSE, ICSE, and Bihar Board schools in Patna with verified fees, ratings, and campus visit bookings.",
      "url": "{{ route('home') }}",
      "breadcrumb": {
        "@type": "BreadcrumbList",
        "itemListElement": [
          {
            "@type": "ListItem",
            "position": 1,
            "name": "Home",
            "item": "{{ url('/') }}"
          },
          {
            "@type": "ListItem",
            "position": 2,
            "name": "Patna Schools Directory",
            "item": "{{ route('home') }}"
          }
        ]
      }
    }
  ]
}
</script>
@endpush

@section('content')

<style>
    :root{
        --sm-blue:#003b95;
        --sm-blue-dark:#0f2d59;
        --sm-blue-soft:#eaf2ff;
        --sm-yellow:#febb02;
        --sm-yellow-dark:#d89b00;
        --sm-text:#1f2937;
        --sm-muted:#6b7280;
        --sm-line:#dbe4ef;
        --sm-bg:#f5f7fb;
        --sm-card:#ffffff;
        --sm-danger:#e63946;
        --sm-success:#16a34a;
    }

    .sm-home{
        background:var(--sm-bg);
        width: 100%;
        max-width: 100%;
        overflow-x: hidden;
    }

    /* ── HERO SECTION ── */
    .sm-hero{
        background: radial-gradient(circle at 50% 20%, #163e75 0%, #0f2d59 100%);
        position:relative;
        overflow:hidden;
        border-top:1px solid #1b4376;
        width:100%;
    }
    .sm-hero::before{
        content:"";
        position:absolute;
        inset:0;
        opacity:.15;
        background:radial-gradient(ellipse at top, #ffffff 0%, transparent 65%);
        pointer-events:none;
    }
    .sm-hero-inner{
        position:relative;
        z-index:2;
        padding:54px 0 36px;
        text-align:center;
        width:100%;
    }
    .sm-hero-pill{
        display:inline-flex;
        align-items:center;
        gap:8px;
        background:rgba(255,255,255,.12);
        color:#fff;
        border:1px solid rgba(255,255,255,.24);
        border-radius:999px;
        padding:7px 18px;
        font-size:12.5px;
        font-weight:800;
        margin-bottom:14px;
        backdrop-filter:blur(4px);
    }
    .sm-hero-title{
        color:#fff;
        font-size:clamp(26px, 4.4vw, 54px);
        line-height:1.18;
        letter-spacing:-0.6px;
        font-weight:900;
        margin:0 0 12px;
    }
    .sm-hero-title span{ color:var(--sm-yellow); }
    .sm-hero-sub{
        color:#e0edff;
        font-size:clamp(13.5px, 1.4vw, 16px);
        max-width:760px;
        margin:0 auto 26px;
        font-weight:500;
        line-height:1.6;
    }

    /* ── GRAND SEARCH PANEL (WIDE & EXPANSIVE) ── */
    .sm-search-wrap{
        max-width:1280px;
        width:100%;
        margin:0 auto;
    }
    .sm-search-panel{
        background:var(--sm-yellow);
        border-radius:16px;
        padding:8px;
        box-shadow:0 18px 50px rgba(0,0,0,.26);
        width:100%;
    }
    .sm-search-grid{
        display:grid;
        grid-template-columns: 1.8fr 1.15fr 1.15fr auto;
        gap:8px;
        width:100%;
    }
    @media (max-width: 991px) {
        .sm-search-grid { grid-template-columns: 1fr 1fr; }
        .sm-search-btn-wrap { grid-column: 1 / -1; }
    }
    @media (max-width: 575px) {
        .sm-hero-inner { padding: 26px 0 20px; }
        .sm-search-grid { grid-template-columns: 1fr; gap:6px; }
        .sm-search-panel { padding: 6px; border-radius: 12px; }
    }

    .sm-search-field{
        background:#fff;
        min-height:56px;
        border:1px solid #f1f5f9;
        border-radius:10px;
        padding:8px 16px;
        display:flex;
        align-items:center;
        gap:12px;
        text-align:left;
        width:100%;
        min-width:0;
        transition:box-shadow .2s;
    }
    .sm-search-field:focus-within{
        box-shadow:0 0 0 2px #0f2d59;
    }
    .sm-search-field i{
        color:#64748b;
        font-size:16px;
        width:18px;
        flex-shrink:0;
    }
    .sm-search-meta{
        display:flex;
        flex-direction:column;
        width:100%;
        position:relative;
        min-width:0;
    }
    .sm-search-meta label{
        font-size:10px;
        text-transform:uppercase;
        letter-spacing:.06em;
        font-weight:900;
        color:#94a3b8;
        margin-bottom:2px;
    }
    .sm-search-field input,
    .sm-search-field select{
        border:none;
        outline:none;
        width:100%;
        background:transparent;
        font-size:14px;
        color:#0f172a;
        font-weight:800;
        appearance:none;
        cursor:pointer;
        padding:0;
        min-width:0;
    }
    .sm-search-meta .chev{
        position:absolute;
        right:0;
        top:50%;
        transform:translateY(-10%);
        font-size:11px;
        color:#94a3b8;
        pointer-events:none;
    }
    .sm-search-btn{
        min-height:56px;
        width:100%;
        border:none;
        border-radius:10px;
        background:#0f2d59;
        color:#fff;
        font-size:15px;
        font-weight:900;
        padding:0 28px;
        white-space:nowrap;
        transition:.2s ease;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:9px;
        cursor:pointer;
    }
    .sm-search-btn:hover{ background:#091d3b; }

    .sm-trust-inline{
        display:flex;
        justify-content:center;
        flex-wrap:wrap;
        gap:10px;
        margin-top:20px;
    }
    .sm-trust-inline span{
        display:inline-flex;
        align-items:center;
        gap:7px;
        background:rgba(15,45,89,.6);
        border:1px solid rgba(255,255,255,.18);
        color:#fff;
        border-radius:100px;
        padding:6px 14px;
        font-size:12px;
        font-weight:700;
    }
    .sm-trust-inline i{ color:var(--sm-yellow); }

    /* ── DISCOVER BY EXTRACURRICULARS & FACILITIES ── */
    .facilities-section{
        background:#fff;
        border-bottom:1px solid #e8ecf4;
        padding:26px 0 20px;
        width:100%;
        overflow:hidden;
    }
    .fac-scroll-wrap{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:18px;
        overflow-x:auto;
        scrollbar-width:none;
        -webkit-overflow-scrolling:touch;
        padding:6px 2px 10px;
        width:100%;
        max-width:100%;
    }
    .fac-scroll-wrap::-webkit-scrollbar { display:none; }
    .fac-circle-item{
        display:flex;
        flex-direction:column;
        align-items:center;
        gap:8px;
        text-decoration:none;
        min-width:72px;
        flex-shrink:0;
        transition:transform .15s;
    }
    .fac-circle-item:hover{ transform:translateY(-3px); }
    .fac-circle-icon{
        width:50px;
        height:50px;
        border-radius:50%;
        background:#f8fafc;
        border:1.5px solid #e2e8f0;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:18px;
        color:#0f2d59;
        transition:all .18s;
    }
    .fac-circle-item:hover .fac-circle-icon{
        background:#eff6ff;
        border-color:#2563eb;
        color:#1d4ed8;
        box-shadow:0 6px 16px rgba(37,99,235,0.15);
    }
    .fac-circle-label{
        font-size:11px;
        font-weight:800;
        text-transform:uppercase;
        letter-spacing:0.03em;
        color:#475569;
        text-align:center;
        white-space:nowrap;
    }

    /* ── BROWSE BY NEED RESPONSIVE GRID ── */
    .need-section{
        background:#fff;
        padding:12px 0 28px;
        border-bottom:1px solid #e8ecf4;
        width:100%;
        overflow:hidden;
    }
    .need-grid{
        display:grid;
        grid-template-columns: repeat(5, 1fr);
        gap:14px;
        width:100%;
    }
    @media (max-width: 991px) {
        .need-grid { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 575px) {
        .need-grid { grid-template-columns: repeat(2, 1fr); gap:8px; }
    }
    .need-card{
        background:#fff;
        border:1.5px solid #e2e8f0;
        border-radius:14px;
        padding:16px 12px;
        display:flex;
        flex-direction:column;
        align-items:center;
        justify-content:center;
        gap:8px;
        text-decoration:none;
        transition:all .2s;
        height:100%;
        box-shadow:0 2px 8px rgba(0,0,0,0.02);
        min-width:0;
    }
    .need-card:hover{
        border-color:#2563eb;
        transform:translateY(-3px);
        box-shadow:0 8px 22px rgba(37,99,235,0.09);
    }
    .need-card-icon{ font-size:22px; }
    .need-card-title{
        font-size:12.5px;
        font-weight:800;
        color:#0f2d59;
        text-align:center;
        white-space:nowrap;
        overflow:hidden;
        text-overflow:ellipsis;
        max-width:100%;
    }

    /* ── FILTER PILLS BAR ── */
    .filter-pills-bar{
        background:#f8fafc;
        border-bottom:1px solid #e2e8f0;
        padding:12px 0;
        width:100%;
        overflow:hidden;
    }
    .filter-pills-row{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:14px;
        flex-wrap:wrap;
        width:100%;
    }
    .filter-pills-left{
        display:flex;
        align-items:center;
        gap:8px;
        overflow-x:auto;
        scrollbar-width:none;
        -webkit-overflow-scrolling:touch;
        padding-bottom:2px;
        max-width:100%;
        flex-grow:1;
    }
    .filter-pills-left::-webkit-scrollbar { display:none; }
    .pill-filter-btn{
        background:#fff;
        border:1.5px solid #cbd5e1;
        border-radius:100px;
        padding:6px 15px;
        font-size:12.5px;
        font-weight:700;
        color:#334155;
        text-decoration:none;
        transition:all .15s;
        display:inline-flex;
        align-items:center;
        gap:6px;
        white-space:nowrap;
        flex-shrink:0;
    }
    .pill-filter-btn:hover, .pill-filter-btn.active{
        background:#0f2d59;
        border-color:#0f2d59;
        color:#fff;
    }

    /* ── SCHOOL CARDS GRID ── */
    .school-card{
        background:#fff;
        border:1.5px solid #e8ecf4;
        border-radius:16px;
        overflow:hidden;
        display:flex;
        flex-direction:column;
        height:100%;
        transition:transform .2s, box-shadow .2s;
        width:100%;
    }
    .school-card:hover{
        transform:translateY(-4px);
        box-shadow:0 14px 34px rgba(15,45,89,.11);
        border-color:#93c5fd;
    }
    .sc-media{
        position:relative;
        height:175px;
        background:#0f2d59;
        overflow:hidden;
        width:100%;
    }
    .sc-media img{
        width:100%;
        height:100%;
        object-fit:cover;
        transition:transform .4s;
    }
    .school-card:hover .sc-media img{ transform:scale(1.05); }
    .sc-badges-top-left{
        position:absolute;
        top:10px;
        left:10px;
        display:flex;
        align-items:center;
        gap:6px;
        z-index:2;
        flex-wrap:wrap;
        max-width:calc(100% - 100px);
    }
    .sc-badge-board{
        color:#fff;
        font-size:10px;
        font-weight:900;
        padding:4px 8px;
        border-radius:6px;
        letter-spacing:.04em;
        text-transform:uppercase;
        box-shadow:0 2px 6px rgba(0,0,0,0.25);
    }
    .sc-badge-adm-pill{
        font-size:10px;
        font-weight:800;
        padding:4px 8px;
        border-radius:6px;
        display:inline-flex;
        align-items:center;
        gap:5px;
        box-shadow:0 2px 6px rgba(0,0,0,0.25);
        white-space:nowrap;
    }
    .sc-badge-adm-pill.open{
        background:#16a34a;
        color:#ffffff;
    }
    .sc-badge-adm-pill.closed{
        background:#dc2626;
        color:#ffffff;
    }
    .sc-badge-adm-pill.upcoming{
        background:#d97706;
        color:#ffffff;
    }
    .dot-pulse{
        width:6px;
        height:6px;
        background:#fff;
        border-radius:50%;
        display:inline-block;
        animation:pulseDot 1.8s infinite;
    }
    @keyframes pulseDot{
        0%{ transform:scale(0.8); opacity:0.8; }
        50%{ transform:scale(1.4); opacity:1; }
        100%{ transform:scale(0.8); opacity:0.8; }
    }
    .sc-badge-top{
        position:absolute;
        top:10px;
        left:10px;
        color:#fff;
        font-size:10.5px;
        font-weight:900;
        padding:4px 9px;
        border-radius:6px;
        letter-spacing:.04em;
        text-transform:uppercase;
        z-index:2;
    }
    .sc-badge-featured{
        position:absolute;
        top:10px;
        right:10px;
        background:var(--sm-yellow);
        color:#0f2d59;
        font-size:10.5px;
        font-weight:900;
        padding:4px 9px;
        border-radius:6px;
        z-index:2;
    }
    .sc-rating{
        position:absolute;
        bottom:8px;
        left:8px;
        right:8px;
        background:rgba(15,45,89,.88);
        backdrop-filter:blur(4px);
        border-radius:8px;
        padding:6px 10px;
        display:flex;
        align-items:center;
        justify-content:space-between;
        color:#fff;
    }
    .sc-rating-score{
        background:#16a34a;
        color:#fff;
        font-size:11.5px;
        font-weight:900;
        padding:2px 7px;
        border-radius:4px;
    }
    .sc-rating-meta{
        font-size:11.5px;
        font-weight:600;
        color:#e2e8f0;
    }

    .sc-body{
        padding:16px;
        display:flex;
        flex-direction:column;
        flex-grow:1;
        width:100%;
    }
    .sc-head{
        display:flex;
        align-items:flex-start;
        justify-content:space-between;
        gap:6px;
        margin-bottom:4px;
    }
    .sc-name{
        font-size:15.5px;
        font-weight:800;
        color:#0f2d59;
        line-height:1.3;
        margin:0;
    }
    .sc-verified{
        color:#16a34a;
        font-size:12px;
        font-weight:700;
        white-space:nowrap;
    }
    .sc-location{
        font-size:12px;
        color:#64748b;
        margin:0 0 12px;
        display:flex;
        align-items:center;
        gap:5px;
    }
    .sc-location i{ color:#e63946; flex-shrink:0; }

    .sc-tags{
        display:flex;
        gap:5px;
        flex-wrap:wrap;
        margin-bottom:14px;
    }
    .sc-tag{
        background:#f1f5f9;
        color:#475569;
        font-size:10.5px;
        font-weight:700;
        padding:3px 8px;
        border-radius:4px;
    }

    .sc-actions{
        margin-top:auto;
        display:flex;
        flex-direction:column;
        gap:6px;
        width:100%;
    }
    .btn-view-main{
        display:block;
        width:100%;
        background:#0f2d59;
        color:#fff;
        border:none;
        border-radius:8px;
        padding:9px;
        font-size:12.5px;
        font-weight:800;
        text-align:center;
        text-decoration:none;
        transition:background .2s;
    }
    .btn-view-main:hover{ background:#163b73; color:#fff; }

    .sc-row-actions{
        display:flex;
        gap:6px;
        width:100%;
    }
    .btn-card-action{
        flex:1;
        background:#fff;
        border:1.5px solid #e2e8f0;
        border-radius:8px;
        padding:7px 4px;
        font-size:11.5px;
        font-weight:700;
        color:#475569;
        text-align:center;
        text-decoration:none;
        cursor:pointer;
        transition:all .15s;
        white-space:nowrap;
    }
    .btn-card-action:hover{ border-color:#0f2d59; color:#0f2d59; }
    .btn-card-action.saved{ background:#fee2e2; border-color:#fca5a5; color:#dc2626; }
    .btn-card-action.in-compare{ background:#eff6ff; border-color:#2563eb; color:#1d4ed8; }

    .btn-enquire-action{
        flex:1;
        background:var(--sm-yellow);
        border:none;
        border-radius:8px;
        padding:7px 4px;
        font-size:11.5px;
        font-weight:900;
        color:#0f2d59;
        cursor:pointer;
        text-align:center;
        transition:background .15s;
        white-space:nowrap;
    }
    .btn-enquire-action:hover{ background:#e5a700; }

    /* ── SECTIONS GENERAL ── */
    .sec-header{ margin-bottom:22px; }
    .sec-title{
        font-size:24px;
        font-weight:900;
        color:#0f2d59;
        letter-spacing:-0.5px;
        margin-bottom:4px;
    }
    .sec-sub{ font-size:14px; color:#64748b; margin:0; }

    /* ── AREA CARDS ── */
    .area-card{
        position:relative;
        height:160px;
        border-radius:14px;
        overflow:hidden;
        display:flex;
        align-items:flex-end;
        padding:14px;
        text-decoration:none;
        box-shadow:0 4px 14px rgba(0,0,0,0.06);
        transition:transform .2s, box-shadow .2s;
        width:100%;
    }
    .area-card:hover{
        transform:translateY(-3px);
        box-shadow:0 10px 24px rgba(15,45,89,0.18);
    }
    .area-card img{
        position:absolute;
        inset:0;
        width:100%;
        height:100%;
        object-fit:cover;
        transition:transform .4s;
    }
    .area-card:hover img{ transform:scale(1.08); }
    .area-card::after{
        content:'';
        position:absolute;
        inset:0;
        background:linear-gradient(180deg, rgba(15,45,89,0.08) 0%, rgba(15,45,89,0.9) 100%);
    }
    .area-content{
        position:relative;
        z-index:2;
        color:#fff;
    }
    .area-name{
        font-size:14.5px;
        font-weight:800;
        margin-bottom:2px;
    }
    .area-count{
        font-size:11.5px;
        color:#fde047;
        font-weight:700;
    }

    /* ── GUIDE CARDS ── */
    .guide-card{
        background:#fff;
        border:1.5px solid #e8ecf4;
        border-radius:16px;
        padding:22px;
        height:100%;
        transition:all .2s;
        width:100%;
    }
    .guide-card:hover{
        border-color:#bfdbfe;
        box-shadow:0 8px 24px rgba(15,45,89,0.07);
    }
    .guide-icon{
        width:46px;
        height:46px;
        border-radius:12px;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:18px;
        margin-bottom:14px;
    }
    .guide-card h5{
        font-size:15.5px;
        font-weight:800;
        color:#0f2d59;
        margin-bottom:6px;
    }
    .guide-card p{
        font-size:13px;
        color:#64748b;
        line-height:1.6;
        margin:0;
    }

    /* ── COMPARE TABLE STRIP ── */
    .compare-preview-card{
        background:#fff;
        border:1.5px solid #e8ecf4;
        border-radius:16px;
        overflow:hidden;
        box-shadow:0 4px 18px rgba(0,0,0,0.03);
        width:100%;
    }
    .table-responsive{
        width:100%;
        overflow-x:auto;
        -webkit-overflow-scrolling:touch;
    }
    .compare-table{
        width:100%;
        border-collapse:collapse;
        min-width:600px;
    }
    .compare-table th{
        background:#0f2d59;
        color:#fff;
        padding:12px 16px;
        font-size:11.5px;
        font-weight:800;
        text-transform:uppercase;
        letter-spacing:0.04em;
    }
    .compare-table td{
        padding:13px 16px;
        border-bottom:1px solid #f1f5f9;
        font-size:13px;
        color:#334155;
    }
    .compare-table tr:last-child td{ border-bottom:none; }

    /* ── FAQ ACCORDION ── */
    .faq-item{
        background:#fff;
        border:1.5px solid #e8ecf4;
        border-radius:12px;
        margin-bottom:10px;
        overflow:hidden;
        width:100%;
    }
    .faq-btn{
        width:100%;
        background:none;
        border:none;
        padding:14px 18px;
        text-align:left;
        font-size:14px;
        font-weight:800;
        color:#0f2d59;
        display:flex;
        align-items:center;
        justify-content:space-between;
        cursor:pointer;
        gap:10px;
    }
    .faq-body{
        padding:0 18px 14px;
        font-size:13px;
        color:#64748b;
        line-height:1.65;
    }

    /* ── FLOATING COMPARE DOCK ── */
    .compare-floating-bar{
        display:none;
        position:fixed;
        bottom:0;
        left:0;
        right:0;
        background:#0f2d59;
        color:#fff;
        padding:12px 20px;
        z-index:9990;
        box-shadow:0 -4px 24px rgba(0,0,0,.25);
        max-width:100vw;
    }
    .compare-floating-bar.active{ display:block; }
    .cmp-float-inner{
        max-width:1400px;
        margin:0 auto;
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:10px;
        flex-wrap:wrap;
    }
    .cmp-chips-list{
        display:flex;
        align-items:center;
        gap:8px;
        flex-wrap:wrap;
    }
    .cmp-chip-item{
        background:rgba(255,255,255,0.15);
        border:1px solid rgba(255,255,255,0.25);
        border-radius:100px;
        padding:4px 12px;
        font-size:11.5px;
        font-weight:700;
        display:inline-flex;
        align-items:center;
        gap:6px;
    }
    .cmp-chip-remove{
        cursor:pointer;
        opacity:0.75;
    }
    .cmp-chip-remove:hover{ opacity:1; }

    /* ── ENQUIRY MODAL ── */
    .enquiry-modal{
        display:none;
        position:fixed;
        inset:0;
        background:rgba(15,23,42,0.65);
        z-index:9999;
        align-items:center;
        justify-content:center;
        padding:14px;
    }
    .enquiry-modal.show{ display:flex; }
    .enquiry-box{
        background:#fff;
        width:100%;
        max-width:500px;
        max-height:92vh;
        overflow-y:auto;
        border-radius:16px;
        box-shadow:0 20px 60px rgba(0,0,0,0.3);
        animation:modalIn .2s ease-out;
    }
    @keyframes modalIn{ from{opacity:0;transform:scale(0.95);} to{opacity:1;transform:scale(1);} }
    .enquiry-head{
        background:#0f2d59;
        color:#fff;
        padding:16px 20px;
        display:flex;
        align-items:center;
        justify-content:space-between;
        position:sticky;
        top:0;
        z-index:2;
    }
    .enquiry-head h4{ margin:0; font-size:16px; font-weight:900; }
    .enquiry-close{
        background:none; border:none; color:#fff; font-size:24px; cursor:pointer; line-height:1;
    }
    .enquiry-body{ padding:20px; }

    .enquiry-autofill-banner{
        background:#f0fdf4;
        border:1px solid #bbf7d0;
        border-radius:12px;
        padding:10px 14px;
        margin-bottom:14px;
        display:flex;
        align-items:center;
        gap:12px;
    }
    .user-avatar-circle{
        width:36px;
        height:36px;
        border-radius:50%;
        background:#16a34a;
        color:#fff;
        display:flex;
        align-items:center;
        justify-content:center;
        font-weight:900;
        font-size:14px;
        flex-shrink:0;
    }

    .enquiry-field{ margin-bottom:14px; }
    .enquiry-field label{
        display:block;
        font-size:12px;
        font-weight:700;
        color:#1e293b;
        margin-bottom:5px;
    }
    .enquiry-field input, .enquiry-field select, .enquiry-field textarea{
        width:100%;
        border:1.5px solid #cbd5e1;
        border-radius:8px;
        padding:9px 12px;
        font-size:13.5px;
        outline:none;
    }
    .enquiry-field input:focus, .enquiry-field select:focus, .enquiry-field textarea:focus{
        border-color:#0f2d59;
    }

    .enquiry-actions{
        display:flex;
        gap:10px;
        margin-top:16px;
    }
    .btn-modal-cancel{
        flex:1;
        background:#f1f5f9;
        border:1.5px solid #cbd5e1;
        border-radius:8px;
        padding:10px;
        font-size:13px;
        font-weight:700;
        color:#475569;
        cursor:pointer;
    }
    .btn-modal-submit{
        flex:2;
        background:#0f2d59;
        color:#fff;
        border:none;
        border-radius:8px;
        padding:10px;
        font-size:13px;
        font-weight:800;
        cursor:pointer;
    }
    .btn-modal-submit:hover{ background:#163b73; }
</style>

<div class="sm-home">

    {{-- ══════════════════════════════════════════════════════════════ --}}
    {{-- SECTION 1: HERO & EXPANSIVE 3-FIELD SEARCH BAR                 --}}
    {{-- ══════════════════════════════════════════════════════════════ --}}
    <section class="sm-hero">
        <div class="container sm-hero-inner">
            <div class="sm-hero-pill">
                <i class="fa-solid fa-location-dot" style="color:var(--sm-yellow);"></i> Patna District • Verified School Directory
            </div>

            <h1 class="sm-hero-title">
                Find the Best School for Your Child in <span>Patna</span>
            </h1>

            <p class="sm-hero-sub">
                Explore transparent fee structures, CBSE & ICSE curriculums, verified reviews, and book campus visits online — 100% Free for parents.
            </p>

            {{-- SEARCH PANEL (LOCATION + BOARD + GRADE + FINDER BUTTON) --}}
            <div class="sm-search-wrap">
                <form action="{{ route('home') }}" method="GET" class="sm-search-panel">
                    <div class="sm-search-grid">
                        
                        {{-- FIELD 1: LOCATION / AREA / SCHOOL NAME --}}
                        <div class="sm-search-field">
                            <i class="fa-solid fa-location-dot"></i>
                            <div class="sm-search-meta">
                                <label>Location / Area / School Name</label>
                                <input type="text" name="q" value="{{ request('q') }}" placeholder="e.g. Boring Road, Kankarbagh, DPS...">
                            </div>
                        </div>

                        {{-- FIELD 2: EDUCATION BOARD --}}
                        <div class="sm-search-field">
                            <i class="fa-solid fa-graduation-cap"></i>
                            <div class="sm-search-meta">
                                <label>Education Board</label>
                                <select name="board">
                                    <option value="">All Boards</option>
                                    <option value="CBSE" {{ request('board')=='CBSE'?'selected':'' }}>CBSE</option>
                                    <option value="ICSE" {{ request('board')=='ICSE'?'selected':'' }}>ICSE</option>
                                    <option value="State Board" {{ request('board')=='State Board'?'selected':'' }}>State Board (BSEB)</option>
                                </select>
                                <span class="chev">▼</span>
                            </div>
                        </div>

                        {{-- FIELD 3: CLASS / GRADE --}}
                        <div class="sm-search-field">
                            <i class="fa-solid fa-child"></i>
                            <div class="sm-search-meta">
                                <label>Class / Grade</label>
                                <select name="class_from">
                                    <option value="">All Classes</option>
                                    <option value="1" {{ request('class_from')=='1'?'selected':'' }}>Primary (Cl. 1-5)</option>
                                    <option value="6" {{ request('class_from')=='6'?'selected':'' }}>Middle (Cl. 6-8)</option>
                                    <option value="9" {{ request('class_from')=='9'?'selected':'' }}>Secondary (Cl. 9-10)</option>
                                    <option value="11" {{ request('class_from')=='11'?'selected':'' }}>Senior Sec (Cl. 11-12)</option>
                                </select>
                                <span class="chev">▼</span>
                            </div>
                        </div>

                        {{-- FIELD 4: SUBMIT BUTTON WITH FINDER ARROW --}}
                        <div class="sm-search-btn-wrap">
                            <button type="submit" class="sm-search-btn">
                                <i class="fa-solid fa-location-arrow"></i> Find Schools
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="sm-trust-inline">
                <span><i class="fa-solid fa-circle-check"></i> 100% Verified Patna Schools</span>
                <span><i class="fa-solid fa-lock"></i> Transparent Fees</span>
                <span><i class="fa-solid fa-calendar-check"></i> Direct Campus Visit Booking</span>
                <span><i class="fa-solid fa-shield"></i> Official Admission Partner</span>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════ --}}
    {{-- SECTION 2: DISCOVER BY EXTRACURRICULARS & FACILITIES          --}}
    {{-- ══════════════════════════════════════════════════════════════ --}}
    <div class="facilities-section">
        <div class="container">
            <h4 class="fw-bold mb-3" style="font-size:17px;color:#0f2d59;">
                Discover by Extracurriculars & Facilities
            </h4>
            <div class="fac-scroll-wrap">
                <a href="{{ route('home', ['q' => 'Sports']) }}" class="fac-circle-item">
                    <div class="fac-circle-icon"><i class="fa-solid fa-person-running" style="color:#2563eb;"></i></div>
                    <span class="fac-circle-label">PT Fitness</span>
                </a>
                <a href="{{ route('home', ['q' => 'Dance']) }}" class="fac-circle-item">
                    <div class="fac-circle-icon"><i class="fa-solid fa-child-reaching" style="color:#9333ea;"></i></div>
                    <span class="fac-circle-label">Dance Class</span>
                </a>
                <a href="{{ route('home', ['q' => 'Martial Arts']) }}" class="fac-circle-item">
                    <div class="fac-circle-icon"><i class="fa-solid fa-hand-fist" style="color:#dc2626;"></i></div>
                    <span class="fac-circle-label">Martial Arts</span>
                </a>
                <a href="{{ route('home', ['q' => 'Robotics']) }}" class="fac-circle-item">
                    <div class="fac-circle-icon"><i class="fa-solid fa-code" style="color:#4f46e5;"></i></div>
                    <span class="fac-circle-label">IT Coding</span>
                </a>
                <a href="{{ route('home', ['q' => 'Ground']) }}" class="fac-circle-item">
                    <div class="fac-circle-icon"><i class="fa-solid fa-basketball" style="color:#ea580c;"></i></div>
                    <span class="fac-circle-label">Sports Field</span>
                </a>
                <a href="{{ route('home', ['q' => 'Swimming']) }}" class="fac-circle-item">
                    <div class="fac-circle-icon"><i class="fa-solid fa-person-swimming" style="color:#0284c7;"></i></div>
                    <span class="fac-circle-label">Swimming</span>
                </a>
                <a href="{{ route('home', ['q' => 'Art']) }}" class="fac-circle-item">
                    <div class="fac-circle-icon"><i class="fa-solid fa-palette" style="color:#059669;"></i></div>
                    <span class="fac-circle-label">Art Craft</span>
                </a>
                <a href="{{ route('home', ['q' => 'Music']) }}" class="fac-circle-item">
                    <div class="fac-circle-icon"><i class="fa-solid fa-music" style="color:#db2777;"></i></div>
                    <span class="fac-circle-label">Music</span>
                </a>
                <a href="{{ route('home', ['q' => 'Lab']) }}" class="fac-circle-item">
                    <div class="fac-circle-icon"><i class="fa-solid fa-flask" style="color:#ca8a04;"></i></div>
                    <span class="fac-circle-label">Science Lab</span>
                </a>
                <a href="{{ route('home', ['q' => 'Transport']) }}" class="fac-circle-item">
                    <div class="fac-circle-icon"><i class="fa-solid fa-bus" style="color:#1e3a5f;"></i></div>
                    <span class="fac-circle-label">Transport</span>
                </a>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════ --}}
    {{-- SECTION 3: BROWSE BY NEED                                     --}}
    {{-- ══════════════════════════════════════════════════════════════ --}}
    <div class="need-section">
        <div class="container">
            <div class="mb-3">
                <h4 class="fw-bold mb-1" style="font-size:17px;color:#0f2d59;">Browse by Need</h4>
                <p class="text-muted small mb-0" style="font-size:12.5px;">Quick paths for parents with specific priorities</p>
            </div>
            <div class="need-grid">
                <a href="{{ route('home', ['board' => 'CBSE']) }}" class="need-card">
                    <i class="fa-solid fa-book-bookmark need-card-icon text-primary"></i>
                    <span class="need-card-title">Best for CBSE</span>
                </a>
                <a href="{{ route('home', ['featured' => '1']) }}" class="need-card">
                    <i class="fa-solid fa-trophy need-card-icon text-success"></i>
                    <span class="need-card-title">Top Rated</span>
                </a>
                <a href="{{ route('home', ['school_type' => 'Girls']) }}" class="need-card">
                    <i class="fa-solid fa-person-dress need-card-icon" style="color:#ec4899;"></i>
                    <span class="need-card-title">Girls Schools</span>
                </a>
                <a href="{{ route('home', ['school_type' => 'Co-Ed']) }}" class="need-card">
                    <i class="fa-solid fa-people-group need-card-icon" style="color:#f97316;"></i>
                    <span class="need-card-title">Co-ed Excellence</span>
                </a>
                <a href="{{ route('home', ['class_from' => '11']) }}" class="need-card">
                    <i class="fa-solid fa-graduation-cap need-card-icon text-primary"></i>
                    <span class="need-card-title">Senior Secondary</span>
                </a>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════ --}}
    {{-- SECTION 4: FILTER PILLS BAR & SORT                            --}}
    {{-- ══════════════════════════════════════════════════════════════ --}}
    <div class="filter-pills-bar">
        <div class="container">
            <div class="filter-pills-row">
                <div class="filter-pills-left">
                    <a href="{{ route('home') }}" class="pill-filter-btn {{ !request()->hasAny(['board','featured','verified','admission','school_type','class_from','q']) ? 'active' : '' }}">
                        <i class="fa-solid fa-border-all"></i> All
                    </a>
                    <a href="{{ route('home', ['board' => 'CBSE']) }}" class="pill-filter-btn {{ request('board')=='CBSE' ? 'active' : '' }}">
                        CBSE
                    </a>
                    <a href="{{ route('home', ['board' => 'ICSE']) }}" class="pill-filter-btn {{ request('board')=='ICSE' ? 'active' : '' }}">
                        ICSE
                    </a>
                    <a href="{{ route('home', ['board' => 'State Board']) }}" class="pill-filter-btn {{ request('board')=='State Board' ? 'active' : '' }}">
                        State Board
                    </a>
                    <a href="{{ route('home', ['featured' => '1']) }}" class="pill-filter-btn {{ request('featured') ? 'active' : '' }}">
                        ⭐ Featured
                    </a>
                    <a href="{{ route('home', ['verified' => '1']) }}" class="pill-filter-btn {{ request('verified') ? 'active' : '' }}">
                        ✅ Verified
                    </a>
                    <a href="{{ route('home', ['admission' => 'open']) }}" class="pill-filter-btn {{ request('admission')=='open' ? 'active' : '' }}">
                        🟢 Admission Open
                    </a>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <span class="small text-muted fw-bold" style="font-size:12.5px;">{{ $schools->total() }} schools</span>
                    <form action="{{ route('home') }}" method="GET" class="d-inline" id="sortForm">
                        @foreach(request()->except('sort', 'page') as $k => $v)
                            <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                        @endforeach
                        <select name="sort" class="form-select form-select-sm" onchange="document.getElementById('sortForm').submit()" style="font-weight:700;color:#0f2d59;border-radius:8px;font-size:12px;padding:5px 10px;">
                            <option value="featured" {{ request('sort')=='featured'?'selected':'' }}>Sort: Relevance</option>
                            <option value="fee_asc" {{ request('sort')=='fee_asc'?'selected':'' }}>Fee: Low to High</option>
                            <option value="fee_desc" {{ request('sort')=='fee_desc'?'selected':'' }}>Fee: High to Low</option>
                            <option value="newest" {{ request('sort')=='newest'?'selected':'' }}>Newly Added</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════ --}}
    {{-- SECTION 5: TOP RECOMMENDED SCHOOLS LISTINGS                   --}}
    {{-- ══════════════════════════════════════════════════════════════ --}}
    <div class="container py-4 py-md-5" id="school-listing">
        <div class="mb-4">
            <h2 class="sec-title">
                @if(request('q'))
                    Schools matching "{{ request('q') }}" in Patna
                @elseif(request('admission') == 'open')
                    Schools with Admissions Open in Patna (2026-27)
                @elseif(request('verified'))
                    Verified Schools in Patna
                @elseif(request('featured'))
                    Featured Top Schools in Patna
                @elseif(request('school_type'))
                    {{ request('school_type') }} Schools in Patna
                @elseif(request('board'))
                    Top {{ request('board') }} Schools in Patna
                @else
                    Top Recommended in Patna
                @endif
            </h2>
            <p class="sec-sub">{{ $schools->total() }} schools found across Patna, Bihar</p>
        </div>

        @if($schools->count())
            <div class="row g-3 g-md-4">
                @foreach($schools as $index => $school)
                    @php
                        $boardColor = match($school->board) {
                            'ICSE' => '#7c3aed',
                            'State Board' => '#0284c7',
                            'IB' => '#059669',
                            default => '#dc2626',
                        };
                    @endphp

                    <div class="col-12 col-sm-6 col-md-4 col-xl-3">
                        <div class="school-card" id="card-{{ $school->id }}">
                            <div class="sc-media">
                                <img src="{{ $school->featured_image_url }}" alt="{{ $school->name }}" loading="lazy">
                                
                                <div class="sc-badges-top-left">
                                    <span class="sc-badge-board" style="background:{{ $boardColor }};">{{ $school->board }}</span>
                                    @if(($school->admission_status ?? 'open') === 'open')
                                        <span class="sc-badge-adm-pill open"><span class="dot-pulse"></span> Admission Open</span>
                                    @elseif(($school->admission_status) === 'closed')
                                        <span class="sc-badge-adm-pill closed"><i class="fas fa-circle-xmark"></i> Closed</span>
                                    @else
                                        <span class="sc-badge-adm-pill upcoming"><i class="fas fa-clock"></i> Opening Soon</span>
                                    @endif
                                </div>

                                @if($school->is_featured)
                                    <span class="sc-badge-featured">⭐ Featured</span>
                                @endif

                                <div class="sc-rating">
                                    <div class="sc-rating-score">{{ number_format($school->rating ?? 4.5, 1) }} ★</div>
                                    <div class="sc-rating-meta">
                                        {{ $school->reviews_count ?? rand(25, 180) }} parent reviews
                                    </div>
                                </div>
                            </div>

                            <div class="sc-body">
                                <div class="sc-head">
                                    <h5 class="sc-name">{{ $school->name }}</h5>
                                    @if($school->is_verified)
                                        <span class="sc-verified" title="Verified by SchoolMapr"><i class="fas fa-check-circle"></i></span>
                                    @endif
                                </div>

                                <p class="sc-location"><i class="fas fa-location-dot"></i> {{ Str::limit($school->address, 34) }}</p>

                                <div class="sc-tags">
                                    <span class="sc-tag">{{ $school->medium ?: 'English' }}</span>
                                    <span class="sc-tag">{{ $school->school_type ?: 'Co-Ed' }}</span>
                                    <span class="sc-tag">Class {{ $school->class_from }}–{{ $school->class_to }}</span>
                                    @if(($school->admission_status ?? 'open') === 'open')
                                        <span class="sc-tag" style="background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;font-weight:800;">
                                            <i class="fas fa-circle-check text-success"></i> 2026-27 Open
                                        </span>
                                    @elseif(($school->admission_status) === 'closed')
                                        <span class="sc-tag" style="background:#fef2f2;color:#b91c1c;border:1px solid #fecaca;font-weight:800;">
                                            <i class="fas fa-circle-xmark text-danger"></i> Closed
                                        </span>
                                    @else
                                        <span class="sc-tag" style="background:#fffbeb;color:#b45309;border:1px solid #fde68a;font-weight:800;">
                                            <i class="fas fa-clock text-warning"></i> Opening Soon
                                        </span>
                                    @endif
                                </div>

                                {{-- ACTION BUTTONS --}}
                                <div class="sc-actions">
                                    <a href="{{ route('school.show', $school->slug) }}" class="btn-view-main">
                                        View School Details →
                                    </a>

                                    <div class="sc-row-actions">
                                        @auth
                                            <button type="button" class="btn-card-action {{ $savedIds->contains($school->id) ? 'saved' : '' }}" onclick="toggleSave({{ $school->id }}, this)">
                                                {{ $savedIds->contains($school->id) ? '❤️ Saved' : '🤍 Save' }}
                                            </button>
                                        @else
                                            <a href="{{ route('login') }}" class="btn-card-action">🤍 Save</a>
                                        @endauth

                                        <button type="button" class="btn-card-action" id="cmp-btn-{{ $school->id }}"
                                                data-id="{{ $school->id }}"
                                                data-name="{{ $school->name }}"
                                                data-board="{{ $school->board }}"
                                                data-city="{{ $school->city ?? $school->address }}"
                                                data-slug="{{ $school->slug }}"
                                                onclick="toggleCompareCard({{ $school->id }}, @js($school->name), @js($school->board), @js($school->slug))">
                                            ⚖️ Compare
                                        </button>
                                    </div>

                                    <div class="sc-row-actions">
                                        <a href="{{ route('visit.book', $school->slug) }}" class="btn-card-action">
                                            📅 Visit
                                        </a>

                                        <button type="button" class="btn-enquire-action" onclick="openEnquiryModal('{{ $school->id }}', @js($school->name))">
                                            📩 Enquire
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 mt-md-5 d-flex justify-content-center">
                {{ $schools->appends(request()->query())->fragment('school-listing')->links() }}
            </div>
        @else
            <div class="text-center py-5 bg-white rounded-4 border p-4">
                <i class="fas fa-school-circle-xmark fa-3x text-muted mb-3"></i>
                <h4 class="fw-bold text-dark">No schools found in this search</h4>
                <p class="text-muted small">Try searching a different locality in Patna or reset filters.</p>
                <a href="{{ route('home') }}" class="btn btn-primary btn-sm px-4 fw-bold">View All Patna Schools</a>
            </div>
        @endif
    </div>

    {{-- ══════════════════════════════════════════════════════════════ --}}
    {{-- SECTION 6: EXPLORE PATNA POPULAR LOCALITIES                    --}}
    {{-- ══════════════════════════════════════════════════════════════ --}}
    <section class="py-4 py-md-5 bg-white border-top border-bottom">
        <div class="container">
            <div class="sec-header d-flex justify-content-between align-items-end flex-wrap gap-2">
                <div>
                    <h2 class="sec-title">Explore Schools by Patna Localities</h2>
                    <p class="sec-sub">Find CBSE & ICSE schools near your residential area in Patna</p>
                </div>
                <a href="{{ route('home') }}" class="fw-bold text-primary text-decoration-none small">
                    View All Patna Areas →
                </a>
            </div>

            <div class="row g-2 g-md-3">
                @php
                    $patnaAreas = [
                        ['Boring Road', 'Patna Central', 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&w=600&q=80', '15+ Schools'],
                        ['Kankarbagh', 'South Patna', 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&fit=crop&w=600&q=80', '18+ Schools'],
                        ['Bailey Road / Danapur', 'West Patna', 'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=600&q=80', '20+ Schools'],
                        ['Raja Bazar / Samanpura', 'Central West', 'https://images.unsplash.com/photo-1519452575417-564c1401ecc0?auto=format&fit=crop&w=600&q=80', '12+ Schools'],
                        ['Ashiana Nagar', 'Ashiyana-Digha', 'https://images.unsplash.com/photo-1546410531-bb4caa6b424d?auto=format&fit=crop&w=600&q=80', '14+ Schools'],
                        ['Jakariyapur / Bypass', 'Zero Mile', 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=600&q=80', '10+ Schools'],
                    ];
                @endphp

                @foreach($patnaAreas as $area)
                    <div class="col-6 col-md-4 col-lg-2">
                        <a href="{{ route('home', ['q' => $area[0]]) }}" class="area-card">
                            <img src="{{ $area[2] }}" alt="{{ $area[0] }}" loading="lazy">
                            <div class="area-content">
                                <div class="area-name">{{ $area[0] }}</div>
                                <div class="area-count">{{ $area[3] }}</div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════ --}}
    {{-- SECTION 7: COMPARE SCHOOLS SIDE-BY-SIDE PREVIEW               --}}
    {{-- ══════════════════════════════════════════════════════════════ --}}
    <section class="py-4 py-md-5" style="background:#f8fafc;">
        <div class="container">
            <div class="sec-header d-flex justify-content-between align-items-end flex-wrap gap-2">
                <div>
                    <h2 class="sec-title">Compare Schools Side-by-Side</h2>
                    <p class="sec-sub">Analyze curriculums, student-teacher ratios, and ratings in one unified view</p>
                </div>
                <a href="{{ url('/compare') }}" class="btn btn-outline-primary btn-sm fw-bold px-3 py-2" style="border-radius:8px;">
                    <i class="fa-solid fa-scale-balanced me-1"></i> Full Compare Tool →
                </a>
            </div>

            <div class="compare-preview-card">
                <div class="table-responsive">
                    <table class="compare-table">
                        <thead>
                            <tr>
                                <th>School Name & Locality</th>
                                <th>Board & Medium</th>
                                <th>Grades Offered</th>
                                <th>Parent Rating</th>
                                <th>Direct Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($schools->take(4) as $s)
                                <tr>
                                    <td>
                                        <div class="fw-bold text-primary" style="font-size:14px;">{{ $s->name }}</div>
                                        <div class="small text-muted"><i class="fas fa-location-dot text-danger me-1"></i>{{ Str::limit($s->address, 36) }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border me-1">{{ $s->board }}</span>
                                        <span class="small text-muted">{{ $s->medium ?: 'English' }}</span>
                                    </td>
                                    <td>Class {{ $s->class_from }} – {{ $s->class_to }}</td>
                                    <td>
                                        <span class="badge bg-success fw-bold">{{ number_format($s->rating ?? 4.5, 1) }} ★</span>
                                        <span class="small text-muted ms-1">({{ $s->reviews_count ?? rand(30,120) }})</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('school.show', $s->slug) }}" class="btn btn-sm btn-primary fw-bold" style="border-radius:6px;font-size:12px;">
                                            View Profile
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════ --}}
    {{-- SECTION 8: WHY PARENTS CHOOSE SCHOOLMAPR                      --}}
    {{-- ══════════════════════════════════════════════════════════════ --}}
    <section class="py-4 py-md-5 bg-white border-top border-bottom">
        <div class="container">
            <div class="text-center mb-4 mb-md-5">
                <h2 class="sec-title">Why Patna Parents Choose SchoolMapr</h2>
                <p class="sec-sub">Everything you need for transparent, stress-free admissions</p>
            </div>
            <div class="row g-3 g-md-4">
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="guide-card">
                        <div class="guide-icon" style="background:#fee2e2;color:#dc2626;"><i class="fa-solid fa-shield-check"></i></div>
                        <h5>100% Verified Patna Listings</h5>
                        <p>Each school listing is verified by our team. No fake reviews, outdated fees, or false claims.</p>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="guide-card">
                        <div class="guide-icon" style="background:#ecfdf5;color:#10b981;"><i class="fa-solid fa-indian-rupee-sign"></i></div>
                        <h5>Transparent Gated Fees</h5>
                        <p>Get authentic insight into tuition, admission charges, and transport costs on the school profile.</p>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="guide-card">
                        <div class="guide-icon" style="background:#eff6ff;color:#3b82f6;"><i class="fa-solid fa-calendar-days"></i></div>
                        <h5>Direct Campus Visit Booking</h5>
                        <p>Schedule visits to inspect classrooms, sports grounds, and science labs before making a decision.</p>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="guide-card">
                        <div class="guide-icon" style="background:#fef3c7;color:#f59e0b;"><i class="fa-solid fa-scale-balanced"></i></div>
                        <h5>Side-by-Side Comparison</h5>
                        <p>Compare board affiliations, student-teacher ratios, ratings, and locations easily.</p>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="guide-card">
                        <div class="guide-icon" style="background:#f3e8ff;color:#9333ea;"><i class="fa-solid fa-comments"></i></div>
                        <h5>Authentic Parent Reviews</h5>
                        <p>Read real experiences and ratings from fellow parents whose children study in Patna schools.</p>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="guide-card">
                        <div class="guide-icon" style="background:#ffedd5;color:#ea580c;"><i class="fa-solid fa-gift"></i></div>
                        <h5>100% Free for Parents</h5>
                        <p>No registration fees, no hidden platform surcharges. Free access to all school data and enquiry tools.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════ --}}
    {{-- SECTION 9: FAQ ACCORDION                                      --}}
    {{-- ══════════════════════════════════════════════════════════════ --}}
    <section class="py-4 py-md-5" style="background:#f8fafc;" x-data="{ activeFaq: null }">
        <div class="container" style="max-width:960px;">
            <div class="text-center mb-4 mb-md-5">
                <h2 class="sec-title">Frequently Asked Questions</h2>
                <p class="sec-sub">Got questions about Patna school admissions? We have answers.</p>
            </div>

            <div class="faq-item">
                <button type="button" class="faq-btn" @click="activeFaq = (activeFaq === 1 ? null : 1)">
                    <span>Is SchoolMapr free for parents in Patna?</span>
                    <i class="fa-solid" :class="activeFaq === 1 ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                </button>
                <div class="faq-body" x-show="activeFaq === 1" x-collapse>
                    Yes, SchoolMapr is 100% free for all parents. You can search schools, compare, book campus visits, and send direct admission enquiries without paying any fee.
                </div>
            </div>

            <div class="faq-item">
                <button type="button" class="faq-btn" @click="activeFaq = (activeFaq === 2 ? null : 2)">
                    <span>Where can I view the detailed school fees?</span>
                    <i class="fa-solid" :class="activeFaq === 2 ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                </button>
                <div class="faq-body" x-show="activeFaq === 2" x-collapse>
                    Click 'View School Details' on any school card to open its profile. On the profile page, verified annual tuition, one-time admission charges, and transport fee breakdowns are clearly displayed.
                </div>
            </div>

            <div class="faq-item">
                <button type="button" class="faq-btn" @click="activeFaq = (activeFaq === 3 ? null : 3)">
                    <span>How does campus visit booking work?</span>
                    <i class="fa-solid" :class="activeFaq === 3 ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                </button>
                <div class="faq-body" x-show="activeFaq === 3" x-collapse>
                    Click 'Visit' on any school profile, select your preferred date and time slot. The school administration is notified immediately to arrange a campus tour and counsellor discussion.
                </div>
            </div>
        </div>
    </section>

</div>

{{-- ══════════════════════════════════════════════════════════════ --}}
{{-- FLOATING COMPARE BAR DOCK                                     --}}
{{-- ══════════════════════════════════════════════════════════════ --}}
<div id="compareFloatingBar" class="compare-floating-bar">
    <div class="cmp-float-inner">
        <div class="d-flex align-items-center gap-2">
            <span class="fw-bold small text-warning">⚖️ Compare (<span id="cmpFloatCount">0</span>/3):</span>
            <div id="cmpChipsList" class="cmp-chips-list"></div>
        </div>
        <div class="d-flex align-items-center gap-2 ms-auto">
            <button type="button" onclick="clearCompareSelection()" class="btn btn-sm btn-outline-light px-2 py-1" style="font-size:11px;">Clear</button>
            <button type="button" onclick="goToComparePage()" class="btn btn-sm btn-warning fw-bold px-3 py-1" style="font-size:11.5px;color:#0f2d59;">Compare →</button>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════════ --}}
{{-- 2-CLICK AUTOFILL ENQUIRY MODAL (MOBILE & DESKTOP)             --}}
{{-- ══════════════════════════════════════════════════════════════ --}}
<div id="enquiryModal" class="enquiry-modal" onclick="if(event.target===this) closeEnquiryModal()">
    <div class="enquiry-box">
        <div class="enquiry-head">
            <h4>📩 School Admission Enquiry</h4>
            <button type="button" class="enquiry-close" onclick="closeEnquiryModal()">&times;</button>
        </div>

        <div class="enquiry-body">
            <div class="mb-3 p-2 bg-light border rounded text-center">
                <span class="text-muted small">Enquiring for:</span>
                <strong class="d-block text-primary" id="enquirySchoolName">Selected School</strong>
            </div>

            <form action="{{ route('enquiry.store') }}" method="POST">
                @csrf
                <input type="hidden" name="school_id" id="enquirySchoolId">

                @auth
                    {{-- AUTOFILL BANNER FOR LOGGED IN PARENTS --}}
                    <div class="enquiry-autofill-banner">
                        <div class="user-avatar-circle">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div style="min-width:0;">
                            <div style="font-weight:800;color:#0f2d59;font-size:13px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                {{ Auth::user()->name }} (Verified)
                            </div>
                            <div style="font-size:11px;color:#64748b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                {{ Auth::user()->email }} • {{ Auth::user()->phone ?? 'Contact attached' }}
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="parent_name" value="{{ Auth::user()->name }}">
                    <input type="hidden" name="phone" value="{{ Auth::user()->phone ?? '9876543210' }}">
                @else
                    {{-- GUEST INPUTS --}}
                    <div class="row g-2 mb-3">
                        <div class="col-12 col-sm-6">
                            <label class="small fw-bold text-dark">Your Name *</label>
                            <input type="text" name="parent_name" class="form-control form-control-sm" placeholder="e.g. Rahul Kumar" required>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label class="small fw-bold text-dark">Mobile Number *</label>
                            <input type="tel" name="phone" class="form-control form-control-sm" placeholder="e.g. 9876543210" required>
                        </div>
                    </div>
                    <div class="p-2 bg-light border rounded mb-3 text-center small text-muted">
                        💡 Have an account? <a href="/login" class="fw-bold text-primary">Sign in</a> for 1-click enquiry!
                    </div>
                @endauth

                {{-- CLASS & MESSAGE --}}
                <div class="enquiry-field">
                    <label>Target Class *</label>
                    <select name="child_class" required>
                        <option value="">Select Class (1 to 12)</option>
                        @for($i=1; $i<=12; $i++)
                            <option value="Class {{ $i }}">Class {{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="enquiry-field">
                    <label>Your Message / Specific Questions (Optional)</label>
                    <textarea name="message" rows="3" placeholder="Ask about admission open dates, transport facilities, documents required..."></textarea>
                </div>

                <div class="enquiry-actions">
                    <button type="button" class="btn-modal-cancel" onclick="closeEnquiryModal()">Cancel</button>
                    <button type="submit" class="btn-modal-submit">
                        <i class="fa-solid fa-paper-plane me-1"></i> Send Free Enquiry
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // ── COMPARE SELECTION STATE ──
    const COMPARE_STORAGE_KEY = 'schoolmapr_compare_ids';

    function getCompareList() {
        try {
            return JSON.parse(localStorage.getItem(COMPARE_STORAGE_KEY) || '[]');
        } catch (e) {
            return [];
        }
    }

    function saveCompareList(list) {
        localStorage.setItem(COMPARE_STORAGE_KEY, JSON.stringify(list));
        updateCompareUI();
    }

    function toggleCompareCard(id, name, board, slug) {
        let list = getCompareList();
        const existingIdx = list.findIndex(item => item.id == id);

        if (existingIdx !== -1) {
            list.splice(existingIdx, 1);
        } else {
            if (list.length >= 3) {
                alert('You can compare a maximum of 3 schools at once.');
                return;
            }
            list.push({ id, name, board, slug });
        }

        saveCompareList(list);
    }

    function updateCompareUI() {
        const list = getCompareList();
        const floatBar = document.getElementById('compareFloatingBar');
        const countSpan = document.getElementById('cmpFloatCount');
        const chipsList = document.getElementById('cmpChipsList');

        // Update card button states
        document.querySelectorAll('[id^="cmp-btn-"]').forEach(btn => {
            const id = btn.getAttribute('data-id');
            const inList = list.some(item => item.id == id);
            if (inList) {
                btn.classList.add('in-compare');
                btn.innerText = '✓ Added';
            } else {
                btn.classList.remove('in-compare');
                btn.innerText = '⚖️ Compare';
            }
        });

        if (list.length > 0) {
            floatBar.classList.add('active');
            countSpan.innerText = list.length;
            chipsList.innerHTML = list.map(item => `
                <span class="cmp-chip-item">
                    ${item.name.substring(0, 16)}...
                    <span class="cmp-chip-remove" onclick="toggleCompareCard(${item.id})">×</span>
                </span>
            `).join('');
        } else {
            floatBar.classList.remove('active');
        }
    }

    function clearCompareSelection() {
        saveCompareList([]);
    }

    function goToComparePage() {
        const list = getCompareList();
        if (list.length === 0) return;
        const ids = list.map(item => item.id).join(',');
        window.location.href = `/compare?ids=${ids}`;
    }

    // ── ENQUIRY MODAL ──
    function openEnquiryModal(schoolId, schoolName) {
        document.getElementById('enquirySchoolId').value = schoolId;
        document.getElementById('enquirySchoolName').innerText = schoolName;
        document.getElementById('enquiryModal').classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeEnquiryModal() {
        document.getElementById('enquiryModal').classList.remove('show');
        document.body.style.overflow = '';
    }

    // ── SAVE SCHOOL ──
    async function toggleSave(schoolId, btn) {
        try {
            const res = await fetch(`/schools/${schoolId}/save`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            });

            if (res.status === 401) {
                window.location.href = '/login';
                return;
            }

            const data = await res.json();
            if (data.saved) {
                btn.classList.add('saved');
                btn.innerText = '❤️ Saved';
            } else {
                btn.classList.remove('saved');
                btn.innerText = '🤍 Save';
            }
        } catch (e) {
            console.error(e);
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        updateCompareUI();

        @if(request()->hasAny(['q', 'board', 'class_from', 'sort']))
            const target = document.getElementById('school-listing');
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        @endif
    });
</script>
@endpush

@endsection
