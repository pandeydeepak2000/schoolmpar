# 🎓 SchoolMapr (schoolmapr.com) — Enterprise School Discovery & Direct Admission SaaS Platform

> **"Find, Compare, Request Prospectuses & Apply to Top Verified Schools in Patna District, Bihar"**  
> SchoolMapr is a modern, high-converting educational marketplace connecting families with verified schools. Built on **Booking.com & NoPaperForms principles** — featuring transparent gated fee structures, campus visit scheduling, instant official prospectus downloads/requests, online admission application workflows, direct Razorpay fee settlements, and 360° parent CRM dossiers.

---

## 🏗️ 1. Technology Stack & Core Architecture

| Layer | Technologies Used | Description |
|---|---|---|
| **Framework & Engine** | **Laravel 12.x** (PHP 8.2+) | MVC architecture, Service Providers, Eloquent ORM, Custom Form Requests |
| **Authentication & RBAC** | **Spatie Laravel-Permission 6.x** + **Laravel Socialite 5.x** | Multi-guard RBAC (`admin`, `school_owner`, `parent`), Google OAuth 2.0, 2FA Two-Factor Authentication |
| **Payment Gateway** | **Razorpay Official PHP SDK 2.9+** | Dynamic Database-backed Test/Live mode toggle, HMAC-SHA256 signature verification, automated token fee collection |
| **Database** | **MySQL 8.0+ / MariaDB** (XAMPP Compatible) | Guarded Schema Migrations, full foreign keys, composite indexes, soft checks |
| **Email & Notification Engine** | **Laravel Mailables + SMTP / Log** | Automated system emails dispatched from `support@schoolmapr.com` with responsive HTML templates |
| **Frontend UI/UX** | **Tailwind CSS + Vanilla CSS + FontAwesome 6 Pro** | Deep Navy corporate theme (`#0f2d59`), zero floating layout glitches, fixed sidebars, internal scroll panes |

---

## 🛡️ 2. Enterprise Security Architecture & Data Safeguards

SchoolMapr incorporates multi-layered security protocols across all public and authenticated endpoints:

1. **Strict Class Scope Guard (Class 1 to 12 Only)**:
   - Platform-wide enforcement restricting all discovery filters, inquiries, campus visit bookings, and admission applications strictly to **Classes 1 through 12**.

2. **Gated Fee Intelligence & Anti-Scraping Protection**:
   - Detailed annual tuition fees, admission charges, and transport breakdowns are visible exclusively to authenticated families, preventing automated web scrapers and competitor crawling.

3. **Multi-Factor Account Security (2FA & Password Management)**:
   - Dedicated Two-Factor Authentication toggle for both Families and School Partners.
   - Protected email integrity: Users and School Partners can manage their names, phone numbers, and passwords while registered email addresses remain locked for security auditing.

4. **Cryptographic Payment Integrity**:
   - Razorpay orders and webhook callbacks are verified against HMAC-SHA256 checksum signatures before updating database records, preventing payment tampering and replay attacks.
   - Admin-level dynamic toggle between **Sandbox / Test Mode** (`rzp_test_...`) and **Production / Live Mode** (`rzp_live_...`) with database encryption.

5. **Audit Logging & Activity Tracking**:
   - Comprehensive `ActivityLog` telemetry capturing IP addresses, browser user-agents, timestamps, and exact administrative actions across schools, leads, and fee collections.

---

## 🔄 3. End-to-End SaaS Workflows

### 🎓 A. Applicant & Student Admission Workflow
```
Explore Schools (Patna Locality / Board / Class) 
    ⬇
View Verified Profile (Faculty, Facilities, Gated Fee Details)
    ⬇
📄 Official Prospectus: Download Instant PDF (if uploaded) OR 1-Click Request Prospectus Lead
    ⬇
📅 Book Scheduled Campus Visit Tour (Select Preferred Date & Time Slot)
    ⬇
📝 Apply for Online Admission (Student DOB, Academic History, Documents)
    ⬇
💳 Pay Registration Token Fee via Razorpay (UPI / Cards / NetBanking)
    ⬇
Applicant Console: Real-time Application Tracking & Downloadable PDF Receipts
```

### 🏫 B. School Partner Console Workflow
```
Register Campus / Claim Existing Listing
    ⬇
Upload 5-Angle Campus Photo Gallery & Official PDF Brochure / Prospectus
    ⬇
Inquiries & Prospectus Inbox: Respond to interested parents via WhatsApp/Call
    ⬇
Manage Visit Requests: Confirm, Reschedule, or Complete Parent Campus Tours
    ⬇
Review Admission Applications: Change status to 'In Review', 'Approved', or 'Rejected'
    ⬇
Fee Collections Ledger: Inspect live Razorpay token settlement records per student
```

### 👑 C. Super Admin Master Console Workflow
```
Review & Approve / Reject New School Listings
    ⬇
🏫 360° Parent Leads Dossier: View unified Admissions, Visits, Inquiries, and Collections
    ⬇
📥 1-Click CSV Export: Export complete parent contact lists for school follow-ups
    ⬇
⚙️ Gateway Settings: Switch Razorpay between Live & Test mode and update API keys dynamically
    ⬇
Activity Log Desk & User Management: Monitor administrative actions and ban/unban accounts
```

---

## ⚙️ 4. Quick Installation & XAMPP MySQL Setup

### 1. Prerequisites
- **PHP** >= 8.2 with `pdo_mysql`, `curl`, `mbstring`, `openssl` extensions enabled
- **Composer** >= 2.x
- **MySQL / MariaDB** (via XAMPP)

### 2. Configure `.env`
Create or update your `.env` file in the root directory:
```env
APP_NAME=SchoolMapr
APP_ENV=local
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=schoolmate
DB_USERNAME=root
DB_PASSWORD=

# ── Mail Configuration (support@schoolmapr.com) ──
MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="support@schoolmapr.com"
MAIL_FROM_NAME="SchoolMapr Support"

# ── Google OAuth 2.0 Credentials ──
GOOGLE_CLIENT_ID=your_google_client_id_here
GOOGLE_CLIENT_SECRET=your_google_client_secret_here
GOOGLE_REDIRECT_URI="${APP_URL}/auth/google/callback"

# ── Razorpay Gateway (Configurable also in Admin Panel) ──
RAZORPAY_KEY=rzp_test_sample
RAZORPAY_SECRET=sample_secret
```

### 3. Safe Migration, Storage & Seeding Commands
Run these commands in your terminal:

```bash
# 1. Run migrations safely (uses guarded schema checks)
php artisan migrate

# 2. Link public storage directory for school photos & PDF brochures
php artisan storage:link

# 3. Seed Patna's top verified schools, sample leads & demo accounts
php artisan db:seed --class=PatnaSchoolsSeeder

# 4. Clear all caches for fresh configuration
php artisan optimize:clear

# 5. Start the local development server
php artisan serve
```

Access the application in your browser at: **`http://127.0.0.1:8000`**

---

## 🔐 5. Default Test Accounts & Access Credentials

| Portal | Email | Password | Access & Capabilities |
|---|---|---|---|
| **Super Admin Console** | `admin@schoolmapr.com` | `admin123` | Master control: 360° Leads CRM, Gateway toggle, School approvals |
| **School Partner Portal** | `owner@schoolmapr.com` | `owner123` | Partner dashboard: Manage campus listings, leads, visits & fee records |
| **Applicant & Student Portal** | `parent@schoolmapr.com` | `parent123` | Applicant console: Unlock fee gating, apply online, 2FA security |

---

## 📍 6. Real Patna Geographic Coverage

Pre-loaded with verified top schools across Patna's premier educational hubs:
- **Bailey Road / Danapur**: Delhi Public School (DPS Patna), St. Karen's High School
- **Kurji / Digha**: St. Michael's High School, Don Bosco Academy
- **Patliputra Colony**: Notre Dame Academy
- **Boring Road / Raja Bazar**: St. Dominic Savio's High School, B.D. Public School
- **Gandhi Maidan / Ashok Rajpath**: St. Xavier's High School, St. Joseph's Convent High School
- **Kankarbagh / Rajendra Nagar**: DAV Public School, Kendriya Vidyalaya Kankarbagh

---

## 📄 7. License & Support

- **Developer / Organization**: SchoolMapr Team
- **Official Inquiries**: [support@schoolmapr.com](mailto:support@schoolmapr.com)
- **Geographic Focus**: Patna District, Bihar, India
