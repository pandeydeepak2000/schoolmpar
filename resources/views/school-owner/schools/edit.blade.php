@extends('school-owner.layout')
@section('title', 'Edit School')

@section('content')

<div class="d-flex align-items-start justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 style="font-size:18px; font-weight:800; color:#1d3557; margin:0;">
            <i class="fas fa-pen me-2 text-danger"></i>Edit School
        </h4>
        <p style="font-size:13px; color:#94a3b8; margin:4px 0 0;">
            {{ $school->name }}
        </p>
    </div>
    <a href="{{ route('school-owner.schools.index') }}" class="btn-ghost">← Back to Schools</a>
</div>

@if(isset($errors) && $errors->any())
<div style="background:#fee2e2;border:1.5px solid #fecaca;border-radius:12px;
            padding:14px 18px;margin-bottom:20px;font-size:13px;color:#991b1b;">
    @foreach($errors->all() as $e)
    <div>• {{ $e }}</div>
    @endforeach
</div>
@endif

@if($school->status === 'rejected')
<div style="background:#fee2e2;border:1.5px solid #fecaca;border-radius:12px;
            padding:14px 18px;margin-bottom:20px;font-size:13px;color:#991b1b;">
    ❌ <strong>Aapka school reject hua hai.</strong>
    Corrections karke resubmit karo — admin dobara review karega.
</div>
@elseif($school->status === 'pending')
<div style="background:#fffbeb;border:1.5px solid #fde68a;border-radius:12px;
            padding:14px 18px;margin-bottom:20px;font-size:13px;color:#92400e;">
    ⏳ <strong>Review pending hai.</strong>
    Edit karne ke baad phir se review ke liye submit hoga.
</div>
@endif

@php
    $gallery = $school->gallery_list;
@endphp

<div x-data="{
    previews: {
        main: '{{ $gallery['main'] }}',
        classroom: '{{ $gallery['classroom'] }}',
        activity: '{{ $gallery['activity'] }}',
        laboratory: '{{ $gallery['laboratory'] }}',
        facilities: '{{ $gallery['facilities'] }}',
        campus: '{{ $gallery['campus'] }}'
    },
    updatePreview(slot, event) {
        const file = event.target.files[0];
        if (file) {
            this.previews[slot] = URL.createObjectURL(file);
        }
    }
}">

<form action="{{ route('school-owner.schools.update', $school->id) }}"
      method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')

{{-- ── PANEL 1: Basic Info ── --}}
<div class="so-panel">
    <div class="so-panel-title">🏫 Basic Information</div>
    <div class="row g-3">
        <div class="col-12">
            <label class="so-label">School Name *</label>
            <input class="so-input" type="text" name="name"
                   value="{{ old('name', $school->name) }}"
                   placeholder="e.g. Delhi Public School Patna" required>
        </div>
        <div class="col-md-6">
            <label class="so-label">City *</label>
            <input class="so-input" type="text" name="city"
                   value="{{ old('city', $school->city) }}"
                   placeholder="e.g. Patna" required>
        </div>
        <div class="col-md-6">
            <label class="so-label">State *</label>
            <input class="so-input" type="text" name="state"
                   value="{{ old('state', $school->state) }}"
                   placeholder="e.g. Bihar" required>
        </div>
        <div class="col-12">
            <label class="so-label">Full Address *</label>
            <input class="so-input" type="text" name="address"
                   value="{{ old('address', $school->address) }}"
                   placeholder="Street, Area, City, Pincode" required>
        </div>
        <div class="col-12">
            <label class="so-label">Description</label>
            <textarea class="so-input" name="description" rows="3"
                      placeholder="Brief about your school...">{{ old('description', $school->description) }}</textarea>
        </div>
    </div>
</div>

{{-- ── PANEL 1.2: 6-Slot Photo Gallery Manager ── --}}
<div class="so-panel">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px; padding-bottom:10px; border-bottom:1px solid #f1f5f9; flex-wrap:wrap; gap:8px;">
        <div>
            <div class="so-panel-title" style="margin:0;">📸 Campus Photo Gallery (6 Upload Slots)</div>
            <p style="font-size:12px; color:#64748b; margin:2px 0 0;">Upload direct images or enter image URLs for your school's live public profile.</p>
        </div>
        <span style="background:#eff6ff; color:#2563eb; font-size:11px; font-weight:800; padding:4px 10px; border-radius:999px;">
            6 Photo Slots
        </span>
    </div>

    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(260px, 1fr)); gap:16px;">
        
        {{-- SLOT 1 --}}
        <div style="border:2px solid #93c5fd; border-radius:12px; padding:12px; background:#eff6ff;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                <strong style="font-size:12.5px; color:#1e40af;">⭐ 1. Home Page Cover & Hero *</strong>
                <span style="font-size:10px; background:#2563eb; color:#fff; padding:2px 6px; border-radius:4px; font-weight:700;">Card + Hero</span>
            </div>
            <div style="width:100%; height:120px; border-radius:8px; overflow:hidden; background:#e2e8f0; margin-bottom:8px; border:1px solid #bfdbfe;">
                <img :src="previews.main" alt="Main Preview" style="width:100%; height:100%; object-fit:cover;">
            </div>
            <label class="so-label" style="font-size:11px; margin-bottom:2px;">Upload Image File:</label>
            <input class="so-input" type="file" name="gallery_main_file" accept="image/*" @change="updatePreview('main', $event)" style="padding:6px; font-size:11px; margin-bottom:6px; background:#fff;">
            <label class="so-label" style="font-size:11px; margin-bottom:2px;">Or Direct Image URL:</label>
            <input class="so-input" type="url" name="gallery_main_url" x-model="previews.main" placeholder="https://..." style="padding:6px 10px; font-size:11.5px;">
        </div>

        {{-- SLOT 2 --}}
        <div style="border:1.5px solid #e2e8f0; border-radius:12px; padding:12px; background:#f8fafc;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                <strong style="font-size:12.5px; color:#0f2d59;">2. Classroom & Smartboard</strong>
                <span style="font-size:10px; background:#2563eb; color:#fff; padding:2px 6px; border-radius:4px; font-weight:700;">Gallery 2</span>
            </div>
            <div style="width:100%; height:120px; border-radius:8px; overflow:hidden; background:#e2e8f0; margin-bottom:8px;">
                <img :src="previews.classroom" alt="Classroom Preview" style="width:100%; height:100%; object-fit:cover;">
            </div>
            <label class="so-label" style="font-size:11px; margin-bottom:2px;">Upload Image File:</label>
            <input class="so-input" type="file" name="gallery_classroom_file" accept="image/*" @change="updatePreview('classroom', $event)" style="padding:6px; font-size:11px; margin-bottom:6px; background:#fff;">
            <label class="so-label" style="font-size:11px; margin-bottom:2px;">Or Direct Image URL:</label>
            <input class="so-input" type="url" name="gallery_classroom_url" x-model="previews.classroom" placeholder="https://..." style="padding:6px 10px; font-size:11.5px;">
        </div>

        {{-- SLOT 3 --}}
        <div style="border:1.5px solid #e2e8f0; border-radius:12px; padding:12px; background:#f8fafc;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                <strong style="font-size:12.5px; color:#0f2d59;">3. Sports & Activity Area</strong>
                <span style="font-size:10px; background:#ca8a04; color:#fff; padding:2px 6px; border-radius:4px; font-weight:700;">Gallery 3</span>
            </div>
            <div style="width:100%; height:120px; border-radius:8px; overflow:hidden; background:#e2e8f0; margin-bottom:8px;">
                <img :src="previews.activity" alt="Activity Preview" style="width:100%; height:100%; object-fit:cover;">
            </div>
            <label class="so-label" style="font-size:11px; margin-bottom:2px;">Upload Image File:</label>
            <input class="so-input" type="file" name="gallery_activity_file" accept="image/*" @change="updatePreview('activity', $event)" style="padding:6px; font-size:11px; margin-bottom:6px; background:#fff;">
            <label class="so-label" style="font-size:11px; margin-bottom:2px;">Or Direct Image URL:</label>
            <input class="so-input" type="url" name="gallery_activity_url" x-model="previews.activity" placeholder="https://..." style="padding:6px 10px; font-size:11.5px;">
        </div>

        {{-- SLOT 4 --}}
        <div style="border:1.5px solid #e2e8f0; border-radius:12px; padding:12px; background:#f8fafc;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                <strong style="font-size:12.5px; color:#0f2d59;">4. Science & IT Lab</strong>
                <span style="font-size:10px; background:#16a34a; color:#fff; padding:2px 6px; border-radius:4px; font-weight:700;">Gallery 4</span>
            </div>
            <div style="width:100%; height:120px; border-radius:8px; overflow:hidden; background:#e2e8f0; margin-bottom:8px;">
                <img :src="previews.laboratory" alt="Lab Preview" style="width:100%; height:100%; object-fit:cover;">
            </div>
            <label class="so-label" style="font-size:11px; margin-bottom:2px;">Upload Image File:</label>
            <input class="so-input" type="file" name="gallery_lab_file" accept="image/*" @change="updatePreview('laboratory', $event)" style="padding:6px; font-size:11px; margin-bottom:6px; background:#fff;">
            <label class="so-label" style="font-size:11px; margin-bottom:2px;">Or Direct Image URL:</label>
            <input class="so-input" type="url" name="gallery_lab_url" x-model="previews.laboratory" placeholder="https://..." style="padding:6px 10px; font-size:11.5px;">
        </div>

        {{-- SLOT 5 --}}
        <div style="border:1.5px solid #e2e8f0; border-radius:12px; padding:12px; background:#f8fafc;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                <strong style="font-size:12.5px; color:#0f2d59;">5. Library & Facilities</strong>
                <span style="font-size:10px; background:#9333ea; color:#fff; padding:2px 6px; border-radius:4px; font-weight:700;">Gallery 5</span>
            </div>
            <div style="width:100%; height:120px; border-radius:8px; overflow:hidden; background:#e2e8f0; margin-bottom:8px;">
                <img :src="previews.facilities" alt="Facilities Preview" style="width:100%; height:100%; object-fit:cover;">
            </div>
            <label class="so-label" style="font-size:11px; margin-bottom:2px;">Upload Image File:</label>
            <input class="so-input" type="file" name="gallery_facilities_file" accept="image/*" @change="updatePreview('facilities', $event)" style="padding:6px; font-size:11px; margin-bottom:6px; background:#fff;">
            <label class="so-label" style="font-size:11px; margin-bottom:2px;">Or Direct Image URL:</label>
            <input class="so-input" type="url" name="gallery_facilities_url" x-model="previews.facilities" placeholder="https://..." style="padding:6px 10px; font-size:11.5px;">
        </div>

        {{-- SLOT 6 --}}
        <div style="border:1.5px solid #e2e8f0; border-radius:12px; padding:12px; background:#f8fafc;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                <strong style="font-size:12.5px; color:#0f2d59;">6. Auditorium & Campus</strong>
                <span style="font-size:10px; background:#0284c7; color:#fff; padding:2px 6px; border-radius:4px; font-weight:700;">Gallery 6</span>
            </div>
            <div style="width:100%; height:120px; border-radius:8px; overflow:hidden; background:#e2e8f0; margin-bottom:8px;">
                <img :src="previews.campus" alt="Campus Preview" style="width:100%; height:100%; object-fit:cover;">
            </div>
            <label class="so-label" style="font-size:11px; margin-bottom:2px;">Upload Image File:</label>
            <input class="so-input" type="file" name="gallery_campus_file" accept="image/*" @change="updatePreview('campus', $event)" style="padding:6px; font-size:11px; margin-bottom:6px; background:#fff;">
            <label class="so-label" style="font-size:11px; margin-bottom:2px;">Or Direct Image URL:</label>
            <input class="so-input" type="url" name="gallery_campus_url" x-model="previews.campus" placeholder="https://..." style="padding:6px 10px; font-size:11.5px;">
        </div>

    </div>
</div>

{{-- ── PANEL 1.5: Prospectus & Brochure ── --}}
<div class="so-panel">
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px;">
        <div class="so-panel-title" style="margin:0;">📄 Official School Prospectus & Fee Brochure</div>
        @if($school->prospectus_path)
            <a href="{{ $school->prospectus_url }}" target="_blank"
               style="background:#eff6ff; color:#2563eb; font-size:12px; font-weight:800; text-decoration:none; padding:5px 12px; border-radius:6px; display:inline-flex; align-items:center; gap:5px;">
                <i class="fas fa-file-pdf"></i> View Current Prospectus
            </a>
        @endif
    </div>
    <p style="font-size:12px; color:#64748b; margin:6px 0 14px;">Upload your school's PDF admission prospectus, fee chart, or brochure for parents.</p>
    <div class="row g-3">
        <div class="col-md-6">
            <label class="so-label">Upload New Prospectus (PDF / DOC / Image)</label>
            <input class="so-input" type="file" name="prospectus_file" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg" style="padding:8px;">
        </div>
        <div class="col-md-6">
            <label class="so-label">Or Online Prospectus / Drive URL</label>
            <input class="so-input" type="url" name="prospectus_url"
                   value="{{ old('prospectus_url', (str_starts_with($school->prospectus_path ?? '', 'http') ? $school->prospectus_path : '')) }}"
                   placeholder="https://drive.google.com/... or https://...">
        </div>
    </div>
</div>

{{-- ── PANEL 2: Academic Details ── --}}
<div class="so-panel">
    <div class="so-panel-title">📚 Academic Details</div>
    <div class="row g-3">

        <div class="col-md-4 col-6">
            <label class="so-label">Board *</label>
            <select class="so-input" name="board" required>
                <option value="">Select Board</option>
                @foreach(['CBSE','ICSE','State Board'] as $b)
                <option value="{{ $b }}"
                    {{ old('board', $school->board)==$b?'selected':'' }}>{{ $b }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4 col-6">
            <label class="so-label">Medium *</label>
            <select class="so-input" name="medium" required>
                <option value="">Select Medium</option>
                @foreach(['English','Hindi','Both'] as $m)
                <option value="{{ $m }}"
                    {{ old('medium', $school->medium)==$m?'selected':'' }}>{{ $m }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4 col-6">
            <label class="so-label">School Type</label>
            <select class="so-input" name="school_type">
                @foreach(['Co-Ed','Boys','Girls'] as $t)
                <option value="{{ $t }}"
                    {{ old('school_type', $school->school_type)==$t?'selected':'' }}>{{ $t }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3 col-6">
            <label class="so-label">Class From *</label>
            <select class="so-input" name="class_from">
                @for($i=1;$i<=12;$i++)
                <option value="{{ $i }}"
                    {{ old('class_from',$school->class_from)==$i?'selected':'' }}>
                    Class {{ $i }}
                </option>
                @endfor
            </select>
        </div>

        <div class="col-md-3 col-6">
            <label class="so-label">Class To *</label>
            <select class="so-input" name="class_to">
                @for($i=1;$i<=12;$i++)
                <option value="{{ $i }}"
                    {{ old('class_to',$school->class_to)==$i?'selected':'' }}>
                    Class {{ $i }}
                </option>
                @endfor
            </select>
        </div>

        <div class="col-md-3 col-6">
            <label class="so-label">Established Year</label>
            <input class="so-input" type="number" name="established_year"
                   min="1800" max="{{ date('Y') }}"
                   value="{{ old('established_year', $school->established_year) }}"
                   placeholder="e.g. 1995">
        </div>

        <div class="col-md-3 col-6">
            <label class="so-label">Total Students</label>
            <input class="so-input" type="number" name="total_students"
                   value="{{ old('total_students', $school->total_students) }}"
                   placeholder="e.g. 1200">
        </div>

        <div class="col-md-6">
            <label class="so-label">Principal Name</label>
            <input class="so-input" type="text" name="principal_name"
                   value="{{ old('principal_name', $school->principal_name) }}"
                   placeholder="e.g. Mr. Ramesh Kumar">
        </div>

        <div class="col-md-6">
            <label class="so-label">Affiliation No.</label>
            <input class="so-input" type="text" name="affiliation_no"
                   value="{{ old('affiliation_no', $school->affiliation_no) }}"
                   placeholder="e.g. 330001">
        </div>

    </div>
</div>

{{-- ── PANEL 3: Admission Details ── --}}
<div class="so-panel">
    <div class="so-panel-title">🎓 Admission Details</div>
    <div class="row g-3">
        <div class="col-md-4 col-6">
            <label class="so-label">Admission Status</label>
            <select class="so-input" name="admission_status">
                <option value="open"
                    {{ old('admission_status',$school->admission_status)=='open'        ?'selected':'' }}>🟢 Open</option>
                <option value="closed"
                    {{ old('admission_status',$school->admission_status)=='closed'      ?'selected':'' }}>🔴 Closed</option>
                <option value="coming_soon"
                    {{ old('admission_status',$school->admission_status)=='coming_soon' ?'selected':'' }}>🟡 Coming Soon</option>
            </select>
        </div>
        <div class="col-md-4 col-6">
            <label class="so-label">Seats Available</label>
            <input class="so-input" type="number" name="seats_available"
                   value="{{ old('seats_available', $school->seats_available) }}"
                   placeholder="e.g. 60">
        </div>
        <div class="col-md-4 col-6">
            <label class="so-label">Admission Fee (₹)</label>
            <input class="so-input" type="number" name="admission_fee"
                   value="{{ old('admission_fee', $school->admission_fee) }}"
                   placeholder="e.g. 10000">
        </div>
    </div>
</div>

{{-- ── PANEL 4: Fee Range ── --}}
<div class="so-panel">
    <div class="so-panel-title">💰 Fee Range (₹/year)</div>
    <div class="row g-3">
        <div class="col-md-4">
            <label class="so-label">Minimum Annual Fee</label>
            <input class="so-input" type="number" name="fee_min"
                   value="{{ old('fee_min', $school->fee_min) }}"
                   placeholder="e.g. 30000">
        </div>
        <div class="col-md-4">
            <label class="so-label">Maximum Annual Fee</label>
            <input class="so-input" type="number" name="fee_max"
                   value="{{ old('fee_max', $school->fee_max) }}"
                   placeholder="e.g. 80000">
        </div>
        <div class="col-md-4">
            <label class="so-label">Transport Fee (₹/year)</label>
            <input class="so-input" type="number" name="transport_fee"
                   value="{{ old('transport_fee', $school->transport_fee) }}"
                   placeholder="e.g. 12000">
        </div>
    </div>
</div>

{{-- ── PANEL 5: Facilities ── --}}
<div class="so-panel">
    <div class="so-panel-title">🏗️ Facilities</div>
    <p style="font-size:12px;color:#888;margin-bottom:14px;">
        Jo facilities available hain unhe select karo
    </p>
    @php
    $allFacilities = [
        'Science Lab','Computer Lab','Library','Sports Ground','School Bus',
        'Cafeteria','Wi-Fi Campus','CCTV Security','Medical Room','Music Room',
        'Swimming Pool','Hostel','Auditorium','Dance Room','Art Room',
    ];
    // DB me JSON ya array store ho sakta hai
    $currentFacilities = old('facilities',
        is_array($school->facilities)
            ? $school->facilities
            : json_decode($school->facilities ?? '[]', true)
    );
    @endphp
    <div class="row g-2">
        @foreach($allFacilities as $fac)
        <div class="col-6 col-md-4">
            <label style="display:flex;align-items:center;gap:8px;font-size:13px;
                          cursor:pointer;padding:6px 0;">
                <input type="checkbox" name="facilities[]" value="{{ $fac }}"
                       {{ in_array($fac, $currentFacilities) ? 'checked' : '' }}
                       style="width:16px;height:16px;accent-color:#e63946;">
                {{ $fac }}
            </label>
        </div>
        @endforeach
    </div>
</div>

{{-- ── PANEL 6: Contact Details ── --}}
<div class="so-panel">
    <div class="so-panel-title">📞 Contact Details</div>
    <div class="row g-3">
        <div class="col-md-4 col-12">
            <label class="so-label">Phone *</label>
            <input class="so-input" type="text" name="phone"
                   value="{{ old('phone', $school->phone) }}"
                   placeholder="9876543210" required>
        </div>
        <div class="col-md-4 col-12">
            <label class="so-label">Email *</label>
            <input class="so-input" type="email" name="email"
                   value="{{ old('email', $school->email) }}"
                   placeholder="school@email.com" required>
        </div>
        <div class="col-md-4 col-12">
            <label class="so-label">Website</label>
            <input class="so-input" type="url" name="website"
                   value="{{ old('website', $school->website) }}"
                   placeholder="https://yourschool.com">
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════
     Submit Buttons
══════════════════════════════════════ --}}
<div class="d-flex gap-3 align-items-center mb-4 flex-wrap">
    <button type="submit" class="btn-red" style="padding:13px 32px;font-size:15px;">
        💾 Save Changes
    </button>
    <a href="{{ route('school-owner.schools.index') }}" class="btn-ghost">Cancel</a>
</div>

</form>
{{-- ✅ Main form BAND — yahan se neeche koi bhi cheez form ke bahar hai --}}

{{-- ══════════════════════════════════════
     DANGER ZONE — Alag form, bilkul bahar
══════════════════════════════════════ --}}
<div style="border-top:1.5px dashed #fecdd3; padding-top:20px; margin-bottom:40px;">
    <p style="font-size:12px; color:#94a3b8; margin-bottom:12px; font-weight:700; text-transform:uppercase; letter-spacing:.05em;">
        ⚠️ Danger Zone
    </p>
    <form action="{{ route('school-owner.schools.destroy', $school->id) }}"
          method="POST"
          onsubmit="return confirm('School permanently delete ho jaayega. Saare admissions aur visits bhi delete honge. Sure ho?');">
        @csrf
        @method('DELETE')
        <button type="submit"
                style="background:#fff5f5; color:#e63946; border:1.5px solid #fecdd3;
                       border-radius:8px; padding:12px 20px; font-size:13px;
                       font-weight:600; cursor:pointer; display:inline-flex;
                       align-items:center; gap:6px;">
            <i class="fas fa-trash"></i> Permanently Delete School
        </button>
    </form>
</div>
</div>

@endsection