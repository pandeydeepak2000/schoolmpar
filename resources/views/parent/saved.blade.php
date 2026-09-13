@extends('layouts.parent')
@section('title', 'Saved Schools – SchoolMapr')

@section('content')
<div class="container-fluid p-0">

    {{-- Header Banner --}}
    <div class="card border-0 rounded-4 shadow-sm mb-4" style="background:linear-gradient(135deg, #0f2d59 0%, #1e4a85 100%);color:#fff;">
        <div class="card-body p-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <span class="badge bg-warning text-dark fw-bold px-3 py-1 mb-2" style="font-size:11px;">My Shortlist</span>
                    <h3 class="fw-bold mb-1">Saved Schools</h3>
                    <p class="mb-0 text-white-50 small">Your shortlisted partner schools in Patna for quick comparison, admissions, and campus visits.</p>
                </div>
                <a href="{{ url('/') }}" class="btn btn-warning fw-bold px-3 py-2" style="border-radius:8px;font-size:13px;color:#0f2d59;">
                    <i class="fa-solid fa-magnifying-glass me-1"></i> Explore More Schools
                </a>
            </div>
        </div>
    </div>

    @if($savedSchools->count() > 0)

    <div class="row g-3">
        @foreach($savedSchools as $saved)
        @php $school = $saved->school; @endphp
        @if($school)
        <div class="col-12 col-md-6 col-lg-4" id="sc-{{ $school->id }}">
            <div class="card border-0 rounded-4 shadow-sm h-100 overflow-hidden bg-white">
                
                {{-- Campus Image & Badges --}}
                <div style="position:relative;height:160px;background:#f1f5f9;">
                    <img src="{{ $school->featured_image_url }}" alt="{{ $school->name }}" style="width:100%;height:100%;object-fit:cover;">
                    <span style="position:absolute;top:10px;left:10px;background:rgba(15,45,89,0.85);color:#fff;font-size:11px;font-weight:800;padding:3px 8px;border-radius:6px;backdrop-filter:blur(4px);">
                        {{ $school->board }}
                    </span>
                    <button type="button" class="btn btn-sm btn-light border-0 shadow-sm rounded-circle"
                            onclick="removeSaved({{ $school->id }})"
                            style="position:absolute;top:10px;right:10px;width:30px;height:30px;display:flex;align-items:center;justify-content:center;color:#dc2626;" title="Remove from shortlist">
                        <i class="fa-solid fa-heart"></i>
                    </button>
                </div>

                {{-- Card Body --}}
                <div class="card-body p-3 d-flex flex-column">
                    <h5 class="fw-bold text-dark mb-1" style="font-size:15px;">
                        <a href="{{ route('school.show', $school->slug) }}" class="text-dark text-decoration-none hover-primary">
                            {{ $school->name }}
                        </a>
                    </h5>
                    <div class="text-muted small mb-2">
                        <i class="fa-solid fa-location-dot text-danger me-1"></i> {{ $school->city ?? 'Patna' }}
                    </div>

                    <div class="d-flex gap-2 flex-wrap mb-3 small">
                        <span class="bg-light border px-2 py-1 rounded text-dark">
                            Class {{ $school->class_from }}–{{ $school->class_to }}
                        </span>
                        @if($school->fee_min && $school->fee_max)
                        <span class="bg-light border px-2 py-1 rounded text-success fw-bold">
                            ₹{{ number_format($school->fee_min/1000) }}K–₹{{ number_format($school->fee_max/1000) }}K/yr
                        </span>
                        @endif
                    </div>

                    {{-- Actions --}}
                    <div class="mt-auto d-flex gap-2">
                        <a href="{{ route('school.show', $school->slug) }}" class="btn btn-sm btn-primary fw-bold flex-grow-1" style="background:#0f2d59;border:none;border-radius:8px;font-size:12px;">
                            View Profile →
                        </a>
                        <a href="{{ route('visit.book', $school->slug) }}" class="btn btn-sm btn-outline-success fw-bold" style="border-radius:8px;font-size:12px;">
                            Book Tour
                        </a>
                    </div>
                </div>

            </div>
        </div>
        @endif
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($savedSchools->hasPages())
    <div class="mt-4">
        {{ $savedSchools->links() }}
    </div>
    @endif

    @else

    <div class="card border-0 rounded-4 shadow-sm p-5 text-center bg-white">
        <div class="display-5 mb-3">❤️</div>
        <h5 class="fw-bold text-dark mb-1">No Saved Schools Yet</h5>
        <p class="text-muted small mb-4 mx-auto" style="max-width:360px;">
            Click the "❤️ Save" icon on any school card to save it to your personal shortlist.
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

@push('scripts')
<script>
function removeSaved(schoolId) {
    if (!confirm('Remove this school from your saved shortlist?')) return;
    fetch(`/schools/${schoolId}/save`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        }
    })
    .then(r => r.json())
    .then(() => {
        const card = document.getElementById('sc-' + schoolId);
        if (card) {
            card.style.transition = 'all .3s';
            card.style.opacity = '0';
            card.style.transform = 'scale(0.9)';
            setTimeout(() => {
                card.remove();
                const remaining = document.querySelectorAll('[id^="sc-"]').length;
                if (remaining === 0) location.reload();
            }, 300);
        }
    })
    .catch(() => alert('Something went wrong. Please try again.'));
}
</script>
@endpush