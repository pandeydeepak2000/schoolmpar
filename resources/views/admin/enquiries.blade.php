@extends('admin.layout')
@section('title', 'Parent Enquiries & Leads CRM – SchoolMapr Admin')
@section('page-title', 'Parent Enquiries & CRM Follow-up Desk')
@section('page-sub', 'Track parent admission leads, brochure requests, follow-up call notes, and schedule date ranges')

@section('content')

{{-- ── 1. KPI STAT CARDS ── --}}
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(210px, 1fr)); gap:16px; margin-bottom:20px;">
    
    <div class="stat-card" style="border-top:3px solid #2563eb;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
            <span style="font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.05em;">Total Inquiries</span>
            <div style="width:34px; height:34px; background:#eff6ff; border-radius:9px; display:flex; align-items:center; justify-content:center;">
                <i class="fas fa-inbox" style="color:#2563eb; font-size:14px;"></i>
            </div>
        </div>
        <div style="font-size:26px; font-weight:900; color:#0f172a;">{{ number_format($enquiries->total()) }}</div>
        <div style="font-size:11.5px; color:#64748b; margin-top:2px;">All incoming parent leads</div>
    </div>

    <div class="stat-card" style="border-top:3px solid #f59e0b;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
            <span style="font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.05em;">New Leads / Action</span>
            <div style="width:34px; height:34px; background:#fffbeb; border-radius:9px; display:flex; align-items:center; justify-content:center;">
                <i class="fas fa-bolt" style="color:#f59e0b; font-size:14px;"></i>
            </div>
        </div>
        <div style="font-size:26px; font-weight:900; color:#0f172a;">{{ number_format($new_count) }}</div>
        <div style="font-size:11.5px; color:#d97706; margin-top:2px; font-weight:700;">Awaiting first follow-up call</div>
    </div>

    <div class="stat-card" style="border-top:3px solid #8b5cf6;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
            <span style="font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.05em;">Brochure Requests</span>
            <div style="width:34px; height:34px; background:#f5f3ff; border-radius:9px; display:flex; align-items:center; justify-content:center;">
                <i class="fas fa-file-pdf" style="color:#8b5cf6; font-size:14px;"></i>
            </div>
        </div>
        <div style="font-size:26px; font-weight:900; color:#0f172a;">{{ number_format($brochure_count ?? 0) }}</div>
        <div style="font-size:11.5px; color:#8b5cf6; margin-top:2px; font-weight:700;">Prospectus downloads requested</div>
    </div>

    <div class="stat-card" style="border-top:3px solid #10b981;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
            <span style="font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.05em;">Contacted & Closed</span>
            <div style="width:34px; height:34px; background:#ecfdf5; border-radius:9px; display:flex; align-items:center; justify-content:center;">
                <i class="fas fa-check-circle" style="color:#10b981; font-size:14px;"></i>
            </div>
        </div>
        <div style="font-size:26px; font-weight:900; color:#0f172a;">{{ number_format($contacted_count) }}</div>
        <div style="font-size:11.5px; color:#10b981; margin-top:2px; font-weight:700;">Parent engaged / counselled</div>
    </div>

</div>

{{-- ── 2. DATE RANGE & FILTERS STRIP ── --}}
<div class="panel" style="margin-bottom:18px;">
    <div style="padding:16px 20px;">
        <form method="GET" action="{{ route('admin.enquiries') }}">
            <div style="display:flex; gap:12px; align-items:flex-end; flex-wrap:wrap;">
                
                {{-- Search --}}
                <div style="flex:1; min-width:210px;">
                    <label style="display:block; font-size:11px; font-weight:700; color:#475569; text-transform:uppercase; letter-spacing:0.04em; margin-bottom:5px;">
                        <i class="fas fa-search me-1 text-slate-400"></i> Search Inquiry
                    </label>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Parent name, mobile, school..."
                           style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:8px 12px; font-size:13px; outline:none; color:#1e293b; box-sizing:border-box; background:#fff;">
                </div>

                {{-- Type --}}
                <div style="min-width:150px;">
                    <label style="display:block; font-size:11px; font-weight:700; color:#475569; text-transform:uppercase; letter-spacing:0.04em; margin-bottom:5px;">
                        <i class="fas fa-tag me-1 text-slate-400"></i> Lead Type
                    </label>
                    <select name="type" style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:8px 12px; font-size:13px; outline:none; color:#334155; background:#fff; box-sizing:border-box;">
                        <option value="">All Inquiry Types</option>
                        <option value="brochure"  {{ request('type')=='brochure'  ? 'selected':'' }}>📄 Brochure Requests</option>
                        <option value="admission" {{ request('type')=='admission' ? 'selected':'' }}>🎓 Admission Inquiries</option>
                    </select>
                </div>

                {{-- Status --}}
                <div style="min-width:130px;">
                    <label style="display:block; font-size:11px; font-weight:700; color:#475569; text-transform:uppercase; letter-spacing:0.04em; margin-bottom:5px;">
                        <i class="fas fa-sliders-h me-1 text-slate-400"></i> Status
                    </label>
                    <select name="status" style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:8px 12px; font-size:13px; outline:none; color:#334155; background:#fff; box-sizing:border-box;">
                        <option value="">All Statuses</option>
                        <option value="new"       {{ request('status')=='new'       ? 'selected':'' }}>⏳ New Leads</option>
                        <option value="contacted" {{ request('status')=='contacted' ? 'selected':'' }}>📞 Contacted</option>
                        <option value="closed"    {{ request('status')=='closed'    ? 'selected':'' }}>🔒 Closed</option>
                    </select>
                </div>

                {{-- From Date --}}
                <div style="min-width:145px;">
                    <label style="display:block; font-size:11px; font-weight:700; color:#475569; text-transform:uppercase; letter-spacing:0.04em; margin-bottom:5px;">
                        <i class="far fa-calendar-alt me-1 text-slate-400"></i> From Date
                    </label>
                    <input type="date" name="from_date" value="{{ request('from_date') }}"
                           style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:8px 12px; font-size:13px; outline:none; color:#334155; background:#fff; box-sizing:border-box;">
                </div>

                {{-- To Date --}}
                <div style="min-width:145px;">
                    <label style="display:block; font-size:11px; font-weight:700; color:#475569; text-transform:uppercase; letter-spacing:0.04em; margin-bottom:5px;">
                        <i class="far fa-calendar-check me-1 text-slate-400"></i> To Date
                    </label>
                    <input type="date" name="to_date" value="{{ request('to_date') }}"
                           style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:8px 12px; font-size:13px; outline:none; color:#334155; background:#fff; box-sizing:border-box;">
                </div>

                {{-- Action Buttons --}}
                <div style="display:flex; gap:8px; align-items:center;">
                    <button type="submit" style="background:#2563eb; color:#fff; border:none; border-radius:8px; padding:9px 18px; font-size:13px; font-weight:700; cursor:pointer; display:inline-flex; align-items:center; gap:6px; box-shadow:0 1px 3px rgba(37,99,235,0.3);">
                        <i class="fas fa-filter"></i> Apply
                    </button>

                    @if(request()->hasAny(['search','status','type','from_date','to_date']))
                    <a href="{{ route('admin.enquiries') }}" style="font-size:12.5px; color:#ef4444; font-weight:700; text-decoration:none; padding:8px 10px;">
                        <i class="fas fa-times me-1"></i> Clear
                    </a>
                    @endif

                    {{-- Export To Excel Button --}}
                    <a href="{{ route('admin.enquiries.export', request()->query()) }}"
                       style="background:linear-gradient(135deg, #059669 0%, #10b981 100%); color:#fff; border:none; border-radius:8px; padding:9px 16px; font-size:13px; font-weight:800; text-decoration:none; display:inline-flex; align-items:center; gap:7px; box-shadow:0 2px 6px rgba(16,185,129,0.25); white-space:nowrap;"
                       title="Export filtered parent inquiries directly to an Excel spreadsheet">
                        <i class="fas fa-file-excel"></i> Export to Excel
                    </a>
                </div>

            </div>
        </form>
    </div>
</div>

{{-- ── 3. BULK ACTION BAR ── --}}
<form id="bulkDeleteEnquiriesForm" action="{{ route('admin.enquiries.bulk-delete') }}" method="POST">
    @csrf

    <div id="bulkActionBarEnquiry" style="display:none; background:#1e293b; color:#fff; border-radius:10px; padding:12px 20px; margin-bottom:14px; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; box-shadow:0 4px 12px rgba(15,23,42,0.18);">
        <div style="display:flex; align-items:center; gap:10px;">
            <i class="fas fa-check-circle" style="color:#38bdf8; font-size:16px;"></i>
            <span style="font-size:13.5px; font-weight:700;">
                <span id="selectedCountEnquiry">0</span> enquiry record(s) selected
            </span>
        </div>
        <div style="display:flex; align-items:center; gap:8px;">
            <button type="button" onclick="confirmBulkDeleteEnquiries()"
                    style="background:#ef4444; color:#fff; border:none; border-radius:7px; padding:7px 14px; font-size:12.5px; font-weight:800; cursor:pointer; display:inline-flex; align-items:center; gap:6px;">
                <i class="fas fa-trash-alt"></i> Delete Selected
            </button>
            <button type="button" onclick="clearAllSelectionsEnquiry()"
                    style="background:rgba(255,255,255,0.15); color:#fff; border:none; border-radius:7px; padding:7px 12px; font-size:12px; font-weight:600; cursor:pointer;">
                Deselect All
            </button>
        </div>
    </div>

    {{-- ── 4. ENQUIRIES DATA TABLE ── --}}
    <div class="panel">
        <div class="panel-header">
            <div class="panel-title">
                <i class="fas fa-inbox" style="color:#0f2d59;"></i>
                Parent Inquiries & Follow-up Leads ({{ $enquiries->total() }})
            </div>
            <div style="font-size:11.5px; color:#64748b;">
                💡 Log call notes, schedule follow-ups, deliver brochure or send instant WhatsApp.
            </div>
        </div>

        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width:36px; text-align:center;">
                            <input type="checkbox" id="selectAllEnquiriesCheckbox" style="cursor:pointer; width:15px; height:15px; accent-color:#0f2d59;">
                        </th>
                        <th style="width:40px;">#</th>
                        <th>Parent Details</th>
                        <th>Contact</th>
                        <th>Target School</th>
                        <th>Query / Type</th>
                        <th>CRM Follow-up Notes</th>
                        <th>Status</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($enquiries as $i => $enquiry)
                    @php
                        $phoneNum = $enquiry->mobile ?: $enquiry->phone;
                        $cleanPhone = preg_replace('/[^0-9]/', '', (string)$phoneNum);
                        if (strlen($cleanPhone) == 10) $cleanPhone = '91' . $cleanPhone;

                        $schoolSlug = $enquiry->school->slug ?? '';
                        $schoolUrl  = $schoolSlug ? url('/schools/' . $schoolSlug) : url('/');
                        $waText     = "Hello " . ($enquiry->parent_name ?: 'Parent') . ", greetings from " . ($enquiry->school->name ?? 'SchoolMapr') . "! Thank you for your inquiry on SchoolMapr. Here is the verified admission brochure, fee structure & campus details: " . $schoolUrl . " . Feel free to reply here if you have any questions!";
                        $waLink     = "https://wa.me/" . $cleanPhone . "?text=" . urlencode($waText);

                        $parentEmail = $enquiry->parent_email ?? ($enquiry->user->email ?? '');
                        $notesList   = $enquiry->notes_list ?? [];
                        $notesCount  = count($notesList);
                        $latestNote  = $notesCount > 0 ? $notesList[0] : null;
                    @endphp
                    <tr id="enquiry-row-{{ $enquiry->id }}">
                        {{-- Row Checkbox --}}
                        <td style="text-align:center;">
                            <input type="checkbox" name="ids[]" value="{{ $enquiry->id }}" class="enquiry-item-checkbox" style="cursor:pointer; width:15px; height:15px; accent-color:#0f2d59;" onchange="updateBulkBarEnquiry()">
                        </td>

                        <td style="color:#94a3b8; font-size:12px;">{{ $enquiries->firstItem() + $i }}</td>
                        
                        {{-- Parent Profile --}}
                        <td>
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div style="width:34px; height:34px; background:linear-gradient(135deg,#0f2d59,#1d4ed8); border-radius:50%; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:800; font-size:12.5px; flex-shrink:0;">
                                    {{ strtoupper(substr($enquiry->parent_name, 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-weight:700; color:#0f172a; font-size:13px;">{{ $enquiry->parent_name }}</div>
                                    @if($parentEmail)
                                        <div style="font-size:11px; color:#64748b;">{{ $parentEmail }}</div>
                                    @endif
                                    <div style="font-size:10.5px; color:#94a3b8; margin-top:1px;">
                                        📅 {{ $enquiry->created_at->format('d M Y, h:i A') }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- Phone Contact --}}
                        <td>
                            @if($phoneNum)
                                <a href="tel:{{ $phoneNum }}" style="color:#0f2d59; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:5px; font-size:12.5px;">
                                    <i class="fas fa-phone-alt" style="color:#10b981; font-size:11px;"></i> {{ $phoneNum }}
                                </a>
                            @else
                                <span style="color:#94a3b8;">—</span>
                            @endif
                        </td>

                        {{-- Target School --}}
                        <td>
                            <div style="font-weight:700; color:#0f172a; font-size:12.5px;">
                                {{ $enquiry->school->name ?? '—' }}
                            </div>
                            @if($enquiry->school?->prospectus_path)
                                <span style="font-size:10.5px; color:#16a34a; font-weight:600; display:inline-flex; align-items:center; gap:4px; margin-top:2px;">
                                    <i class="fas fa-file-pdf"></i> Official PDF Attached
                                </span>
                            @endif
                        </td>

                        {{-- Type / Query --}}
                        <td>
                            @if($enquiry->is_brochure_request)
                                <span class="badge" style="background:#f3e8ff; color:#7e22ce; border:1px solid #d8b4fe; font-weight:800; font-size:11px;">
                                    📄 Brochure Request
                                </span>
                            @else
                                <span class="badge badge-blue" style="font-weight:800; font-size:11px;">
                                    🎓 {{ $enquiry->formatted_class }}
                                </span>
                            @endif

                            @if($enquiry->message)
                                <div style="font-size:11.5px; color:#475569; margin-top:4px; max-width:210px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="{{ $enquiry->message }}">
                                    💬 "{{ $enquiry->message }}"
                                </div>
                            @endif
                        </td>

                        {{-- CRM Notes / Follow-up Timeline Summary --}}
                        <td style="min-width:200px;">
                            <button type="button" 
                                    onclick="openCrmNotesModal({{ $enquiry->id }}, '{{ addslashes($enquiry->parent_name) }}', '{{ $phoneNum }}', '{{ addslashes($enquiry->school->name ?? 'School') }}', '{{ $enquiry->status }}')"
                                    id="notes-btn-{{ $enquiry->id }}"
                                    style="background:{{ $notesCount > 0 ? '#eff6ff' : '#f8fafc' }}; color:{{ $notesCount > 0 ? '#1d4ed8' : '#475569' }}; border:1.5px solid {{ $notesCount > 0 ? '#bfdbfe' : '#e2e8f0' }}; border-radius:8px; padding:6px 12px; font-size:12px; font-weight:700; cursor:pointer; display:inline-flex; align-items:center; gap:6px; transition:all 0.15s; width:100%; text-align:left; box-sizing:border-box;">
                                <i class="fas fa-comment-dots" style="color:{{ $notesCount > 0 ? '#2563eb' : '#94a3b8' }};"></i>
                                <span id="notes-label-{{ $enquiry->id }}">
                                    {{ $notesCount > 0 ? "{$notesCount} Follow-up Note(s)" : "+ Add Call Note" }}
                                </span>
                            </button>

                            {{-- Latest Note Snippet Preview --}}
                            <div id="notes-preview-{{ $enquiry->id }}" style="margin-top:4px;">
                                @if($latestNote)
                                    <div style="font-size:11px; color:#64748b; line-height:1.35; max-width:220px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="{{ $latestNote['note'] }}">
                                        <strong>{{ $latestNote['author'] ?? 'Admin' }}:</strong> {{ $latestNote['note'] }}
                                    </div>
                                    @if(!empty($latestNote['followup_date']))
                                        <div style="font-size:10.5px; color:#d97706; font-weight:700; margin-top:2px;">
                                            ⏰ Next Call: {{ $latestNote['followup_date'] }}
                                        </div>
                                    @endif
                                @endif
                            </div>

                            {{-- Stored Hidden JSON Data for Fast Client-Side Rendering --}}
                            <script id="notes-data-{{ $enquiry->id }}" type="application/json">
                                {!! json_encode($notesList) !!}
                            </script>
                        </td>

                        {{-- Status --}}
                        <td>
                            @if($enquiry->status == 'new')
                                <span class="badge" style="background:#fffbeb; color:#d97706; border:1px solid #fde68a; font-weight:800; font-size:11px;">● New Lead</span>
                            @elseif($enquiry->status == 'contacted')
                                <span class="badge" style="background:#ecfdf5; color:#059669; border:1px solid #a7f3d0; font-weight:800; font-size:11px;">● Contacted</span>
                            @else
                                <span class="badge" style="background:#f1f5f9; color:#475569; border:1px solid #cbd5e1; font-weight:800; font-size:11px;">● Closed</span>
                            @endif
                        </td>

                        {{-- Quick Actions --}}
                        <td style="text-align:right;">
                            <div style="display:inline-flex; align-items:center; gap:5px; flex-wrap:nowrap; justify-content:flex-end;">
                                {{-- WhatsApp Button --}}
                                @if($cleanPhone)
                                <a href="{{ $waLink }}" target="_blank"
                                   style="background:#ecfdf5; color:#059669; border:1px solid #a7f3d0; border-radius:6px; padding:5px 9px; font-size:11.5px; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:4px; transition:all 0.15s;"
                                   title="Chat with parent on WhatsApp">
                                    <i class="fab fa-whatsapp" style="font-size:12.5px; color:#10b981;"></i> WA
                                </a>
                                @endif

                                {{-- Email Brochure Button --}}
                                <button type="button"
                                        onclick="openBrochureModal('{{ $enquiry->id }}', '{{ addslashes($enquiry->parent_name) }}', '{{ $parentEmail }}', '{{ addslashes($enquiry->school->name ?? 'School') }}', '{{ $enquiry->school?->prospectus_path ? 1 : 0 }}')"
                                        style="background:#eff6ff; color:#2563eb; border:1px solid #bfdbfe; border-radius:6px; padding:5px 9px; font-size:11.5px; font-weight:700; cursor:pointer; display:inline-flex; align-items:center; gap:4px; transition:all 0.15s;"
                                        title="Send official school brochure to parent email">
                                    <i class="fas fa-envelope" style="font-size:11px;"></i> Brochure
                                </button>

                                {{-- Quick Status Dropdown --}}
                                <form action="/admin/enquiries/{{ $enquiry->id }}/status" method="POST" style="margin:0; display:inline;">
                                    @csrf @method('PATCH')
                                    <select name="status" onchange="this.form.submit()"
                                        style="border:1.5px solid #e2e8f0; border-radius:6px; padding:4px 7px; font-size:11px; outline:none; background:#fff; cursor:pointer; color:#374151; font-weight:700;">
                                        <option value="new"       {{ $enquiry->status=='new'       ? 'selected':'' }}>New</option>
                                        <option value="contacted" {{ $enquiry->status=='contacted' ? 'selected':'' }}>Contacted</option>
                                        <option value="closed"    {{ $enquiry->status=='closed'    ? 'selected':'' }}>Closed</option>
                                    </select>
                                </form>

                                {{-- Single Delete Button --}}
                                <button type="button" onclick="singleDeleteEnquiry('{{ $enquiry->id }}', '{{ addslashes($enquiry->parent_name) }}')"
                                        style="background:#fff1f2; color:#e11d48; border:1px solid #fecdd3; border-radius:6px; padding:5px 8px; font-size:11px; cursor:pointer;"
                                        title="Delete this enquiry record">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" style="text-align:center; padding:60px 20px; color:#94a3b8;">
                            <div style="font-size:36px; margin-bottom:8px;">📬</div>
                            <div style="font-size:14px; font-weight:700; color:#334155;">No parent enquiries found</div>
                            <div style="font-size:12px; color:#94a3b8; margin-top:2px;">Adjust your search keyword, date range, or lead type.</div>
                            <a href="{{ route('admin.enquiries') }}" style="display:inline-block; margin-top:12px; background:#0f2d59; color:#fff; border-radius:6px; padding:7px 16px; font-size:12px; font-weight:700; text-decoration:none;">
                                Reset All Filters
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($enquiries->hasPages())
        <div style="padding:14px 18px; border-top:1px solid #f0f4fb;">
            {{ $enquiries->links() }}
        </div>
        @endif
    </div>
</form>

{{-- Single Delete Enquiry Form Helper --}}
<form id="singleDeleteEnquiryForm" action="{{ route('admin.enquiries.bulk-delete') }}" method="POST" style="display:none;">
    @csrf
    <input type="hidden" name="ids[]" id="singleDeleteEnquiryId">
</form>

{{-- ── 5. MODAL: CRM FOLLOW-UP NOTES & REMARKS DRAWER ── --}}
<div id="crmNotesModal" style="display:none; position:fixed; inset:0; background:rgba(15,23,42,0.65); z-index:9999; align-items:center; justify-content:center; padding:16px;">
    <div style="background:#fff; border-radius:16px; max-width:620px; width:100%; max-height:92vh; display:flex; flex-direction:column; box-shadow:0 25px 60px rgba(0,0,0,0.3); overflow:hidden;">
        
        {{-- Modal Header --}}
        <div style="background:linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color:#fff; padding:16px 22px; display:flex; align-items:center; justify-content:space-between; flex-shrink:0;">
            <div>
                <div style="font-size:16px; font-weight:900; display:flex; align-items:center; gap:8px;">
                    <i class="fas fa-headset text-sky-200"></i> Follow-up CRM & Call Log
                </div>
                <div id="crmModalSubHeader" style="font-size:12px; color:rgba(255,255,255,0.85); margin-top:2px;">
                    —
                </div>
            </div>
            <button type="button" onclick="closeCrmNotesModal()" style="background:transparent; border:none; color:#fff; font-size:24px; line-height:1; cursor:pointer;">&times;</button>
        </div>

        {{-- Modal Body: Timeline & Add Note Form --}}
        <div style="padding:22px; overflow-y:auto; flex:1; display:flex; flex-direction:column; gap:20px;">
            
            {{-- Quick Info Card --}}
            <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:12px 16px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px;">
                <div>
                    <div style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase;">Parent Lead</div>
                    <div id="crmParentNameDisplay" style="font-size:14.5px; font-weight:800; color:#0f172a;">—</div>
                </div>
                <div style="text-align:right;">
                    <div style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase;">Contact Phone</div>
                    <a id="crmPhoneLink" href="#" style="font-size:13.5px; font-weight:800; color:#2563eb; text-decoration:none;">—</a>
                </div>
            </div>

            {{-- New Note Form --}}
            <form id="addNoteForm" onsubmit="submitCrmNote(event)" style="background:#f0f7ff; border:1.5px solid #bfdbfe; border-radius:12px; padding:16px; margin:0;">
                <input type="hidden" id="crmActiveEnquiryId" name="enquiry_id" value="">

                <label style="display:block; font-size:12.5px; font-weight:800; color:#1d4ed8; margin-bottom:6px;">
                    <i class="fas fa-pen-fancy me-1"></i> Log Call Notes / Conversation Remarks *
                </label>
                <textarea id="crmNoteText" name="note" rows="3" required
                          placeholder="e.g. Called parent. Requested callback in 15 days for Class 5 admission. Mother inquired about school bus route..."
                          style="width:100%; padding:10px 12px; border:1.5px solid #cbd5e1; border-radius:8px; font-size:13px; outline:none; color:#1e293b; box-sizing:border-box; background:#fff; resize:vertical;"></textarea>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-top:12px;">
                    {{-- Next Follow-up Date --}}
                    <div>
                        <label style="display:block; font-size:11.5px; font-weight:700; color:#334155; margin-bottom:4px;">
                            <i class="far fa-calendar-alt text-amber-600"></i> Next Follow-up Date (Optional)
                        </label>
                        <input type="date" id="crmFollowupDate" name="followup_date"
                                style="width:100%; padding:7px 10px; border:1.5px solid #cbd5e1; border-radius:7px; font-size:12.5px; outline:none; color:#334155; background:#fff; box-sizing:border-box;">
                    </div>

                    {{-- Update Status --}}
                    <div>
                        <label style="display:block; font-size:11.5px; font-weight:700; color:#334155; margin-bottom:4px;">
                            <i class="fas fa-tasks text-emerald-600"></i> Update Lead Status
                        </label>
                        <select id="crmStatusSelect" name="status"
                                style="width:100%; padding:7px 10px; border:1.5px solid #cbd5e1; border-radius:7px; font-size:12.5px; outline:none; color:#334155; background:#fff; box-sizing:border-box;">
                            <option value="">Keep Current Status</option>
                            <option value="new">⏳ New Lead</option>
                            <option value="contacted" selected>📞 Contacted / In Discussion</option>
                            <option value="closed">🔒 Closed / Enrolled</option>
                        </select>
                    </div>
                </div>

                <div style="margin-top:12px; display:flex; justify-content:flex-end;">
                    <button type="submit" id="saveNoteSubmitBtn"
                            style="background:#2563eb; color:#fff; border:none; border-radius:8px; padding:9px 20px; font-size:13px; font-weight:800; cursor:pointer; display:inline-flex; align-items:center; gap:6px; box-shadow:0 2px 6px rgba(37,99,235,0.25);">
                        <i class="fas fa-save"></i> Save Follow-up Remark
                    </button>
                </div>
            </form>

            {{-- Past Call Notes Timeline --}}
            <div>
                <div style="font-size:13px; font-weight:800; color:#0f2d59; margin-bottom:12px; display:flex; align-items:center; justify-content:space-between;">
                    <span><i class="fas fa-history text-slate-400 me-1"></i> Past Follow-up History</span>
                    <span id="crmNotesCounterBadge" style="font-size:11px; font-weight:800; background:#eff6ff; color:#2563eb; padding:2px 8px; border-radius:100px;">0 entries</span>
                </div>

                <div id="crmTimelineContainer" style="display:flex; flex-direction:column; gap:10px;">
                    {{-- Dynamically populated --}}
                </div>
            </div>

        </div>

        {{-- Modal Footer --}}
        <div style="background:#f8fafc; border-top:1px solid #e2e8f0; padding:12px 22px; display:flex; justify-content:flex-end;">
            <button type="button" onclick="closeCrmNotesModal()" style="padding:8px 18px; border:1.5px solid #e2e8f0; background:#fff; border-radius:8px; font-size:13px; font-weight:700; color:#64748b; cursor:pointer;">
                Close Window
            </button>
        </div>
    </div>
</div>

{{-- ── 6. MODAL: SEND BROCHURE TO PARENT EMAIL ── --}}
<div id="brochureEmailModal" style="display:none; position:fixed; inset:0; background:rgba(15,23,42,0.65); z-index:9999; align-items:center; justify-content:center; padding:12px;">
    <div style="background:#fff; border-radius:16px; max-width:520px; width:100%; max-height:90vh; display:flex; flex-direction:column; box-shadow:0 20px 60px rgba(0,0,0,0.3); overflow:hidden;">
        <div style="background:#0f2d59; color:#fff; padding:16px 20px; display:flex; align-items:center; justify-content:space-between; flex-shrink:0;">
            <div style="font-size:15px; font-weight:900;"><i class="fas fa-file-pdf text-amber-400 me-2"></i> Send Official Brochure to Parent</div>
            <button type="button" onclick="closeBrochureModal()" style="background:transparent; border:none; color:#fff; font-size:22px; line-height:1; cursor:pointer;">&times;</button>
        </div>

        <form id="sendBrochureForm" method="POST" action="" enctype="multipart/form-data" style="display:flex; flex-direction:column; overflow-y:auto; flex:1; margin:0;">
            @csrf
            <div style="padding:20px; overflow-y:auto;">
                <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:12px 16px; margin-bottom:16px;">
                    <div style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase;">School Target</div>
                    <div id="modalSchoolName" style="font-size:14px; font-weight:800; color:#0f2d59; margin-top:2px;">—</div>
                    <div id="modalPdfStatus" style="font-size:11.5px; color:#16a34a; margin-top:4px; font-weight:600;">
                        <i class="fas fa-check-circle"></i> Official Prospectus PDF will be attached & linked
                    </div>
                </div>

                <div style="margin-bottom:14px;">
                    <label style="display:block; font-size:12px; font-weight:700; color:#334155; margin-bottom:4px;">Parent / Recipient Name</label>
                    <input type="text" id="modalParentName" readonly style="width:100%; padding:9px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:13px; background:#f8fafc; color:#475569;">
                </div>

                <div style="margin-bottom:14px;">
                    <label style="display:block; font-size:12px; font-weight:700; color:#334155; margin-bottom:4px;">Parent Email Address *</label>
                    <input type="email" name="email" id="modalParentEmail" required placeholder="Enter parent's email address" style="width:100%; padding:9px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:13px; outline:none; color:#0f2d59; font-weight:600;">
                </div>

                <div style="margin-bottom:14px;">
                    <label style="display:block; font-size:12px; font-weight:700; color:#334155; margin-bottom:4px;">
                        <i class="fas fa-paperclip me-1 text-primary"></i> Attach Brochure / Prospectus File (Optional)
                    </label>
                    <input type="file" name="brochure_file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" style="width:100%; padding:7px 10px; border:1.5px dashed #cbd5e1; border-radius:8px; font-size:12px; background:#f8fafc; color:#475569; cursor:pointer;">
                    <div style="font-size:11px; color:#94a3b8; margin-top:3px;">
                        Attach any PDF / Brochure file (Max 15MB). If selected, it will be emailed directly to the parent.
                    </div>
                </div>

                <div style="margin-bottom:14px;">
                    <label style="display:block; font-size:12px; font-weight:700; color:#334155; margin-bottom:4px;">Optional Note from Admissions Desk</label>
                    <textarea name="message" rows="3" placeholder="e.g. Please find the official brochure attached. Admissions are open till 31st March..." style="width:100%; padding:9px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:12.5px; outline:none; color:#334155;"></textarea>
                </div>

                <div style="display:flex; gap:10px; justify-content:flex-end; margin-top:20px;">
                    <button type="button" onclick="closeBrochureModal()" style="padding:10px 18px; border:1.5px solid #e2e8f0; background:#fff; border-radius:8px; font-size:13px; font-weight:700; color:#64748b; cursor:pointer;">Cancel</button>
                    <button type="submit" style="padding:10px 22px; background:#0f2d59; border:none; border-radius:8px; font-size:13px; font-weight:800; color:#fff; cursor:pointer;">
                        🚀 Send Brochure Packet Now
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // ── Bulk Actions Script ──
    const selectAllEnquiriesCheckbox = document.getElementById('selectAllEnquiriesCheckbox');
    const bulkActionBarEnquiry = document.getElementById('bulkActionBarEnquiry');
    const selectedCountEnquiry = document.getElementById('selectedCountEnquiry');

    if (selectAllEnquiriesCheckbox) {
        selectAllEnquiriesCheckbox.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.enquiry-item-checkbox');
            checkboxes.forEach(cb => cb.checked = this.checked);
            updateBulkBarEnquiry();
        });
    }

    function updateBulkBarEnquiry() {
        const checked = document.querySelectorAll('.enquiry-item-checkbox:checked');
        const count = checked.length;
        if (count > 0) {
            bulkActionBarEnquiry.style.display = 'flex';
            selectedCountEnquiry.textContent = count;
        } else {
            bulkActionBarEnquiry.style.display = 'none';
            if (selectAllEnquiriesCheckbox) selectAllEnquiriesCheckbox.checked = false;
        }
    }

    function clearAllSelectionsEnquiry() {
        document.querySelectorAll('.enquiry-item-checkbox').forEach(cb => cb.checked = false);
        if (selectAllEnquiriesCheckbox) selectAllEnquiriesCheckbox.checked = false;
        updateBulkBarEnquiry();
    }

    function confirmBulkDeleteEnquiries() {
        const count = document.querySelectorAll('.enquiry-item-checkbox:checked').length;
        if (count === 0) return;
        if (confirm(`⚠️ Are you sure you want to permanently delete the ${count} selected enquiry lead(s)?`)) {
            document.getElementById('bulkDeleteEnquiriesForm').submit();
        }
    }

    function singleDeleteEnquiry(id, name) {
        if (confirm(`⚠️ Delete enquiry record for "${name}"?`)) {
            document.getElementById('singleDeleteEnquiryId').value = id;
            document.getElementById('singleDeleteEnquiryForm').submit();
        }
    }

    // ── CRM Notes Modal Script ──
    function openCrmNotesModal(enquiryId, parentName, phone, schoolName, currentStatus) {
        document.getElementById('crmActiveEnquiryId').value = enquiryId;
        document.getElementById('crmModalSubHeader').innerText = `Target School: ${schoolName}`;
        document.getElementById('crmParentNameDisplay').innerText = parentName;
        
        const phoneLink = document.getElementById('crmPhoneLink');
        if (phone) {
            phoneLink.href = 'tel:' + phone;
            phoneLink.innerText = '📞 ' + phone;
        } else {
            phoneLink.href = '#';
            phoneLink.innerText = 'No phone';
        }

        document.getElementById('crmNoteText').value = '';
        document.getElementById('crmFollowupDate').value = '';
        document.getElementById('crmStatusSelect').value = 'contacted';

        // Render past notes
        renderNotesTimeline(enquiryId);

        document.getElementById('crmNotesModal').style.display = 'flex';
    }

    function closeCrmNotesModal() {
        document.getElementById('crmNotesModal').style.display = 'none';
    }

    function renderNotesTimeline(enquiryId) {
        const scriptEl = document.getElementById(`notes-data-${enquiryId}`);
        let notes = [];
        if (scriptEl && scriptEl.textContent) {
            try {
                notes = JSON.parse(scriptEl.textContent);
            } catch(e) {
                notes = [];
            }
        }

        const container = document.getElementById('crmTimelineContainer');
        const countBadge = document.getElementById('crmNotesCounterBadge');
        countBadge.innerText = `${notes.length} log entry(s)`;

        if (!notes || notes.length === 0) {
            container.innerHTML = `
                <div style="background:#f8fafc; border:1px dashed #cbd5e1; border-radius:8px; padding:20px; text-align:center; color:#94a3b8; font-size:12.5px;">
                    <i class="far fa-clipboard" style="font-size:22px; margin-bottom:6px; display:block;"></i>
                    No CRM remarks recorded yet. Use the box above to log your call notes.
                </div>
            `;
            return;
        }

        let html = '';
        notes.forEach(item => {
            const dt = item.created_at_human || item.created_at || 'Just now';
            const author = item.author || 'Admin';
            const followup = item.followup_date ? `<span style="background:#fffbeb; color:#b45309; border:1px solid #fde68a; border-radius:4px; padding:1px 6px; font-size:10.5px; font-weight:800; margin-left:8px;"><i class="far fa-clock"></i> Next Call: ${item.followup_date}</span>` : '';

            html += `
                <div style="background:#fff; border:1px solid #e2e8f0; border-left:4px solid #0f2d59; border-radius:8px; padding:12px 14px; box-shadow:0 1px 3px rgba(0,0,0,0.04);">
                    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:6px; flex-wrap:wrap; gap:4px;">
                        <div style="font-size:11.5px; font-weight:800; color:#0f2d59; display:flex; align-items:center;">
                            <i class="fas fa-user-tie me-1 text-slate-400"></i> ${escapeHtml(author)}
                            ${followup}
                        </div>
                        <div style="font-size:11px; color:#94a3b8;">
                            ${escapeHtml(dt)}
                        </div>
                    </div>
                    <div style="font-size:12.5px; color:#334155; line-height:1.45; white-space:pre-wrap;">${escapeHtml(item.note)}</div>
                </div>
            `;
        });

        container.innerHTML = html;
    }

    async function submitCrmNote(e) {
        e.preventDefault();
        const enquiryId = document.getElementById('crmActiveEnquiryId').value;
        const noteText  = document.getElementById('crmNoteText').value.trim();
        const followup  = document.getElementById('crmFollowupDate').value;
        const status    = document.getElementById('crmStatusSelect').value;
        const btn       = document.getElementById('saveNoteSubmitBtn');

        if (!noteText) return;

        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';

        try {
            const response = await fetch(`/admin/enquiries/${enquiryId}/notes`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    note: noteText,
                    followup_date: followup,
                    status: status
                })
            });

            const result = await response.json();

            if (result.success) {
                // Update hidden JSON script tag
                const scriptEl = document.getElementById(`notes-data-${enquiryId}`);
                if (scriptEl) {
                    scriptEl.textContent = JSON.stringify(result.notes);
                }

                // Update row button label & preview
                const notesBtn = document.getElementById(`notes-btn-${enquiryId}`);
                const notesLabel = document.getElementById(`notes-label-${enquiryId}`);
                const previewEl = document.getElementById(`notes-preview-${enquiryId}`);

                if (notesBtn && notesLabel) {
                    notesBtn.style.background = '#eff6ff';
                    notesBtn.style.color = '#1d4ed8';
                    notesBtn.style.borderColor = '#bfdbfe';
                    notesLabel.textContent = `${result.notes_count} Follow-up Note(s)`;
                }

                if (previewEl && result.note) {
                    const nextFollowHtml = result.note.followup_date 
                        ? `<div style="font-size:10.5px; color:#d97706; font-weight:700; margin-top:2px;">⏰ Next Call: ${result.note.followup_date}</div>` 
                        : '';
                    previewEl.innerHTML = `
                        <div style="font-size:11px; color:#64748b; line-height:1.35; max-width:220px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="${escapeHtml(result.note.note)}">
                            <strong>${escapeHtml(result.note.author || 'Admin')}:</strong> ${escapeHtml(result.note.note)}
                        </div>
                        ${nextFollowHtml}
                    `;
                }

                // Reset form fields
                document.getElementById('crmNoteText').value = '';
                document.getElementById('crmFollowupDate').value = '';

                // Re-render modal timeline
                renderNotesTimeline(enquiryId);
            } else {
                alert(result.message || 'Error saving note.');
            }
        } catch(err) {
            console.error(err);
            alert('Server error occurred while saving follow-up note.');
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-save"></i> Save Follow-up Remark';
        }
    }

    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // ── Send Brochure Modal ──
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