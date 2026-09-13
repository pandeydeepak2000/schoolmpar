<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;

// Controllers
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\VisitBookingController;

// Auth & Profile
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProfileController;

// Admin
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SchoolManageController;
use App\Http\Controllers\Admin\UserManageController;
use App\Http\Controllers\Admin\SchoolCrudController;
use App\Http\Controllers\Admin\SettingsController;

// School Owner
use App\Http\Controllers\SchoolOwner\SchoolOwnerAuthController;
use App\Http\Controllers\SchoolOwner\SchoolOwnerController;
use App\Http\Controllers\SchoolOwner\EnquiryController as OwnerEnquiryController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/', [SchoolController::class, 'index'])->name('home');
Route::get('/schools/{slug}/print-summary', [SchoolController::class, 'printSummary'])->name('school.print');
Route::get('/schools/{slug}', [SchoolController::class, 'show'])->name('school.show');

Route::get('/school-data/{id}', [SchoolController::class, 'jsonById'])
     ->where('id', '[0-9]+')
     ->name('school.jsonById');

Route::get('/compare', fn() => view('schools.compare'))->name('school.compare.public');

/*
|--------------------------------------------------------------------------
| INFORMATIONAL PAGES
|--------------------------------------------------------------------------
*/
Route::view('/about', 'pages.about')->name('pages.about');
Route::view('/contact', 'pages.contact')->name('pages.contact');
Route::post('/contact', function(\Illuminate\Http\Request $request) {
    return back()->with('success', 'Thank you! Your message has been received. Our team in Patna will contact you shortly.');
})->middleware('throttle:5,1')->name('pages.contact.send');
Route::view('/privacy-policy', 'pages.privacy')->name('pages.privacy');
Route::view('/terms', 'pages.terms')->name('pages.terms');
Route::view('/faq', 'pages.faq')->name('pages.faq');

/*
|--------------------------------------------------------------------------
| ENQUIRY (Public)
|--------------------------------------------------------------------------
*/
Route::post('/enquiries', [EnquiryController::class, 'store'])
     ->middleware('throttle:enquiry')
     ->name('enquiry.store');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/register',  [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:register');
Route::post('/auth/send-otp', [AuthController::class, 'sendOtp'])
     ->middleware('throttle:otp')
     ->name('auth.sendOtp');

Route::get('/login',     [AuthController::class, 'loginForm'])->name('login');
Route::post('/login',    [AuthController::class, 'login'])->middleware('throttle:login');

Route::get('/auth/google',          [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/school-owner/register',  [SchoolOwnerAuthController::class, 'showRegister'])->name('school-owner.register');
Route::post('/school-owner/register', [SchoolOwnerAuthController::class, 'register'])
     ->middleware('throttle:register')
     ->name('school-owner.register.post');

/*
|--------------------------------------------------------------------------
| FORGOT / RESET PASSWORD
|--------------------------------------------------------------------------
*/
Route::get('/forgot-password', fn() => view('auth.forgot-password'))->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);
    $status = Password::sendResetLink($request->only('email'));
    return $status === Password::RESET_LINK_SENT
        ? back()->with('status', 'Password reset link sent!')
        : back()->withErrors(['email' => 'This email is not registered.']);
})->middleware('throttle:5,1')->name('password.email');

Route::get('/reset-password/{token}', fn(string $token) =>
    view('auth.reset-password', ['token' => $token])
)->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token'    => 'required',
        'email'    => 'required|email',
        'password' => 'required|min:6|confirmed',
    ]);
    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        fn($user, $password) => $user->forceFill(['password' => bcrypt($password)])->save()
    );
    return $status === Password::PASSWORD_RESET
        ? redirect('/login')->with('success', 'Password reset successfully!')
        : back()->withErrors(['email' => __($status)]);
})->name('password.update');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
     ->name('admin.')
     ->middleware(['auth', 'role:admin'])
     ->group(function () {

    // ── Dashboard ────────────────────────────────────────
    Route::get('/dashboard',       [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/enquiries',       [DashboardController::class, 'enquiries'])->name('enquiries');
    Route::get('/admissions',      [DashboardController::class, 'admissions'])->name('admissions');
    Route::get('/visits',          [DashboardController::class, 'visits'])->name('visits');
    Route::get('/payments',        [DashboardController::class, 'payments'])->name('payments');
    Route::get('/logs',            [DashboardController::class, 'activityLogs'])->name('logs');

    // ── Schools List (SchoolManageController) ────────────
    // ⚠️ /schools/pending PEHLE hona chahiye /schools se — warna Laravel
    //    {id} samjhega "pending" ko
    Route::get('/schools/pending', [DashboardController::class, 'pendingSchools'])->name('schools.pending');
    Route::get('/schools',         [SchoolManageController::class, 'index'])->name('schools');

    // ── Single School Manage ─────────────────────────────
    Route::get('/schools/{id}/manage',         [SchoolManageController::class, 'manage'])->name('schools.manage');
    Route::get('/schools/{id}/export-parents', [SchoolManageController::class, 'exportParents'])->name('schools.export-parents');
    Route::post('/schools/{id}/assign-owner',  [SchoolManageController::class, 'assignOwner'])->name('schools.assign-owner');

    // ── School Status Actions ────────────────────────────
    Route::patch('/schools/{id}/approve', [SchoolManageController::class, 'approve'])->name('schools.approve');
    Route::patch('/schools/{id}/reject',  [SchoolManageController::class, 'reject'])->name('schools.reject');
    Route::patch('/schools/{id}/toggle',  [SchoolManageController::class, 'toggle'])->name('schools.toggle');

    // ── Enquiry ──────────────────────────────────────────
    Route::patch('/enquiries/{id}/status',       [SchoolManageController::class, 'updateEnquiry'])->name('enquiries.status');
    Route::post('/enquiries/{id}/send-brochure', [SchoolManageController::class, 'sendBrochure'])->name('enquiries.sendBrochure');

    // ── Users ────────────────────────────────────────────
    Route::get('/users',           [UserManageController::class, 'index'])->name('users');
    Route::get('/users/create',    [UserManageController::class, 'create'])->name('users.create');
    Route::post('/users',          [UserManageController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [UserManageController::class, 'edit'])->name('users.edit');
    Route::patch('/users/{id}',    [UserManageController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}',   [UserManageController::class, 'destroy'])->name('users.destroy');

    // ── Admin: Admission Actions (no-owner schools) ──────
    Route::patch('/schools/{schoolId}/admissions/{id}/approve',
        [SchoolManageController::class, 'approveAdmission'])->name('schools.admissions.approve');
    Route::patch('/schools/{schoolId}/admissions/{id}/reject',
        [SchoolManageController::class, 'rejectAdmission'])->name('schools.admissions.reject');
    Route::patch('/schools/{schoolId}/admissions/{id}/review',
        [SchoolManageController::class, 'reviewAdmission'])->name('schools.admissions.review');

    // ── Admin: Visit Actions (no-owner schools) ──────────
    Route::patch('/schools/{schoolId}/visits/{id}/confirm',
        [SchoolManageController::class, 'confirmVisit'])->name('schools.visits.confirm');
    Route::patch('/schools/{schoolId}/visits/{id}/cancel',
        [SchoolManageController::class, 'cancelVisit'])->name('schools.visits.cancel');
    Route::patch('/schools/{schoolId}/visits/{id}/complete',
        [SchoolManageController::class, 'completeVisit'])->name('schools.visits.complete');

    // ── School CRUD (Admin add/edit school) ──────────────
    Route::resource('schools-manage', SchoolCrudController::class)
         ->names('schools.crud');

    // ── Platform Settings (Gateway, Mail Server & Captcha) ─
    Route::get('/settings',                  [SettingsController::class, 'index'])->name('settings');
    Route::match(['get', 'post'], '/settings/payments', [SettingsController::class, 'updatePayments'])->name('settings.payments.update');
    Route::match(['get', 'post'], '/settings/mail',     [SettingsController::class, 'updateMail'])->name('settings.mail.update');
    Route::post('/settings/mail/test',                  [SettingsController::class, 'sendTestMail'])->name('settings.mail.test');
    Route::match(['get', 'post'], '/settings/recaptcha',[SettingsController::class, 'updateRecaptcha'])->name('settings.recaptcha.update');
});

/*
|--------------------------------------------------------------------------
| SCHOOL OWNER ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('school-owner')
     ->name('school-owner.')
     ->middleware(['auth', 'role:school_owner'])
     ->group(function () {

    Route::get('/dashboard',  [SchoolOwnerController::class, 'dashboard'])->name('dashboard');
    Route::match(['get', 'post'], '/logout', [SchoolOwnerAuthController::class, 'logout'])->name('logout');

    Route::get('/profile',                  [ProfileController::class, 'showSchoolOwnerProfile'])->name('profile');
    Route::patch('/profile',                [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::patch('/profile/password',       [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::patch('/profile/2fa',            [ProfileController::class, 'toggleTwoFactor'])->name('two_factor.toggle');

    Route::get('/schools',           [SchoolOwnerController::class, 'index'])->name('schools.index');
    Route::get('/schools/create',    [SchoolOwnerController::class, 'create'])->name('schools.create');
    Route::post('/schools',          [SchoolOwnerController::class, 'store'])->name('schools.store');
    Route::get('/schools/{id}/edit', [SchoolOwnerController::class, 'edit'])->name('schools.edit');
    Route::put('/schools/{id}',      [SchoolOwnerController::class, 'update'])->name('schools.update');
    Route::delete('/schools/{id}',   [SchoolOwnerController::class, 'destroy'])->name('schools.destroy');

    Route::get('/enquiries',                     [OwnerEnquiryController::class, 'index'])->name('enquiries.index');
    Route::get('/enquiries/{id}',                [OwnerEnquiryController::class, 'show'])->name('enquiries.show');
    Route::patch('/enquiries/{id}/status',       [OwnerEnquiryController::class, 'updateStatus'])->name('enquiries.status');
    Route::post('/enquiries/{id}/send-brochure', [OwnerEnquiryController::class, 'sendBrochure'])->name('enquiries.sendBrochure');

    Route::get('/visits',                [VisitBookingController::class, 'schoolVisits'])->name('visits.index');
    Route::post('/visits/{id}/confirm',  [VisitBookingController::class, 'confirm'])->name('visits.confirm');
    Route::post('/visits/{id}/reject',   [VisitBookingController::class, 'reject'])->name('visits.reject');
    Route::post('/visits/{id}/complete', [VisitBookingController::class, 'complete'])->name('visits.complete');

    Route::get('/admissions',                [AdmissionController::class, 'schoolAdmissions'])->name('admissions.index');
    Route::patch('/admissions/{id}/approve', [AdmissionController::class, 'approve'])->name('admissions.approve');
    Route::patch('/admissions/{id}/reject',  [AdmissionController::class, 'reject'])->name('admissions.reject');
    Route::patch('/admissions/{id}/review',  [AdmissionController::class, 'review'])->name('admissions.review');

    Route::get('/payments',                  [SchoolOwnerController::class, 'payments'])->name('payments.index');
});

/*
|--------------------------------------------------------------------------
| PARENT / AUTH USER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard',                  [ParentController::class, 'dashboard'])->name('parent.dashboard');
    Route::get('/dashboard/profile',          [ProfileController::class, 'showParentProfile'])->name('parent.profile');
    Route::patch('/dashboard/profile',        [ProfileController::class, 'updateProfile'])->name('parent.profile.update');
    Route::patch('/dashboard/profile/password',[ProfileController::class, 'updatePassword'])->name('parent.password.update');
    Route::patch('/dashboard/profile/2fa',     [ProfileController::class, 'toggleTwoFactor'])->name('parent.two_factor.toggle');

    Route::get('/saved-schools',              [ParentController::class, 'saved'])->name('parent.saved');
    Route::get('/my-enquiries',               [ParentController::class, 'enquiries'])->name('parent.enquiries');
    Route::get('/dashboard/payments',         [ParentController::class, 'payments'])->name('parent.payments');
    Route::get('/parent/compare',             [ParentController::class, 'compare'])->name('parent.compare');

    Route::get('/admission/{id}/receipt', [AdmissionController::class, 'receipt'])->name('admission.receipt');
    Route::post('/schools/{id}/save', [SchoolController::class, 'toggleSave'])->name('school.toggleSave');

    // Visit Booking
    Route::get('/schools/{slug}/visit',           [VisitBookingController::class, 'create'])->name('visit.book');
    Route::post('/schools/{slug}/visit',          [VisitBookingController::class, 'store'])->name('visit.store');
    Route::get('/visit/{id}/confirmation',        [VisitBookingController::class, 'confirmation'])->name('visit.confirmation');
    Route::get('/dashboard/visits',               [VisitBookingController::class, 'myVisits'])->name('dashboard.visits');
    Route::post('/dashboard/visits/{id}/cancel',  [VisitBookingController::class, 'cancel'])->name('visit.cancel');

    // Admission
    Route::get('/schools/{slug}/apply',       [AdmissionController::class, 'create'])->name('admission.create');
    Route::post('/schools/{slug}/apply',      [AdmissionController::class, 'store'])->name('admission.store');
    Route::get('/admission/{id}/status',      [AdmissionController::class, 'status'])->name('admission.status');
    Route::get('/dashboard/admissions',       [AdmissionController::class, 'myAdmissions'])->name('dashboard.admissions');
    Route::delete('/admission/{id}/withdraw', [AdmissionController::class, 'withdraw'])->name('admission.withdraw');

    // Payment
    Route::get('/payment/checkout', [PaymentController::class, 'create'])->name('payment.create');
    Route::post('/payment/verify',  [PaymentController::class, 'verify'])->name('payment.verify');
    Route::get('/payment/failed',   [PaymentController::class, 'failed'])->name('payment.failed');
});