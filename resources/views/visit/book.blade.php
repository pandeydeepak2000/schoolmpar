@extends('layouts.public')

@section('title', 'Book a School Visit – ' . $school->name)
@section('metadesc', 'Schedule a visit for ' . $school->name . ' and explore the campus before admission.')

@push('styles')
<style>
.vb-hero {
    background: linear-gradient(135deg, #1d3557 0%, #457b9d 60%, #1d3557 100%);
    padding: 48px 0 40px;
    position: relative;
    overflow: hidden;
}
.vb-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(circle at 10% 50%, rgba(255,255,255,.07), transparent 40%),
        radial-gradient(circle at 90% 20%, rgba(255,255,255,.06), transparent 35%);
    pointer-events: none;
}
.vb-hero .container {
    position: relative;
    z-index: 2;
}
.vb-breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: rgba(255,255,255,.65);
    margin-bottom: 18px;
    flex-wrap: wrap;
}
.vb-breadcrumb a {
    color: rgba(255,255,255,.85);
    text-decoration: none;
}
.vb-breadcrumb a:hover {
    color: #fff;
}
.vb-breadcrumb span {
    color: rgba(255,255,255,.4);
}
.vb-hero h1 {
    color: #fff;
    font-size: clamp(22px, 3.5vw, 34px);
    font-weight: 900;
    margin: 0 0 8px;
    letter-spacing: -.3px;
}
.vb-hero p {
    color: rgba(255,255,255,.75);
    font-size: 14px;
    margin: 0;
}

.vb-school-strip {
    background: #fff;
    border-bottom: 1.5px solid #edf1f7;
    padding: 16px 0;
    box-shadow: 0 2px 12px rgba(20,32,60,.05);
}
.vb-school-info {
    display: flex;
    align-items: center;
    gap: 14px;
    flex-wrap: wrap;
}
.vb-school-emoji {
    font-size: 36px;
    flex-shrink: 0;
}
.vb-school-name {
    font-size: 16px;
    font-weight: 800;
    color: #1d3557;
}
.vb-school-meta {
    font-size: 13px;
    color: #7b8794;
    margin-top: 2px;
}
.vb-school-badge {
    display: inline-block;
    background: #dbeafe;
    color: #1d4ed8;
    border-radius: 999px;
    padding: 3px 12px;
    font-size: 11px;
    font-weight: 700;
    margin-top: 5px;
}

.vb-layout {
    display: grid;
    grid-template-columns: minmax(0, 1fr) 360px;
    gap: 28px;
    align-items: start;
    padding: 36px 0 60px;
}

.vb-form-card {
    background: #fff;
    border-radius: 20px;
    border: 1.5px solid #edf1f7;
    box-shadow: 0 8px 28px rgba(20,32,60,.06);
    overflow: hidden;
}
.vb-form-header {
    background: linear-gradient(135deg, #f8fafc, #edf4ff);
    padding: 22px 24px;
    border-bottom: 1.5px solid #e8edf5;
    display: flex;
    align-items: center;
    gap: 12px;
}
.vb-form-header-icon {
    width: 44px;
    height: 44px;
    background: #1d3557;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}
.vb-form-header h2 {
    font-size: 17px;
    font-weight: 800;
    color: #1d3557;
    margin: 0 0 2px;
}
.vb-form-header p {
    font-size: 12px;
    color: #8a94a6;
    margin: 0;
}
.vb-form-body {
    padding: 26px 24px;
}

.vb-section-label {
    font-size: 11px;
    font-weight: 800;
    color: #1d3557;
    letter-spacing: .6px;
    text-transform: uppercase;
    margin-bottom: 14px;
    padding-bottom: 8px;
    border-bottom: 1.5px solid #edf1f7;
}
.vb-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
    margin-bottom: 14px;
}
.vb-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
    margin-bottom: 14px;
}
.vb-label {
    font-size: 13px;
    font-weight: 700;
    color: #374151;
}
.vb-label .req {
    color: #e63946;
    margin-left: 2px;
}
.vb-input,
.vb-select,
.vb-textarea {
    width: 100%;
    border: 1.5px solid #e5e9f0;
    border-radius: 10px;
    padding: 11px 14px;
    font-size: 14px;
    color: #1d3557;
    background: #fafbfc;
    outline: none;
    transition: border-color .2s, box-shadow .2s, background .2s;
    font-family: inherit;
}
.vb-input:focus,
.vb-select:focus,
.vb-textarea:focus {
    border-color: #1d3557;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(29,53,87,.08);
}
.vb-input.is-error,
.vb-select.is-error,
.vb-textarea.is-error {
    border-color: #e63946;
    background: #fff8f8;
}
.vb-textarea {
    resize: vertical;
    min-height: 90px;
}
.vb-error-msg {
    font-size: 12px;
    color: #e63946;
    font-weight: 600;
    margin-top: 2px;
}

.vb-time-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 8px;
    margin-top: 4px;
}
.vb-time-slot {
    position: relative;
}
.vb-time-slot input[type="radio"] {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
}
.vb-time-slot label {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 10px 6px;
    border: 1.5px solid #e5e9f0;
    border-radius: 10px;
    font-size: 12px;
    font-weight: 700;
    color: #6b7280;
    background: #fafbfc;
    cursor: pointer;
    transition: all .2s;
    text-align: center;
    line-height: 1.3;
    min-height: 42px;
}
.vb-time-slot input[type="radio"]:checked + label {
    background: #1d3557;
    color: #fff;
    border-color: #1d3557;
    box-shadow: 0 4px 12px rgba(29,53,87,.2);
}
.vb-time-slot label:hover {
    border-color: #1d3557;
    color: #1d3557;
    background: #f0f4f8;
}

.vb-submit-btn {
    width: 100%;
    padding: 15px;
    background: #e63946;
    color: #fff;
    border: none;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 800;
    cursor: pointer;
    transition: background .2s, transform .15s, box-shadow .2s;
    font-family: inherit;
    margin-top: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}
.vb-submit-btn:hover {
    background: #c1121f;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(230,57,70,.3);
}
.vb-submit-btn:active {
    transform: translateY(0);
}

.vb-sidebar {
    display: flex;
    flex-direction: column;
    gap: 18px;
}
.vb-info-card {
    background: #fff;
    border-radius: 18px;
    border: 1.5px solid #edf1f7;
    box-shadow: 0 4px 16px rgba(20,32,60,.05);
    overflow: hidden;
}
.vb-info-head {
    background: linear-gradient(135deg, #1d3557, #2d5282);
    padding: 16px 18px;
}
.vb-info-head h3 {
    color: #fff;
    font-size: 14px;
    font-weight: 800;
    margin: 0;
}
.vb-info-body {
    padding: 16px 18px;
}
.vb-info-item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 10px 0;
    border-bottom: 1px solid #f3f4f6;
    font-size: 13px;
    color: #4b5563;
    line-height: 1.5;
}
.vb-info-item:last-child {
    border-bottom: none;
}
.vb-info-item .icon {
    font-size: 16px;
    flex-shrink: 0;
    margin-top: 1px;
}

.vb-tips-card {
    background: linear-gradient(135deg, #fffbeb, #fef3c7);
    border: 1.5px solid #fde68a;
    border-radius: 18px;
    padding: 18px;
}
.vb-tips-card h4 {
    font-size: 13px;
    font-weight: 800;
    color: #92400e;
    margin: 0 0 12px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.vb-tip-item {
    display: flex;
    gap: 8px;
    font-size: 12px;
    color: #78350f;
    margin-bottom: 8px;
    line-height: 1.5;
}
.vb-tip-item:last-child {
    margin-bottom: 0;
}
.vb-tip-dot {
    width: 6px;
    height: 6px;
    background: #d97706;
    border-radius: 50%;
    flex-shrink: 0;
    margin-top: 6px;
}
.vb-alert {
    padding: 14px 16px;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 20px;
    display: flex;
    align-items: flex-start;
    gap: 10px;
}
.vb-alert.success {
    background: #dcfce7;
    color: #15803d;
    border: 1px solid #bbf7d0;
}
.vb-alert.error {
    background: #fee2e2;
    color: #dc2626;
    border: 1px solid #fecaca;
}

@media (max-width: 900px) {
    .vb-layout {
        grid-template-columns: 1fr;
    }
    .vb-sidebar {
        order: -1;
    }
}
@media (max-width: 576px) {
    .vb-row {
        grid-template-columns: 1fr;
    }
    .vb-time-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .vb-form-body {
        padding: 18px 16px;
    }
}
</style>
@endpush

@section('content')

<div class="vb-hero">
    <div class="container">
        <div class="vb-breadcrumb">
            <a href="/">Home</a>
            <span>›</span>
            <a href="{{ route('school.show', $school->slug) }}">{{ $school->name }}</a>
            <span>›</span>
            <span style="color:#fff;">Book Visit</span>
        </div>
        <h1>📅 Book a School Visit</h1>
        <p>Schedule a visit and explore the school in person before applying</p>
    </div>
</div>

<div class="vb-school-strip">
    <div class="container">
        <div class="vb-school-info">
            <span class="vb-school-emoji">🏫</span>
            <div>
                <div class="vb-school-name">{{ $school->name }}</div>
                <div class="vb-school-meta">📍 {{ $school->city ?? $school->address }}</div>
                <span class="vb-school-badge">{{ $school->board }}</span>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="vb-layout">

        <div>
            @if(session('success'))
                <div class="vb-alert success">
                    <span>✅</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="vb-alert error">
                    <span>⚠️</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <div class="vb-form-card">
                <div class="vb-form-header">
                    <div class="vb-form-header-icon">📅</div>
                    <div>
                        <h2>Schedule Your Visit</h2>
                        <p>Fill in your details to book a visit slot</p>
                    </div>
                </div>

                <div class="vb-form-body">
                    <form action="{{ route('visit.store', $school->slug) }}" method="POST" id="visitForm">
                        @csrf

                        <div class="vb-section-label">👤 Visitor Details</div>

                        <div class="vb-row">
                            <div class="vb-group">
                                <label class="vb-label" for="visitor_name">
                                    Full Name <span class="req">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="visitor_name"
                                    name="visitor_name"
                                    class="vb-input @error('visitor_name') is-error @enderror"
                                    placeholder="Your full name"
                                    value="{{ old('visitor_name', auth()->user()->name ?? '') }}"
                                    required
                                >
                                @error('visitor_name')
                                    <span class="vb-error-msg">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="vb-group">
                                <label class="vb-label" for="visitor_phone">
                                    Phone Number <span class="req">*</span>
                                </label>
                                <input
                                    type="tel"
                                    id="visitor_phone"
                                    name="visitor_phone"
                                    class="vb-input @error('visitor_phone') is-error @enderror"
                                    placeholder="10-digit mobile number"
                                    value="{{ old('visitor_phone') }}"
                                    maxlength="15"
                                    required
                                >
                                @error('visitor_phone')
                                    <span class="vb-error-msg">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="vb-section-label" style="margin-top:8px;">📅 Visit Schedule</div>

                        <div class="vb-row">
                            <div class="vb-group">
                                <label class="vb-label" for="visitDate">
                                    Visit Date <span class="req">*</span>
                                </label>
                                <input
                                    type="date"
                                    name="visit_date"
                                    id="visitDate"
                                    class="vb-input @error('visit_date') is-error @enderror"
                                    value="{{ old('visit_date') }}"
                                    min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                    required
                                >
                                @error('visit_date')
                                    <span class="vb-error-msg">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="vb-group">
                                <label class="vb-label">
                                    Preferred Time <span class="req">*</span>
                                </label>
                                <input type="hidden" name="visit_time" id="visitTimeInput" value="{{ old('visit_time') }}">
                                <div class="vb-time-grid">
                                    @php
                                        $slots = [
                                            '09:00' => '9:00 AM',
                                            '10:00' => '10:00 AM',
                                            '11:00' => '11:00 AM',
                                            '12:00' => '12:00 PM',
                                            '14:00' => '2:00 PM',
                                            '15:00' => '3:00 PM',
                                        ];
                                    @endphp

                                    @foreach($slots as $value => $label)
                                        <div class="vb-time-slot">
                                            <input
                                                type="radio"
                                                name="visit_time_radio"
                                                id="slot_{{ $loop->index }}"
                                                value="{{ $value }}"
                                                {{ old('visit_time') === $value ? 'checked' : '' }}
                                                onchange="document.getElementById('visitTimeInput').value = this.value"
                                            >
                                            <label for="slot_{{ $loop->index }}">{{ $label }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('visit_time')
                                    <span class="vb-error-msg">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="vb-group" style="margin-top:8px;">
                            <label class="vb-label" for="notes">
                                Additional Notes <span style="color:#9ca3af;font-weight:500;">(optional)</span>
                            </label>
                            <textarea
                                id="notes"
                                name="notes"
                                class="vb-textarea @error('notes') is-error @enderror"
                                placeholder="Any specific areas you'd like to visit, questions, or special requirements..."
                            >{{ old('notes') }}</textarea>
                            @error('notes')
                                <span class="vb-error-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="vb-submit-btn" id="submitBtn">
                            <span>📅</span>
                            <span>Confirm Visit Booking</span>
                        </button>

                        <p style="text-align:center;font-size:12px;color:#9ca3af;margin-top:12px;">
                            Booking is free. School will confirm within 24 hours.
                        </p>
                    </form>
                </div>
            </div>
        </div>

        <div class="vb-sidebar">

            <div class="vb-info-card">
                <div class="vb-info-head">
                    <h3>🏫 School Information</h3>
                </div>
                <div class="vb-info-body">
                    <div class="vb-info-item">
                        <span class="icon">📋</span>
                        <span><strong>Board:</strong> {{ $school->board ?? '—' }}</span>
                    </div>
                    <div class="vb-info-item">
                        <span class="icon">🗣️</span>
                        <span><strong>Medium:</strong> {{ $school->medium ?? '—' }}</span>
                    </div>
                    <div class="vb-info-item">
                        <span class="icon">🎓</span>
                        <span><strong>Classes:</strong> Class {{ $school->class_from }} – {{ $school->class_to }}</span>
                    </div>
                    <div class="vb-info-item">
                        <span class="icon">📍</span>
                        <span><strong>Address:</strong> {{ $school->address }}</span>
                    </div>
                    @if($school->phone)
                    <div class="vb-info-item">
                        <span class="icon">📞</span>
                        <span><strong>Phone:</strong>
                            <a href="tel:{{ $school->phone }}" style="color:#e63946;font-weight:700;text-decoration:none;">
                                {{ $school->phone }}
                            </a>
                        </span>
                    </div>
                    @endif
                    @if($school->principal_name)
                    <div class="vb-info-item">
                        <span class="icon">👨‍🏫</span>
                        <span><strong>Principal:</strong> {{ $school->principal_name }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <div class="vb-info-card">
                <div class="vb-info-head">
                    <h3>⚡ How Visit Works</h3>
                </div>
                <div class="vb-info-body">
                    <div class="vb-info-item">
                        <span class="icon">1️⃣</span>
                        <span>Fill the form and submit your visit request</span>
                    </div>
                    <div class="vb-info-item">
                        <span class="icon">2️⃣</span>
                        <span>School reviews and confirms within 24 hours</span>
                    </div>
                    <div class="vb-info-item">
                        <span class="icon">3️⃣</span>
                        <span>You receive a confirmation on your dashboard</span>
                    </div>
                    <div class="vb-info-item">
                        <span class="icon">4️⃣</span>
                        <span>Visit the school on your scheduled date</span>
                    </div>
                    <div class="vb-info-item">
                        <span class="icon">5️⃣</span>
                        <span>Apply for admission directly after your visit</span>
                    </div>
                </div>
            </div>

            <div class="vb-tips-card">
                <h4>💡 Visit Tips</h4>
                <div class="vb-tip-item">
                    <div class="vb-tip-dot"></div>
                    <span>Carry a valid ID proof on the visit day</span>
                </div>
                <div class="vb-tip-item">
                    <div class="vb-tip-dot"></div>
                    <span>Prepare a list of questions to ask the principal</span>
                </div>
                <div class="vb-tip-item">
                    <div class="vb-tip-dot"></div>
                    <span>Morning slots (9–11 AM) give you the best experience</span>
                </div>
                <div class="vb-tip-item">
                    <div class="vb-tip-dot"></div>
                    <span>Visit during school hours to see actual classrooms</span>
                </div>
            </div>

            <a href="{{ route('school.show', $school->slug) }}"
               style="display:block;text-align:center;background:#f8fafc;border:1.5px solid #e5e9f0;
                      border-radius:12px;padding:13px;font-size:14px;font-weight:700;
                      color:#1d3557;text-decoration:none;transition:background .2s;">
                ← Back to School Details
            </a>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const dateInput = document.getElementById('visitDate');
    const form = document.getElementById('visitForm');
    const timeInput = document.getElementById('visitTimeInput');
    const submitBtn = document.getElementById('submitBtn');

    if (dateInput) {
        dateInput.addEventListener('input', function () {
            const day = new Date(this.value).getDay();
            if (day === 0) {
                alert('School visits are not available on Sundays. Please select another date.');
                this.value = '';
            }
        });
    }

    if (form) {
        form.addEventListener('submit', function (e) {
            if (!timeInput.value) {
                e.preventDefault();
                alert('Please select a preferred time slot.');
                return;
            }
            submitBtn.innerHTML = '<span>⏳</span><span>Booking...</span>';
            submitBtn.disabled = true;
        });
    }
});
</script>
@endpush