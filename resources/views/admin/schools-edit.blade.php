@extends('admin.layout')
@section('title', 'Edit School – SchoolMapr Admin')

@section('content')
@php
    $gallery = $school->gallery_list;
@endphp

<div style="max-width:1080px;" x-data="{
    state: '{{ old('state', $school->state ?: 'Bihar') }}',
    district: '{{ old('district', $school->district ?: 'Patna') }}',
    districts: {
        'Bihar': ['Patna', 'Gaya', 'Muzaffarpur', 'Bhagalpur', 'Darbhanga', 'Purnia', 'Nalanda', 'Begusarai', 'Vaishali', 'Saran', 'Rohtas', 'Samastipur', 'Bhojpur', 'Siwan', 'Madhubani'],
        'Jharkhand': ['Ranchi', 'Jamshedpur', 'Dhanbad', 'Bokaro'],
        'Uttar Pradesh': ['Varanasi', 'Lucknow', 'Kanpur', 'Noida'],
        'Delhi': ['New Delhi', 'Central Delhi', 'South Delhi']
    },
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

    {{-- Header --}}
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; flex-wrap:wrap; gap:12px;">
        <div>
            <h2 style="font-size:22px; font-weight:800; color:#0f2d59; margin:0;">Edit School Profile & Gallery</h2>
            <p style="font-size:13px; color:#64748b; margin:4px 0 0;">
                Editing: <strong style="color:#0f2d59;">{{ $school->name }}</strong> (ID: #{{ $school->id }}) • Patna District
            </p>
        </div>
        <div style="display:flex; gap:10px;">
            <a href="{{ route('school.show', $school->slug) }}" target="_blank"
               style="background:#eff6ff; color:#1d4ed8; border:1px solid #bfdbfe; border-radius:8px; padding:9px 16px; font-size:13px; font-weight:700; text-decoration:none;">
                👁️ View Live Profile ↗
            </a>
            <a href="{{ route('admin.schools') }}"
               style="background:#f1f5f9; color:#475569; border:1px solid #e2e8f0; border-radius:8px; padding:9px 18px; font-size:13px; font-weight:700; text-decoration:none;">
                ← Back to Schools
            </a>
        </div>
    </div>

    {{-- Errors --}}
    @if(isset($errors) && $errors->any())
    <div style="background:#fff5f5; border:1.5px solid #fca5a5; border-radius:10px; padding:14px 18px; margin-bottom:20px;">
        <p style="font-size:13px; font-weight:700; color:#dc2626; margin:0 0 8px;">Please fix the following issues:</p>
        <ul style="margin:0; padding-left:18px; color:#dc2626; font-size:13px;">
            @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Success --}}
    @if(session('success'))
    <div style="background:#f0fdf4; border:1.5px solid #86efac; border-radius:10px; padding:12px 18px; margin-bottom:20px; font-size:13.5px; color:#16a34a; font-weight:700;">
        ✅ {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('admin.schools.crud.update', $school->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Panel 1: Basic & Location Info --}}
        <div style="background:#fff; border:1.5px solid #e8ecf4; border-radius:14px; padding:24px; margin-bottom:20px; box-shadow:0 2px 8px rgba(0,0,0,0.02);">
            <h3 style="font-size:15px; font-weight:800; color:#0f2d59; margin:0 0 18px; padding-bottom:12px; border-bottom:1.5px solid #f1f5f9;">
                🏫 Basic Information & Location (Patna / Bihar)
            </h3>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div style="grid-column:1/-1;">
                    <label style="font-size:12px; font-weight:700; color:#374151; display:block; margin-bottom:5px;">School Name *</label>
                    <input type="text" name="name" value="{{ old('name', $school->name) }}" required
                           style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:10px 14px; font-size:14px; outline:none; box-sizing:border-box;">
                </div>

                {{-- State Selector --}}
                <div>
                    <label style="font-size:12px; font-weight:700; color:#374151; display:block; margin-bottom:5px;">State *</label>
                    <select name="state" x-model="state" @change="district = districts[state][0]"
                            style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:10px 14px; font-size:14px; outline:none; box-sizing:border-box;">
                        <option value="Bihar">Bihar</option>
                        <option value="Jharkhand">Jharkhand</option>
                        <option value="Uttar Pradesh">Uttar Pradesh</option>
                        <option value="Delhi">Delhi NCR</option>
                    </select>
                </div>

                {{-- District Selector --}}
                <div>
                    <label style="font-size:12px; font-weight:700; color:#374151; display:block; margin-bottom:5px;">District *</label>
                    <select name="district" x-model="district"
                            style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:10px 14px; font-size:14px; outline:none; box-sizing:border-box;">
                        <template x-for="d in (districts[state] || ['Patna'])" :key="d">
                            <option :value="d" x-text="d" :selected="d === district"></option>
                        </template>
                    </select>
                </div>

                <div>
                    <label style="font-size:12px; font-weight:700; color:#374151; display:block; margin-bottom:5px;">Area / City / Locality *</label>
                    <input type="text" name="city" value="{{ old('city', $school->city) }}" required
                           placeholder="e.g. Boring Road, Danapur, Patliputra, Kankarbagh"
                           style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:10px 14px; font-size:14px; outline:none; box-sizing:border-box;">
                </div>

                <div>
                    <label style="font-size:12px; font-weight:700; color:#374151; display:block; margin-bottom:5px;">Full Campus Address *</label>
                    <input type="text" name="address" value="{{ old('address', $school->address) }}" required
                           style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:10px 14px; font-size:14px; outline:none; box-sizing:border-box;">
                </div>
            </div>

            <div style="margin-top:16px;">
                <label style="font-size:12px; font-weight:700; color:#374151; display:block; margin-bottom:5px;">About / Overview Description</label>
                <textarea name="description" rows="3"
                          style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:10px 14px; font-size:14px; outline:none; resize:vertical; box-sizing:border-box;">{{ old('description', $school->description) }}</textarea>
            </div>
        </div>

        {{-- Panel 2: 5-SLOT PHOTO GALLERY MANAGER (INSTANT LIVE PREVIEW) --}}
        <div style="background:#fff; border:1.5px solid #e8ecf4; border-radius:14px; padding:24px; margin-bottom:20px; box-shadow:0 2px 8px rgba(0,0,0,0.02);">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px; padding-bottom:12px; border-bottom:1.5px solid #f1f5f9;">
                <div>
                    <h3 style="font-size:15px; font-weight:800; color:#0f2d59; margin:0;">
                        📸 Campus Photo Gallery (All 5 Slots on Profile)
                    </h3>
                    <p style="font-size:12px; color:#64748b; margin:2px 0 0;">
                        Upload files or enter direct image URLs. Changes will reflect instantly on the public school page.
                    </p>
                </div>
                <span style="background:#eff6ff; color:#2563eb; font-size:11px; font-weight:800; padding:4px 10px; border-radius:999px;">
                    6 Profile Photo Slots
                </span>
            </div>

            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:18px;">
                
                {{-- SLOT 1: MAIN CAMPUS / HOME PAGE COVER --}}
                <div style="border:2px solid #93c5fd; border-radius:12px; padding:14px; background:#eff6ff;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                        <strong style="font-size:13px; color:#1e40af;">⭐ 1. Home Page Cover & Main Hero Photo *</strong>
                        <span style="font-size:10px; background:#2563eb; color:#fff; padding:2px 6px; border-radius:4px; font-weight:700;">Home + Hero</span>
                    </div>
                    <p style="font-size:11px; color:#3b82f6; margin:0 0 8px;">
                        This photo is shown on the Home Page search card and the top main hero image.
                    </p>
                    <div style="width:100%; height:140px; border-radius:8px; overflow:hidden; background:#e2e8f0; margin-bottom:10px; border:1px solid #bfdbfe;">
                        <img :src="previews.main" alt="Main Campus Preview" style="width:100%; height:100%; object-fit:cover;">
                    </div>
                    <label style="font-size:11px; font-weight:700; color:#1e3a8a; display:block; margin-bottom:3px;">Upload Image File (JPG/PNG/WEBP):</label>
                    <input type="file" name="gallery_main_file" accept="image/*" @change="updatePreview('main', $event)"
                           style="width:100%; font-size:11.5px; margin-bottom:8px; border:1px solid #cbd5e1; border-radius:6px; padding:6px; background:#fff;">
                    <label style="font-size:11px; font-weight:700; color:#1e3a8a; display:block; margin-bottom:3px;">Or Direct Image URL:</label>
                    <input type="url" name="gallery_main_url" x-model="previews.main" placeholder="https://..."
                           style="width:100%; font-size:12px; border:1px solid #cbd5e1; border-radius:6px; padding:6px 8px; box-sizing:border-box;">
                </div>

                {{-- SLOT 2: CLASSROOM & SMARTBOARDS --}}
                <div style="border:1.5px solid #e2e8f0; border-radius:12px; padding:14px; background:#f8fafc;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                        <strong style="font-size:13px; color:#0f2d59;">2. Classroom & Smartboard</strong>
                        <span style="font-size:10px; background:#2563eb; color:#fff; padding:2px 6px; border-radius:4px; font-weight:700;">Gallery 2</span>
                    </div>
                    <div style="width:100%; height:130px; border-radius:8px; overflow:hidden; background:#e2e8f0; margin-bottom:10px;">
                        <img :src="previews.classroom" alt="Classroom Preview" style="width:100%; height:100%; object-fit:cover;">
                    </div>
                    <label style="font-size:11px; font-weight:700; color:#475569; display:block; margin-bottom:3px;">Upload Image File:</label>
                    <input type="file" name="gallery_classroom_file" accept="image/*" @change="updatePreview('classroom', $event)"
                           style="width:100%; font-size:11.5px; margin-bottom:8px; border:1px solid #cbd5e1; border-radius:6px; padding:6px; background:#fff;">
                    <label style="font-size:11px; font-weight:700; color:#475569; display:block; margin-bottom:3px;">Or Image URL:</label>
                    <input type="url" name="gallery_classroom_url" x-model="previews.classroom" placeholder="https://..."
                           style="width:100%; font-size:12px; border:1px solid #cbd5e1; border-radius:6px; padding:6px 8px; box-sizing:border-box;">
                </div>

                {{-- SLOT 3: ACTIVITY / SPORTS GROUND --}}
                <div style="border:1.5px solid #e2e8f0; border-radius:12px; padding:14px; background:#f8fafc;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                        <strong style="font-size:13px; color:#0f2d59;">3. Activity / Sports Area</strong>
                        <span style="font-size:10px; background:#ca8a04; color:#fff; padding:2px 6px; border-radius:4px; font-weight:700;">Gallery 3</span>
                    </div>
                    <div style="width:100%; height:130px; border-radius:8px; overflow:hidden; background:#e2e8f0; margin-bottom:10px;">
                        <img :src="previews.activity" alt="Activity Preview" style="width:100%; height:100%; object-fit:cover;">
                    </div>
                    <label style="font-size:11px; font-weight:700; color:#475569; display:block; margin-bottom:3px;">Upload Image File:</label>
                    <input type="file" name="gallery_activity_file" accept="image/*" @change="updatePreview('activity', $event)"
                           style="width:100%; font-size:11.5px; margin-bottom:8px; border:1px solid #cbd5e1; border-radius:6px; padding:6px; background:#fff;">
                    <label style="font-size:11px; font-weight:700; color:#475569; display:block; margin-bottom:3px;">Or Image URL:</label>
                    <input type="url" name="gallery_activity_url" x-model="previews.activity" placeholder="https://..."
                           style="width:100%; font-size:12px; border:1px solid #cbd5e1; border-radius:6px; padding:6px 8px; box-sizing:border-box;">
                </div>

                {{-- SLOT 4: SCIENCE & COMPUTER LAB --}}
                <div style="border:1.5px solid #e2e8f0; border-radius:12px; padding:14px; background:#f8fafc;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                        <strong style="font-size:13px; color:#0f2d59;">4. Science & IT Laboratory</strong>
                        <span style="font-size:10px; background:#16a34a; color:#fff; padding:2px 6px; border-radius:4px; font-weight:700;">Gallery 4</span>
                    </div>
                    <div style="width:100%; height:130px; border-radius:8px; overflow:hidden; background:#e2e8f0; margin-bottom:10px;">
                        <img :src="previews.laboratory" alt="Lab Preview" style="width:100%; height:100%; object-fit:cover;">
                    </div>
                    <label style="font-size:11px; font-weight:700; color:#475569; display:block; margin-bottom:3px;">Upload Image File:</label>
                    <input type="file" name="gallery_lab_file" accept="image/*" @change="updatePreview('laboratory', $event)"
                           style="width:100%; font-size:11.5px; margin-bottom:8px; border:1px solid #cbd5e1; border-radius:6px; padding:6px; background:#fff;">
                    <label style="font-size:11px; font-weight:700; color:#475569; display:block; margin-bottom:3px;">Or Image URL:</label>
                    <input type="url" name="gallery_lab_url" x-model="previews.laboratory" placeholder="https://..."
                           style="width:100%; font-size:12px; border:1px solid #cbd5e1; border-radius:6px; padding:6px 8px; box-sizing:border-box;">
                </div>

                {{-- SLOT 5: LIBRARY & LEARNING RESOURCES --}}
                <div style="border:1.5px solid #e2e8f0; border-radius:12px; padding:14px; background:#f8fafc;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                        <strong style="font-size:13px; color:#0f2d59;">5. Library & Learning Resources</strong>
                        <span style="font-size:10px; background:#9333ea; color:#fff; padding:2px 6px; border-radius:4px; font-weight:700;">Gallery 5</span>
                    </div>
                    <div style="width:100%; height:130px; border-radius:8px; overflow:hidden; background:#e2e8f0; margin-bottom:10px;">
                        <img :src="previews.facilities" alt="Facilities Preview" style="width:100%; height:100%; object-fit:cover;">
                    </div>
                    <label style="font-size:11px; font-weight:700; color:#475569; display:block; margin-bottom:3px;">Upload Image File:</label>
                    <input type="file" name="gallery_facilities_file" accept="image/*" @change="updatePreview('facilities', $event)"
                           style="width:100%; font-size:11.5px; margin-bottom:8px; border:1px solid #cbd5e1; border-radius:6px; padding:6px; background:#fff;">
                    <label style="font-size:11px; font-weight:700; color:#475569; display:block; margin-bottom:3px;">Or Image URL:</label>
                    <input type="url" name="gallery_facilities_url" x-model="previews.facilities" placeholder="https://..."
                           style="width:100%; font-size:12px; border:1px solid #cbd5e1; border-radius:6px; padding:6px 8px; box-sizing:border-box;">
                </div>

                {{-- SLOT 6: AUDITORIUM & CAMPUS INFRASTRUCTURE --}}
                <div style="border:1.5px solid #e2e8f0; border-radius:12px; padding:14px; background:#f8fafc;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                        <strong style="font-size:13px; color:#0f2d59;">6. Auditorium & Campus Infrastructure</strong>
                        <span style="font-size:10px; background:#0284c7; color:#fff; padding:2px 6px; border-radius:4px; font-weight:700;">Gallery 6</span>
                    </div>
                    <div style="width:100%; height:130px; border-radius:8px; overflow:hidden; background:#e2e8f0; margin-bottom:10px;">
                        <img :src="previews.campus" alt="Campus Infrastructure Preview" style="width:100%; height:100%; object-fit:cover;">
                    </div>
                    <label style="font-size:11px; font-weight:700; color:#475569; display:block; margin-bottom:3px;">Upload Image File:</label>
                    <input type="file" name="gallery_campus_file" accept="image/*" @change="updatePreview('campus', $event)"
                           style="width:100%; font-size:11.5px; margin-bottom:8px; border:1px solid #cbd5e1; border-radius:6px; padding:6px; background:#fff;">
                    <label style="font-size:11px; font-weight:700; color:#475569; display:block; margin-bottom:3px;">Or Image URL:</label>
                    <input type="url" name="gallery_campus_url" x-model="previews.campus" placeholder="https://..."
                           style="width:100%; font-size:12px; border:1px solid #cbd5e1; border-radius:6px; padding:6px 8px; box-sizing:border-box;">
                </div>

            </div>
        </div>

        {{-- Panel 2.5: PROSPECTUS & BROCHURE UPLOAD --}}
        <div style="background:#fff; border:1.5px solid #e8ecf4; border-radius:14px; padding:24px; margin-bottom:20px; box-shadow:0 2px 8px rgba(0,0,0,0.02);">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px; padding-bottom:12px; border-bottom:1.5px solid #f1f5f9; flex-wrap:wrap; gap:10px;">
                <div>
                    <h3 style="font-size:15px; font-weight:800; color:#0f2d59; margin:0;">
                        📄 Official School Prospectus & Fee Brochure (PDF/Image)
                    </h3>
                    <p style="font-size:12px; color:#64748b; margin:2px 0 0;">
                        Upload the official PDF prospectus or brochure so parents can download and review it on the public school page.
                    </p>
                </div>
                @if($school->prospectus_path)
                <a href="{{ $school->prospectus_url }}" target="_blank"
                   style="background:#eff6ff; color:#2563eb; font-size:12px; font-weight:800; text-decoration:none; padding:6px 14px; border-radius:6px; display:inline-flex; align-items:center; gap:6px;">
                    <i class="fas fa-file-pdf"></i> View Current Prospectus
                </a>
                @endif
            </div>
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(240px, 1fr)); gap:16px;">
                <div>
                    <label style="font-size:12px; font-weight:700; color:#374151; display:block; margin-bottom:5px;">Upload New Prospectus File (PDF / DOC / Image):</label>
                    <input type="file" name="prospectus_file" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg"
                           style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:8px 12px; font-size:13px; background:#fff; box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:12px; font-weight:700; color:#374151; display:block; margin-bottom:5px;">Or Online Prospectus / Drive URL:</label>
                    <input type="url" name="prospectus_url" value="{{ old('prospectus_url', (str_starts_with($school->prospectus_path ?? '', 'http') ? $school->prospectus_path : '')) }}"
                           placeholder="https://drive.google.com/... or https://..."
                           style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:10px 14px; font-size:14px; outline:none; box-sizing:border-box;">
                </div>
            </div>
        </div>

        {{-- Panel 3: Academic Info --}}
        <div style="background:#fff; border:1.5px solid #e8ecf4; border-radius:14px; padding:24px; margin-bottom:20px; box-shadow:0 2px 8px rgba(0,0,0,0.02);">
            <h3 style="font-size:15px; font-weight:800; color:#0f2d59; margin:0 0 18px; padding-bottom:12px; border-bottom:1.5px solid #f1f5f9;">
                📚 Academic Details & Grades
            </h3>
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:16px;">
                <div>
                    <label style="font-size:12px; font-weight:700; color:#374151; display:block; margin-bottom:5px;">Board *</label>
                    <select name="board" required style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:10px 14px; font-size:14px; outline:none; box-sizing:border-box;">
                        <option value="CBSE"        {{ old('board', $school->board)=='CBSE'        ? 'selected':'' }}>CBSE</option>
                        <option value="ICSE"        {{ old('board', $school->board)=='ICSE'        ? 'selected':'' }}>ICSE</option>
                        <option value="State Board" {{ old('board', $school->board)=='State Board' ? 'selected':'' }}>State Board (BSEB)</option>
                    </select>
                </div>

                <div>
                    <label style="font-size:12px; font-weight:700; color:#374151; display:block; margin-bottom:5px;">Medium *</label>
                    <select name="medium" required style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:10px 14px; font-size:14px; outline:none; box-sizing:border-box;">
                        <option value="English" {{ old('medium', $school->medium)=='English' ? 'selected':'' }}>English</option>
                        <option value="Hindi"   {{ old('medium', $school->medium)=='Hindi'   ? 'selected':'' }}>Hindi</option>
                        <option value="Both"    {{ old('medium', $school->medium)=='Both'    ? 'selected':'' }}>Both (Bilingual)</option>
                    </select>
                </div>

                <div>
                    <label style="font-size:12px; font-weight:700; color:#374151; display:block; margin-bottom:5px;">School Type</label>
                    <select name="school_type" style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:10px 14px; font-size:14px; outline:none; box-sizing:border-box;">
                        <option value="Co-Ed" {{ old('school_type', $school->school_type)=='Co-Ed' ? 'selected':'' }}>Co-Educational</option>
                        <option value="Boys"  {{ old('school_type', $school->school_type)=='Boys'  ? 'selected':'' }}>Boys Only</option>
                        <option value="Girls" {{ old('school_type', $school->school_type)=='Girls' ? 'selected':'' }}>Girls Only</option>
                    </select>
                </div>

                <div>
                    <label style="font-size:12px; font-weight:700; color:#374151; display:block; margin-bottom:5px;">Class From *</label>
                    <input type="number" name="class_from" value="{{ old('class_from', $school->class_from) }}" min="1" max="12" required
                           style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:10px 14px; font-size:14px; outline:none; box-sizing:border-box;">
                </div>

                <div>
                    <label style="font-size:12px; font-weight:700; color:#374151; display:block; margin-bottom:5px;">Class To *</label>
                    <input type="number" name="class_to" value="{{ old('class_to', $school->class_to) }}" min="1" max="12" required
                           style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:10px 14px; font-size:14px; outline:none; box-sizing:border-box;">
                </div>

                <div>
                    <label style="font-size:12px; font-weight:700; color:#374151; display:block; margin-bottom:5px;">Approval Status *</label>
                    <select name="status" required style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:10px 14px; font-size:14px; outline:none; box-sizing:border-box;">
                        <option value="approved" {{ old('status', $school->status)=='approved' ? 'selected':'' }}>✅ Approved & Active</option>
                        <option value="pending"  {{ old('status', $school->status)=='pending'  ? 'selected':'' }}>⏳ Pending Review</option>
                        <option value="rejected" {{ old('status', $school->status)=='rejected' ? 'selected':'' }}>🚫 Rejected</option>
                        <option value="inactive" {{ old('status', $school->status)=='inactive' ? 'selected':'' }}>❌ Inactive</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Panel 4: Fee Structure --}}
        <div style="background:#fff; border:1.5px solid #e8ecf4; border-radius:14px; padding:24px; margin-bottom:20px; box-shadow:0 2px 8px rgba(0,0,0,0.02);">
            <h3 style="font-size:15px; font-weight:800; color:#0f2d59; margin:0 0 18px; padding-bottom:12px; border-bottom:1.5px solid #f1f5f9;">
                💰 Verified Fee Structure
            </h3>
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:16px;">
                <div>
                    <label style="font-size:12px; font-weight:700; color:#374151; display:block; margin-bottom:5px;">Min Annual Tuition (₹)</label>
                    <input type="number" name="fee_min" value="{{ old('fee_min', $school->fee_min) }}"
                           style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:10px 14px; font-size:14px; outline:none; box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:12px; font-weight:700; color:#374151; display:block; margin-bottom:5px;">Max Annual Tuition (₹)</label>
                    <input type="number" name="fee_max" value="{{ old('fee_max', $school->fee_max) }}"
                           style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:10px 14px; font-size:14px; outline:none; box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:12px; font-weight:700; color:#374151; display:block; margin-bottom:5px;">Admission Fee (₹ One-time)</label>
                    <input type="number" name="admission_fee" value="{{ old('admission_fee', $school->admission_fee) }}"
                           style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:10px 14px; font-size:14px; outline:none; box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:12px; font-weight:700; color:#374151; display:block; margin-bottom:5px;">Transport Fee (₹/year)</label>
                    <input type="number" name="transport_fee" value="{{ old('transport_fee', $school->transport_fee) }}"
                           style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:10px 14px; font-size:14px; outline:none; box-sizing:border-box;">
                </div>
            </div>
        </div>

        {{-- Panel 5: Contact & Badges --}}
        <div style="background:#fff; border:1.5px solid #e8ecf4; border-radius:14px; padding:24px; margin-bottom:20px; box-shadow:0 2px 8px rgba(0,0,0,0.02);">
            <h3 style="font-size:15px; font-weight:800; color:#0f2d59; margin:0 0 18px; padding-bottom:12px; border-bottom:1.5px solid #f1f5f9;">
                📞 Contact & Verified Badges
            </h3>
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:16px; margin-bottom:18px;">
                <div>
                    <label style="font-size:12px; font-weight:700; color:#374151; display:block; margin-bottom:5px;">Official Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $school->phone) }}"
                           style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:10px 14px; font-size:14px; outline:none; box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:12px; font-weight:700; color:#374151; display:block; margin-bottom:5px;">Official Email</label>
                    <input type="email" name="email" value="{{ old('email', $school->email) }}"
                           style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:10px 14px; font-size:14px; outline:none; box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:12px; font-weight:700; color:#374151; display:block; margin-bottom:5px;">Admission Status</label>
                    <select name="admission_status" required style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:10px 14px; font-size:14px; outline:none; box-sizing:border-box;">
                        <option value="open"        {{ old('admission_status', $school->admission_status)=='open' ? 'selected':'' }}>🟢 Open 2026-27</option>
                        <option value="coming_soon" {{ old('admission_status', $school->admission_status)=='coming_soon' ? 'selected':'' }}>🟡 Opening Soon</option>
                        <option value="closed"      {{ old('admission_status', $school->admission_status)=='closed' ? 'selected':'' }}>🔴 Closed</option>
                    </select>
                </div>
            </div>

            <div style="display:flex; gap:32px; padding-top:14px; border-top:1px solid #f1f5f9; flex-wrap:wrap;">
                <label style="display:flex; align-items:center; gap:8px; font-size:13px; font-weight:700; color:#0f2d59; cursor:pointer;">
                    <input type="checkbox" name="is_verified" value="1" {{ old('is_verified', $school->is_verified) ? 'checked':'' }}
                           style="accent-color:#16a34a; width:18px; height:18px;">
                    ✅ Verified School by SchoolMapr
                </label>
                <label style="display:flex; align-items:center; gap:8px; font-size:13px; font-weight:700; color:#0f2d59; cursor:pointer;">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $school->is_featured) ? 'checked':'' }}
                           style="accent-color:#f59e0b; width:18px; height:18px;">
                    ⭐ Featured on Homepage
                </label>
            </div>
        </div>

        {{-- Buttons --}}
        <div style="display:flex; gap:12px; margin-bottom:40px;">
            <button type="submit"
                    style="background:#0f2d59; color:#fff; border:none; border-radius:10px; padding:14px 40px; font-weight:800; font-size:15px; cursor:pointer;">
                💾 Save Changes & Update Live Profile
            </button>
            <a href="{{ route('admin.schools') }}"
               style="background:#f8fafc; color:#64748b; border:1.5px solid #cbd5e1; border-radius:10px; padding:14px 26px; font-weight:700; font-size:14px; text-decoration:none;">
                Cancel
            </a>
        </div>

    </form>
</div>
@endsection