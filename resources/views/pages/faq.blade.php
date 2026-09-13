@extends('layouts.public')

@section('title', 'Parent Help Center & FAQs – SchoolMapr')
@section('metadesc', 'Frequently Asked Questions about Patna school admissions, fee structures, campus visits, CBSE/ICSE curriculum selection, and SchoolMapr.')
@section('keywords', 'SchoolMapr FAQ, Patna school admission queries, school fees Patna FAQ, how to choose school Patna')

@push('seo')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "Is SchoolMapr completely free for parents?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes, SchoolMapr is 100% free for parents, guardians, and students. You can search schools, view verified fee ranges, compare schools side-by-side, book physical campus visits, and submit direct admission enquiries without paying any fee."
      }
    },
    {
      "@type": "Question",
      "name": "Why is school fee information protected behind login?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "We gate detailed annual tuition, admission fees, and transport fee schedules behind user authentication to prevent automated scraping by competitors and bots. Signing in with Google or creating a free parent account instantly unlocks all fees across every school."
      }
    },
    {
      "@type": "Question",
      "name": "Which areas of Patna District are covered on SchoolMapr?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "We cover all major residential and commercial localities across Patna District including Boring Road, Kankarbagh, Bailey Road, Danapur Cantt, Saguna More, Patliputra Colony, Kurji, Digha, Raja Bazar, Ashiana Nagar, Jakariyapur, 70 Feet Road, Rajendra Nagar, and Gandhi Maidan."
      }
    },
    {
      "@type": "Question",
      "name": "How does Campus Visit Booking work?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "On any school profile page, click 'Book Campus Visit'. Select your preferred date and time slot. The school's admission team receives the request immediately to arrange a campus tour, classroom inspection, and counselling session."
      }
    },
    {
      "@type": "Question",
      "name": "How does the 2-Click Direct Admission Enquiry work?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "When you are logged into your parent account, your name, mobile number, and email are automatically autofilled in the enquiry form. You only need to pick your child's target class and type your message."
      }
    },
    {
      "@type": "Question",
      "name": "How can a school partner list or update their profile on SchoolMapr?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "School principals and owners can click 'List Your School for Free' in the footer or visit the Partner Portal to claim their school profile, update fee structures, upload campus photos, and respond to parent leads."
      }
    }
  ]
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
    }
    .page-hero h1{
        font-size:clamp(28px, 4vw, 44px);
        font-weight:900;
        margin-bottom:10px;
    }
    .page-hero h1 span{ color:#febb02; }
    .page-hero p{ font-size:15px; color:#dbeafe; max-width:600px; margin:0 auto; }
    .page-section{ padding:48px 0; }
    .faq-item{
        background:#fff;
        border:1.5px solid #e8ecf4;
        border-radius:12px;
        margin-bottom:12px;
        overflow:hidden;
        box-shadow:0 2px 8px rgba(0,0,0,0.02);
    }
    .faq-btn{
        width:100%;
        background:none;
        border:none;
        padding:16px 20px;
        text-align:left;
        font-size:15px;
        font-weight:800;
        color:#0f2d59;
        display:flex;
        align-items:center;
        justify-content:space-between;
        cursor:pointer;
        gap:10px;
    }
    .faq-body{
        padding:0 20px 18px;
        font-size:14px;
        color:#475569;
        line-height:1.7;
    }
</style>

<div class="page-hero">
    <div class="container">
        <span class="badge bg-warning text-dark fw-bold px-3 py-1 mb-3" style="font-size:11.5px;">Parent Help Center</span>
        <h1>Frequently Asked <span>Questions</span></h1>
        <p>Everything you need to know about school admissions in Patna District and using SchoolMapr.</p>
    </div>
</div>

<div class="page-section" x-data="{ active: 1 }">
    <div class="container" style="max-width:880px;">

        <div class="faq-item">
            <button type="button" class="faq-btn" @click="active = (active === 1 ? null : 1)">
                <span>1. Is SchoolMapr completely free for parents?</span>
                <i class="fa-solid" :class="active === 1 ? 'fa-chevron-up text-primary' : 'fa-chevron-down text-muted'"></i>
            </button>
            <div class="faq-body" x-show="active === 1" x-collapse>
                Yes, SchoolMapr is 100% free for parents, guardians, and students. You can search schools, view verified fee ranges, compare schools side-by-side, book physical campus visits, and submit direct admission enquiries without paying any fee.
            </div>
        </div>

        <div class="faq-item">
            <button type="button" class="faq-btn" @click="active = (active === 2 ? null : 2)">
                <span>2. Why is school fee information protected behind login?</span>
                <i class="fa-solid" :class="active === 2 ? 'fa-chevron-up text-primary' : 'fa-chevron-down text-muted'"></i>
            </button>
            <div class="faq-body" x-show="active === 2" x-collapse>
                We gate detailed annual tuition, admission fees, and transport fee schedules behind user authentication to prevent automated scraping by competitors and bots. Signing in with Google or creating a free parent account instantly unlocks all fees across every school.
            </div>
        </div>

        <div class="faq-item">
            <button type="button" class="faq-btn" @click="active = (active === 3 ? null : 3)">
                <span>3. Which areas of Patna District are covered on SchoolMapr?</span>
                <i class="fa-solid" :class="active === 3 ? 'fa-chevron-up text-primary' : 'fa-chevron-down text-muted'"></i>
            </button>
            <div class="faq-body" x-show="active === 3" x-collapse>
                We cover all major residential and commercial localities across Patna District including Boring Road, Kankarbagh, Bailey Road, Danapur Cantt, Saguna More, Patliputra Colony, Kurji, Digha, Raja Bazar, Ashiana Nagar, Jakariyapur, 70 Feet Road, Rajendra Nagar, and Gandhi Maidan.
            </div>
        </div>

        <div class="faq-item">
            <button type="button" class="faq-btn" @click="active = (active === 4 ? null : 4)">
                <span>4. How does Campus Visit Booking work?</span>
                <i class="fa-solid" :class="active === 4 ? 'fa-chevron-up text-primary' : 'fa-chevron-down text-muted'"></i>
            </button>
            <div class="faq-body" x-show="active === 4" x-collapse>
                On any school profile page, click <strong>"📅 Book Campus Visit"</strong>. Select your preferred date and time slot. The school's admission team receives the request immediately to arrange a campus tour, classroom inspection, and counselling session.
            </div>
        </div>

        <div class="faq-item">
            <button type="button" class="faq-btn" @click="active = (active === 5 ? null : 5)">
                <span>5. How does the 2-Click Direct Admission Enquiry work?</span>
                <i class="fa-solid" :class="active === 5 ? 'fa-chevron-up text-primary' : 'fa-chevron-down text-muted'"></i>
            </button>
            <div class="faq-body" x-show="active === 5" x-collapse>
                When you are logged into your parent account, your name, mobile number, and email are automatically autofilled in the enquiry form. You only need to pick your child's target class and type your message.
            </div>
        </div>

        <div class="faq-item">
            <button type="button" class="faq-btn" @click="active = (active === 6 ? null : 6)">
                <span>6. How can a school partner list or update their profile on SchoolMapr?</span>
                <i class="fa-solid" :class="active === 6 ? 'fa-chevron-up text-primary' : 'fa-chevron-down text-muted'"></i>
            </button>
            <div class="faq-body" x-show="active === 6" x-collapse>
                School principals and owners can click <strong>"List Your School for Free"</strong> in the footer or visit the Partner Portal to claim their school profile, update fee structures, upload campus photos, and respond to parent leads.
            </div>
        </div>

        <div class="text-center mt-5 p-4 bg-white rounded-4 border">
            <h5 class="fw-bold mb-1" style="color:#0f2d59;">Still have questions?</h5>
            <p class="text-muted small mb-3">Our support team in Patna is ready to assist you.</p>
            <a href="{{ route('pages.contact') }}" class="btn btn-primary fw-bold px-4 py-2" style="border-radius:8px;font-size:13.5px;">
                Contact Support Desk →
            </a>
        </div>

    </div>
</div>

@endsection
