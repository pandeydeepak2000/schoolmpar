@extends('layouts.parent')
@section('title', 'Applicant Console – SchoolMapr')

@section('content')

<div class="container-fluid p-0">

    {{-- Welcome Banner --}}
    <div class="card border-0 rounded-4 shadow-sm mb-4" style="background:linear-gradient(135deg, #0f2d59 0%, #1e4a85 100%);color:#fff;">
        <div class="card-body p-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <span class="badge bg-warning text-dark fw-bold px-3 py-1 mb-2" style="font-size:11px;">Applicant Console</span>
                    <h3 class="fw-bold mb-1">Welcome, {{ auth()->user()->name }} 👋</h3>
                    <p class="mb-0 text-white-50 small">Track your shortlisted campuses, verified fees, admission enquiries, and scheduled visits.</p>
                </div>
                <a href="{{ url('/') }}" class="btn btn-warning fw-bold px-3 py-2" style="border-radius:8px;font-size:13px;color:#0f2d59;">
                    <i class="fa-solid fa-location-arrow me-1"></i> Explore More Schools
                </a>
            </div>
        </div>
    </div>

    {{-- 4 Modern Stat Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 rounded-4 shadow-sm p-3 h-100" style="background:#fff;">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="small fw-bold text-muted">Saved Schools</span>
                    <div style="width:36px;height:36px;border-radius:10px;background:#fee2e2;color:#dc2626;display:flex;align-items:center;justify-content:center;font-size:16px;">
                        <i class="fa-solid fa-heart"></i>
                    </div>
                </div>
                <h2 class="fw-bold text-dark mb-0">{{ $totalSaved }}</h2>
                <a href="{{ route('parent.saved') }}" class="small fw-bold text-primary text-decoration-none mt-2 d-inline-block">View List →</a>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card border-0 rounded-4 shadow-sm p-3 h-100" style="background:#fff;">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="small fw-bold text-muted">My Enquiries</span>
                    <div style="width:36px;height:36px;border-radius:10px;background:#eff6ff;color:#2563eb;display:flex;align-items:center;justify-content:center;font-size:16px;">
                        <i class="fa-solid fa-paper-plane"></i>
                    </div>
                </div>
                <h2 class="fw-bold text-dark mb-0">{{ $totalEnquiries }}</h2>
                <a href="{{ route('parent.enquiries') }}" class="small fw-bold text-primary text-decoration-none mt-2 d-inline-block">Track Status →</a>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card border-0 rounded-4 shadow-sm p-3 h-100" style="background:#fff;">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="small fw-bold text-muted">Campus Visits</span>
                    <div style="width:36px;height:36px;border-radius:10px;background:#f0fdf4;color:#16a34a;display:flex;align-items:center;justify-content:center;font-size:16px;">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                </div>
                <h2 class="fw-bold text-dark mb-0">{{ $totalVisits ?? 0 }}</h2>
                <a href="{{ route('dashboard.visits') }}" class="small fw-bold text-primary text-decoration-none mt-2 d-inline-block">View Visits →</a>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card border-0 rounded-4 shadow-sm p-3 h-100" style="background:#fff;">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="small fw-bold text-muted">Compare Deck</span>
                    <div style="width:36px;height:36px;border-radius:10px;background:#fefce8;color:#ca8a04;display:flex;align-items:center;justify-content:center;font-size:16px;">
                        <i class="fa-solid fa-scale-balanced"></i>
                    </div>
                </div>
                <h2 class="fw-bold text-dark mb-0">3 Max</h2>
                <a href="{{ url('/compare') }}" class="small fw-bold text-primary text-decoration-none mt-2 d-inline-block">Compare Tool →</a>
            </div>
        </div>
    </div>

    {{-- Saved Schools Section --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-dark m-0">❤️ Shortlisted Schools</h5>
        <a href="{{ route('parent.saved') }}" class="small fw-bold text-primary text-decoration-none">View All ({{ $totalSaved }})</a>
    </div>

    <div class="row g-3 mb-5">
        @forelse($savedSchools as $saved)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card border-0 rounded-4 shadow-sm h-100 overflow-hidden" style="background:#fff;">
                    <div style="height:120px;background:#0f2d59;position:relative;overflow:hidden;">
                        <img src="{{ $saved->school->featured_image_url }}" alt="{{ $saved->school->name }}" style="width:100%;height:100%;object-fit:cover;">
                        <span class="badge bg-danger position-absolute top-0 start-0 m-2" style="font-size:10px;">{{ $saved->school->board }}</span>
                    </div>
                    <div class="card-body p-3 d-flex flex-column">
                        <h6 class="fw-bold text-dark mb-1">{{ $saved->school->name }}</h6>
                        <small class="text-muted mb-2"><i class="fa-solid fa-location-dot text-danger me-1"></i>{{ Str::limit($saved->school->address, 32) }}</small>
                        <div class="small fw-bold text-success mb-3">
                            ₹{{ number_format($saved->school->fee_min) }} – ₹{{ number_format($saved->school->fee_max) }}/yr
                        </div>
                        <div class="mt-auto d-flex gap-2">
                            <a href="{{ route('school.show', $saved->school->slug) }}" class="btn btn-sm btn-primary fw-bold flex-grow-1" style="border-radius:6px;font-size:12px;">
                                View Profile
                            </a>
                            <a href="{{ route('visit.book', $saved->school->slug) }}" class="btn btn-sm btn-outline-dark fw-bold" style="border-radius:6px;font-size:12px;">
                                📅 Visit
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5 bg-white rounded-4 border p-4">
                    <i class="fa-solid fa-heart-crack fa-3x text-muted mb-3"></i>
                    <h5 class="fw-bold text-dark">No saved schools yet</h5>
                    <p class="text-muted small">Explore Patna schools and click the 🤍 Save button to bookmark them.</p>
                    <a href="{{ url('/') }}" class="btn btn-primary btn-sm fw-bold px-4 py-2" style="border-radius:8px;">
                        Browse Top Patna Schools
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Recent Enquiries Section --}}
    @if($totalEnquiries > 0)
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold text-dark m-0">📩 Recent Admission Enquiries</h5>
            <a href="{{ route('parent.enquiries') }}" class="small fw-bold text-primary text-decoration-none">View All</a>
        </div>

        <div class="card border-0 rounded-4 shadow-sm overflow-hidden mb-4" style="background:#fff;">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0 text-muted small fw-bold">School Name</th>
                            <th class="border-0 text-muted small fw-bold">Target Class</th>
                            <th class="border-0 text-muted small fw-bold">Date Submitted</th>
                            <th class="border-0 text-muted small fw-bold">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($enquiries as $enq)
                            <tr>
                                <td class="fw-bold text-dark">{{ $enq->school->name ?? 'School' }}</td>
                                <td><span class="badge bg-light text-dark border">{{ $enq->child_class ?? 'General' }}</span></td>
                                <td class="small text-muted">{{ $enq->created_at->format('d M, Y') }}</td>
                                <td>
                                    <span class="badge bg-success text-white px-2 py-1" style="font-size:11px;">
                                        Submitted to School
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div>

@endsection