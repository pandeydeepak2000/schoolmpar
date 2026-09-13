@extends('layouts.public')

@section('title', 'Terms & Conditions – SchoolMapr')
@section('metadesc', 'Terms and Conditions of service for SchoolMapr (schoolmapr.com). Rules for parents, students, and school partners in Patna, Bihar.')

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
        <h1>Terms & Conditions</h1>
        <p>Last updated: August 2026 • Governing use of SchoolMapr (`schoolmapr.com`)</p>
    </div>
</div>

<div class="page-section">
    <div class="container" style="max-width:900px;">
        <div class="legal-card">
            <h2>1. Acceptance of Terms</h2>
            <p>
                By accessing or registering on <strong>SchoolMapr</strong> (accessible via <code>https://schoolmapr.com</code>), you agree to be bound by these Terms and Conditions. If you disagree with any portion of these terms, you should discontinue use of the platform.
            </p>

            <h2>2. 100% Free Service for Parents</h2>
            <p>
                SchoolMapr provides school directory search, fee structure comparisons, campus visit booking, and direct admission enquiry transmission <strong>completely free of charge</strong> to parents, guardians, and students. SchoolMapr does not charge parents any booking fees or registration surcharges.
            </p>

            <h2>3. School Information & Fee Accuracy</h2>
            <p>
                While SchoolMapr takes reasonable measures to verify school details, curriculum affiliations (CBSE, ICSE, BSEB, IB), and fee ranges provided by institutions in Patna District, official admission terms, seat confirmations, and final fee receipts remain subject to the respective school management's discretion.
            </p>

            <h2>4. User Account & Conduct</h2>
            <ul>
                <li>Parents agree to provide accurate and authentic contact details (name and phone number) when submitting admission enquiries or visit requests.</li>
                <li>Users shall not engage in automated scraping, data extraction, or denial-of-service attacks against the portal.</li>
                <li>School partners agree to upload authentic campus imagery, truthful fee ranges, and genuine contact numbers.</li>
            </ul>

            <h2>5. Campus Visit & Direct Admissions</h2>
            <p>
                Scheduling a campus visit on SchoolMapr coordinates an appointment between the parent and the school. Final admission eligibility, entrance assessments (if applicable), and document verification remain the direct responsibility of the respective school.
            </p>

            <h2>6. Intellectual Property</h2>
            <p>
                All brand marks, design assets, database structures, and platform code associated with <strong>SchoolMapr</strong> are the exclusive property of SchoolMapr. School logos and trademarks remain the intellectual property of their respective institutions.
            </p>

            <h2>7. Governing Law & Jurisdiction</h2>
            <p>
                These terms shall be governed by and construed in accordance with the laws of India, and disputes shall be subject to the exclusive jurisdiction of the competent courts in <strong>Patna, Bihar</strong>.
            </p>
        </div>
    </div>
</div>

@endsection
