@extends('layouts.public')

@section('title', 'Privacy Policy – SchoolMapr')
@section('metadesc', 'Privacy Policy for SchoolMapr (schoolmapr.com). Learn how we protect parent information, student data, and school partner details in Bihar.')

@section('content')

<style>
    .page-hero{
        background:linear-gradient(135deg, #0f2d59 0%, #1a4277 100%);
        color:#fff;
        padding:48px 0 36px;
        text-align:center;
    }
    .page-hero h1{
        font-size:clamp(26px, 3.8vw, 38px);
        font-weight:900;
        margin-bottom:8px;
    }
    .page-hero p{ font-size:14px; color:#dbeafe; }
    .page-section{ padding:44px 0; }
    .legal-card{
        background:#fff;
        border:1.5px solid #e8ecf4;
        border-radius:16px;
        padding:34px 28px;
        box-shadow:0 6px 24px rgba(15,45,89,0.04);
    }
    .legal-card h2{
        font-size:20px;
        font-weight:800;
        color:#0f2d59;
        margin-top:28px;
        margin-bottom:12px;
    }
    .legal-card h2:first-child{ margin-top:0; }
    .legal-card p{
        font-size:14px;
        color:#475569;
        line-height:1.8;
        margin-bottom:14px;
    }
    .legal-card ul{
        font-size:14px;
        color:#475569;
        line-height:1.8;
        margin-bottom:16px;
        padding-left:20px;
    }
</style>

<div class="page-hero">
    <div class="container">
        <h1>Privacy Policy</h1>
        <p>Last updated: August 2026 • Effective for all SchoolMapr (`schoolmapr.com`) users</p>
    </div>
</div>

<div class="page-section">
    <div class="container" style="max-width:900px;">
        <div class="legal-card">
            <h2>1. Introduction & Scope</h2>
            <p>
                Welcome to <strong>SchoolMapr</strong> (operating at <code>schoolmapr.com</code>). We are committed to safeguarding the privacy of parents, guardians, students, and school administrators who use our portal for school discovery, fee analysis, campus visit bookings, and admission enquiries.
            </p>

            <h2>2. Information We Collect</h2>
            <p>We only collect data necessary to provide a smooth, transparent admission discovery experience:</p>
            <ul>
                <li><strong>Parent & User Information:</strong> Name, mobile number, email address, child's target class, and residential locality.</li>
                <li><strong>Google Sign-In Data:</strong> Profile name, email address, and verified avatar when you choose to log in using Google OAuth.</li>
                <li><strong>School Partner Information:</strong> School official name, affiliation documents, fee schedule, campus photos, administrator phone, and official email.</li>
                <li><strong>Technical Logs:</strong> IP address, device type, and basic analytics to prevent automated bot scraping of school fees.</li>
            </ul>

            <h2>3. How We Use Your Information</h2>
            <p>Your data is used strictly for legitimate educational services:</p>
            <ul>
                <li>To display transparent fee breakdowns and comparisons to registered parents.</li>
                <li>To transmit your admission enquiry directly to the authorized admission team of the selected school.</li>
                <li>To schedule and confirm your physical campus visit.</li>
                <li>To send transactional updates regarding your enquiry status and visit reminders.</li>
            </ul>

            <h2>4. Fee Protection & Anti-Scraping Policy</h2>
            <p>
                SchoolMapr gates detailed fee breakdowns behind user authentication to protect educational institutions from competitor scraping and automated commercial harvesting. We do not sell parent contact information to third-party telemarketers or loan agencies.
            </p>

            <h2>5. Data Sharing with Schools</h2>
            <p>
                When a parent explicitly submits an <strong>Admission Enquiry</strong> or books a <strong>Campus Visit</strong>, only the submitted details (Parent Name, Contact Number, Target Class, and Message) are shared with the respective school's administration to enable their counselling team to follow up.
            </p>

            <h2>6. Data Security & Storage</h2>
            <p>
                We use industry-standard encryption, secure session storage, and salted password hashing (Bcrypt). Your account password is never stored in plain text.
            </p>

            <h2>7. Contact & Grievance Officer</h2>
            <p>
                For any questions, data modification requests, or privacy concerns, please contact our support desk in Patna:
                <br><strong>Helpline:</strong> <a href="tel:+918893112323" style="color:inherit;font-weight:700;text-decoration:none;">+91 88931 12323</a>
                <br><strong>Email:</strong> privacy@schoolmapr.com / contact@schoolmapr.com
                <br><strong>Address:</strong> Boring Road Crossing, Patna District, Bihar 800001
            </p>
        </div>
    </div>
</div>

@endsection
