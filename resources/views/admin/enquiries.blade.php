@extends('admin.layout')
@section('title', 'All Enquiries & Brochure Requests')
@section('page-title', 'All Enquiries & Brochure Requests')
@section('page-sub', 'Manage parent leads, admission enquiries and brochure delivery')

@section('content')

<!-- Stats Strip -->
<div class="stat-grid-4" style="display:grid;grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));gap:14px;margin-bottom:18px;">
    <div class="stat-card" style="display:flex;align-items:center;gap:14px;padding:16px 18px;">
        <div style="width:38px;height:38px;background:#eff6ff;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="fas fa-inbox" style="color:#3b82f6;font-size:15px;"></i>
        </div>
        <div>
            <div style="font-size:22px;font-weight:900;color:#0f1729;line-height:1;">{{ $enquiries->total() }}</div>
            <div style="font-size:11.5px;color:#64748b;margin-top:3px;font-weight:500;">Total Inquiries</div>
        </div>
    </div>

    <div class="stat-card" style="display:flex;align-items:center;gap:14px;padding:16px 18px;">
        <div style="width:38px;height:38px;background:#fef3c7;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="fas fa-bolt" style="color:#d97706;font-size:14px;"></i>
        </div>
        <div>
            <div style="font-size:22px;font-weight:900;color:#0f1729;line-height:1;">{{ $new_count }}</div>
            <div style="font-size:11.5px;color:#64748b;margin-top:3px;font-weight:500;">New / Action Needed</div>
        </div>
        @if($new_count > 0)
        <span class="badge badge-blue" style="margin-left:auto;background:#fee2e2;color:#b91c1c;">New Leads</span>
        @endif
    </div>

    <div class="stat-card" style="display:flex;align-items:center;gap:14px;padding:16px 18px;">
        <div style="width:38px;height:38px;background:#f3e8ff;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="fas fa-file-pdf" style="color:#9333ea;font-size:15px;"></i>
        </div>
        <div>
            <div style="font-size:22px;font-weight:900;color:#0f1729;line-height:1;">{{ $brochure_count ?? 0 }}</div>
            <div style="font-size:11.5px;color:#64748b;margin-top:3px;font-weight:500;">Brochure Requests</div>
        </div>
    </div>

    <div class="stat-card" style="display:flex;align-items:center;gap:14px;padding:16px 18px;">
        <div style="width:38px;height:38px;background:#f0fdf4;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="fas fa-check-circle" style="color:#22c55e;font-size:14px;"></i>
        </div>
        <div>
            <div style="font-size:22px;font-weight:900;color:#0f1729;line-height:1;">{{ $contacted_count }}</div>
            <div style="font-size:11.5px;color:#64748b;margin-top:3px;font-weight:500;">Contacted / Replied</div>
        </div>
    </div>
</div>

<!-- Search & Filter Bar -->
<div class="panel" style="margin-bottom:16px;overflow:visible;">
    <div style="padding:14px 18px;">
        <form method="GET" action="/admin/enquiries">
            <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
                <div style="position:relative;flex:1;min-width:220px;">
                    <i class="fas fa-search" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#c4c9d4;font-size:12px;"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search by parent name, mobile, or school..."
                        style="width:100%;border:1.5px solid #e8ecf4;border-radius:9px;padding:9px 14px 9px 34px;font-size:13px;outline:none;color:#374151;"
                        onfocus="this.style.borderColor='#f43f5e'" onblur="this.style.borderColor='#e8ecf4'">
                </div>

                <select name="type" style="border:1.5px solid #e8ecf4;border-radius:9px;padding:9px 14px;font-size:13px;outline:none;color:#374151;background:#fff;min-width:170px;">
                    <option value="">All Inquiry Types</option>
                    <option value="brochure"  {{ request('type')=='brochure'  ? 'selected':'' }}>📄 Brochure Requests</option>
                    <option value="admission" {{ request('type')=='admission' ? 'selected':'' }}>🎓 Admission Inquiries</option>
                </select>

                <select name="status" style="border:1.5px solid #e8ecf4;border-radius:9px;padding:9px 14px;font-size:13px;outline:none;color:#374151;background:#fff;min-width:140px;">
                    <option value="">All Statuses</option>
                    <option value="new"       {{ request('status')=='new'       ? 'selected':'' }}>⏳ New</option>
                    <option value="contacted" {{ request('status')=='contacted' ? 'selected':'' }}>📞 Contacted</option>
                    <option value="closed"    {{ request('status')=='closed'    ? 'selected':'' }}>🔒 Closed</option>
                </select>

                <button type="submit" style="background:#0f2040;color:#fff;border:none;border-radius:9px;padding:9px 20px;font-size:13px;font-weight:700;cursor:pointer;">
                    <i class="fas fa-filter" style="margin-right:6px;"></i>Filter
                </button>

                @if(request('search') || request('status') || request('type'))
                <a href="/admin/enquiries" style="font-size:12.5px;color:#f43f5e;font-weight:700;text-decoration:none;">
                    <i class="fas fa-times" style="margin-right:4px;"></i>Clear
                </a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Table -->
<div class="panel">
    <div class="panel-header" style="display:flex;align-items:center;justify-content:space-between;">
        <div class="panel-title">
            <i class="fas fa-inbox" style="color:#f43f5e;font-size:12px;"></i>
            Inquiries List ({{ $enquiries->total() }})
        </div>
        <div style="font-size:12px;color:#64748b;">
            💡 Click <strong>WhatsApp</strong> or <strong>Email Brochure</strong> to deliver school information directly to parents.
        </div>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Parent Name</th>
                <th>Contact</th>
                <th>School Target</th>
                <th>Type / Target</th>
                <th>Date</th>
                <th>Status</th>
                <th>Quick Actions & Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($enquiries as $i => $enquiry)
            @php
                $phoneNum = $enquiry->mobile ?: $enquiry->phone;
                $cleanPhone = preg_replace('/[^0-9]/', '', $phoneNum);
                if (strlen($cleanPhone) == 10) $cleanPhone = '91' . $cleanPhone;

                $schoolSlug = $enquiry->school->slug ?? '';
                $schoolUrl  = $schoolSlug ? url('/schools/' . $schoolSlug) : url('/');
                $waText     = "Hello " . ($enquiry->parent_name ?: 'Parent') . ", greetings from " . ($enquiry->school->name ?? 'SchoolMapr') . "! Thank you for your inquiry on SchoolMapr. Here is the verified admission brochure, fee structure & campus details: " . $schoolUrl . " . Feel free to reply here if you have any questions!";
                $waLink     = "https://wa.me/" . $cleanPhone . "?text=" . urlencode($waText);

                $parentEmail = $enquiry->parent_email ?? ($enquiry->user->email ?? '');
            @endphp
            <tr>
                <td style="color:#94a3b8;font-size:12px;">{{ $enquiries->firstItem() + $i }}</td>
                <td>
                    <div style="display:flex;align-items:center;gap:9px;">
                        <div style="width:32px;height:32px;background:linear-gradient(135deg,#0f2040,#2a4a7f);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:800;font-size:12px;flex-shrink:0;">
                            {{ strtoupper(substr($enquiry->parent_name, 0, 1)) }}
                        </div>
                        <div>
                            <span style="font-weight:700;color:#0f1729;font-size:13px;display:block;">{{ $enquiry->parent_name }}</span>
                            @if($parentEmail)
                                <span style="font-size:11px;color:#64748b;">{{ $parentEmail }}</span>
                            @endif
                        </div>
                    </div>
                </td>
                <td style="font-size:13px;">
                    @if($phoneNum)
                        <a href="tel:{{ $phoneNum }}" style="color:#0f2d59;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;gap:5px;">
                            <i class="fas fa-phone-alt text-success" style="font-size:11px;"></i> {{ $phoneNum }}
                        </a>
                    @else
                        <span style="color:#94a3b8;">—</span>
                    @endif
                </td>
                <td style="color:#0f2d59;font-size:13px;font-weight:700;">
                    {{ $enquiry->school->name ?? '—' }}
                    @if($enquiry->school?->prospectus_path)
                        <span style="font-size:10.5px;color:#16a34a;display:block;font-weight:600;"><i class="fas fa-file-pdf"></i> PDF Attached</span>
                    @endif
                </td>
                <td>
                    @if($enquiry->is_brochure_request)
                        <span class="badge" style="background:#f3e8ff;color:#7e22ce;border:1px solid #d8b4fe;font-weight:700;font-size:11px;">
                            📄 Brochure Request
                        </span>
                    @else
                        <span class="badge badge-blue" style="font-weight:700;font-size:11px;">
                            🎓 {{ $enquiry->formatted_class }}
                        </span>
                    @endif

                    @if($enquiry->message)
                        <div style="font-size:11px;color:#64748b;margin-top:4px;max-width:220px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" title="{{ $enquiry->message }}">
                            💬 "{{ $enquiry->message }}"
                        </div>
                    @endif
                </td>
                <td style="color:#64748b;font-size:12px;white-space:nowrap;">{{ $enquiry->created_at->format('d M Y') }}<br><span style="font-size:10.5px;color:#94a3b8;">{{ $enquiry->created_at->format('h:i A') }}</span></td>
                <td>
                    @if($enquiry->status == 'new')
                        <span class="badge badge-blue">● New</span>
                    @elseif($enquiry->status == 'contacted')
                        <span class="badge badge-green">● Contacted</span>
                    @else
                        <span class="badge badge-gray">● Closed</span>
                    @endif
                </td>
                <td>
                    <div style="display:flex;align-items:center;gap:6px;flex-wrap:wrap;">
                        {{-- WhatsApp 1-Click Send Button --}}
                        @if($cleanPhone)
                        <a href="{{ $waLink }}" target="_blank"
                           style="background:#25D366;color:#fff;border-radius:6px;padding:5px 9px;font-size:11.5px;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;gap:4px;box-shadow:0 2px 4px rgba(37,211,102,0.2);"
                           title="Deliver Brochure & Info via WhatsApp">
                            <i class="fab fa-whatsapp" style="font-size:13px;"></i> WhatsApp
                        </a>
                        @endif

                        {{-- Send Brochure Email Action --}}
                        <button type="button"
                                onclick="openBrochureModal('{{ $enquiry->id }}', '{{ addslashes($enquiry->parent_name) }}', '{{ $parentEmail }}', '{{ addslashes($enquiry->school->name ?? 'School') }}', '{{ $enquiry->school?->prospectus_path ? 1 : 0 }}')"
                                style="background:#0f2d59;color:#fff;border:none;border-radius:6px;padding:5px 9px;font-size:11.5px;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:4px;"
                                title="Email Official Brochure to Parent">
                            <i class="fas fa-envelope"></i> Email Brochure
                        </button>

                        {{-- Update Status Dropdown --}}
                        <form action="/admin/enquiries/{{ $enquiry->id }}/status" method="POST" style="margin:0;">
                            @csrf @method('PATCH')
                            <select name="status" onchange="this.form.submit()"
                                style="border:1.5px solid #e8ecf4;border-radius:6px;padding:4px 8px;font-size:11.5px;outline:none;background:#fff;cursor:pointer;color:#374151;"
                                onfocus="this.style.borderColor='#f43f5e'" onblur="this.style.borderColor='#e8ecf4'">
                                <option value="new"       {{ $enquiry->status=='new'       ? 'selected':'' }}>New</option>
                                <option value="contacted" {{ $enquiry->status=='contacted' ? 'selected':'' }}>Contacted</option>
                                <option value="closed"    {{ $enquiry->status=='closed'    ? 'selected':'' }}>Closed</option>
                            </select>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center;padding:60px 20px;color:#94a3b8;">
                    <i class="fas fa-inbox" style="font-size:32px;display:block;margin-bottom:10px;color:#e2e8f0;"></i>
                    No parent inquiries or brochure requests found
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="padding:14px 18px;border-top:1px solid #f0f4fb;">
        {{ $enquiries->links() }}
    </div>
</div>

<!-- Modal: Send Brochure to Parent Email -->
<div id="brochureEmailModal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(15,23,42,0.65);z-index:9999;align-items:center;justify-content:center;padding:12px;">
    <div style="background:#fff;border-radius:16px;max-width:520px;width:100%;max-height:90vh;display:flex;flex-direction:column;box-shadow:0 20px 60px rgba(0,0,0,0.3);overflow:hidden;">
        <div style="background:#0f2d59;color:#fff;padding:16px 20px;display:flex;align-items:center;justify-content:space-between;flex-shrink:0;">
            <div style="font-size:15px;font-weight:900;"><i class="fas fa-file-pdf text-warning me-2"></i> Send Official Brochure to Parent</div>
            <button type="button" onclick="closeBrochureModal()" style="background:transparent;border:none;color:#fff;font-size:22px;line-height:1;cursor:pointer;">&times;</button>
        </div>

        <form id="sendBrochureForm" method="POST" action="" enctype="multipart/form-data" style="display:flex;flex-direction:column;overflow-y:auto;flex:1;margin:0;">
            @csrf
            <div style="padding:20px;overflow-y:auto;">
                <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:12px 16px;margin-bottom:16px;">
                    <div style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;">School Target</div>
                    <div id="modalSchoolName" style="font-size:14px;font-weight:800;color:#0f2d59;margin-top:2px;">—</div>
                    <div id="modalPdfStatus" style="font-size:11.5px;color:#16a34a;margin-top:4px;font-weight:600;">
                        <i class="fas fa-check-circle"></i> Official Prospectus PDF will be attached & linked
                    </div>
                </div>

                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:12px;font-weight:700;color:#334155;margin-bottom:4px;">Parent / Recipient Name</label>
                    <input type="text" id="modalParentName" readonly style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;background:#f8fafc;color:#475569;">
                </div>

                <div style="margin-bottom:14px;">
                    <label style="display:block;font-size:12px;font-weight:700;color:#334155;margin-bottom:4px;">Parent Email Address *</label>
                    <input type="email" name="email" id="modalParentEmail" required placeholder="Enter parent's email address" style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;color:#0f2d59;font-weight:600;" onfocus="this.style.borderColor='#0f2d59'" onblur="this.style.borderColor='#e2e8f0'">
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
                    <label style="display:block;font-size:12px;font-weight:700;color:#334155;margin-bottom:4px;">Optional Note from Admissions Desk</label>
                    <textarea name="message" rows="3" placeholder="e.g. Please find the official brochure attached. Admissions are open till 31st March..." style="width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:12.5px;outline:none;color:#334155;" onfocus="this.style.borderColor='#0f2d59'" onblur="this.style.borderColor='#e2e8f0'"></textarea>
                </div>

                <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:20px;">
                    <button type="button" onclick="closeBrochureModal()" style="padding:10px 18px;border:1.5px solid #e2e8f0;background:#fff;border-radius:8px;font-size:13px;font-weight:700;color:#64748b;cursor:pointer;">Cancel</button>
                    <button type="submit" style="padding:10px 22px;background:#0f2d59;border:none;border-radius:8px;font-size:13px;font-weight:800;color:#fff;cursor:pointer;">
                        🚀 Send Brochure Packet Now
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function openBrochureModal(enquiryId, parentName, parentEmail, schoolName, hasPdf) {
    const modal = document.getElementById('brochureEmailModal');
    const form  = document.getElementById('sendBrochureForm');
    form.action = '/admin/enquiries/' + enquiryId + '/send-brochure';

    document.getElementById('modalSchoolName').innerText = schoolName;
    document.getElementById('modalParentName').value = parentName;
    document.getElementById('modalParentEmail').value = parentEmail || '';

    const pdfStatusEl = document.getElementById('modalPdfStatus');
    if (hasPdf == 1) {
        pdfStatusEl.innerHTML = '<i class="fas fa-check-circle"></i> Official Prospectus PDF will be attached & linked';
        pdfStatusEl.style.color = '#16a34a';
    } else {
        pdfStatusEl.innerHTML = '<i class="fas fa-info-circle"></i> Verified School Profile & Fee Sheet will be included in the email';
        pdfStatusEl.style.color = '#0284c7';
    }

    modal.style.display = 'flex';
}

function closeBrochureModal() {
    document.getElementById('brochureEmailModal').style.display = 'none';
}
</script>

@endsection