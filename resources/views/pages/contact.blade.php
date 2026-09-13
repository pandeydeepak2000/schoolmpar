@extends('layouts.public')

@section('title', 'Contact Us – SchoolMapr (Patna Support Desk)')
@section('metadesc', 'Get in touch with SchoolMapr support team in Patna, Bihar. School listings support, parent admission enquiries, and partnership queries.')
@section('keywords', 'Contact SchoolMapr, Patna school support, SchoolMapr phone number, Bihar school admissions helpline')

@push('seo')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "ContactPage",
  "mainEntity": {
    "@type": "Organization",
    "name": "SchoolMapr",
    "url": "{{ url('/') }}",
    "telephone": "+91-9876543210",
    "email": "support@schoolmapr.com",
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "Bailey Road / Boring Road Hub",
      "addressLocality": "Patna",
      "addressRegion": "Bihar",
      "postalCode": "800001",
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
        max-width:600px;
        margin:0 auto;
        line-height:1.6;
    }
    .page-section{ padding:50px 0; }
    .contact-card{
        background:#fff;
        border:1.5px solid #e8ecf4;
        border-radius:16px;
        padding:32px 28px;
        box-shadow:0 6px 24px rgba(15,45,89,0.04);
        height:100%;
    }
    .contact-card h3{
        font-size:22px;
        font-weight:900;
        color:#0f2d59;
        margin-bottom:16px;
    }
    .contact-info-item{
        display:flex;
        align-items:flex-start;
        gap:14px;
        margin-bottom:20px;
    }
    .contact-info-icon{
        width:42px;
        height:42px;
        border-radius:10px;
        background:#eff6ff;
        color:#2563eb;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:17px;
        flex-shrink:0;
    }
    .contact-info-text h6{
        font-size:14px;
        font-weight:800;
        color:#0f2d59;
        margin-bottom:2px;
    }
    .contact-info-text p{
        font-size:13.5px;
        color:#64748b;
        margin:0;
        line-height:1.5;
    }
    .form-label{
        font-size:13px;
        font-weight:700;
        color:#1e293b;
        margin-bottom:6px;
    }
    .form-control, .form-select{
        border:1.5px solid #cbd5e1;
        border-radius:8px;
        padding:10px 14px;
        font-size:13.5px;
        outline:none;
    }
    .form-control:focus, .form-select:focus{
        border-color:#0f2d59;
        box-shadow:0 0 0 3px rgba(15,45,89,0.08);
    }
</style>

<div class="page-hero">
    <div class="container">
        <span class="badge bg-warning text-dark fw-bold px-3 py-1 mb-3" style="font-size:11.5px;">Contact Support</span>
        <h1>We are here to <span>Help You</span></h1>
        <p>Have questions about admissions in Patna or wish to partner your school with SchoolMapr? Reach out to us anytime.</p>
    </div>
</div>

<div class="page-section">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-5">
                <div class="contact-card">
                    <h3>Contact Information</h3>
                    <p class="text-muted small mb-4">Our dedicated parent and school partner support team operates in Patna to assist you.</p>

                    <div class="contact-info-item">
                        <div class="contact-info-icon"><i class="fa-solid fa-location-dot"></i></div>
                        <div class="contact-info-text">
                            <h6>Head Office Address</h6>
                            <p>Boring Road Crossing, Patna District, Bihar 800001, India</p>
                        </div>
                    </div>

                    <div class="contact-info-item">
                        <div class="contact-info-icon"><i class="fa-solid fa-phone"></i></div>
                        <div class="contact-info-text">
                            <h6>Helpline Number</h6>
                            <p><a href="tel:+918893112323" style="color:inherit;text-decoration:none;font-weight:700;">+91 88931 12323</a> (Mon–Sat: 9:00 AM – 6:00 PM)</p>
                        </div>
                    </div>

                    <div class="contact-info-item">
                        <div class="contact-info-icon"><i class="fa-solid fa-envelope"></i></div>
                        <div class="contact-info-text">
                            <h6>Official Email</h6>
                            <p>contact@schoolmapr.com / support@schoolmapr.com</p>
                        </div>
                    </div>

                    <div class="contact-info-item">
                        <div class="contact-info-icon"><i class="fa-solid fa-globe"></i></div>
                        <div class="contact-info-text">
                            <h6>Official Portal</h6>
                            <p>https://schoolmapr.com</p>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="p-3 bg-light rounded-3 border">
                        <h6 class="fw-bold mb-1" style="font-size:13px;color:#0f2d59;">🚀 School Partnership Queries?</h6>
                        <p class="small text-muted mb-2">School principals and trustees can register directly on the partner portal.</p>
                        <a href="{{ route('school-owner.register') }}" class="btn btn-sm btn-outline-primary fw-bold">
                            List Your School for Free →
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="contact-card">
                    <h3>Send Us a Message</h3>
                    <p class="text-muted small mb-4">Fill in your inquiry details below and our team will get back to you within 24 hours.</p>

                    <form action="{{ route('pages.contact.send') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name *</label>
                                <input type="text" name="name" class="form-control" placeholder="e.g. Ramesh Kumar" required value="{{ Auth::check() ? Auth::user()->name : '' }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Phone Number *</label>
                                <input type="tel" name="phone" class="form-control" placeholder="e.g. 9876543210" required value="{{ Auth::check() ? Auth::user()->phone : '' }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email Address *</label>
                                <input type="email" name="email" class="form-control" placeholder="e.g. ramesh@gmail.com" required value="{{ Auth::check() ? Auth::user()->email : '' }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Topic / Subject *</label>
                                <select name="subject" class="form-select" required>
                                    <option value="">Select Topic</option>
                                    <option value="Admission Query">Admission / School Query</option>
                                    <option value="Campus Visit Help">Campus Visit Assistance</option>
                                    <option value="School Partner Listing">List / Claim School Listing</option>
                                    <option value="Feedback / Suggestion">Feedback / Bug Report</option>
                                    <option value="Other">Other Query</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Your Message *</label>
                                <textarea name="message" class="form-control" rows="5" placeholder="Write your questions or feedback in detail..." required></textarea>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary fw-bold px-4 py-2" style="background:#0f2d59;border:none;border-radius:8px;font-size:14px;">
                                    <i class="fa-solid fa-paper-plane me-1"></i> Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
