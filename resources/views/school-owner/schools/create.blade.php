@extends('school-owner.layout')
@section('title', 'List Your School for Free – SchoolMapr Partner')

@section('content')

<div x-data="{
    imageUrl: '{{ old('image_url') }}',
    state: '{{ old('state', 'Bihar') }}',
    district: '{{ old('district', 'Patna') }}',
    districts: {
        'Bihar': ['Patna', 'Gaya', 'Muzaffarpur', 'Bhagalpur', 'Darbhanga', 'Purnia', 'Nalanda', 'Begusarai', 'Vaishali', 'Saran', 'Rohtas', 'Samastipur', 'Bhojpur', 'Siwan', 'Madhubani'],
        'Jharkhand': ['Ranchi', 'Jamshedpur', 'Dhanbad', 'Bokaro'],
        'Uttar Pradesh': ['Varanasi', 'Lucknow', 'Kanpur', 'Noida'],
        'Delhi': ['New Delhi', 'Central Delhi', 'South Delhi']
    },
    previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            this.imageUrl = URL.createObjectURL(file);
        }
    }
}">

    <div class="d-flex align-items-start justify-content-between mb-4 flex-wrap gap-2">
        <div>
            <h4 style="font-size:20px; font-weight:800; color:#0f2d59; margin:0;">
                <i class="fas fa-plus-circle me-2 text-warning"></i>List Your School for Free on SchoolMapr
            </h4>
            <p style="font-size:13px; color:#64748b; margin:4px 0 0;">
                Submit your school details. Our Patna verification team will review and approve within 24 hours.
            </p>
        </div>
        <a href="{{ route('school-owner.schools.index') }}" class="btn-ghost">← Back to My Schools</a>
    </div>

    <div style="background:#eff6ff;border:1.5px solid #bfdbfe;border-radius:12px;padding:14px 18px;margin-bottom:24px;font-size:13px;color:#1e40af;">
        ℹ️ Listing your school on <strong>SchoolMapr</strong> is <strong>100% Free</strong>. Gain direct visibility among parents in Patna looking for admissions.
    </div>

    @if(isset($errors) && $errors->any())
    <div style="background:#fee2e2;border:1.5px solid #fecaca;border-radius:12px;padding:14px 18px;margin-bottom:20px;font-size:13px;color:#991b1b;">
        <strong style="display:block;margin-bottom:6px;">Please fix the following:</strong>
        @foreach($errors->all() as $e)
        <div>• {{ $e }}</div>
        @endforeach
    </div>
    @endif

    <form action="{{ route('school-owner.schools.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    {{-- PANEL 1: Basic & Location Info --}}
    <div class="so-panel">
        <div class="so-panel-title">🏫 Basic School Information & Patna Location</div>
        <div class="row g-3">
            <div class="col-12">
                <label class="so-label">School Name *</label>
                <input class="so-input" type="text" name="name"
                       value="{{ old('name') }}"
                       placeholder="e.g. St. Michael's High School" required>
            </div>

            <div class="col-md-4">
                <label class="so-label">State *</label>
                <select class="so-input" name="state" x-model="state" @change="district = districts[state][0]">
                    <option value="Bihar">Bihar</option>
                    <option value="Jharkhand">Jharkhand</option>
                    <option value="Uttar Pradesh">Uttar Pradesh</option>
                    <option value="Delhi">Delhi NCR</option>
                </select>
            </div>

            <div class="col-md-4">
                <label class="so-label">District *</label>
                <select class="so-input" name="district" x-model="district">
                    <template x-for="d in (districts[state] || ['Patna'])" :key="d">
                        <option :value="d" x-text="d" :selected="d === district"></option>
                    </template>
                </select>
            </div>

            <div class="col-md-4">
                <label class="so-label">Locality / Area *</label>
                <input class="so-input" type="text" name="city"
                       value="{{ old('city', 'Patna') }}" placeholder="e.g. Boring Road, Kurji, Danapur" required>
            </div>

            <div class="col-12">
                <label class="so-label">Full Campus Address *</label>
                <input class="so-input" type="text" name="address"
                       value="{{ old('address') }}"
                       placeholder="Street, Landmark, Patna, Pincode" required>
            </div>

            <div class="col-12">
                <label class="so-label">About the School</label>
                <textarea class="so-input" name="description" rows="3"
                          placeholder="Tell parents about your campus infrastructure, teaching methodology, achievements...">{{ old('description') }}</textarea>
            </div>
        </div>
    </div>

    {{-- PANEL 2: Campus Photos --}}
    <div class="so-panel">
        <div class="so-panel-title">📸 Campus Photo / Banner Image</div>
        <div class="row g-3 align-items-center">
            <div class="col-md-8">
                <label class="so-label">Upload School Photo (PNG, JPG, WebP max 4MB)</label>
                <input class="so-input" type="file" name="image_file" accept="image/*" @change="previewImage" style="padding:8px;">

                <div class="mt-2">
                    <label class="so-label">Or Direct Image URL</label>
                    <input class="so-input" type="url" name="image_url" x-model="imageUrl" placeholder="https://...">
                </div>
            </div>

            <div class="col-md-4 text-center">
                <span style="font-size:11px;font-weight:700;color:#64748b;display:block;margin-bottom:4px;">Image Preview</span>
                <div style="width:100%;height:110px;border-radius:8px;background:#f8fafc;border:1px solid #e2e8f0;display:flex;align-items:center;justify-content:center;overflow:hidden;">
                    <template x-if="imageUrl">
                        <img :src="imageUrl" alt="Preview" style="width:100%;height:100%;object-fit:cover;">
                    </template>
                    <template x-if="!imageUrl">
                        <span style="color:#94a3b8;font-size:11px;">No image selected</span>
                    </template>
                </div>
            </div>
        </div>
    {{-- PANEL 2.5: Prospectus & Brochure --}}
    <div class="so-panel">
        <div class="so-panel-title">📄 Official School Prospectus & Fee Brochure</div>
        <p style="font-size:12px; color:#64748b; margin:-8px 0 14px;">Upload your school's PDF admission prospectus, fee chart, or brochure for parents.</p>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="so-label">Upload Prospectus File (PDF / DOC / Image)</label>
                <input class="so-input" type="file" name="prospectus_file" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg" style="padding:8px;">
            </div>
            <div class="col-md-6">
                <label class="so-label">Or Online Prospectus / Drive URL</label>
                <input class="so-input" type="url" name="prospectus_url" value="{{ old('prospectus_url') }}" placeholder="https://drive.google.com/... or https://...">
            </div>
        </div>
    </div>

    {{-- PANEL 3: Academic & Classes --}}
    <div class="so-panel">
        <div class="so-panel-title">📚 Academic Details</div>
        <div class="row g-3">
            <div class="col-md-4">
                <label class="so-label">Board *</label>
                <select class="so-input" name="board" required>
                    <option value="CBSE"        {{ old('board')=='CBSE'        ? 'selected':'' }}>CBSE</option>
                    <option value="ICSE"        {{ old('board')=='ICSE'        ? 'selected':'' }}>ICSE</option>
                    <option value="State Board" {{ old('board')=='State Board' ? 'selected':'' }}>State Board (BSEB)</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="so-label">Medium *</label>
                <select class="so-input" name="medium" required>
                    <option value="English" {{ old('medium')=='English' ? 'selected':'' }}>English</option>
                    <option value="Hindi"   {{ old('medium')=='Hindi'   ? 'selected':'' }}>Hindi</option>
                    <option value="Both"    {{ old('medium')=='Both'    ? 'selected':'' }}>Both</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="so-label">School Type</label>
                <select class="so-input" name="school_type">
                    <option value="Co-Ed">Co-Educational</option>
                    <option value="Boys">Boys Only</option>
                    <option value="Girls">Girls Only</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="so-label">Class From *</label>
                <input class="so-input" type="number" name="class_from"
                       value="{{ old('class_from', 1) }}" min="1" max="12" required>
            </div>
            <div class="col-md-6">
                <label class="so-label">Class To *</label>
                <input class="so-input" type="number" name="class_to"
                       value="{{ old('class_to', 12) }}" min="1" max="12" required>
            </div>
        </div>
    </div>

    {{-- PANEL 3.5: Admission Details --}}
    <div class="so-panel">
        <div class="so-panel-title">🎓 Admission Details (2026-27 Session)</div>
        <div class="row g-3">
            <div class="col-md-6 col-12">
                <label class="so-label">Admission Status *</label>
                <select class="so-input" name="admission_status">
                    <option value="open" {{ old('admission_status', 'open')=='open' ?'selected':'' }}>🟢 Open (2026-27)</option>
                    <option value="coming_soon" {{ old('admission_status')=='coming_soon' ?'selected':'' }}>🟡 Opening Soon</option>
                    <option value="closed" {{ old('admission_status')=='closed' ?'selected':'' }}>🔴 Closed</option>
                </select>
            </div>
            <div class="col-md-6 col-12">
                <label class="so-label">Seats Available</label>
                <input class="so-input" type="number" name="seats_available"
                       value="{{ old('seats_available', 60) }}" placeholder="e.g. 60">
            </div>
        </div>
    </div>

    {{-- PANEL 4: Fee Structure --}}
    <div class="so-panel">
        <div class="so-panel-title">💰 Fee Structure (Protected for Verified Parents)</div>
        <div class="row g-3">
            <div class="col-md-3">
                <label class="so-label">Min Tuition (₹/year)</label>
                <input class="so-input" type="number" name="fee_min"
                       value="{{ old('fee_min') }}" placeholder="e.g. 30000">
            </div>
            <div class="col-md-3">
                <label class="so-label">Max Tuition (₹/year)</label>
                <input class="so-input" type="number" name="fee_max"
                       value="{{ old('fee_max') }}" placeholder="e.g. 70000">
            </div>
            <div class="col-md-3">
                <label class="so-label">One-Time Admission Fee (₹)</label>
                <input class="so-input" type="number" name="admission_fee"
                       value="{{ old('admission_fee') }}" placeholder="e.g. 15000">
            </div>
            <div class="col-md-3">
                <label class="so-label">Transport Fee (₹/year)</label>
                <input class="so-input" type="number" name="transport_fee"
                       value="{{ old('transport_fee') }}" placeholder="e.g. 12000">
            </div>
        </div>
    </div>

    {{-- PANEL 5: Contact Info --}}
    <div class="so-panel">
        <div class="so-panel-title">📞 School Contact Information</div>
        <div class="row g-3">
            <div class="col-md-4">
                <label class="so-label">Phone *</label>
                <input class="so-input" type="text" name="phone"
                       value="{{ old('phone') }}" placeholder="+91 612 XXXXXXX" required>
            </div>
            <div class="col-md-4">
                <label class="so-label">Email *</label>
                <input class="so-input" type="email" name="email"
                       value="{{ old('email') }}" placeholder="admissions@school.edu.in" required>
            </div>
            <div class="col-md-4">
                <label class="so-label">Website</label>
                <input class="so-input" type="url" name="website"
                       value="{{ old('website') }}" placeholder="https://yourschool.com">
            </div>
        </div>
    </div>

    <div class="d-flex gap-3 mt-4">
        <button type="submit" class="btn-yellow px-4 py-2" style="font-size:14px;">
            🚀 Submit School for Admin Approval
        </button>
        <a href="{{ route('school-owner.schools.index') }}" class="btn-ghost py-2">
            Cancel
        </a>
    </div>

    </form>
</div>

@endsection