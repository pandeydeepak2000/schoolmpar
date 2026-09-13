@extends('school-owner.layout')
@section('title', 'Enquiries')

@section('content')

@if(session('success'))
<div class="alert-success">✅ {{ session('success') }}</div>
@endif

{{-- Header --}}
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 style="font-size:18px;font-weight:800;color:#1d3557;margin:0;">📩 Parent Enquiries</h4>
        <p style="font-size:13px;color:#94a3b8;margin:4px 0 0;">All enquiries received on your schools</p>
    </div>
    <a href="{{ route('school-owner.enquiries.index') }}?export=1&{{ http_build_query(request()->except('export')) }}"
       style="background:#1d3557;color:#fff;border-radius:10px;padding:9px 18px;
              font-size:13px;font-weight:700;text-decoration:none;
              display:inline-flex;align-items:center;gap:6px;">
        📥 Export CSV
    </a>
</div>

{{-- Stats --}}
<div class="row g-3 mb-4">
    @foreach([
        ['📩','#eff6ff','#2563eb',$stats['total'],    'Total'],
        ['🆕','#fef9c3','#ca8a04',$stats['new'],      'New'],
        ['📞','#dbeafe','#2563eb',$stats['contacted'], 'Contacted'],
        ['✅','#dcfce7','#16a34a',$stats['replied'],   'Replied'],
        ['🔒','#f1f5f9','#64748b',$stats['closed'],   'Closed'],
        ['📅','#fff5f5','#e63946',$stats['today'],    'Today'],
    ] as [$icon,$bg,$color,$val,$label])
    <div class="col-4 col-md-2">
        <div class="stat-card" style="text-align:center;padding:14px 8px;">
            <div style="font-size:20px;margin-bottom:2px;">{{ $icon }}</div>
            <div style="font-size:20px;font-weight:900;color:{{ $color }};">{{ $val }}</div>
            <div style="font-size:11px;color:#888;margin-top:1px;">{{ $label }}</div>
        </div>
    </div>
    @endforeach
</div>

{{-- Search + Filters --}}
<form method="GET" action="{{ route('school-owner.enquiries.index') }}" id="filterForm">

    {{-- Search Bar --}}
    <div style="position:relative;margin-bottom:12px;">
        <span style="position:absolute;left:14px;top:50%;transform:translateY(-50%);
                     font-size:15px;color:#94a3b8;pointer-events:none;">🔍</span>
        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Search by parent name, mobile or school name..."
               autocomplete="off"
               style="width:100%;padding:11px 14px 11px 42px;
                      border:1.5px solid #e2e8f0;border-radius:12px;
                      font-size:14px;font-family:'Inter',sans-serif;
                      outline:none;transition:border .2s;background:#fff;"
               onfocus="this.style.borderColor='#e63946';this.style.boxShadow='0 0 0 3px rgba(230,57,70,.07)'"
               onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
        @if(request('search'))
        <button type="button" onclick="clearField('search')"
                style="position:absolute;right:12px;top:50%;transform:translateY(-50%);
                       background:none;border:none;cursor:pointer;color:#94a3b8;font-size:16px;padding:4px;">✕</button>
        @endif
    </div>

    {{-- Filter Row --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(170px,1fr));
                gap:10px;margin-bottom:12px;align-items:end;">

        {{-- School --}}
        <div>
            <label style="font-size:11px;font-weight:700;color:#64748b;display:block;margin-bottom:4px;">🏫 School</label>
            <select name="school_id"
                    style="width:100%;padding:10px 12px;border:1.5px solid #e2e8f0;border-radius:10px;
                           font-size:13px;font-family:'Inter',sans-serif;outline:none;cursor:pointer;
                           color:#1d3557;background:#fff;"
                    onfocus="this.style.borderColor='#e63946'" onblur="this.style.borderColor='#e2e8f0'">
                <option value="">All Schools</option>
                @foreach($mySchools as $school)
                <option value="{{ $school->id }}" {{ request('school_id') == $school->id ? 'selected' : '' }}>
                    {{ Str::limit($school->name, 28) }}
                </option>
                @endforeach
            </select>
        </div>

        {{-- Class --}}
        <div>
            <label style="font-size:11px;font-weight:700;color:#64748b;display:block;margin-bottom:4px;">🎓 Class</label>
            <select name="child_class"
                    style="width:100%;padding:10px 12px;border:1.5px solid #e2e8f0;border-radius:10px;
                           font-size:13px;font-family:'Inter',sans-serif;outline:none;cursor:pointer;
                           color:#1d3557;background:#fff;"
                    onfocus="this.style.borderColor='#e63946'" onblur="this.style.borderColor='#e2e8f0'">
                <option value="">All Classes</option>
                @for($i=1;$i<=12;$i++)
                <option value="{{ $i }}" {{ request('child_class')==$i?'selected':'' }}>Class {{ $i }}</option>
                @endfor
            </select>
        </div>

        {{-- Date From --}}
        <div>
            <label style="font-size:11px;font-weight:700;color:#64748b;display:block;margin-bottom:4px;">📅 Date From</label>
            <input type="date" name="date_from" value="{{ request('date_from') }}"
                   style="width:100%;padding:10px 12px;border:1.5px solid #e2e8f0;border-radius:10px;
                          font-size:13px;font-family:'Inter',sans-serif;outline:none;color:#1d3557;background:#fff;"
                   onfocus="this.style.borderColor='#e63946'" onblur="this.style.borderColor='#e2e8f0'">
        </div>

        {{-- Date To --}}
        <div>
            <label style="font-size:11px;font-weight:700;color:#64748b;display:block;margin-bottom:4px;">📅 Date To</label>
            <input type="date" name="date_to" value="{{ request('date_to') }}"
                   style="width:100%;padding:10px 12px;border:1.5px solid #e2e8f0;border-radius:10px;
                          font-size:13px;font-family:'Inter',sans-serif;outline:none;color:#1d3557;background:#fff;"
                   onfocus="this.style.borderColor='#e63946'" onblur="this.style.borderColor='#e2e8f0'">
        </div>

        {{-- Sort --}}
        <div>
            <label style="font-size:11px;font-weight:700;color:#64748b;display:block;margin-bottom:4px;">🔃 Sort By</label>
            <select name="sort"
                    style="width:100%;padding:10px 12px;border:1.5px solid #e2e8f0;border-radius:10px;
                           font-size:13px;font-family:'Inter',sans-serif;outline:none;cursor:pointer;
                           color:#1d3557;background:#fff;"
                    onfocus="this.style.borderColor='#e63946'" onblur="this.style.borderColor='#e2e8f0'">
                <option value="latest" {{ request('sort','latest')==='latest' ?'selected':'' }}>Newest First</option>
                <option value="oldest" {{ request('sort')==='oldest' ?'selected':'' }}>Oldest First</option>
                <option value="name"   {{ request('sort')==='name'   ?'selected':'' }}>Name A–Z</option>
            </select>
        </div>

        {{-- Buttons --}}
        <div style="display:flex;gap:8px;align-items:end;">
            <button type="submit"
                    style="flex:1;background:#e63946;color:#fff;border:none;border-radius:10px;
                           padding:11px 14px;font-size:13px;font-weight:700;cursor:pointer;
                           font-family:'Inter',sans-serif;transition:background .2s;white-space:nowrap;"
                    onmouseover="this.style.background='#c1121f'"
                    onmouseout="this.style.background='#e63946'">
                Apply
            </button>
            <a href="{{ route('school-owner.enquiries.index') }}"
               style="flex:1;background:#f1f5f9;color:#64748b;border-radius:10px;padding:11px 10px;
                      font-size:13px;font-weight:600;text-align:center;text-decoration:none;
                      white-space:nowrap;transition:background .2s;"
               onmouseover="this.style.background='#e2e8f0'"
               onmouseout="this.style.background='#f1f5f9'">
                Clear
            </a>
        </div>
    </div>

    <input type="hidden" name="status" id="statusInput" value="{{ request('status','') }}">
</form>

{{-- Status Tabs --}}
<div style="display:flex;gap:6px;margin-bottom:16px;flex-wrap:wrap;">
    @foreach([
        [''         ,'All'        ,$stats['total']],
        ['new'      ,'🆕 New'     ,$stats['new']],
        ['contacted','📞 Contacted',$stats['contacted']],
        ['replied'  ,'✅ Replied'  ,$stats['replied']],
        ['closed'   ,'🔒 Closed'  ,$stats['closed']],
    ] as [$val,$label,$count])
    <button type="button" onclick="setStatus('{{ $val }}')"
            style="padding:7px 14px;border-radius:100px;font-size:12px;font-weight:600;
                   cursor:pointer;transition:all .2s;border:1.5px solid;
                   {{ request('status')===$val
                      ? 'background:#e63946;color:#fff;border-color:#e63946;'
                      : 'background:#fff;color:#555;border-color:#dee2e6;' }}">
        {{ $label }}
        <span style="background:rgba(0,0,0,.08);border-radius:100px;padding:1px 7px;
                     font-size:11px;margin-left:3px;">{{ $count }}</span>
    </button>
    @endforeach
</div>

{{-- Active Filter Chips --}}
@php
$mySchoolsCollection = collect($mySchools);
$activeFilters = array_filter([
    'search'     => request('search'),
    'school_id'  => request('school_id')   ? ($mySchoolsCollection->find(request('school_id'))->name ?? null) : null,
    'child_class'=> request('child_class') ? 'Class '.request('child_class') : null,
    'date_from'  => request('date_from')   ? 'From: '.request('date_from') : null,
    'date_to'    => request('date_to')     ? 'To: '.request('date_to')     : null,
]);
@endphp
@if(count($activeFilters))
<div style="display:flex;flex-wrap:wrap;gap:6px;margin-bottom:14px;align-items:center;">
    <span style="font-size:12px;color:#94a3b8;font-weight:600;">Active filters:</span>
    @foreach($activeFilters as $key=>$chip)
    <span style="background:#fff0f0;color:#e63946;border:1px solid #fca5a5;
                 border-radius:100px;padding:3px 12px;font-size:12px;font-weight:600;
                 display:inline-flex;align-items:center;gap:5px;">
        {{ $chip }}
        <a href="?{{ http_build_query(array_merge(request()->except($key),['status'=>request('status')])) }}"
           style="color:#e63946;text-decoration:none;font-size:14px;line-height:1;">✕</a>
    </span>
    @endforeach
</div>
@endif

{{-- Result Count --}}
<p style="font-size:13px;color:#94a3b8;margin-bottom:12px;">
    Showing <strong style="color:#1d3557;">{{ $enquiries->total() }}</strong>
    enquir{{ $enquiries->total()!=1?'ies':'y' }}
    @if(request()->hasAny(['search','school_id','child_class','date_from','date_to','status']))
    &mdash; filtered
    @endif
</p>

{{-- Enquiry Cards --}}
@forelse($enquiries as $enq)
@php
$stMap = [
    'new'       => ['#fef9c3','#ca8a04','⏳ New'],
    'contacted' => ['#dbeafe','#2563eb','📞 Contacted'],
    'replied'   => ['#dcfce7','#16a34a','✅ Replied'],
    'closed'    => ['#f1f5f9','#64748b','🔒 Closed'],
];
$st = $stMap[$enq->status] ?? $stMap['new'];
@endphp

<div style="background:#fff;border-radius:14px;border:1.5px solid #f0f0f0;
            padding:18px;margin-bottom:10px;transition:box-shadow .2s;"
     onmouseover="this.style.boxShadow='0 4px 16px rgba(0,0,0,.08)'"
     onmouseout="this.style.boxShadow='none'">

    @php
        $phoneNum = $enq->mobile ?: $enq->phone;
        $cleanPhone = preg_replace('/[^0-9]/', '', $phoneNum);
        if (strlen($cleanPhone) == 10) $cleanPhone = '91' . $cleanPhone;

        $schoolSlug = $enq->school->slug ?? '';
        $schoolUrl  = $schoolSlug ? url('/schools/' . $schoolSlug) : url('/');
        $waText     = "Hello " . ($enq->parent_name ?: 'Parent') . ", greetings from " . ($enq->school->name ?? 'our School Admissions Desk') . "! Thank you for your inquiry on SchoolMapr. Here is the verified admission brochure, fee structure & details: " . $schoolUrl . " . Feel free to reply here if you have any questions!";
        $waLink     = "https://wa.me/" . $cleanPhone . "?text=" . urlencode($waText);

        $parentEmail = $enq->parent_email ?? ($enq->user->email ?? '');
    @endphp

    <div class="d-flex align-items-start gap-3 flex-wrap">

        <div style="width:46px;height:46px;flex-shrink:0;border-radius:12px;
                    background:linear-gradient(135deg,#1d3557,#457b9d);
                    display:flex;align-items:center;justify-content:center;font-size:20px;">
            👨‍👩‍👧
        </div>

        <div style="flex:1;min-width:0;">
            <div style="font-size:15px;font-weight:800;color:#1d3557;">
                {{ $enq->parent_name }}
                @if($parentEmail)
                    <span style="font-size:12px;font-weight:500;color:#64748b;margin-left:6px;">({{ $parentEmail }})</span>
                @endif
            </div>
            <div style="font-size:12px;color:#888;margin-top:3px;display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                <span>🏫 {{ $enq->school->name ?? '—' }}</span>
                <span>•</span>
                @if($enq->is_brochure_request)
                    <span style="background:#f3e8ff;color:#7e22ce;padding:2px 8px;border-radius:6px;font-weight:800;font-size:11px;border:1px solid #d8b4fe;">
                        📄 Brochure Request
                    </span>
                @else
                    <span style="background:#eff6ff;color:#1d4ed8;padding:2px 8px;border-radius:6px;font-weight:700;font-size:11px;">
                        🎓 {{ $enq->formatted_class }}
                    </span>
                @endif
                <span>•</span>
                <span>🕐 {{ $enq->created_at->diffForHumans() }}</span>
            </div>

            <div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:10px;">
                <a href="tel:{{ $phoneNum }}"
                   style="display:inline-flex;align-items:center;gap:6px;
                          background:#f0fdf4;color:#16a34a;border:1.5px solid #86efac;
                          border-radius:8px;padding:5px 12px;font-size:12.5px;font-weight:700;
                          text-decoration:none;transition:all .2s;"
                   onmouseover="this.style.background='#16a34a';this.style.color='#fff'"
                   onmouseout="this.style.background='#f0fdf4';this.style.color='#16a34a'">
                    📞 {{ $phoneNum }}
                </a>

                @if($cleanPhone)
                <a href="{{ $waLink }}" target="_blank"
                   style="display:inline-flex;align-items:center;gap:6px;
                          background:#25D366;color:#fff;border-radius:8px;padding:5px 12px;
                          font-size:12.5px;font-weight:700;text-decoration:none;box-shadow:0 2px 6px rgba(37,211,102,.25);">
                    <i class="fab fa-whatsapp"></i> Send on WhatsApp
                </a>
                @endif

                <button type="button"
                        onclick="openOwnerBrochureModal('{{ $enq->id }}', '{{ addslashes($enq->parent_name) }}', '{{ $parentEmail }}', '{{ addslashes($enq->school->name ?? 'School') }}', '{{ $enq->school?->prospectus_path ? 1 : 0 }}')"
                        style="display:inline-flex;align-items:center;gap:6px;
                               background:#0f2d59;color:#fff;border:none;border-radius:8px;
                               padding:5px 12px;font-size:12.5px;font-weight:700;cursor:pointer;">
                    <i class="fas fa-envelope"></i> Email Brochure
                </button>

                @if($enq->message)
                <span style="background:#f8f9fa;color:#555;border-radius:8px;
                             padding:5px 12px;font-size:12px;font-style:italic;
                             max-width:280px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"
                      title="{{ $enq->message }}">
                    💬 "{{ $enq->message }}"
                </span>
                @endif
            </div>
        </div>

        <div style="display:flex;flex-direction:column;align-items:flex-end;gap:8px;flex-shrink:0;">
            <span style="background:{{ $st[0] }};color:{{ $st[1] }};
                         padding:4px 12px;border-radius:100px;font-size:11px;font-weight:700;">
                {{ $st[2] }}
            </span>

            <select onchange="updateStatus({{ $enq->id }}, this.value, this)"
                    style="border:1.5px solid #dee2e6;border-radius:8px;padding:5px 8px;
                           font-size:12px;font-weight:600;outline:none;cursor:pointer;
                           color:#1d3557;font-family:'Inter',sans-serif;">
                <option value="new"       {{ $enq->status=='new'       ?'selected':'' }}>⏳ New</option>
                <option value="contacted" {{ $enq->status=='contacted' ?'selected':'' }}>📞 Contacted</option>
                <option value="replied"   {{ $enq->status=='replied'   ?'selected':'' }}>✅ Replied</option>
                <option value="closed"    {{ $enq->status=='closed'    ?'selected':'' }}>🔒 Closed</option>
            </select>

            <a href="{{ route('school-owner.enquiries.show', $enq->id) }}"
               style="font-size:12px;color:#457b9d;font-weight:600;text-decoration:none;">
                View Details →
            </a>
        </div>
    </div>
</div>

@empty
<div style="text-align:center;padding:70px 20px;background:#fff;
            border-radius:18px;border:1.5px solid #f0f0f0;">
    <div style="font-size:52px;margin-bottom:14px;">📭</div>
    <h5 style="color:#1d3557;font-weight:800;margin-bottom:8px;">
        @if(request()->hasAny(['search','school_id','status','child_class','date_from','date_to']))
            No enquiries match your filters.
        @else
            No enquiries received yet!
        @endif
    </h5>
    <p style="color:#888;font-size:14px;margin-bottom:16px;">
        @if(request()->hasAny(['search','school_id','status','child_class','date_from','date_to']))
            Try adjusting your filters or
            <a href="{{ route('school-owner.enquiries.index') }}"
               style="color:#e63946;font-weight:700;">clear all</a>.
        @else
            When parents submit enquiries on your school, they will appear here.
        @endif
    </p>
</div>
@endforelse

{{-- Pagination --}}
@if($enquiries->hasPages())
<div class="mt-4 d-flex justify-content-center">
    {{ $enquiries->appends(request()->except('page'))->links() }}
</div>
@endif

{{-- Modal: Send Brochure to Parent Email (School Owner) --}}
<div id="ownerBrochureModal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(15,23,42,0.65);z-index:9999;align-items:center;justify-content:center;padding:12px;">
    <div style="background:#fff;border-radius:16px;max-width:520px;width:100%;max-height:90vh;display:flex;flex-direction:column;box-shadow:0 20px 60px rgba(0,0,0,0.3);overflow:hidden;">
        <div style="background:#1d3557;color:#fff;padding:16px 20px;display:flex;align-items:center;justify-content:space-between;flex-shrink:0;">
            <div style="font-size:15px;font-weight:900;"><i class="fas fa-file-pdf text-warning me-2"></i> Email Official School Brochure</div>
            <button type="button" onclick="closeOwnerBrochureModal()" style="background:transparent;border:none;color:#fff;font-size:22px;line-height:1;cursor:pointer;">&times;</button>
        </div>

        <form id="ownerBrochureForm" method="POST" action="" enctype="multipart/form-data" style="display:flex;flex-direction:column;overflow-y:auto;flex:1;margin:0;">
            @csrf
            <div style="padding:20px;overflow-y:auto;">
                <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:12px 16px;margin-bottom:16px;">
                    <div style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;">School Campus</div>
                    <div id="ownerModalSchoolName" style="font-size:14px;font-weight:800;color:#1d3557;margin-top:2px;">—</div>
                    <div id="ownerModalPdfStatus" style="font-size:11.5px;color:#16a34a;margin-top:4px;font-weight:600;">
                        <i class="fas fa-check-circle"></i> Official Prospectus PDF will be attached & linked
                    </div>
                </div>

                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:12px;font-weight:700;color:#334155;margin-bottom:4px;">Parent / Guardian Name</label>
                    <input type="text" id="ownerModalParentName" readonly style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;background:#f8fafc;color:#475569;">
                </div>

                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:12px;font-weight:700;color:#334155;margin-bottom:4px;">Parent Email Address *</label>
                    <input type="email" name="email" id="ownerModalParentEmail" required placeholder="Enter parent's email address" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;color:#1d3557;font-weight:600;" onfocus="this.style.borderColor='#1d3557'" onblur="this.style.borderColor='#e2e8f0'">
                </div>

                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:12px;font-weight:700;color:#334155;margin-bottom:4px;">
                        <i class="fas fa-paperclip me-1 text-primary"></i> Attach Brochure / Prospectus File (Optional)
                    </label>
                    <input type="file" name="brochure_file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" style="width:100%;padding:7px 10px;border:1.5px dashed #cbd5e1;border-radius:8px;font-size:12px;background:#f8fafc;color:#475569;cursor:pointer;">
                    <div style="font-size:11px;color:#94a3b8;margin-top:3px;">
                        Attach any PDF / Brochure file (Max 15MB). If selected, it will be emailed directly to the parent.
                    </div>
                </div>

                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:12px;font-weight:700;color:#334155;margin-bottom:4px;">Message from Principal / Admissions Office</label>
                    <textarea name="message" rows="3" placeholder="e.g. Greetings from our admissions team! Please find our official prospectus and transparent fee breakup..." style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:12.5px;outline:none;color:#334155;" onfocus="this.style.borderColor='#1d3557'" onblur="this.style.borderColor='#e2e8f0'"></textarea>
                </div>

                <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:20px;">
                    <button type="button" onclick="closeOwnerBrochureModal()" style="padding:10px 18px;border:1.5px solid #e2e8f0;background:#fff;border-radius:8px;font-size:13px;font-weight:700;color:#64748b;cursor:pointer;">Cancel</button>
                    <button type="submit" style="padding:10px 22px;background:#e63946;border:none;border-radius:8px;font-size:13px;font-weight:800;color:#fff;cursor:pointer;">
                        🚀 Send Brochure Packet
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openOwnerBrochureModal(enquiryId, parentName, parentEmail, schoolName, hasPdf) {
    const modal = document.getElementById('ownerBrochureModal');
    const form  = document.getElementById('ownerBrochureForm');
    form.action = '/school-owner/enquiries/' + enquiryId + '/send-brochure';

    document.getElementById('ownerModalSchoolName').innerText = schoolName;
    document.getElementById('ownerModalParentName').value = parentName;
    document.getElementById('ownerModalParentEmail').value = parentEmail || '';

    const pdfStatusEl = document.getElementById('ownerModalPdfStatus');
    if (hasPdf == 1) {
        pdfStatusEl.innerHTML = '<i class="fas fa-check-circle"></i> Official Prospectus PDF will be attached & linked';
        pdfStatusEl.style.color = '#16a34a';
    } else {
        pdfStatusEl.innerHTML = '<i class="fas fa-info-circle"></i> Verified Digital School Profile & Fee Sheet will be sent';
        pdfStatusEl.style.color = '#0284c7';
    }

    modal.style.display = 'flex';
}

function closeOwnerBrochureModal() {
    document.getElementById('ownerBrochureModal').style.display = 'none';
}

function setStatus(val) {
    document.getElementById('statusInput').value = val;
    document.getElementById('filterForm').submit();
}

function clearField(name) {
    const el = document.querySelector(`[name="${name}"]`);
    if (el) el.value = '';
    document.getElementById('filterForm').submit();
}

function updateStatus(enquiryId, newStatus, selectEl) {
    const row   = selectEl.closest('div[style*="background:#fff"]');
    const badge = row.querySelector('span[style*="border-radius:100px"]');
    const map   = {
        'new'      : ['#fef9c3','#ca8a04','⏳ New'],
        'contacted': ['#dbeafe','#2563eb','📞 Contacted'],
        'replied'  : ['#dcfce7','#16a34a','✅ Replied'],
        'closed'   : ['#f1f5f9','#64748b','🔒 Closed'],
    };
    const [bg,color,label] = map[newStatus];
    badge.style.background = bg;
    badge.style.color      = color;
    badge.textContent      = label;

    fetch(`/school-owner/enquiries/${enquiryId}/status`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
            'Accept'      : 'application/json',
        },
        body: JSON.stringify({ status: newStatus }),
    })
    .then(r => r.json())
    .then(data => { if (!data.success) location.reload(); })
    .catch(() => { alert('Network error. Please refresh.'); location.reload(); });
}

let searchTimer;
document.querySelector('[name="search"]').addEventListener('input', function() {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(() => document.getElementById('filterForm').submit(), 500);
});
</script>
@endpush