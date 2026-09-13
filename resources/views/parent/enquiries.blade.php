@extends('layouts.parent')
@section('title', 'My Enquiries – SchoolMapr')

@section('content')
<div class="container-fluid p-0">

    {{-- Header Banner --}}
    <div class="card border-0 rounded-4 shadow-sm mb-4" style="background:linear-gradient(135deg, #0f2d59 0%, #1e4a85 100%);color:#fff;">
        <div class="card-body p-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <span class="badge bg-warning text-dark fw-bold px-3 py-1 mb-2" style="font-size:11px;">Admission Inquiries</span>
                    <h3 class="fw-bold mb-1">My School Enquiries</h3>
                    <p class="mb-0 text-white-50 small">Track responses, counsellor callbacks, and query statuses from Patna schools.</p>
                </div>
                <a href="{{ url('/') }}" class="btn btn-warning fw-bold px-3 py-2" style="border-radius:8px;font-size:13px;color:#0f2d59;">
                    <i class="fa-solid fa-paper-plane me-1"></i> Send New Enquiry
                </a>
            </div>
        </div>
    </div>

    @if($enquiries->count() > 0)

    <div class="d-flex flex-column gap-3">
        @foreach($enquiries as $enq)
        @php
            $statusMap = [
                'new'       => ['bg'=>'#fffbeb','border'=>'#fde68a','color'=>'#d97706','label'=>'⏳ Pending Callback'],
                'replied'   => ['bg'=>'#ecfdf5','border'=>'#a7f3d0','color'=>'#059669','label'=>'✅ Counsellor Replied'],
                'contacted' => ['bg'=>'#eff6ff','border'=>'#bfdbfe','color'=>'#2563eb','label'=>'📞 Contacted'],
                'closed'    => ['bg'=>'#f1f5f9','border'=>'#e2e8f0','color'=>'#64748b','label'=>'🔒 Resolved'],
            ];
            $st = $statusMap[$enq->status] ?? $statusMap['new'];
        @endphp

        <div class="card border-0 rounded-4 shadow-sm p-3 p-md-4 bg-white">
            <div class="d-flex align-items-start gap-3 flex-wrap">
                
                {{-- Campus Thumbnail --}}
                <div style="width:60px;height:60px;border-radius:12px;overflow:hidden;background:#f1f5f9;flex-shrink:0;">
                    <img src="{{ $enq->school->featured_image_url ?? asset('images/default-school.jpg') }}" alt="{{ $enq->school->name ?? 'School' }}" style="width:100%;height:100%;object-fit:cover;">
                </div>

                {{-- Main Info --}}
                <div class="flex-grow-1" style="min-width:240px;">
                    <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                        <h5 class="fw-bold text-dark mb-0" style="font-size:16px;">
                            <a href="{{ route('school.show', $enq->school->slug ?? '#') }}" class="text-dark text-decoration-none hover-primary">
                                {{ $enq->school->name ?? 'School Profile' }}
                            </a>
                        </h5>
                        <span style="font-size:11px;font-weight:800;background:{{ $st['bg'] }};color:{{ $st['color'] }};border:1px solid {{ $st['border'] }};padding:2px 10px;border-radius:999px;">
                            {{ $st['label'] }}
                        </span>
                    </div>

                    <div class="text-muted small mb-2">
                        <i class="fa-solid fa-location-dot text-danger me-1"></i> {{ $enq->school->city ?? 'Patna' }}
                        @if($enq->school->board ?? false)
                            &nbsp;•&nbsp; <span class="badge bg-light text-dark border">{{ $enq->school->board }}</span>
                        @endif
                        &nbsp;•&nbsp; Submitted {{ $enq->created_at->diffForHumans() }}
                    </div>

                    {{-- Data Chips --}}
                    <div class="d-flex gap-2 flex-wrap align-items-center small mt-2">
                        <span class="bg-light border px-2 py-1 rounded text-dark fw-bold">
                            👤 Parent: {{ $enq->parent_name }}
                        </span>
                        <span class="bg-light border px-2 py-1 rounded text-primary fw-bold">
                            🎓 {{ Str::startsWith(strtolower(trim($enq->child_class ?? '')), 'class') ? trim($enq->child_class) : 'Class ' . trim($enq->child_class ?? '') }}
                        </span>
                        <span class="bg-light border px-2 py-1 rounded text-dark">
                            📞 {{ $enq->mobile ?? '—' }}
                        </span>
                    </div>

                    {{-- Parent Message --}}
                    @if($enq->message)
                    <div class="mt-2 p-2 rounded-2 bg-light text-secondary small">
                        <i class="fa-regular fa-comment-dots text-primary me-1"></i>
                        <strong>Query Message:</strong> {{ $enq->message }}
                    </div>
                    @endif
                </div>

                {{-- Action Button --}}
                <div class="flex-shrink-0">
                    <a href="/schools/{{ $enq->school->slug ?? '#' }}" class="btn btn-sm btn-outline-primary fw-bold" style="border-radius:8px;font-size:12px;">
                        <i class="fa-solid fa-eye me-1"></i> View School
                    </a>
                </div>

            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($enquiries->hasPages())
    <div class="mt-4">
        {{ $enquiries->links() }}
    </div>
    @endif

    @else

    <div class="card border-0 rounded-4 shadow-sm p-5 text-center bg-white">
        <div class="display-5 mb-3">📭</div>
        <h5 class="fw-bold text-dark mb-1">No Enquiries Sent Yet</h5>
        <p class="text-muted small mb-4 mx-auto" style="max-width:360px;">
            Submit a direct enquiry on any school's page to request fee details, admission brochures, and transport routes.
        </p>
        <div>
            <a href="{{ url('/') }}" class="btn btn-primary fw-bold px-4 py-2" style="background:#0f2d59;border:none;border-radius:8px;">
                <i class="fa-solid fa-magnifying-glass me-1"></i> Explore Patna Schools
            </a>
        </div>
    </div>

    @endif

</div>
@endsection