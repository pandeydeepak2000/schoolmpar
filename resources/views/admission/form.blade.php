@extends('layouts.public')
@section('title', 'Apply for Admission – ' . $school->name)

@push('styles')
<style>
.af-hero {
    background: linear-gradient(135deg, #1d3557 0%, #e63946 100%);
    padding: 46px 0 38px;
    position: relative;
    overflow: hidden;
}
.af-hero::before {
    content:'';position:absolute;inset:0;
    background: radial-gradient(circle at 80% 20%, rgba(255,255,255,.08), transparent 35%);
    pointer-events:none;
}
.af-hero .container { position:relative;z-index:2; }
.af-hero h1 { color:#fff;font-size:clamp(22px,3.5vw,34px);font-weight:900;margin:0 0 8px;letter-spacing:-.3px; }
.af-hero p  { color:rgba(255,255,255,.75);font-size:14px;margin:0; }
.af-breadcrumb { display:flex;align-items:center;gap:8px;font-size:13px;color:rgba(255,255,255,.65);margin-bottom:16px;flex-wrap:wrap; }
.af-breadcrumb a { color:rgba(255,255,255,.8);text-decoration:none; }
.af-breadcrumb a:hover { color:#fff; }

.af-layout {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 24px;
    padding: 32px 0 60px;
    align-items: start;
}
.af-card {
    background:#fff;border-radius:20px;border:1.5px solid #edf1f7;
    box-shadow:0 8px 28px rgba(20,32,60,.06);overflow:hidden;
}
.af-card-head {
    background:linear-gradient(135deg,#f8fafc,#edf4ff);
    padding:18px 22px;border-bottom:1.5px solid #e8edf5;
    display:flex;align-items:center;gap:12px;
}
.af-card-head-icon {
    width:42px;height:42px;background:#e63946;border-radius:11px;
    display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;
}
.af-card-head h2 { font-size:16px;font-weight:800;color:#1d3557;margin:0 0 2px; }
.af-card-head p  { font-size:12px;color:#8a94a6;margin:0; }
.af-card-body { padding:24px 22px; }

.af-section-title {
    font-size:11px;font-weight:800;color:#1d3557;letter-spacing:.6px;
    text-transform:uppercase;margin-bottom:14px;padding-bottom:8px;
    border-bottom:1.5px solid #edf1f7;margin-top:4px;
}
.af-row { display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px; }
.af-row.full { grid-template-columns:1fr; }
.af-row.three { grid-template-columns:1fr 1fr 1fr; }
.af-group { display:flex;flex-direction:column;gap:5px;margin-bottom:14px; }
.af-label { font-size:13px;font-weight:700;color:#374151; }
.af-label .req { color:#e63946;margin-left:2px; }
.af-label .opt { color:#9ca3af;font-weight:400;font-size:12px; }
.af-input,.af-select,.af-textarea {
    width:100%;border:1.5px solid #e5e9f0;border-radius:10px;
    padding:11px 14px;font-size:14px;color:#1d3557;background:#fafbfc;
    outline:none;transition:border-color .2s,box-shadow .2s,background .2s;font-family:inherit;
}
.af-input:focus,.af-select:focus,.af-textarea:focus {
    border-color:#e63946;background:#fff;box-shadow:0 0 0 3px rgba(230,57,70,.08);
}
.af-input.is-error,.af-select.is-error { border-color:#e63946;background:#fff8f8; }
.af-textarea { resize:vertical;min-height:80px; }
.af-error { font-size:12px;color:#e63946;font-weight:600;margin-top:2px; }

/* Gender Radio */
.af-gender-group { display:flex;gap:10px;margin-top:4px; }
.af-gender-opt { flex:1; }
.af-gender-opt input[type="radio"] { position:absolute;opacity:0;width:0;height:0; }
.af-gender-opt label {
    display:flex;align-items:center;justify-content:center;gap:6px;
    padding:10px;border:1.5px solid #e5e9f0;border-radius:10px;
    font-size:13px;font-weight:700;color:#6b7280;background:#fafbfc;
    cursor:pointer;transition:all .2s;
}
.af-gender-opt input[type="radio"]:checked + label {
    background:#e63946;color:#fff;border-color:#e63946;
    box-shadow:0 4px 12px rgba(230,57,70,.2);
}
.af-gender-opt label:hover { border-color:#e63946;color:#e63946;background:#fff5f5; }

/* File Upload */
.af-file-area {
    border:2px dashed #d1d5db;border-radius:12px;padding:20px;text-align:center;
    background:#fafbfc;cursor:pointer;transition:border-color .2s,background .2s;
}
.af-file-area:hover { border-color:#e63946;background:#fff5f5; }
.af-file-area input[type="file"] { display:none; }
.af-file-label { cursor:pointer;display:block; }
.af-file-icon { font-size:28px;margin-bottom:8px;display:block; }
.af-file-text { font-size:13px;font-weight:700;color:#374151;margin-bottom:4px; }
.af-file-sub { font-size:11px;color:#9ca3af; }

/* Submit */
.af-submit-btn {
    width:100%;padding:15px;background:#e63946;color:#fff;border:none;
    border-radius:12px;font-size:15px;font-weight:800;cursor:pointer;
    transition:background .2s,transform .15s,box-shadow .2s;font-family:inherit;
    display:flex;align-items:center;justify-content:center;gap:8px;margin-top:8px;
}
.af-submit-btn:hover { background:#c1121f;transform:translateY(-1px);box-shadow:0 6px 20px rgba(230,57,70,.3); }

/* Already Applied */
.af-applied-banner {
    background:linear-gradient(135deg,#fef9c3,#fffbeb);border:1.5px solid #fde68a;
    border-radius:16px;padding:20px 22px;margin-bottom:20px;display:flex;gap:14px;align-items:flex-start;
}

/* Sidebar */
.af-sidebar { display:flex;flex-direction:column;gap:16px; }
.af-side-card {
    background:#fff;border-radius:18px;border:1.5px solid #edf1f7;
    box-shadow:0 4px 16px rgba(20,32,60,.05);overflow:hidden;
}
.af-side-head { background:linear-gradient(135deg,#1d3557,#2d5282);padding:14px 18px; }
.af-side-head h3 { color:#fff;font-size:13px;font-weight:800;margin:0; }
.af-side-body { padding:14px 18px; }
.af-side-row {
    display:flex;align-items:flex-start;gap:10px;padding:9px 0;
    border-bottom:1px solid #f3f4f6;font-size:13px;color:#4b5563;
}
.af-side-row:last-child { border-bottom:none; }

/* Responsive */
@media (max-width:900px) { .af-layout { grid-template-columns:1fr; } }
@media (max-width:576px) {
    .af-row,.af-row.three { grid-template-columns:1fr; }
    .af-card-body { padding:18px 14px; }
}
</style>
@endpush

@section('content')

<div class="af-hero">
    <div class="container">
        <div class="af-breadcrumb">
            <a href="/">Home</a><span>›</span>
            <a href="/schools/{{ $school->slug }}">{{ $school->name }}</a>
            <span>›</span><span style="color:#fff;">Apply Now</span>
        </div>
        <h1>📝 Apply for Admission</h1>
        <p>Fill the form below to submit your child's admission application</p>
    </div>
</div>

<div class="container">
    <div class="af-layout">

        {{-- ── LEFT: Form ── --}}
        <div>

            @if($alreadyApplied)
            <div class="af-applied-banner">
                <span style="font-size:24px;flex-shrink:0;">⚠️</span>
                <div>
                    <div style="font-size:14px;font-weight:800;color:#92400e;margin-bottom:4px;">Application Already Submitted</div>
                    <div style="font-size:13px;color:#78350f;">You have already applied to this school. Track your application status in your dashboard.</div>
                    <a href="{{ route('dashboard.admissions') }}" style="display:inline-block;margin-top:10px;background:#f59e0b;color:#fff;border-radius:8px;padding:8px 18px;font-size:13px;font-weight:800;text-decoration:none;">
                        Track Application →
                    </a>
                </div>
            </div>
            @endif

            @if(!$alreadyApplied)
            <div class="af-card">
                <div class="af-card-head">
                    <div class="af-card-head-icon">📝</div>
                    <div>
                        <h2>Admission Application Form</h2>
                        <p>All fields marked with * are required</p>
                    </div>
                </div>
                <div class="af-card-body">
                    <form action="{{ route('admission.store', $school->slug) }}" method="POST" enctype="multipart/form-data" id="admissionForm">
                        @csrf

                        {{-- Student Details --}}
                        <div class="af-section-title">👦 Student Details</div>

                        <div class="af-row">
                            <div class="af-group">
                                <label class="af-label">Student Full Name <span class="req">*</span></label>
                                <input type="text" name="student_name" class="af-input @error('student_name') is-error @enderror"
                                    placeholder="As per birth certificate" value="{{ old('student_name') }}" required>
                                @error('student_name')<span class="af-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="af-group">
                                <label class="af-label">Date of Birth <span class="req">*</span></label>
                                <input type="date" name="student_dob" class="af-input @error('student_dob') is-error @enderror"
                                    value="{{ old('student_dob') }}" max="{{ date('Y-m-d', strtotime('-3 years')) }}" required>
                                @error('student_dob')<span class="af-error">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="af-row">
                            <div class="af-group">
                                <label class="af-label">Gender <span class="req">*</span></label>
                                <div class="af-gender-group">
                                    @foreach(['male'=>'👦 Male','female'=>'👧 Female','other'=>'🧒 Other'] as $val=>$lbl)
                                    <div class="af-gender-opt" style="position:relative;">
                                        <input type="radio" name="student_gender" id="g_{{ $val }}" value="{{ $val }}"
                                            {{ old('student_gender') === $val ? 'checked' : '' }}>
                                        <label for="g_{{ $val }}">{{ $lbl }}</label>
                                    </div>
                                    @endforeach
                                </div>
                                @error('student_gender')<span class="af-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="af-group">
                                <label class="af-label">Class Applying For <span class="req">*</span></label>
                                <select name="class_applying" class="af-select @error('class_applying') is-error @enderror" required>
                                    <option value="">Select Class</option>
                                    @for($i = $school->class_from; $i <= $school->class_to; $i++)
                                        <option value="Class {{ $i }}" {{ old('class_applying') == 'Class '.$i ? 'selected' : '' }}>
                                            Class {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                                @error('class_applying')<span class="af-error">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        {{-- Parent Details --}}
                        <div class="af-section-title" style="margin-top:10px;">👨‍👩‍👧 Parent / Guardian Details</div>

                        <div class="af-row">
                            <div class="af-group">
                                <label class="af-label">Parent / Guardian Name <span class="req">*</span></label>
                                <input type="text" name="parent_name" class="af-input @error('parent_name') is-error @enderror"
                                    placeholder="Full name" value="{{ old('parent_name', auth()->user()->name) }}" required>
                                @error('parent_name')<span class="af-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="af-group">
                                <label class="af-label">Mobile Number <span class="req">*</span></label>
                                <input type="tel" name="parent_phone" class="af-input @error('parent_phone') is-error @enderror"
                                    placeholder="10-digit number" value="{{ old('parent_phone') }}" maxlength="15" required>
                                @error('parent_phone')<span class="af-error">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="af-row">
                            <div class="af-group">
                                <label class="af-label">Email Address <span class="opt">(optional)</span></label>
                                <input type="email" name="parent_email" class="af-input"
                                    placeholder="your@email.com" value="{{ old('parent_email', auth()->user()->email) }}">
                            </div>
                            <div class="af-group">
                                <label class="af-label">Home Address <span class="req">*</span></label>
                                <input type="text" name="address" class="af-input @error('address') is-error @enderror"
                                    placeholder="Full address with city" value="{{ old('address') }}" required>
                                @error('address')<span class="af-error">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        {{-- Previous School --}}
                        <div class="af-section-title" style="margin-top:10px;">🏫 Previous School <span style="color:#9ca3af;font-weight:400;text-transform:none;letter-spacing:0;font-size:11px;">(optional)</span></div>

                        <div class="af-row three">
                            <div class="af-group">
                                <label class="af-label">School Name</label>
                                <input type="text" name="previous_school" class="af-input" placeholder="Previous school" value="{{ old('previous_school') }}">
                            </div>
                            <div class="af-group">
                                <label class="af-label">Last Class</label>
                                <input type="text" name="previous_class" class="af-input" placeholder="e.g. Class 5" value="{{ old('previous_class') }}">
                            </div>
                            <div class="af-group">
                                <label class="af-label">Percentage / Grade</label>
                                <input type="number" name="previous_percentage" class="af-input" placeholder="e.g. 85" min="0" max="100" step="0.01" value="{{ old('previous_percentage') }}">
                            </div>
                        </div>

                        {{-- Document Upload --}}
                        <div class="af-section-title" style="margin-top:10px;">📎 Document Upload <span style="color:#9ca3af;font-weight:400;text-transform:none;letter-spacing:0;font-size:11px;">(optional)</span></div>

                        <div class="af-file-area" onclick="document.getElementById('docUpload').click()">
                            <label class="af-file-label">
                                <span class="af-file-icon">📄</span>
                                <div class="af-file-text" id="fileName">Click to upload Birth Certificate / Transfer Certificate</div>
                                <div class="af-file-sub">PDF, JPG, PNG — Max 2MB</div>
                            </label>
                            <input type="file" id="docUpload" name="document" accept=".pdf,.jpg,.jpeg,.png"
                                onchange="document.getElementById('fileName').textContent = this.files[0]?.name || 'Click to upload'">
                        </div>
                        @error('document')<span class="af-error">{{ $message }}</span>@enderror

                        {{-- Submit --}}
                        @if($school->admission_fee && $school->admission_fee > 0)
                        <div style="background:#fef9c3;border:1px solid #fde68a;border-radius:12px;padding:14px 16px;margin-top:20px;display:flex;align-items:center;gap:12px;">
                            <span style="font-size:20px;">💳</span>
                            <div>
                                <div style="font-size:13px;font-weight:800;color:#92400e;">Registration Fee Required</div>
                                <div style="font-size:12px;color:#78350f;margin-top:2px;">
                                    You will be redirected to pay ₹{{ number_format($school->admission_fee) }} via Razorpay after submitting this form.
                                </div>
                            </div>
                        </div>
                        @endif

                        <button type="submit" class="af-submit-btn" id="afSubmitBtn">
                            <span>📝</span>
                            <span>
                                @if($school->admission_fee && $school->admission_fee > 0)
                                    Submit & Pay ₹{{ number_format($school->admission_fee) }}
                                @else
                                    Submit Application
                                @endif
                            </span>
                        </button>

                        <p style="text-align:center;font-size:12px;color:#9ca3af;margin-top:10px;">
                            Your information is safe and will only be shared with the school.
                        </p>
                    </form>
                </div>
            </div>
            @endif
        </div>

        {{-- ── RIGHT: Sidebar ── --}}
        <div class="af-sidebar">

            {{-- School Info --}}
            <div class="af-side-card">
                <div class="af-side-head"><h3>🏫 {{ $school->name }}</h3></div>
                <div class="af-side-body">
                    <div class="af-side-row"><span style="font-size:15px;flex-shrink:0;">📋</span><span><strong>Board:</strong> {{ $school->board }}</span></div>
                    <div class="af-side-row"><span style="font-size:15px;flex-shrink:0;">🎓</span><span><strong>Classes:</strong> {{ $school->class_from }} – {{ $school->class_to }}</span></div>
                    <div class="af-side-row"><span style="font-size:15px;flex-shrink:0;">📍</span><span>{{ $school->city ?? $school->address }}</span></div>
                    @if($school->admission_fee)
                    <div class="af-side-row"><span style="font-size:15px;flex-shrink:0;">💰</span><span><strong>Registration Fee:</strong> ₹{{ number_format($school->admission_fee) }}</span></div>
                    @else
                    <div class="af-side-row"><span style="font-size:15px;flex-shrink:0;">💰</span><span><strong>Registration Fee:</strong> <span style="color:#15803d;font-weight:700;">Free</span></span></div>
                    @endif
                    @if($school->phone)
                    <div class="af-side-row"><span style="font-size:15px;flex-shrink:0;">📞</span><a href="tel:{{ $school->phone }}" style="color:#e63946;font-weight:700;text-decoration:none;">{{ $school->phone }}</a></div>
                    @endif
                </div>
            </div>

            {{-- Process --}}
            <div class="af-side-card">
                <div class="af-side-head"><h3>📋 Admission Process</h3></div>
                <div class="af-side-body">
                    <div class="af-side-row"><span style="font-size:15px;flex-shrink:0;">1️⃣</span><span>Fill and submit this form</span></div>
                    <div class="af-side-row"><span style="font-size:15px;flex-shrink:0;">2️⃣</span><span>Pay registration fee (if applicable)</span></div>
                    <div class="af-side-row"><span style="font-size:15px;flex-shrink:0;">3️⃣</span><span>School reviews your application</span></div>
                    <div class="af-side-row"><span style="font-size:15px;flex-shrink:0;">4️⃣</span><span>Receive approval / rejection notification</span></div>
                    <div class="af-side-row"><span style="font-size:15px;flex-shrink:0;">5️⃣</span><span>Complete admission at school office</span></div>
                </div>
            </div>

            <a href="/schools/{{ $school->slug }}"
               style="display:block;text-align:center;background:#f8fafc;border:1.5px solid #e5e9f0;border-radius:12px;padding:13px;font-size:14px;font-weight:700;color:#1d3557;text-decoration:none;">
                ← Back to School Details
            </a>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.getElementById('admissionForm')?.addEventListener('submit', function () {
    const btn = document.getElementById('afSubmitBtn');
    btn.innerHTML = '<span>⏳</span><span>Submitting...</span>';
    btn.disabled = true;
});
</script>
@endpush