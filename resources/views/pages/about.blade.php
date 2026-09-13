@extends('layouts.public')

@section('title', 'About Us – SchoolMapr (Bihar\'s School Discovery Platform)')
@section('metadesc', 'Learn about SchoolMapr, Bihar\'s first transparent school discovery and admission ecosystem starting in Patna District. Empowering parents with verified school fees, curriculums, and direct visits.')
@section('keywords', 'About SchoolMapr, Patna school discovery platform, Bihar education admission portal')

@push('seo')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "AboutPage",
  "mainEntity": {
    "@type": "Organization",
    "name": "SchoolMapr",
    "url": "{{ url('/') }}",
    "logo": "{{ asset('favicon.png') }}",
    "description": "SchoolMapr is Bihar's premier school search and admission discovery platform based in Patna, connecting parents with verified schools.",
    "address": {
      "@type": "PostalAddress",
      "addressLocality": "Patna",
      "addressRegion": "Bihar",
      "addressCountry": "IN"
    }
  }
}
</script>
@endpush

@section('content')

<style>
    .page-hero{
        background:linear-gradient(135deg, #0f2d59 0%, #1a4277 100%);
        color:#fff;
        padding:54px 0 42px;
        text-align:center;
        position:relative;
    }
    .page-hero h1{
        font-size:clamp(28px, 4vw, 44px);
        font-weight:900;
        margin-bottom:12px;
    }
    .page-hero h1 span{ color:#febb02; }
    .page-hero p{
        font-size:15px;
        color:#dbeafe;
        max-width:640px;
        margin:0 auto;
        line-height:1.6;
    }
    .page-section{ padding:50px 0; }
    .content-card{
        background:#fff;
        border:1.5px solid #e8ecf4;
        border-radius:16px;
        padding:32px 28px;
        box-shadow:0 6px 24px rgba(15,45,89,0.04);
        margin-bottom:24px;
    }
    .content-card h3{
        font-size:22px;
        font-weight:900;
        color:#0f2d59;
        margin-bottom:14px;
        display:flex;
        align-items:center;
        gap:10px;
    }
    .content-card p{
        font-size:14.5px;
        color:#475569;
        line-height:1.8;
        margin-bottom:14px;
    }
    .pillar-card{
        background:#f8fafc;
        border:1.5px solid #e2e8f0;
        border-radius:12px;
        padding:22px;
        height:100%;
        transition:all .2s;
    }
    .pillar-card:hover{
        border-color:#2563eb;
        background:#fff;
        box-shadow:0 8px 24px rgba(37,99,235,0.08);
    }
    .pillar-icon{
        width:48px;
        height:48px;
        border-radius:12px;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:20px;
        margin-bottom:14px;
    }
    .pillar-card h5{
        font-size:16px;
        font-weight:800;
        color:#0f2d59;
        margin-bottom:8px;
    }
    .pillar-card p{
        font-size:13px;
        color:#64748b;
        line-height:1.6;
        margin:0;
    }
</style>

<div class="page-hero">
    <div class="container">
        <span class="badge bg-warning text-dark fw-bold px-3 py-1 mb-3" style="font-size:11.5px;">About SchoolMapr</span>
        <h1>Bihar's #1 School Discovery <span>Ecosystem</span></h1>
        <p>Bringing transparency, genuine fee insights, and direct admission convenience to parents in Patna District and beyond.</p>
    </div>
</div>

<div class="page-section">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="content-card">
                    <h3><i class="fa-solid fa-bullseye text-primary"></i> Our Mission</h3>
                    <p>
                        Choosing the right school for a child is one of the most critical decisions a family makes. In cities like Patna, parents often struggle with opaque fee structures, unverified claims, and tedious manual visits across congested city areas.
                    </p>
                    <p>
                        <strong>SchoolMapr (`schoolmapr.com`)</strong> is designed to solve this exact challenge. Inspired by modern discovery platforms like Booking.com, SchoolMapr brings verified school profiles, curriculum breakdowns (CBSE, ICSE, BSEB), real parent reviews, fee transparency, and direct campus visit booking into one unified digital experience.
                    </p>
                </div>

                <div class="content-card">
                    <h3><i class="fa-solid fa-eye text-warning"></i> Our Vision for Bihar's Education</h3>
                    <p>
                        We envision an educational landscape where every parent in Bihar has equal, barrier-free access to reliable school information regardless of locality. Starting with all key neighborhoods of Patna (Boring Road, Kankarbagh, Bailey Road, Danapur, Patliputra, Kurji, Raja Bazar, Jakariyapur, 70 Feet Road), SchoolMapr is expanding to cover Gaya, Muzaffarpur, Bhagalpur, and other educational hubs across Bihar.
                    </p>
                </div>

                <div class="content-card">
                    <h3><i class="fa-solid fa-shield-halved text-success"></i> 4 Core Pillars of SchoolMapr</h3>
                    <div class="row g-3 mt-1">
                        <div class="col-sm-6">
                            <div class="pillar-card">
                                <div class="pillar-icon" style="background:#eff6ff;color:#2563eb;"><i class="fa-solid fa-lock-open"></i></div>
                                <h5>1. 100% Fee Transparency</h5>
                                <p>Authentic breakdown of annual tuition, admission fees, and transport costs without hidden surcharges.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="pillar-card">
                                <div class="pillar-icon" style="background:#f0fdf4;color:#16a34a;"><i class="fa-solid fa-circle-check"></i></div>
                                <h5>2. Verified School Profiles</h5>
                                <p>Every listed school is physically verified for affiliation numbers, campus infrastructure, and facilities.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="pillar-card">
                                <div class="pillar-icon" style="background:#fefce8;color:#ca8a04;"><i class="fa-solid fa-calendar-days"></i></div>
                                <h5>3. 1-Click Campus Visit</h5>
                                <p>Parents can schedule physical walk-ins and counsellor interactions online with instant confirmation.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="pillar-card">
                                <div class="pillar-icon" style="background:#fee2e2;color:#dc2626;"><i class="fa-solid fa-scale-balanced"></i></div>
                                <h5>4. Free for All Parents</h5>
                                <p>Zero platform fees, zero commissions. Unrestricted search and comparison for every family.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="content-card p-4">
                    <h4 class="fw-bold mb-3" style="color:#0f2d59;font-size:18px;">📍 Key Facts</h4>
                    <ul class="list-unstyled mb-0" style="font-size:13.5px;color:#475569;line-height:2.2;">
                        <li><strong>Platform Name:</strong> SchoolMapr</li>
                        <li><strong>Domain:</strong> schoolmapr.com</li>
                        <li><strong>Primary District:</strong> Patna, Bihar</li>
                        <li><strong>Target Boards:</strong> CBSE, ICSE, State Board</li>
                        <li><strong>Platform Access:</strong> 100% Free for Parents</li>
                        <li><strong>Helpline Support:</strong> <a href="tel:+918893112323" style="color:#0f2d59;font-weight:700;text-decoration:none;">+91 88931 12323</a></li>
                        <li><strong>Support Email:</strong> contact@schoolmapr.com</li>
                    </ul>
                    <hr>
                    <a href="{{ url('/') }}" class="btn btn-primary fw-bold w-100 py-2" style="border-radius:8px;font-size:13px;">
                        <i class="fa-solid fa-location-arrow me-1"></i> Browse Patna Schools
                    </a>
                </div>

                <div class="content-card p-4 text-center" style="background:#0f2d59;color:#fff;">
                    <h5 class="fw-bold mb-2">Are you a School Owner?</h5>
                    <p class="small text-white-50 mb-3">Partner with SchoolMapr to list your school and connect directly with thousands of verified parents.</p>
                    <a href="{{ route('school-owner.register') }}" class="btn btn-warning fw-bold w-100 py-2" style="border-radius:8px;font-size:13px;color:#0f2d59;">
                        List Your School for Free →
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
