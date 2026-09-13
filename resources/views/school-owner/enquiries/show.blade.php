@extends('school-owner.layout')
@section('title', 'Enquiry Detail')

@section('content')

@php
$stMap = [
    'new'       => ['#fef9c3','#ca8a04','⏳ New — Follow up required!'],
    'contacted' => ['#dbeafe','#2563eb','📞 Contacted'],
    'replied'   => ['#dcfce7','#16a34a','✅ Replied'],
    'closed'    => ['#f1f5f9','#64748b','🔒 Closed'],
];
$st = $stMap[$enquiry->status] ?? $stMap['new'];
@endphp

<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 style="font-size:18px;font-weight:800;color:#1d3557;margin:0;">📩 Enquiry Detail</h4>
        <p style="font-size:13px;color:#94a3b8;margin:4px 0 0;">
            Received on {{ $enquiry->created_at->format('d M Y, h:i A') }}
        </p>
    </div>
    <a href="{{ route('school-owner.enquiries.index') }}" class="btn-ghost">← Back to Enquiries</a>
</div>

<div class="row g-4">

    {{-- Left: Parent Info --}}
    <div class="col-md-7">
        <div class="so-panel" style="margin-bottom:0;">
            <div class="so-panel-title">👨‍👩‍👧 Parent Information</div>

            <div class="row g-3">
                <div class="col-6">
                    <div style="background:#f8f9fa;border-radius:10px;padding:14px;text-align:center;">
                        <div style="font-size:11px;color:#888;margin-bottom:4px;">Parent Name</div>
                        <div style="font-size:14px;font-weight:800;color:#1d3557;">{{ $enquiry->parent_name }}</div>
                    </div>
                </div>
                <div class="col-6">
                    <div style="background:#f0fdf4;border-radius:10px;padding:14px;text-align:center;
                                border:1.5px solid #86efac;">
                        <div style="font-size:11px;color:#888;margin-bottom:4px;">📞 Mobile</div>
                        <a href="tel:{{ $enquiry->mobile }}"
                           style="font-size:18px;font-weight:900;color:#16a34a;text-decoration:none;display:block;">
                            {{ $enquiry->mobile }}
                        </a>
                        <div style="font-size:11px;color:#16a34a;margin-top:4px;font-weight:600;">Tap to Call</div>
                    </div>
                </div>
                <div class="col-6">
                    <div style="background:#f8f9fa;border-radius:10px;padding:14px;text-align:center;">
                        <div style="font-size:11px;color:#888;margin-bottom:4px;">Inquiry Type / Class</div>
                        <div style="font-size:14px;font-weight:800;color:#1d3557;">
                            @if($enquiry->is_brochure_request)
                                <span style="color:#7e22ce;"><i class="fas fa-file-pdf"></i> Brochure Request</span>
                            @else
                                {{ $enquiry->formatted_class }}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div style="background:#f8f9fa;border-radius:10px;padding:14px;text-align:center;">
                        <div style="font-size:11px;color:#888;margin-bottom:4px;">Submitted</div>
                        <div style="font-size:13px;font-weight:700;color:#1d3557;">
                            {{ $enquiry->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            </div>

            @if($enquiry->message)
            <div style="margin-top:16px;background:#f8f9fa;border-radius:12px;padding:16px;">
                <div style="font-size:11px;color:#888;margin-bottom:6px;font-weight:600;">💬 Message from Parent</div>
                <div style="font-size:14px;color:#444;line-height:1.6;">"{{ $enquiry->message }}"</div>
            </div>
            @endif

            {{-- Quick Response CTAs --}}
            @php
                $cleanPhone = preg_replace('/[^0-9]/', '', $enquiry->mobile);
                if (strlen($cleanPhone) == 10) $cleanPhone = '91' . $cleanPhone;
                $schoolUrl = url('/schools/' . ($enquiry->school->slug ?? ''));
                $waMsg = "Hello " . ($enquiry->parent_name ?: 'Parent') . ", greetings from " . ($enquiry->school->name ?? 'our School Admissions Desk') . "! Thank you for your inquiry on SchoolMapr. Here is the verified admission brochure, fee structure & campus details: " . $schoolUrl . " . Feel free to reply here if you have any questions!";
                $waLink = "https://wa.me/" . $cleanPhone . "?text=" . urlencode($waMsg);
            @endphp

            <div style="margin-top:20px;padding:20px;background:linear-gradient(135deg,#1d3557,#457b9d);border-radius:14px;text-align:center;">
                <div style="color:rgba(255,255,255,.9);font-size:14px;font-weight:700;margin-bottom:12px;">
                    ⚡ Connect & Send Admission Brochure to Parent
                </div>
                <div style="display:flex;gap:10px;justify-content:center;flex-wrap:wrap;">
                    <a href="tel:{{ $enquiry->mobile }}"
                       style="display:inline-flex;align-items:center;gap:6px;background:#16a34a;color:#fff;border-radius:10px;padding:11px 22px;font-size:14px;font-weight:800;text-decoration:none;">
                        📞 Call {{ $enquiry->mobile }}
                    </a>
                    @if($cleanPhone)
                    <a href="{{ $waLink }}" target="_blank"
                       style="display:inline-flex;align-items:center;gap:6px;background:#25D366;color:#fff;border-radius:10px;padding:11px 22px;font-size:14px;font-weight:800;text-decoration:none;box-shadow:0 4px 12px rgba(37,211,102,.3);">
                        <i class="fab fa-whatsapp"></i> Send on WhatsApp
                    </a>
                    @endif
                </div>
                <div style="color:rgba(255,255,255,.6);font-size:11.5px;margin-top:12px;">
                    After connecting with the parent, update the inquiry status on the right.
                </div>
            </div>
        </div>
    </div>

    {{-- Right: Status + School --}}
    <div class="col-md-5">

        <div class="so-panel" style="margin-bottom:16px;">
            <div class="so-panel-title">🔄 Update Status</div>

            <div style="text-align:center;margin-bottom:16px;">
                <span style="background:{{ $st[0] }};color:{{ $st[1] }};
                             padding:8px 20px;border-radius:100px;font-size:14px;font-weight:800;">
                    {{ $st[2] }}
                </span>
            </div>

            <p style="font-size:12px;color:#888;margin-bottom:10px;text-align:center;">
                Click to change status:
            </p>

            <div style="display:flex;flex-direction:column;gap:8px;">
                @foreach([
                    ['new',       '⏳','New',       '#fef9c3','#ca8a04'],
                    ['contacted', '📞','Contacted', '#dbeafe','#2563eb'],
                    ['replied',   '✅','Replied',   '#dcfce7','#16a34a'],
                    ['closed',    '🔒','Closed',    '#f1f5f9','#64748b'],
                ] as [$val,$icon,$label,$bg,$color])
                <button onclick="updateStatusPage('{{ $val }}')"
                        id="btn-{{ $val }}"
                        style="padding:10px 16px;border-radius:10px;font-size:13px;font-weight:700;
                               cursor:pointer;transition:all .2s;text-align:left;border:2px solid;
                               {{ $enquiry->status === $val
                                  ? "background:{$bg};color:{$color};border-color:{$color};"
                                  : "background:#fff;color:#555;border-color:#dee2e6;" }}">
                    {{ $icon }} {{ $label }}
                    @if($enquiry->status === $val)
                    <span style="float:right;font-size:11px;opacity:.7;">← Current</span>
                    @endif
                </button>
                @endforeach
            </div>
        </div>

        <div class="so-panel" style="margin-bottom:0;">
            <div class="so-panel-title">🏫 School</div>
            <div style="font-size:14px;font-weight:700;color:#1d3557;margin-bottom:4px;">
                {{ $enquiry->school->name ?? '—' }}
            </div>
            <div style="font-size:12px;color:#888;">
                📍 {{ $enquiry->school->city ?? '' }}
                @if($enquiry->school->board ?? false) &nbsp;•&nbsp; {{ $enquiry->school->board }} @endif
            </div>
            @if($enquiry->school->slug ?? false)
            <a href="/schools/{{ $enquiry->school->slug }}" target="_blank"
               style="display:inline-block;margin-top:10px;font-size:13px;color:#e63946;font-weight:600;">
                View School Page →
            </a>
            @endif
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
const enquiryId = {{ $enquiry->id }};
const statusMap = {
    'new'      : ['#fef9c3','#ca8a04','⏳ New — Follow up required!'],
    'contacted': ['#dbeafe','#2563eb','📞 Contacted'],
    'replied'  : ['#dcfce7','#16a34a','✅ Replied'],
    'closed'   : ['#f1f5f9','#64748b','🔒 Closed'],
};

function updateStatusPage(newStatus) {
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
    .then(data => {
        if (!data.success) return;
        Object.keys(statusMap).forEach(s => {
            const btn = document.getElementById('btn-' + s);
            if (!btn) return;
            const [bg, color] = statusMap[s];
            if (s === newStatus) {
                btn.style.cssText = `padding:10px 16px;border-radius:10px;font-size:13px;
                    font-weight:700;cursor:pointer;transition:all .2s;text-align:left;
                    border:2px solid;background:${bg};color:${color};border-color:${color};`;
                btn.innerHTML = btn.textContent.trim() +
                    ' <span style="float:right;font-size:11px;opacity:.7;">← Current</span>';
            } else {
                btn.style.cssText = `padding:10px 16px;border-radius:10px;font-size:13px;
                    font-weight:700;cursor:pointer;transition:all .2s;text-align:left;
                    border:2px solid;background:#fff;color:#555;border-color:#dee2e6;`;
                btn.innerHTML = btn.textContent.trim();
            }
        });

        const [bg, color, label] = statusMap[newStatus];
        const badge = document.querySelector('span[style*="border-radius:100px"]');
        if (badge) {
            badge.style.background = bg;
            badge.style.color      = color;
            badge.textContent      = label;
        }
    })
    .catch(() => alert('Error! Please refresh the page.'));
}
</script>
@endpush