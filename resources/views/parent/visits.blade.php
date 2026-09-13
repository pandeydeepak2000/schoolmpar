@extends('layouts.parent')
@section('title', 'Campus Visit Appointments – SchoolMapr')

@section('content')
<div class="container-fluid p-0">

    {{-- ── 1. HEADER BANNER ── --}}
    <div class="card border-0 rounded-4 shadow-sm mb-4" style="background:linear-gradient(135deg, #0f2d59 0%, #1e4a85 100%);color:#fff;">
        <div class="card-body p-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <span class="badge bg-warning text-dark fw-bold px-3 py-1 mb-2" style="font-size:11px;">Campus Guided Tours</span>
                    <h3 class="fw-bold mb-1">Campus Visit Appointments</h3>
                    <p class="mb-0 text-white-50 small">Track scheduled school tours, confirmed time slots, and counsellor meetings across Patna.</p>
                </div>
                <a href="{{ url('/') }}" class="btn btn-warning fw-bold px-3 py-2" style="border-radius:8px;font-size:13px;color:#0f2d59;">
                    <i class="fa-solid fa-plus me-1"></i> Book New School Tour
                </a>
            </div>
        </div>
    </div>

    {{-- ── 2. KPI STAT METRICS ── --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 rounded-4 shadow-sm p-3 h-100" style="background:#fff;border-top:3px solid #3b82f6 !important;">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="small fw-bold text-muted">Total Visits</span>
                    <div style="width:34px;height:34px;border-radius:8px;background:#eff6ff;color:#3b82f6;display:flex;align-items:center;justify-content:center;font-size:14px;">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-0">{{ $visits->total() }}</h3>
                <span class="small text-muted">All appointments</span>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card border-0 rounded-4 shadow-sm p-3 h-100" style="background:#fff;border-top:3px solid #f59e0b !important;">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="small fw-bold text-muted">Pending Slot</span>
                    <div style="width:34px;height:34px;border-radius:8px;background:#fffbeb;color:#f59e0b;display:flex;align-items:center;justify-content:center;font-size:14px;">
                        <i class="fa-solid fa-hourglass-half"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-0">{{ $visits->getCollection()->where('status','pending')->count() }}</h3>
                <span class="small text-warning fw-bold">Awaiting confirmation</span>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card border-0 rounded-4 shadow-sm p-3 h-100" style="background:#fff;border-top:3px solid #10b981 !important;">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="small fw-bold text-muted">Confirmed</span>
                    <div style="width:34px;height:34px;border-radius:8px;background:#ecfdf5;color:#10b981;display:flex;align-items:center;justify-content:center;font-size:14px;">
                        <i class="fa-solid fa-check-circle"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-0">{{ $visits->getCollection()->where('status','confirmed')->count() }}</h3>
                <span class="small text-success fw-bold">Time slot locked</span>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card border-0 rounded-4 shadow-sm p-3 h-100" style="background:#fff;border-top:3px solid #8b5cf6 !important;">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="small fw-bold text-muted">Completed</span>
                    <div style="width:34px;height:34px;border-radius:8px;background:#f5f3ff;color:#8b5cf6;display:flex;align-items:center;justify-content:center;font-size:14px;">
                        <i class="fa-solid fa-flag-checkered"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-0">{{ $visits->getCollection()->where('status','completed')->count() }}</h3>
                <span class="small text-purple fw-bold">Tour concluded</span>
            </div>
        </div>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
    <div class="alert alert-success border-0 rounded-3 shadow-sm py-2 px-3 small fw-bold mb-3">
        ✅ {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger border-0 rounded-3 shadow-sm py-2 px-3 small fw-bold mb-3">
        ❌ {{ session('error') }}
    </div>
    @endif

    {{-- ── 3. VISITS LIST ── --}}
    @if($visits->isEmpty())
    <div class="card border-0 rounded-4 shadow-sm p-5 text-center bg-white">
        <div class="display-5 mb-3">📅</div>
        <h5 class="fw-bold text-dark mb-1">No Campus Visits Booked Yet</h5>
        <p class="text-muted small mb-4 mx-auto" style="max-width:360px;">
            Explore top schools in Patna and schedule a free guided tour to inspect classrooms, labs, and sports facilities.
        </p>
        <div>
            <a href="{{ url('/') }}" class="btn btn-primary fw-bold px-4 py-2" style="background:#0f2d59;border:none;border-radius:8px;">
                <i class="fa-solid fa-magnifying-glass me-1"></i> Explore Patna Schools
            </a>
        </div>
    </div>

    @else

    <div class="d-flex flex-column gap-3">
    @foreach($visits as $visit)
    <div class="card border-0 rounded-4 shadow-sm p-3 p-md-4 bg-white">
        <div class="d-flex align-items-start gap-3 flex-wrap">

            {{-- School Campus Thumbnail --}}
            <div style="width:64px;height:64px;border-radius:12px;overflow:hidden;background:#f1f5f9;flex-shrink:0;">
                <img src="{{ $visit->school->featured_image_url }}" alt="{{ $visit->school->name }}" style="width:100%;height:100%;object-fit:cover;">
            </div>

            {{-- Visit Main Details --}}
            <div class="flex-grow-1" style="min-width:240px;">
                <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                    <h5 class="fw-bold text-dark mb-0" style="font-size:16px;">
                        <a href="{{ route('school.show', $visit->school->slug) }}" class="text-dark text-decoration-none hover-primary">
                            {{ $visit->school->name }}
                        </a>
                    </h5>

                    {{-- Status Badge --}}
                    @if($visit->status === 'confirmed')
                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill" style="font-size:11px;">
                            ● Confirmed Slot
                        </span>
                    @elseif($visit->status === 'pending')
                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1 rounded-pill" style="font-size:11px;">
                            ⏳ Pending Confirmation
                        </span>
                    @elseif($visit->status === 'completed')
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 rounded-pill" style="font-size:11px;">
                            🏁 Completed Tour
                        </span>
                    @else
                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 rounded-pill" style="font-size:11px;">
                            ❌ Cancelled
                        </span>
                    @endif
                </div>

                <div class="text-muted small mb-2">
                    <i class="fa-solid fa-location-dot text-danger me-1"></i> {{ $visit->school->address }}
                </div>

                {{-- Key Appointment Metadata Chips --}}
                <div class="d-flex gap-2 flex-wrap align-items-center small mt-2">
                    <span class="bg-light border px-2 py-1 rounded text-dark fw-bold">
                        📅 {{ \Carbon\Carbon::parse($visit->visit_date)->format('D, d M Y') }}
                    </span>
                    <span class="bg-light border px-2 py-1 rounded text-dark fw-bold">
                        ⏰ {{ \Carbon\Carbon::parse($visit->visit_time)->format('h:i A') }}
                    </span>
                    <span class="text-muted">
                        👤 Visitor: <strong class="text-dark">{{ $visit->visitor_name }}</strong>
                    </span>
                    <span class="text-muted">
                        📞 <a href="tel:{{ $visit->visitor_phone }}" class="text-dark text-decoration-none">{{ $visit->visitor_phone }}</a>
                    </span>
                </div>

                {{-- Notes / Special Requests --}}
                @if($visit->notes)
                <div class="mt-2 p-2 rounded-2 bg-light text-secondary small">
                    <i class="fa-regular fa-comment-dots text-primary me-1"></i>
                    <strong>Parent Note:</strong> {{ $visit->notes }}
                </div>
                @endif

                @if($visit->cancel_reason && $visit->status === 'cancelled')
                <div class="mt-2 p-2 rounded-2 bg-danger-subtle text-danger small">
                    <i class="fa-solid fa-circle-exclamation me-1"></i>
                    <strong>Cancellation Note:</strong> {{ $visit->cancel_reason }}
                </div>
                @endif
            </div>

            {{-- Action Buttons --}}
            <div class="d-flex flex-column gap-2 flex-shrink-0 align-items-stretch" style="min-width:130px;">
                <a href="{{ route('school.show', $visit->school->slug) }}" target="_blank"
                   class="btn btn-sm btn-outline-primary fw-bold text-center" style="border-radius:8px;font-size:12px;">
                    <i class="fa-solid fa-eye me-1"></i> View School
                </a>

                @if($visit->isPending())
                <form method="POST" action="{{ route('visit.cancel', $visit->id) }}"
                      onsubmit="return confirm('Are you sure you want to cancel this campus visit booking?')">
                    @csrf
                    <input type="hidden" name="reason" value="Cancelled by parent">
                    <button type="submit" class="btn btn-sm btn-outline-danger fw-bold w-100" style="border-radius:8px;font-size:12px;">
                        <i class="fa-solid fa-xmark me-1"></i> Cancel Slot
                    </button>
                </form>
                @endif
            </div>

        </div>
    </div>
    @endforeach
    </div>

    {{-- Pagination --}}
    @if($visits->hasPages())
    <div class="mt-4">
        {{ $visits->links() }}
    </div>
    @endif

    @endif

</div>
@endsection