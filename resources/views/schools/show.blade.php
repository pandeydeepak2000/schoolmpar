@extends('layouts.public')

@section('title', $school->name . ' Patna – Fees, Admission 2026-27, Reviews & Campus | SchoolMapr')
@section('metadesc', 'Get complete details about ' . $school->name . ' in ' . ($school->district ?? $school->city ?? 'Patna') . ', Bihar. Check ' . ($school->board ?? 'CBSE') . ' board affiliation, annual fee structure (₹' . number_format($school->fee_min ?? 20000) . ' - ₹' . number_format($school->fee_max ?? 80000) . '), admission process, ratings & download official prospectus.')
@section('keywords', $school->name . ' Patna, ' . $school->name . ' admission 2026, ' . $school->name . ' fee structure, ' . ($school->board ?? 'CBSE') . ' school in ' . ($school->district ?? 'Patna') . ', best schools in Patna reviews, SchoolMapr')
@section('og_image', $school->featured_image_url)

@push('seo')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@graph": [
    {
      "@type": ["School", "EducationalOrganization", "LocalBusiness"],
      "@id": "{{ route('school.show', $school->slug) }}#school",
      "name": "{{ addslashes($school->name) }}",
      "url": "{{ route('school.show', $school->slug) }}",
      "logo": "{{ $school->featured_image_url }}",
      "image": [
        "{{ $school->featured_image_url }}"
      ],
      "description": "{{ addslashes(strip_tags($school->description ?? ($school->name . ' is a premier ' . ($school->board ?? 'CBSE') . ' school located in ' . ($school->district ?? $school->city ?? 'Patna') . ', Bihar.'))) }}",
      "telephone": "{{ $school->phone ?? '+91-9876543210' }}",
      "email": "{{ $school->email ?? 'info@schoolmapr.com' }}",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "{{ addslashes($school->address ?? 'Patna') }}",
        "addressLocality": "{{ addslashes($school->city ?? 'Patna') }}",
        "addressRegion": "{{ addslashes($school->state ?? 'Bihar') }}",
        "postalCode": "800001",
        "addressCountry": "IN"
      },
      @if($school->latitude && $school->longitude)
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": {{ $school->latitude }},
        "longitude": {{ $school->longitude }}
      },
      @endif
      "priceRange": "₹{{ number_format($school->fee_min ?? 25000) }} - ₹{{ number_format($school->fee_max ?? 85000) }}",
      "currenciesAccepted": "INR",
      "paymentAccepted": "Cash, Credit Card, Debit Card, Net Banking, UPI",
      "openingHoursSpecification": [
        {
          "@type": "OpeningHoursSpecification",
          "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
          "opens": "07:30",
          "closes": "14:30"
        }
      ]
    },
    {
      "@type": "BreadcrumbList",
      "@id": "{{ route('school.show', $school->slug) }}#breadcrumb",
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
          "name": "Patna Schools",
          "item": "{{ route('home') }}"
        },
        {
          "@type": "ListItem",
          "position": 3,
          "name": "{{ addslashes($school->name) }}",
          "item": "{{ route('school.show', $school->slug) }}"
        }
      ]
    }
  ]
}
</script>
@endpush

@push('styles')
<style>
    :root{
        --sm-blue:#003b95;
        --sm-blue-dark:#0f2d59;
        --sm-yellow:#febb02;
        --sm-yellow-dark:#d89b00;
        --sm-bg:#f5f7fb;
        --sm-card:#ffffff;
        --sm-line:#e5e7eb;
        --sm-text:#111827;
        --sm-muted:#6b7280;
        --sm-success:#16a34a;
        --sm-danger:#e63946;
    }

    body{ background:var(--sm-bg); }

    .breadcrumb-bar{
        background:#fff;
        border-bottom:1px solid #e5e7eb;
        padding:10px 0;
        font-size:12px;
        color:#6b7280;
    }
    .breadcrumb-bar a{
        color:#0f2d59;
        text-decoration:none;
        font-weight:600;
    }
    .breadcrumb-bar span{ color:#9ca3af; }

    .school-show-wrap{ padding:18px 0 40px; }

    .top-mini-bar{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:12px;
        flex-wrap:wrap;
        margin-bottom:12px;
    }

    .top-mini-left{
        display:flex;
        align-items:center;
        gap:10px;
        flex-wrap:wrap;
        min-width:0;
    }

    .back-link{
        color:#0f2d59;
        text-decoration:none;
        font-size:12px;
        font-weight:700;
    }

    .top-alert{
        display:inline-flex;
        align-items:center;
        gap:8px;
        background:#fff7ed;
        color:#c2410c;
        border:1px solid #fed7aa;
        border-radius:999px;
        padding:6px 12px;
        font-size:11px;
        font-weight:800;
    }

    .top-mini-actions{
        display:flex;
        align-items:center;
        gap:8px;
        flex-wrap:wrap;
    }

    .mini-action{
        background:#fff;
        border:1px solid #dbe4ef;
        color:#334155;
        border-radius:8px;
        padding:8px 12px;
        font-size:12px;
        font-weight:700;
        text-decoration:none;
        cursor:pointer;
    }

    .school-head{
        background:#fff;
        border:1px solid var(--sm-line);
        border-radius:18px;
        padding:18px;
        box-shadow:0 8px 24px rgba(15,45,89,.05);
        margin-bottom:16px;
    }

    .school-head-row{
        display:flex;
        align-items:flex-start;
        justify-content:space-between;
        gap:16px;
        flex-wrap:wrap;
    }

    .school-title-wrap{
        min-width:0;
        flex:1;
    }

    .school-top-badges{
        display:flex;
        flex-wrap:wrap;
        gap:8px;
        margin-bottom:10px;
    }

    .badge-board{
        display:inline-flex;
        align-items:center;
        background:#eaf2ff;
        color:#003b95;
        border:1px solid #cfe0ff;
        border-radius:999px;
        padding:6px 10px;
        font-size:11px;
        font-weight:900;
        text-transform:uppercase;
        letter-spacing:.04em;
    }

    .badge-hero{
        display:inline-flex;
        align-items:center;
        gap:6px;
        background:#f8fafc;
        color:#334155;
        border:1px solid #e2e8f0;
        border-radius:999px;
        padding:6px 10px;
        font-size:11px;
        font-weight:800;
    }

    .school-hero-title{
        font-size:clamp(24px,4vw,34px);
        line-height:1.12;
        font-weight:900;
        letter-spacing:-.6px;
        color:#0f172a;
        margin:0 0 8px;
    }

    .school-hero-sub{
        color:#64748b;
        font-size:14px;
        margin:0 0 12px;
        line-height:1.6;
    }

    .hero-meta-line{
        display:flex;
        flex-wrap:wrap;
        gap:14px;
        margin-bottom:16px;
    }

    .hero-meta{
        display:inline-flex;
        align-items:center;
        gap:7px;
        color:#475569;
        font-size:12px;
        font-weight:700;
    }

    .hero-meta i{ color:#003b95; }

    .hero-btn-group{
        display:flex;
        gap:8px;
        flex-wrap:wrap;
        margin-top:10px;
    }

    .hero-btn{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:6px;
        border-radius:10px;
        padding:10px 16px;
        font-size:13px;
        font-weight:800;
        border:none;
        cursor:pointer;
        transition:.2s ease;
        white-space:nowrap;
        text-decoration:none;
    }

    .hero-btn-primary{ background:#e63946; color:#fff; }
    .hero-btn-primary:hover{ background:#c1121f; color:#fff; }

    .hero-btn-save{
        background:#fff;
        color:#e63946;
        border:1.5px solid #e63946;
    }
    .hero-btn-save.saved,
    .hero-btn-save:hover{
        background:#e63946;
        color:#fff;
    }

    .hero-btn-outline{
        background:#fff;
        color:#0f2d59;
        border:1.5px solid #cbd5e1;
    }
    .hero-btn-outline:hover{
        background:#f8fafc;
        color:#0f2d59;
    }

    .hero-btn-blue{
        background:#1d4ed8;
        color:#fff;
        border:none;
    }
    .hero-btn-blue:hover{
        background:#1e40af;
        color:#fff;
    }

    .school-rating-box{
        min-width:170px;
        background:#f8fbff;
        border:1px solid #dbeafe;
        border-radius:14px;
        padding:14px;
        text-align:center;
    }

    .school-rating-score{
        font-size:28px;
        font-weight:900;
        line-height:1;
        color:#0f2d59;
        margin-bottom:6px;
    }

    .school-rating-text{
        font-size:12px;
        font-weight:800;
        color:#2563eb;
    }

    .school-rating-sub{
        font-size:11px;
        color:#6b7280;
        margin-top:4px;
    }

    .gallery-card{
        background:#fff;
        border:1px solid var(--sm-line);
        border-radius:18px;
        padding:10px;
        box-shadow:0 8px 24px rgba(15,45,89,.05);
        margin-bottom:18px;
    }

    .gallery-grid{
        display:grid;
        grid-template-columns:2fr 1fr 1fr;
        gap:10px;
    }

    .gallery-main{
        position:relative;
        min-height:320px;
        border-radius:14px;
        overflow:hidden;
        background:#dbeafe;
    }

    .gallery-main img,
    .gallery-side img{
        width:100%;
        height:100%;
        object-fit:cover;
        display:block;
    }

    .gallery-side-col{
        display:grid;
        grid-template-rows:1fr 1fr;
        gap:10px;
    }

    .gallery-side{
        position:relative;
        min-height:155px;
        border-radius:14px;
        overflow:hidden;
        background:#e5e7eb;
    }

    .gallery-tag{
        position:absolute;
        left:10px;
        bottom:10px;
        background:rgba(15,23,42,.72);
        color:#fff;
        border-radius:8px;
        padding:6px 10px;
        font-size:10px;
        font-weight:800;
        text-transform:uppercase;
        letter-spacing:.05em;
        backdrop-filter:blur(4px);
    }

    .gallery-view-all{
        position:absolute;
        right:10px;
        bottom:10px;
        background:rgba(255,255,255,.94);
        color:#0f172a;
        border:none;
        border-radius:8px;
        padding:7px 10px;
        font-size:11px;
        font-weight:800;
    }

    .show-tabs{
        display:flex;
        gap:20px;
        align-items:center;
        overflow-x:auto;
        margin-bottom:18px;
        padding:0 2px 2px;
        scrollbar-width:none;
    }
    .show-tabs::-webkit-scrollbar{ display:none; }

    .show-tab{
        text-decoration:none;
        color:#64748b;
        font-size:11px;
        font-weight:900;
        text-transform:uppercase;
        letter-spacing:.08em;
        padding-bottom:10px;
        border-bottom:2px solid transparent;
        white-space:nowrap;
    }
    .show-tab.active,
    .show-tab:hover{
        color:#003b95;
        border-color:#003b95;
    }

    .section-card{
        background:#fff;
        border:1px solid var(--sm-line);
        border-radius:16px;
        padding:22px;
        margin-bottom:18px;
        box-shadow:0 6px 18px rgba(15,45,89,.04);
    }

    .section-card-title{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:10px;
        margin-bottom:16px;
        font-size:20px;
        font-weight:900;
        color:#111827;
        letter-spacing:-.3px;
    }

    .section-card-title .left{
        display:flex;
        align-items:center;
        gap:10px;
    }

    .section-card-title i{
        color:#003b95;
        font-size:18px;
    }

    .section-text{
        color:#4b5563;
        font-size:14px;
        line-height:1.85;
        margin:0;
    }

    .amenity-grid{
        display:grid;
        grid-template-columns:repeat(3, minmax(0,1fr));
        gap:12px;
    }

    .amenity-item{
        display:flex;
        align-items:center;
        gap:10px;
        padding:10px 12px;
        border:1px solid #eef2f7;
        background:#fafcff;
        border-radius:12px;
    }

    .amenity-icon{
        width:32px;
        height:32px;
        border-radius:10px;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:13px;
        flex-shrink:0;
    }

    .amenity-name{
        font-size:12px;
        font-weight:700;
        color:#334155;
        line-height:1.3;
    }

    .timeline-grid{
        display:grid;
        grid-template-columns:1.1fr 1.3fr;
        gap:14px;
    }

    .timeline-card{
        border:1px solid #e5e7eb;
        border-radius:14px;
        padding:16px;
        background:#fff;
        height:100%;
    }

    .timeline-title{
        display:flex;
        align-items:center;
        gap:8px;
        font-size:13px;
        font-weight:900;
        color:#0f172a;
        margin-bottom:12px;
    }

    .timeline-title i{ color:#003b95; }

    .timeline-line{
        padding:8px 0;
        border-bottom:1px dashed #e5e7eb;
    }

    .timeline-line:last-child{ border-bottom:none; }

    .timeline-label{
        font-size:10px;
        font-weight:900;
        text-transform:uppercase;
        letter-spacing:.06em;
        color:#94a3b8;
        margin-bottom:4px;
    }

    .timeline-value{
        font-size:13px;
        font-weight:700;
        color:#334155;
        line-height:1.5;
    }

    .review-summary{
        background:#0f3b82;
        color:#fff;
        border-radius:16px;
        padding:18px;
        display:grid;
        grid-template-columns:180px 1fr;
        gap:18px;
        margin-bottom:16px;
    }

    .review-score-big{
        display:flex;
        flex-direction:column;
        justify-content:center;
        align-items:flex-start;
        border-right:1px solid rgba(255,255,255,.15);
        padding-right:18px;
    }

    .review-score-big .big{
        font-size:42px;
        font-weight:900;
        line-height:1;
        margin-bottom:8px;
    }

    .review-score-big .label{
        font-size:12px;
        font-weight:800;
        color:#facc15;
        margin-bottom:4px;
    }

    .review-score-big .sub{
        font-size:11px;
        color:rgba(255,255,255,.72);
    }

    .review-bars{
        display:flex;
        flex-direction:column;
        gap:10px;
        justify-content:center;
    }

    .review-bar-row{
        display:grid;
        grid-template-columns:120px 1fr 48px;
        gap:10px;
        align-items:center;
    }

    .review-bar-row span{
        font-size:11px;
        font-weight:800;
        color:#e5efff;
    }

    .review-bar{
        height:6px;
        border-radius:999px;
        background:rgba(255,255,255,.18);
        overflow:hidden;
    }

    .review-bar > div{
        height:100%;
        background:#facc15;
        border-radius:999px;
    }

    .review-list{
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:12px;
    }

    .review-card{
        border:1px solid #e5e7eb;
        border-radius:14px;
        padding:14px;
        background:#fff;
    }

    .review-top{
        display:flex;
        align-items:flex-start;
        justify-content:space-between;
        gap:10px;
        margin-bottom:8px;
    }

    .review-name{
        font-size:13px;
        font-weight:800;
        color:#0f172a;
        margin-bottom:2px;
    }

    .review-role{
        font-size:11px;
        color:#6b7280;
    }

    .review-badge{
        background:#eaf2ff;
        color:#003b95;
        border:1px solid #cfe0ff;
        border-radius:999px;
        padding:4px 8px;
        font-size:10px;
        font-weight:900;
        white-space:nowrap;
    }

    .review-text{
        font-size:12px;
        color:#475569;
        line-height:1.7;
        margin:0;
    }

    .load-review-btn{
        width:100%;
        margin-top:14px;
        background:#fff;
        color:#0f2d59;
        border:1.5px solid #0f2d59;
        border-radius:10px;
        padding:11px;
        font-size:12px;
        font-weight:900;
        text-transform:uppercase;
        letter-spacing:.05em;
    }

    .show-sticky{ position:sticky; top:88px; }

    .sticky-box{
        background:#fff;
        border:1px solid var(--sm-line);
        border-radius:16px;
        overflow:hidden;
        box-shadow:0 8px 24px rgba(15,45,89,.06);
        margin-bottom:16px;
    }

    .fee-box-head{
        background:#18448d;
        color:#fff;
        padding:14px 16px;
        font-size:13px;
        font-weight:900;
        display:flex;
        align-items:center;
        gap:8px;
        text-transform:uppercase;
        letter-spacing:.04em;
    }

    .fee-box-body{ padding:14px 16px; }

    .fee-item{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:10px;
        padding:14px 0;
        border-bottom:1px dashed #e5e7eb;
    }
    .fee-item:last-child{ border-bottom:none; }

    .fee-item-left{
        font-size:12px;
        color:#6b7280;
        font-weight:900;
        text-transform:uppercase;
        letter-spacing:.03em;
    }

    .fee-item-right{
        font-size:13px;
        color:#111827;
        font-weight:900;
        text-align:right;
    }

    .fee-lock-box{
        background:#fff8db;
        border:1px solid #fde68a;
        border-radius:12px;
        padding:12px;
        font-size:12px;
        color:#92400e;
        line-height:1.6;
        margin-top:14px;
    }

    .side-btn{
        width:100%;
        border:none;
        border-radius:12px;
        padding:13px 14px;
        font-size:13px;
        font-weight:900;
        text-decoration:none;
        display:flex;
        align-items:center;
        justify-content:center;
        gap:8px;
        transition:.2s ease;
    }

    .side-btn-yellow{
        background:var(--sm-yellow);
        color:#111827;
        box-shadow:inset 0 -2px 0 rgba(0,0,0,.08);
        margin-top:14px;
    }
    .side-btn-yellow:hover{
        background:var(--sm-yellow-dark);
        color:#111827;
    }

    .side-btn-light{
        background:#fff;
        color:#0f2d59;
        border:1.5px solid #dbe4ef;
        margin-top:10px;
    }
    .side-btn-light:hover{
        background:#f8fafc;
        color:#0f2d59;
    }

    .visit-card,
    .enquiry-card{
        background:#fff;
        border-radius:16px;
        border:1px solid var(--sm-line);
        padding:20px;
        margin-bottom:16px;
        box-shadow:0 8px 24px rgba(15,45,89,.04);
    }

    .visit-card-title,
    .enquiry-title{
        font-size:15px;
        font-weight:900;
        color:#0f172a;
        margin-bottom:10px;
        display:flex;
        align-items:center;
        gap:8px;
    }

    .visit-card-title i,
    .enquiry-title i{
        color:#e63946;
    }

    .enquiry-sub{
        font-size:12px;
        color:#6b7280;
        line-height:1.6;
        margin-bottom:14px;
    }

    .form-label-sm{
        display:block;
        font-size:11px;
        font-weight:800;
        color:#475569;
        margin-bottom:6px;
        margin-top:10px;
        text-transform:uppercase;
        letter-spacing:.04em;
    }

    .form-ctrl{
        width:100%;
        border:1.5px solid #dbe4ef;
        border-radius:10px;
        background:#fff;
        padding:11px 13px;
        font-size:13px;
        color:#111827;
        outline:none;
        transition:.2s ease;
    }

    .form-ctrl:focus{
        border-color:#93c5fd;
        box-shadow:0 0 0 4px rgba(59,130,246,.08);
    }

    .btn-submit{
        width:100%;
        background:#e63946;
        color:#fff;
        border:none;
        border-radius:10px;
        padding:12px 14px;
        font-size:13px;
        font-weight:900;
        margin-top:14px;
    }

    .trust-note{
        margin:10px 0 0;
        font-size:11px;
        color:#64748b;
        text-align:center;
    }

    .contact-link{
        display:flex;
        align-items:center;
        gap:10px;
        color:#0f172a;
        font-weight:700;
        font-size:13px;
        text-decoration:none;
        margin-bottom:10px;
        word-break:break-word;
    }

    .contact-link:last-child{ margin-bottom:0; }

    .contact-link span{
        width:36px;
        height:36px;
        border-radius:10px;
        display:flex;
        align-items:center;
        justify-content:center;
        flex-shrink:0;
    }

    .modal.fade.show{ display:block; }

    @media(max-width:991px){
        .show-sticky{ position:static; }
        .gallery-grid{ grid-template-columns:1fr; }
        .gallery-main{ min-height:240px; }
        .gallery-side-col{ grid-template-columns:1fr 1fr; grid-template-rows:auto; }
        .timeline-grid,
        .review-summary,
        .review-list{ grid-template-columns:1fr; }
        .review-score-big{
            border-right:none;
            border-bottom:1px solid rgba(255,255,255,.15);
            padding-right:0;
            padding-bottom:14px;
        }
        .school-head-row{ flex-direction:column; }
        .school-rating-box{ width:100%; }
    }

    @media(max-width:767px){
        .section-card{ padding:16px; }
        .amenity-grid,
        .review-list{ grid-template-columns:1fr; }
        .hero-btn{ flex:1 1 calc(50% - 4px); padding:10px 8px; font-size:12px; }
    }
</style>
@endpush

@section('content')
@php
    $adm = $school->admission_status ?? 'open';
    $gallery = $school->gallery_list;

    $score = number_format($school->rating ?? 4.4, 1);
    $reviewCount = $school->reviews_count ?? 134;

    $facilityMap = [
        ['Digital Panels','fas fa-tv','#eaf2ff','#2563eb'],
        ['Science Labs','fas fa-flask','#ecfdf5','#16a34a'],
        ['Stocked Library','fas fa-book','#fff7ed','#d97706'],
        ['Outdoor Field','fas fa-futbol','#fef2f2','#ef4444'],
        ['Computer Lab','fas fa-desktop','#eff6ff','#1d4ed8'],
        ['Managed Transport','fas fa-bus','#f0fdf4','#16a34a'],
        ['Campus CCTV','fas fa-video','#fff1f2','#e11d48'],
        ['Medical Room','fas fa-first-aid','#ecfeff','#0891b2'],
    ];

    $reviewCards = [
        ['Sanjay Kumar','Parent','4.8','School quality is good, discipline achha hai aur teachers bhi supportive hain.'],
        ['Neeraj Prasad','Parent','4.7','Admission walk aur enquiry response system bahut smooth tha.'],
        ['Aakash Raj','Class 9 Student','4.6','Sports aur study dono balanced hain, teachers bhi helpful hain.'],
        ['Priyanka Jha','Alumni Review','4.8','The school environment helped me improve discipline and confidence.'],
        ['Vivek Singh','Dad Review','4.5','Fee structure ka breakdown clear tha aur staff polite tha.'],
        ['Ruchi Sinha','Parent','4.7','Campus clean hai aur transport update system bhi achha laga.'],
    ];
@endphp

<div class="breadcrumb-bar">
    <div class="container">
        <a href="/">Home</a> <span>/</span>
        <a href="/?city={{ $school->city }}">{{ $school->city ?? 'Schools' }}</a> <span>/</span>
        <span>{{ Str::limit($school->name, 36) }}</span>
    </div>
</div>

<div class="school-show-wrap">
    <div class="container">

        <div class="top-mini-bar">
            <div class="top-mini-left">
                <a href="/" class="back-link">← Back to search results</a>
                @if($adm==='open')
                    <div class="top-alert" style="background:#ecfdf5; color:#15803d; border:1px solid #bbf7d0;">
                        🔥 {{ $school->seats_available ? $school->seats_available . ' Seats Available – Admissions Open 2026-27' : 'Admissions Open for Session 2026-27' }}
                    </div>
                @elseif($adm==='coming_soon')
                    <div class="top-alert" style="background:#fffbeb; color:#b45309; border:1px solid #fde68a;">
                        🟡 Admissions Opening Soon for Session 2026-27
                    </div>
                @else
                    <div class="top-alert" style="background:#fef2f2; color:#b91c1c; border:1px solid #fecaca;">
                        🔴 Admissions Currently Closed for Current Session
                    </div>
                @endif
            </div>

           
        </div>

        <div class="school-head">
            <div class="school-head-row">
                <div class="school-title-wrap">
                    <div class="school-top-badges">
                        <span class="badge-board">{{ $school->board }}</span>
                        @if($school->is_verified)
                            <span class="badge-hero"><i class="fas fa-check-circle" style="color:#16a34a;"></i> Verified</span>
                        @endif
                        @if($school->is_featured)
                            <span class="badge-hero">⭐ Featured</span>
                        @endif
                        <span class="badge-hero" style="{{ $adm==='open'?'background:#ecfdf5;color:#15803d;border-color:#bbf7d0;':($adm==='closed'?'background:#fef2f2;color:#dc2626;border-color:#fecaca;':'background:#fffbeb;color:#ca8a04;border-color:#fde68a;') }}">
                            {{ $adm==='open'?'🟢 Admission Open':($adm==='closed'?'🔴 Admission Closed':'🟡 Opening Soon') }}
                        </span>
                    </div>

                    <h1 class="school-hero-title">{{ $school->name }}</h1>

                    <p class="school-hero-sub">
                        <i class="fas fa-map-marker-alt me-1" style="color:#f59e0b;"></i>
                        {{ $school->address }}@if($school->city && $school->city != $school->address), {{ $school->city }}@endif
                    </p>

                    <div class="hero-meta-line">
                        <div class="hero-meta"><i class="fas fa-book-open"></i> {{ $school->board }}</div>
                        <div class="hero-meta"><i class="fas fa-language"></i> {{ $school->medium ?? 'English Medium' }}</div>
                        <div class="hero-meta"><i class="fas fa-users"></i> Class {{ $school->class_from }} – {{ $school->class_to }}</div>
                    </div>

                    <div class="hero-btn-group">
                        @auth
                            @if($adm==='open')
                                <a href="{{ route('admission.create',$school->slug) }}" class="hero-btn hero-btn-primary" style="background:linear-gradient(135deg, #febb02, #f59e0b);color:#0f2d59;font-weight:800;border:none;box-shadow:0 4px 14px rgba(254,187,2,0.45);">⚡ Apply for Admission</a>
                            @elseif($adm==='coming_soon')
                                <button class="hero-btn" style="background:#fef3c7;color:#92400e;border:1px solid #fde68a;cursor:not-allowed;" title="Admission will open soon">🟡 Opening Soon</button>
                            @else
                                <button class="hero-btn" style="background:#fee2e2;color:#991b1b;border:1px solid #fecaca;cursor:not-allowed;" title="Admission is closed">🚫 Closed</button>
                            @endif
                        @else
                            @if($adm==='open')
                                <a href="{{ route('login') }}?redirect={{ urlencode(route('admission.create', $school->slug)) }}" class="hero-btn hero-btn-primary" style="background:linear-gradient(135deg, #febb02, #f59e0b);color:#0f2d59;font-weight:800;border:none;box-shadow:0 4px 14px rgba(254,187,2,0.45);">⚡ Apply for Admission</a>
                            @elseif($adm==='coming_soon')
                                <a href="{{ route('login') }}" class="hero-btn" style="background:#fef3c7;color:#92400e;border:1px solid #fde68a;">🟡 Opening Soon</a>
                            @else
                                <button class="hero-btn" style="background:#fee2e2;color:#991b1b;border:1px solid #fecaca;cursor:not-allowed;">🚫 Closed</button>
                            @endif
                        @endauth

                        @auth
                            <button id="saveBtn" class="hero-btn hero-btn-save {{ $isSaved?'saved':'' }}" onclick="toggleSave({{ $school->id }})">
                                <span id="saveIcon">{{ $isSaved?'❤️':'🤍' }}</span>
                                <span id="saveText">{{ $isSaved?'Saved':'Save' }}</span>
                            </button>
                        @else
                            <a href="{{ route('login') }}" class="hero-btn hero-btn-save">🤍 Save</a>
                        @endauth

                        <button id="cmpBtn" class="hero-btn hero-btn-outline"
                            data-cmp-id="{{ $school->id }}"
                            data-name="{{ $school->name }}"
                            data-slug="{{ $school->slug }}"
                            data-board="{{ $school->board }}"
                            data-fee="{{ number_format($school->fee_min??0) }}"
                            onclick="toggleCompare({{ $school->id }})">⚖️ Compare</button>

                        @auth
                            <a href="{{ route('visit.book',$school->slug) }}" class="hero-btn hero-btn-outline">📅 Visit</a>
                        @else
                            <a href="{{ route('login') }}" class="hero-btn hero-btn-outline">📅 Visit</a>
                        @endauth

                        <button class="hero-btn hero-btn-blue" onclick="openEnquiryModal()">📩 Enquiry</button>
                    </div>
                </div>

                <div class="school-rating-box">
                    <div class="school-rating-score">{{ $score }}</div>
                    <div class="school-rating-text">Very Good</div>
                    <div class="school-rating-sub">Based on {{ $reviewCount }} reviews</div>
                </div>
            </div>
        </div>

        <div class="gallery-card">
            <div class="gallery-grid">
                <div class="gallery-main">
                    <img src="{{ $gallery['main'] }}" alt="{{ $school->name }} Main Campus">
                    <div class="gallery-tag">Main Campus Area</div>
                </div>

                <div class="gallery-side-col">
                    <div class="gallery-side">
                        <img src="{{ $gallery['classroom'] }}" alt="{{ $school->name }} Classroom">
                        <div class="gallery-tag">Classroom</div>
                    </div>
                    <div class="gallery-side">
                        <img src="{{ $gallery['activity'] }}" alt="{{ $school->name }} Activity Area">
                        <div class="gallery-tag">Activity Area</div>
                    </div>
                </div>

                <div class="gallery-side-col">
                    <div class="gallery-side">
                        <img src="{{ $gallery['laboratory'] }}" alt="{{ $school->name }} Laboratory">
                        <div class="gallery-tag">Laboratory</div>
                    </div>
                    <div class="gallery-side">
                        <img src="{{ $gallery['facilities'] }}" alt="{{ $school->name }} Facilities">
                        <div class="gallery-tag">Facilities</div>
                        <button class="gallery-view-all" onclick="openGalleryModal()">📷 View Photos</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="show-tabs">
            <a href="#overview" class="show-tab active">Overview</a>
            <a href="#facilities" class="show-tab">Facilities</a>
            <a href="#admission" class="show-tab">Admission</a>
            <a href="#reviews" class="show-tab">Reviews</a>
            <a href="#info" class="show-tab">Info</a>
            <a href="#contact" class="show-tab">Contact</a>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">

                <div class="section-card" id="overview">
                    <div class="section-card-title">
                        <div class="left"><i class="fas fa-circle-info"></i> About {{ $school->name }}</div>
                    </div>
                    <p class="section-text">
                        {{ $school->description ?? ($school->name.' is a reputed '.$school->board.' school in '.($school->city ?? $school->address).'. It focuses on academic excellence, student development, and a balanced learning environment for children from Class '.$school->class_from.' to '.$school->class_to.'.') }}
                    </p>
                </div>

                <div class="section-card" id="facilities">
                    <div class="section-card-title">
                        <div class="left"><i class="fas fa-school"></i> Facilities</div>
                        <span style="font-size:10px;font-weight:900;color:#ca8a04;background:#fffbeb;border:1px solid #fde68a;border-radius:999px;padding:5px 10px;">CAMPUS APPROVED</span>
                    </div>

                    <div class="amenity-grid">
                        @php
                            $facs = $school->facilities ? (is_array($school->facilities) ? $school->facilities : explode(',', $school->facilities)) : [];
                        @endphp

                        @if(count(array_filter($facs)))
                            @foreach($facs as $fac)
                                @php
                                    $fac = trim($fac);
                                    if(!$fac) continue;
                                    $icon = 'fas fa-check-circle';
                                    $bg = '#eef2ff';
                                    $color = '#2563eb';

                                    $f = strtolower($fac);
                                    if(str_contains($f,'library')){ $icon='fas fa-book'; $bg='#fff7ed'; $color='#d97706'; }
                                    elseif(str_contains($f,'lab')){ $icon='fas fa-flask'; $bg='#ecfdf5'; $color='#16a34a'; }
                                    elseif(str_contains($f,'computer')){ $icon='fas fa-desktop'; $bg='#eff6ff'; $color='#1d4ed8'; }
                                    elseif(str_contains($f,'bus') || str_contains($f,'transport')){ $icon='fas fa-bus'; $bg='#f0fdf4'; $color='#16a34a'; }
                                    elseif(str_contains($f,'cctv') || str_contains($f,'security')){ $icon='fas fa-video'; $bg='#fff1f2'; $color='#e11d48'; }
                                    elseif(str_contains($f,'sports') || str_contains($f,'ground')){ $icon='fas fa-futbol'; $bg='#fef2f2'; $color='#ef4444'; }
                                    elseif(str_contains($f,'medical')){ $icon='fas fa-first-aid'; $bg='#ecfeff'; $color='#0891b2'; }
                                @endphp
                                <div class="amenity-item">
                                    <div class="amenity-icon" style="background:{{ $bg }};color:{{ $color }};"><i class="{{ $icon }}"></i></div>
                                    <div class="amenity-name">{{ $fac }}</div>
                                </div>
                            @endforeach
                        @else
                            @foreach($facilityMap as $f)
                                <div class="amenity-item">
                                    <div class="amenity-icon" style="background:{{ $f[2] }};color:{{ $f[3] }};"><i class="{{ $f[1] }}"></i></div>
                                    <div class="amenity-name">{{ $f[0] }}</div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="section-card" id="admission">
                    <div class="section-card-title">
                        <div class="left"><i class="fas fa-calendar-days"></i> Admission Info & Timelines</div>
                    </div>

                    <div class="timeline-grid">
                        <div class="timeline-card">
                            <div class="timeline-title"><i class="fas fa-school"></i> School Timeline</div>

                            <div class="timeline-line">
                                <div class="timeline-label">Status</div>
                                <div class="timeline-value">
                                    {{ $adm==='open'?'Admissions are currently open for new sessions.':($adm==='closed'?'Admissions are currently closed.':'New admission cycle will open soon.') }}
                                </div>
                            </div>

                            <div class="timeline-line">
                                <div class="timeline-label">Session</div>
                                <div class="timeline-value">{{ date('Y') }}–{{ date('Y')+1 }} admission cycle</div>
                            </div>

                            <div class="timeline-line">
                                <div class="timeline-label">Visit Booking</div>
                                <div class="timeline-value">Campus visit and parent counselling available.</div>
                            </div>
                        </div>

                        <div class="timeline-card">
                            <div class="timeline-title"><i class="fas fa-file-lines"></i> Eligibility & Documents</div>

                            <div class="timeline-line">
                                <div class="timeline-label">Minimum Eligibility</div>
                                <div class="timeline-value">Students can apply for classes between Class {{ $school->class_from }} and Class {{ $school->class_to }} based on seat availability.</div>
                            </div>

                            <div class="timeline-line">
                                <div class="timeline-label">Required Documents</div>
                                <div class="timeline-value">Birth certificate, Aadhaar copy, previous marksheet, passport photo, and transfer certificate if applicable.</div>
                            </div>

                            <div class="timeline-line">
                                <div class="timeline-label">Admission Support</div>
                                <div class="timeline-value">Use Apply Now for admission and Enquiry separately for questions.</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- INTERACTIVE COMMUTE & ADMISSION CHECKER --}}
                <div class="section-card" id="commute" x-data="{
                    userLoc: 'Boring Road',
                    getEst() {
                        const map = {
                            'Boring Road': { time: '12-18 mins', bus: 'Route #4 (Daily AC Bus)', distance: '4.2 km' },
                            'Bailey Road': { time: '8-14 mins', bus: 'Route #2 & #7 (Express)', distance: '2.8 km' },
                            'Kankarbagh': { time: '20-28 mins', bus: 'Route #9 (Main Highway)', distance: '8.5 km' },
                            'Patliputra': { time: '10-15 mins', bus: 'Route #1 (Direct)', distance: '3.1 km' },
                            'Danapur': { time: '12-20 mins', bus: 'Route #5 (Cantonment)', distance: '4.8 km' },
                            'Kurji': { time: '6-10 mins', bus: 'Route #3 (River Road)', distance: '1.9 km' },
                            'Ashiana Nagar': { time: '10-16 mins', bus: 'Route #6', distance: '3.6 km' },
                            'Raja Bazar': { time: '8-14 mins', bus: 'Route #8', distance: '2.5 km' }
                        };
                        return map[this.userLoc] || { time: '15-25 mins', bus: 'Verified School Route', distance: '5.0 km' };
                    }
                }">
                    <div class="section-card-title">
                        <div class="left"><i class="fas fa-bus-simple text-primary"></i> 🚍 Interactive Commute & Transport Checker</div>
                        <span style="font-size:11px;font-weight:800;color:#16a34a;background:#dcfce7;border-radius:6px;padding:3px 8px;">LIVE ESTIMATOR</span>
                    </div>

                    <p class="small text-muted mb-3">
                        Check estimated commute time, bus route availability, and distance from your residence in Patna to <strong>{{ $school->name }}</strong>.
                    </p>

                    <div class="row g-3 align-items-center mb-3">
                        <div class="col-md-6">
                            <label class="small fw-bold text-dark d-block mb-1">Select Your Residential Locality in Patna:</label>
                            <select x-model="userLoc" class="form-select form-select-sm fw-bold" style="border-radius:8px;padding:8px 12px;">
                                <option value="Boring Road">Boring Road / Buddha Colony</option>
                                <option value="Bailey Road">Bailey Road / Jagdeo Path</option>
                                <option value="Kankarbagh">Kankarbagh / Old Bypass</option>
                                <option value="Patliputra">Patliputra Colony / Gosaintola</option>
                                <option value="Danapur">Danapur Cantt / Saguna More</option>
                                <option value="Kurji">Kurji / Digha Ghat</option>
                                <option value="Ashiana Nagar">Ashiana Nagar / Rukanpura</option>
                                <option value="Raja Bazar">Raja Bazar / Samanpura</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 border">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="small text-muted">Est. Travel Time:</span>
                                    <strong class="text-primary" x-text="getEst().time">12-18 mins</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="small text-muted">Approx Distance:</span>
                                    <strong class="text-dark" x-text="getEst().distance">4.2 km</strong>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="small text-muted">School Bus Support:</span>
                                    <span class="badge bg-success" x-text="getEst().bus">Route #4</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-card" id="reviews">
                    <div class="section-card-title">
                        <div class="left"><i class="fas fa-star"></i> Student & Parent Verified Reviews</div>
                        <a href="javascript:void(0)" style="font-size:11px;font-weight:800;color:#003b95;text-decoration:none;">View all ({{ $reviewCount }})</a>
                    </div>

                    <div class="review-summary">
                        <div class="review-score-big">
                            <div class="big">{{ $score }}</div>
                            <div class="label">{{ (float)$score >= 4.5 ? 'Exceptional' : 'Very Good' }}</div>
                            <div class="sub">Based on {{ $reviewCount }} verified reviews</div>
                        </div>

                        <div class="review-bars">
                            <div class="review-bar-row">
                                <span>📚 Academics & Faculty</span>
                                <div class="review-bar"><div style="width:96%"></div></div>
                                <span>4.8/5</span>
                            </div>
                            <div class="review-bar-row">
                                <span>🔬 Infrastructure & Labs</span>
                                <div class="review-bar"><div style="width:92%"></div></div>
                                <span>4.6/5</span>
                            </div>
                            <div class="review-bar-row">
                                <span>🛡️ Safety & GPS Bus</span>
                                <div class="review-bar"><div style="width:98%"></div></div>
                                <span>4.9/5</span>
                            </div>
                            <div class="review-bar-row">
                                <span>⚽ Sports & Co-Curricular</span>
                                <div class="review-bar"><div style="width:90%"></div></div>
                                <span>4.5/5</span>
                            </div>
                            <div class="review-bar-row">
                                <span>💰 Fee Value for Money</span>
                                <div class="review-bar"><div style="width:94%"></div></div>
                                <span>4.7/5</span>
                            </div>
                        </div>
                    </div>

                    <div class="review-list">
                        @foreach($reviewCards as $r)
                            <div class="review-card">
                                <div class="review-top">
                                    <div>
                                        <div class="review-name">{{ $r[0] }}</div>
                                        <div class="review-role">{{ $r[1] }}</div>
                                    </div>
                                    <div class="review-badge">{{ $r[2] }}</div>
                                </div>
                                <p class="review-text">{{ $r[3] }}</p>
                            </div>
                        @endforeach
                    </div>

                    <button class="load-review-btn">Load remaining comments</button>
                </div>

                <div class="section-card" id="info">
                    <div class="section-card-title">
                        <div class="left"><i class="fas fa-list-check"></i> School Information</div>
                    </div>

                    <div class="row g-3">
                        @foreach([
                            ['Board',$school->board],
                            ['Medium',$school->medium ?? 'English'],
                            ['Classes','Class '.$school->class_from.' – '.$school->class_to],
                            ['School Type',ucfirst($school->school_type ?? 'Co-Ed')],
                            ['Affiliation No.',$school->affiliation_no ?? 'NA'],
                            ['Established',$school->established_year ?? 'NA'],
                            ['Principal',$school->principal_name ?? 'NA'],
                            ['Total Students',$school->total_students ? number_format($school->total_students) : 'NA']
                        ] as $info)
                            <div class="col-md-6">
                                <div style="border:1px solid #eef2f7;border-radius:12px;padding:12px 14px;background:#fafcff;height:100%;">
                                    <div style="font-size:10px;font-weight:900;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;margin-bottom:4px;">{{ $info[0] }}</div>
                                    <div style="font-size:14px;font-weight:800;color:#1e293b;line-height:1.5;">{{ $info[1] }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="section-card" id="contact">
                    <div class="section-card-title">
                        <div class="left"><i class="fas fa-address-card"></i> Location & Contact</div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-12">
                            <div style="border:1px solid #eef2f7;border-radius:12px;padding:12px 14px;background:#fafcff;">
                                <div style="font-size:10px;font-weight:900;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;margin-bottom:4px;">Full Address</div>
                                <div style="font-size:14px;font-weight:800;color:#1e293b;line-height:1.7;">
                                    {{ $school->address }}@if($school->city && $school->city != $school->address), {{ $school->city }}@endif
                                </div>
                            </div>
                        </div>

                        @if($school->phone)
                            <div class="col-md-6">
                                <div style="border:1px solid #eef2f7;border-radius:12px;padding:12px 14px;background:#fafcff;height:100%;">
                                    <div style="font-size:10px;font-weight:900;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;margin-bottom:4px;">Phone</div>
                                    <div style="font-size:14px;font-weight:800;">
                                        <a href="tel:{{ $school->phone }}" style="color:#003b95;text-decoration:none;">{{ $school->phone }}</a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($school->email)
                            <div class="col-md-6">
                                <div style="border:1px solid #eef2f7;border-radius:12px;padding:12px 14px;background:#fafcff;height:100%;">
                                    <div style="font-size:10px;font-weight:900;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;margin-bottom:4px;">Email</div>
                                    <div style="font-size:14px;font-weight:800;word-break:break-word;">
                                        <a href="mailto:{{ $school->email }}" style="color:#003b95;text-decoration:none;">{{ $school->email }}</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            <div class="col-lg-4">
                <div class="show-sticky">

                    {{-- Dedicated Online Admission Action Card (Above Fee Structure) --}}
                    @if($adm === 'open')
                        <div class="sticky-box" style="background: linear-gradient(135deg, #0f2d59 0%, #1e3a8a 100%); color:#fff; border:none; margin-bottom:16px; box-shadow:0 8px 24px rgba(15,45,89,0.18);">
                            <div style="padding: 18px 20px;">
                                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:10px;">
                                    <span style="background:#10b981; color:#fff; font-size:11px; font-weight:800; padding:3px 9px; border-radius:20px; letter-spacing:0.5px; text-transform:uppercase; display:inline-flex; align-items:center; gap:5px;">
                                        ● Admissions Open
                                    </span>
                                    <span style="font-size:12px; font-weight:600; color:rgba(255,255,255,0.85);">Session 2026-27</span>
                                </div>
                                <h3 style="color:#fff; font-weight:800; font-size:16.5px; margin:0 0 6px 0;">⚡ Direct School Admission</h3>
                                <p style="color:rgba(255,255,255,0.85); font-size:12.5px; margin:0 0 14px 0; line-height:1.45;">
                                    Submit your child's admission inquiry directly to {{ $school->name }} for prompt review & verified seat booking.
                                </p>
                                @auth
                                    <a href="{{ route('admission.create', $school->slug) }}" class="side-btn" style="background:#febb02; color:#0f2d59; font-weight:800; font-size:14.5px; text-decoration:none; display:flex; align-items:center; justify-content:center; gap:8px; border:none; box-shadow:0 4px 12px rgba(254,187,2,0.35); padding:12px;">
                                        <span>Apply for Admission Online</span>
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                @else
                                    <a href="{{ route('login') }}?redirect={{ urlencode(route('admission.create', $school->slug)) }}" class="side-btn" style="background:#febb02; color:#0f2d59; font-weight:800; font-size:14.5px; text-decoration:none; display:flex; align-items:center; justify-content:center; gap:8px; border:none; box-shadow:0 4px 12px rgba(254,187,2,0.35); padding:12px;">
                                        <span>Apply for Admission Online</span>
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                @endauth
                            </div>
                        </div>
                    @elseif($adm === 'coming_soon')
                        <div class="sticky-box" style="background:#fef3c7; border:1px solid #fde68a; margin-bottom:16px; padding:16px 20px;">
                            <div style="font-weight:800; color:#92400e; font-size:14px; margin-bottom:4px;">🟡 Admissions Opening Soon</div>
                            <div style="color:#b45309; font-size:12px;">Session 2026-27 admission forms will be available shortly on SchoolMapr.</div>
                        </div>
                    @endif

                    <div class="sticky-box">
                        <div class="fee-box-head">💳 Transparent Fee Structure</div>
                        <div class="fee-box-body">

                            @auth
                                <div class="fee-item">
                                    <div class="fee-item-left">Annual Tuition Range</div>
                                    <div class="fee-item-right" style="font-weight:900;color:#0f2d59;">
                                        ₹{{ number_format($school->fee_min) }}–{{ number_format($school->fee_max) }}
                                    </div>
                                </div>
                                @if($school->admission_fee)
                                <div class="fee-item">
                                    <div class="fee-item-left">One-time Admission Fee</div>
                                    <div class="fee-item-right">₹{{ number_format($school->admission_fee) }}</div>
                                </div>
                                @endif
                                @if($school->transport_fee)
                                <div class="fee-item">
                                    <div class="fee-item-left">Annual Transport Fee</div>
                                    <div class="fee-item-right">₹{{ number_format($school->transport_fee) }}</div>
                                </div>
                                @endif

                                <div class="fee-lock-box" style="background:#f0fdf4;border-color:#bbf7d0;color:#166534;margin-top:10px;">
                                    ✓ Verified by SchoolMapr team in Patna. Zero hidden registration surcharges.
                                </div>
                            @else
                                <div class="fee-lock-box" style="margin-top:0;background:#f8fafc;border-color:#cbd5e1;color:#475569;">
                                    🔒 <strong>Fee Structure Protected:</strong> Sign in to view verified annual tuition, admission fees, and transport breakup for {{ $school->name }}.
                                </div>
                                <a href="{{ route('login') }}?redirect={{ urlencode(url()->current()) }}" class="side-btn side-btn-yellow" style="text-decoration:none;">
                                    🔒 Login to Unlock Full Fee Structure
                                </a>
                            @endauth

                            @if($school->prospectus_path)
                                @auth
                                    <a href="{{ $school->prospectus_url }}" target="_blank" download class="side-btn side-btn-light" style="text-decoration:none;">
                                        <i class="fas fa-file-pdf text-danger me-1"></i> 📄 Download School Brochure
                                    </a>
                                @else
                                    <a href="{{ route('login') }}?redirect={{ urlencode(url()->current()) }}" class="side-btn side-btn-light" style="text-decoration:none;">
                                        <i class="fas fa-lock text-warning me-1"></i> 🔒 Login to Download Brochure
                                    </a>
                                @endauth
                            @else
                                @auth
                                    <button type="button" class="side-btn side-btn-light" onclick="openProspectusRequestModal()">
                                        <i class="fas fa-file-signature text-primary me-1"></i> 📄 Request School Brochure
                                    </button>
                                @else
                                    <a href="{{ route('login') }}?redirect={{ urlencode(url()->current()) }}" class="side-btn side-btn-light" style="text-decoration:none;">
                                        <i class="fas fa-file-signature text-primary me-1"></i> 📄 Login to Request Brochure
                                    </a>
                                @endauth
                            @endif
                        </div>
                    </div>

                    <div class="visit-card">
                        <div class="visit-card-title"><i class="fas fa-calendar-check"></i> Book School Visit</div>
                        <p style="font-size:13px;color:#6b7280;line-height:1.7;margin-bottom:14px;">Visit the campus in Patna and interact with the admission staff before deciding.</p>

                        @auth
                            <a href="{{ route('visit.book',$school->slug) }}" class="side-btn" style="background:#0f2d59;color:#fff;text-decoration:none;">📅 Book Campus Visit</a>
                        @else
                            <a href="{{ route('login') }}" class="side-btn" style="background:#0f2d59;color:#fff;text-decoration:none;">📅 Login to Book Visit</a>
                        @endauth
                    </div>

                    <div class="enquiry-card">
                        <div class="enquiry-title"><i class="fas fa-paper-plane"></i> Quick Admission Enquiry</div>
                        <p class="enquiry-sub">Direct enquiry to {{ $school->name }}. School will call back with details.</p>
                        <button type="button" class="side-btn side-btn-light" style="margin-top:0;" onclick="openEnquiryModal()">📩 Open Enquiry Form</button>
                    </div>

                    @if($school->phone || $school->email)
                        <div class="visit-card">
                            <div class="visit-card-title"><i class="fas fa-phone"></i> Contact School</div>

                            @if($school->phone)
                                <a href="tel:{{ $school->phone }}" class="contact-link">
                                    <span style="background:#eff6ff;color:#2563eb;"><i class="fas fa-phone"></i></span>
                                    {{ $school->phone }}
                                </a>
                            @endif

                            @if($school->email)
                                <a href="mailto:{{ $school->email }}" class="contact-link">
                                    <span style="background:#fff1f2;color:#e11d48;"><i class="fas fa-envelope"></i></span>
                                    {{ $school->email }}
                                </a>
                            @endif
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

{{-- ENQUIRY MODAL (WITH 2-CLICK AUTOFILL) --}}
<div class="modal fade" id="enquiryModal" tabindex="-1" aria-hidden="true" style="background:rgba(15,23,42,.65);display:none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border:none;border-radius:18px;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,0.3);">
            <div style="background:#0f2d59;color:#fff;padding:16px 18px;display:flex;align-items:center;justify-content:space-between;">
                <div style="font-size:16px;font-weight:900;">📩 Enquiry for {{ Str::limit($school->name, 28) }}</div>
                <button type="button" onclick="closeEnquiryModal()" style="background:transparent;border:none;color:#fff;font-size:24px;line-height:1;cursor:pointer;">&times;</button>
            </div>
            <div style="padding:20px;background:#fff;">
                <form action="{{ route('enquiry.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="school_id" value="{{ $school->id }}">

                    @auth
                        {{-- Logged in parent info --}}
                        <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:10px 14px;margin-bottom:16px;display:flex;align-items:center;gap:10px;">
                            <div style="width:34px;height:34px;border-radius:50%;background:#16a34a;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:900;font-size:14px;flex-shrink:0;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight:800;color:#0f2d59;font-size:13.5px;">{{ auth()->user()->name }}</div>
                                <div style="font-size:11.5px;color:#64748b;">{{ auth()->user()->email }} • {{ auth()->user()->phone ?? 'Contact attached' }}</div>
                            </div>
                        </div>
                        <input type="hidden" name="parent_name" value="{{ auth()->user()->name }}">
                        <input type="hidden" name="phone" value="{{ auth()->user()->phone ?? '9876543210' }}">
                    @else
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label-sm">Parent Name *</label>
                                <input type="text" name="parent_name" class="form-ctrl" required placeholder="e.g. Ramesh Kumar">
                            </div>
                            <div class="col-6">
                                <label class="form-label-sm">Mobile Number *</label>
                                <input type="tel" name="phone" class="form-ctrl" required placeholder="e.g. 9876543210">
                            </div>
                        </div>
                    @endauth

                    <label class="form-label-sm">Target Class *</label>
                    <select name="child_class" class="form-ctrl" required>
                        <option value="">Select Class (1 to 12)</option>
                        @for($i = max(1, (int)($school->class_from ?? 1)); $i <= min(12, (int)($school->class_to ?? 12)); $i++)
                            <option value="Class {{ $i }}">Class {{ $i }}</option>
                        @endfor
                    </select>

                    <label class="form-label-sm" style="margin-top:12px;">Specific Questions / Message (Optional)</label>
                    <textarea name="message" class="form-ctrl" rows="3" placeholder="Ask about admission open dates, transport routes, fee payment plans..."></textarea>

                    <button type="submit" class="btn-submit" style="margin-top:16px;background:#0f2d59;font-weight:800;">
                        <i class="fa-solid fa-paper-plane me-1"></i> Submit Free Enquiry →
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- PROSPECTUS REQUEST MODAL --}}
<div class="modal fade" id="prospectusModal" tabindex="-1" aria-hidden="true" style="background:rgba(15,23,42,.65);display:none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border:none;border-radius:18px;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,0.3);">
            <div style="background:#0f2d59;color:#fff;padding:16px 18px;display:flex;align-items:center;justify-content:space-between;">
                <div style="font-size:16px;font-weight:900;">📄 Request School Brochure</div>
                <button type="button" onclick="closeProspectusRequestModal()" style="background:transparent;border:none;color:#fff;font-size:24px;line-height:1;cursor:pointer;">&times;</button>
            </div>
            <div style="padding:20px;background:#fff;">
                <p style="font-size:13px; color:#64748b; margin-bottom:16px;">
                    Request the official admission brochure and transparent fee schedule directly from <strong>{{ $school->name }}</strong>.
                </p>
                <form action="{{ route('enquiry.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="school_id" value="{{ $school->id }}">
                    <input type="hidden" name="child_class" value="Admission Brochure Request">
                    <input type="hidden" name="message" value="Parent requested the official 2026-27 admission brochure and transparent fee schedule for {{ $school->name }}.">

                    @auth
                    <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:10px 14px;margin-bottom:16px;display:flex;align-items:center;gap:10px;">
                        <div style="width:34px;height:34px;border-radius:50%;background:#16a34a;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:900;font-size:14px;flex-shrink:0;">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-size:13px;font-weight:800;color:#14532d;">{{ auth()->user()->name }}</div>
                            <div style="font-size:11px;color:#16a34a;">Verified Parent Account • {{ auth()->user()->email }}</div>
                        </div>
                    </div>
                    <div style="margin-bottom:14px;">
                        <label class="form-label-sm">Contact Number to Receive Brochure *</label>
                        <input type="tel" name="phone" value="{{ auth()->user()->phone }}" class="form-ctrl" placeholder="10-digit WhatsApp/mobile number" required>
                    </div>
                    @endauth

                    <button type="submit" class="btn-submit" style="background:#0f2d59; color:#fff; border-radius:10px; padding:12px; font-weight:800; font-size:14px; width:100%; border:none; cursor:pointer;">
                        🚀 Send Brochure Request to School
                    </button>
                    <p class="trust-note" style="margin-top:10px; font-size:11px; color:#64748b; text-align:center;">
                        🔒 Your request will be directly delivered to the school's partner console.
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true" style="background:rgba(2,6,23,.82);display:none;">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content" style="background:#0f172a;border:none;border-radius:18px;overflow:hidden;">
            <div style="padding:14px 16px;color:#fff;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid rgba(255,255,255,.08);">
                <div style="font-size:16px;font-weight:900;">{{ $school->name }} – Campus Photos</div>
                <button type="button" onclick="closeGalleryModal()" style="background:transparent;border:none;color:#fff;font-size:20px;">&times;</button>
            </div>
            <div style="padding:16px;">
                <div class="row g-3">
                    @foreach($gallery as $slot => $img)
                        <div class="col-md-4">
                            <div style="border-radius:14px;overflow:hidden;background:#111827;position:relative;">
                                <img src="{{ $img }}" alt="{{ $school->name }}" style="width:100%;height:240px;object-fit:cover;display:block;">
                                <span style="position:absolute;bottom:10px;left:10px;background:rgba(0,0,0,0.8);color:#fff;font-size:11px;font-weight:700;padding:4px 10px;border-radius:6px;">
                                    {{ match($slot) { 'main' => '🏫 Main Campus Hero', 'classroom' => '📚 Classrooms & Smartboards', 'activity' => '⚽ Sports & Playground', 'laboratory' => '🔬 Science & Computer Labs', 'facilities' => '📖 Library & Facilities', 'campus' => '🏛️ Auditorium & Campus', default => ucfirst($slot) } }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleSave(schoolId) {
    const btn = document.getElementById('saveBtn');
    const icon = document.getElementById('saveIcon');
    const text = document.getElementById('saveText');
    if (!btn) return;

    const isSaved = btn.classList.contains('saved');
    btn.disabled = true;
    btn.style.opacity = '.7';

    fetch(`/schools/${schoolId}/save`, {
        method: isSaved ? 'DELETE' : 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(r => {
        if (r.status === 401) {
            location.href = '/login';
            return null;
        }
        return r.json();
    })
    .then(data => {
        if (!data) return;
        btn.disabled = false;
        btn.style.opacity = '1';

        if (data.saved) {
            btn.classList.add('saved');
            icon.textContent = '❤️';
            text.textContent = 'Saved';
        } else {
            btn.classList.remove('saved');
            icon.textContent = '🤍';
            text.textContent = 'Save';
        }
    })
    .catch(() => {
        btn.disabled = false;
        btn.style.opacity = '1';
    });
}

function toggleCompare(id){
    const btn = document.getElementById('cmpBtn');
    try{
        let list = JSON.parse(sessionStorage.getItem('sm_compare_v2') || '[]');
        const exists = list.find(i => i.id == id);

        if(exists){
            list = list.filter(i => i.id != id);
            btn.textContent = '⚖️ Compare';
            btn.style.background = '#fff';
            btn.style.color = '#0f2d59';
        }else{
            if(list.length >= 3){
                alert('Maximum 3 schools compare kar sakte ho.');
                return;
            }
            list.push({
                id: id,
                name: btn.dataset.name,
                slug: btn.dataset.slug,
                board: btn.dataset.board,
                fee: btn.dataset.fee
            });
            btn.textContent = '✅ Added';
            btn.style.background = '#0f2d59';
            btn.style.color = '#fff';
        }

        sessionStorage.setItem('sm_compare_v2', JSON.stringify(list));
    }catch(e){}
}

function openEnquiryModal(){
    const modal = document.getElementById('enquiryModal');
    modal.style.display = 'block';
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeEnquiryModal(){
    const modal = document.getElementById('enquiryModal');
    modal.style.display = 'none';
    modal.classList.remove('show');
    document.body.style.overflow = '';
}

function openProspectusRequestModal(){
    const modal = document.getElementById('prospectusModal');
    if (modal) {
        modal.style.display = 'block';
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }
}

function closeProspectusRequestModal(){
    const modal = document.getElementById('prospectusModal');
    if (modal) {
        modal.style.display = 'none';
        modal.classList.remove('show');
        document.body.style.overflow = '';
    }
}

function openGalleryModal(){
    const modal = document.getElementById('galleryModal');
    modal.style.display = 'block';
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeGalleryModal(){
    const modal = document.getElementById('galleryModal');
    modal.style.display = 'none';
    modal.classList.remove('show');
    document.body.style.overflow = '';
}

document.addEventListener('DOMContentLoaded', function(){
    const cmpBtn = document.getElementById('cmpBtn');
    try{
        const list = JSON.parse(sessionStorage.getItem('sm_compare_v2') || '[]');
        if(cmpBtn && list.find(s => s.id == {{ $school->id }})){
            cmpBtn.textContent = '✅ Added';
            cmpBtn.style.background = '#0f2d59';
            cmpBtn.style.color = '#fff';
        }
    }catch(e){}

    document.querySelectorAll('#enquiryModal, #prospectusModal, #galleryModal').forEach(function(modal){
        modal.addEventListener('click', function(e){
            if(e.target === modal){
                modal.style.display = 'none';
                modal.classList.remove('show');
                document.body.style.overflow = '';
            }
        });
    });
});
</script>
@endpush