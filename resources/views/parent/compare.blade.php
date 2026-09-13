@extends('layouts.parent')
@section('title', 'Compare Schools – SchoolMapr')

@push('styles')
<style>
    .page-hero {
        background:linear-gradient(135deg,#1d3557,#457b9d);
        border-radius:18px; padding:24px 28px; margin-bottom:20px;
    }
    .page-hero .breadcrumb-nav { display:flex; align-items:center; gap:8px; margin-bottom:10px; }
    .page-hero .breadcrumb-nav a { color:rgba(255,255,255,.65); font-size:13px; text-decoration:none; }
    .page-hero .breadcrumb-nav span { color:rgba(255,255,255,.3); }
    .page-hero h1 { color:#fff; font-size:22px; font-weight:800; margin:0; }
    .page-hero p  { color:rgba(255,255,255,.7); font-size:13px; margin-top:4px; }
    .page-hero-top { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; }

    .table-card {
        background:#fff; border-radius:20px; overflow:hidden;
        border:1.5px solid #f0f0f0;
        box-shadow:0 4px 16px rgba(0,0,0,.06);
    }
    .compare-table { width:100%; border-collapse:collapse; }
    .compare-table thead th {
        background:#1d3557; color:#fff;
        padding:20px 16px; text-align:center;
        font-size:14px; border:1px solid #2a4a6b;
        min-width:150px;
    }
    .compare-table thead th.feature-head {
        background:#0d2137; text-align:left;
        font-size:13px; font-weight:700;
        width:130px; min-width:110px;
    }
    .school-emoji  { font-size:26px; display:block; margin-bottom:6px; }
    .school-name-h { font-size:14px; font-weight:800; line-height:1.3; }
    .school-city-h { font-size:11px; opacity:.7; margin-top:4px; }

    .compare-table tbody td {
        padding:13px 16px; font-size:13px; color:#444;
        border:1px solid #f0f0f0; text-align:center; vertical-align:middle;
    }
    .compare-table tbody td.feature-col {
        background:#f4f6f9 !important; font-weight:700;
        color:#1d3557; text-align:left;
    }
    .compare-table tbody tr:nth-child(even) td:not(.feature-col) { background:#fafafa; }
    .compare-table tbody tr:hover td { background:#fff8f8; transition:background .15s; }
    .best-cell  { background:#d4edda !important; font-weight:800; color:#155724; }
    .best-label { font-size:10px; display:block; font-weight:600; color:#16a34a; margin-top:2px; }
    .action-row td { background:#fff !important; padding:18px 16px; }

    .btn-view {
        background:#e63946; color:#fff; border:none; border-radius:10px;
        padding:10px 20px; font-weight:700; font-size:13px;
        display:inline-block; transition:all .2s; text-decoration:none;
    }
    .btn-view:hover { background:#c1121f; color:#fff; transform:translateY(-1px); }

    .mobile-compare { display:none; }

    .empty-state {
        text-align:center; padding:80px 20px; background:#fff;
        border-radius:20px; border:1.5px solid #f0f0f0;
    }
    .empty-state .e-icon { font-size:56px; margin-bottom:16px; }
    .empty-state h5 { color:#1d3557; font-weight:800; margin-bottom:8px; font-size:18px; }
    .empty-state p  { color:#888; font-size:14px; margin-bottom:24px; }
    .empty-state a  {
        background:#e63946; color:#fff; border-radius:12px;
        padding:12px 32px; font-weight:700; font-size:14px;
        display:inline-block; text-decoration:none;
    }
    .hint-bar { text-align:center; font-size:12px; color:#aaa; margin-top:12px; }
    .hint-bar code { background:#f4f6f9; padding:2px 8px; border-radius:4px; color:#666; }

    @media (max-width: 640px) {
        .table-card     { display:none; }
        .mobile-compare { display:block; }

        .m-school-card {
            background:#fff; border-radius:16px;
            border:1.5px solid #f0f0f0;
            box-shadow:0 2px 10px rgba(0,0,0,.05);
            margin-bottom:16px; overflow:hidden;
        }
        .m-school-header {
            background:#1d3557; color:#fff;
            padding:16px 18px; text-align:center;
        }
        .m-school-header .s-emoji { font-size:26px; margin-bottom:4px; }
        .m-school-header .s-name  { font-size:15px; font-weight:800; }
        .m-school-header .s-city  { font-size:11px; opacity:.7; margin-top:2px; }

        .m-row {
            display:flex; justify-content:space-between; align-items:center;
            padding:11px 16px; border-bottom:1px solid #f5f5f5; gap:8px;
        }
        .m-row:last-child { border-bottom:none; }
        .m-row .m-label { font-size:12px; font-weight:700; color:#1d3557; }
        .m-row .m-val   { font-size:13px; color:#444; text-align:right; }
        .m-action { padding:16px; }

        .page-hero { padding:20px 16px; }
    }
</style>
@endpush

@section('content')

<div class="page-hero">
    <div class="breadcrumb-nav">
        <a href="{{ route('parent.dashboard') }}">← Dashboard</a>
        <span>/</span>
        <span style="color:#fff;">Compare Schools</span>
    </div>
    <div class="page-hero-top">
        <div>
            <h1>⚖️ Compare Schools</h1>
            <p>Side-by-side comparison to help you choose the right school.</p>
        </div>
        @if($schools->count() > 0)
        <a href="/" style="background:rgba(255,255,255,.15);color:#fff;
                           border:1.5px solid rgba(255,255,255,.3);border-radius:8px;
                           padding:8px 16px;font-size:13px;font-weight:600;text-decoration:none;">
            + Add More Schools
        </a>
        @endif
    </div>
</div>

@if($schools->count() < 2)

<div class="empty-state">
    <div class="e-icon">⚖️</div>
    <h5>Select at Least 2 Schools to Compare</h5>
    <p>Click the "Compare" button on school cards from the home page.</p>
    <a href="/">← Browse Schools</a>
</div>

@else

{{-- Desktop Table --}}
<div class="table-card">
    <div class="table-responsive">
        <table class="compare-table">
            <thead>
                <tr>
                    <th class="feature-head">Feature</th>
                    @foreach($schools as $s)
                    <th>
                        <span class="school-emoji">🏫</span>
                        <div class="school-name-h">{{ $s->name }}</div>
                        <div class="school-city-h">
                            <i class="fas fa-map-marker-alt me-1"></i>
                            {{ $s->city }}@if($s->state ?? false), {{ $s->state }}@endif
                        </div>
                    </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="feature-col">📋 Board</td>
                    @foreach($schools as $s)
                        <td><strong>{{ $s->board }}</strong></td>
                    @endforeach
                </tr>
                <tr>
                    <td class="feature-col">🗣️ Medium</td>
                    @foreach($schools as $s)
                        <td>{{ $s->medium }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td class="feature-col">🎓 Classes</td>
                    @foreach($schools as $s)
                        <td>Class {{ $s->class_from }} – {{ $s->class_to }}</td>
                    @endforeach
                </tr>

                @php $minFee = $schools->min('fee_min'); @endphp
                <tr>
                    <td class="feature-col">💰 Min Fees</td>
                    @foreach($schools as $s)
                    <td class="{{ $s->fee_min == $minFee ? 'best-cell' : '' }}">
                        ₹{{ number_format($s->fee_min) }}
                        @if($s->fee_min == $minFee)
                            <span class="best-label">✅ Lowest</span>
                        @endif
                    </td>
                    @endforeach
                </tr>

                @php $minMaxFee = $schools->min('fee_max'); @endphp
                <tr>
                    <td class="feature-col">💸 Max Fees</td>
                    @foreach($schools as $s)
                    <td class="{{ $s->fee_max == $minMaxFee ? 'best-cell' : '' }}">
                        ₹{{ number_format($s->fee_max) }}
                        @if($s->fee_max == $minMaxFee)
                            <span class="best-label">✅ Lowest</span>
                        @endif
                    </td>
                    @endforeach
                </tr>

                <tr>
                    <td class="feature-col">📍 City</td>
                    @foreach($schools as $s)<td>{{ $s->city }}</td>@endforeach
                </tr>
                <tr>
                    <td class="feature-col">✅ Verified</td>
                    @foreach($schools as $s)
                    <td>
                        @if($s->is_verified ?? false)
                            <span style="background:#dcfce7;color:#16a34a;font-size:11px;
                                         font-weight:700;padding:4px 10px;border-radius:100px;">
                                ✅ Verified
                            </span>
                        @else
                            <span style="color:#aaa;">—</span>
                        @endif
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <td class="feature-col">⭐ Featured</td>
                    @foreach($schools as $s)
                    <td>
                        @if($s->is_featured ?? false)
                            <span style="background:#fef9c3;color:#ca8a04;font-size:11px;
                                         font-weight:700;padding:4px 10px;border-radius:100px;">
                                ⭐ Featured
                            </span>
                        @else
                            <span style="color:#aaa;">—</span>
                        @endif
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <td class="feature-col">📝 Admission</td>
                    @foreach($schools as $s)
                    @php
                        $admMap = [
                            'open'        => ['#dcfce7','#16a34a','🟢 Open'],
                            'closed'      => ['#fee2e2','#dc2626','🔴 Closed'],
                            'coming_soon' => ['#fef9c3','#ca8a04','🟡 Coming Soon'],
                        ];
                        $adm = $admMap[$s->admission_status ?? 'open'] ?? $admMap['open'];
                    @endphp
                    <td>
                        <span style="background:{{ $adm[0] }};color:{{ $adm[1] }};
                                     font-size:11px;font-weight:700;
                                     padding:4px 10px;border-radius:100px;">
                            {{ $adm[2] }}
                        </span>
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <td class="feature-col">💺 Seats</td>
                    @foreach($schools as $s)
                    <td>
                        @if($s->seats_available ?? false)
                            <strong style="color:#1d3557;">{{ $s->seats_available }}</strong>
                            <span style="font-size:11px;color:#888;"> available</span>
                        @else
                            <span style="color:#aaa;">—</span>
                        @endif
                    </td>
                    @endforeach
                </tr>
                <tr class="action-row">
                    <td class="feature-col" style="background:#f4f6f9!important;"></td>
                    @foreach($schools as $s)
                    <td>
                        <a href="/schools/{{ $s->slug ?? $s->id }}" class="btn-view">
                            View Details →
                        </a>
                    </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>
</div>

{{-- Mobile Cards --}}
<div class="mobile-compare">
    @foreach($schools as $s)
    @php
        $admMap2 = [
            'open'        => ['#dcfce7','#16a34a','🟢 Open'],
            'closed'      => ['#fee2e2','#dc2626','🔴 Closed'],
            'coming_soon' => ['#fef9c3','#ca8a04','🟡 Coming Soon'],
        ];
        $adm2 = $admMap2[$s->admission_status ?? 'open'] ?? $admMap2['open'];
    @endphp
    <div class="m-school-card">
        <div class="m-school-header">
            <div class="s-emoji">🏫</div>
            <div class="s-name">{{ $s->name }}</div>
            <div class="s-city">📍 {{ $s->city }}@if($s->state ?? false), {{ $s->state }}@endif</div>
        </div>
        <div class="m-row">
            <span class="m-label">📋 Board</span>
            <span class="m-val"><strong>{{ $s->board }}</strong></span>
        </div>
        <div class="m-row">
            <span class="m-label">🗣️ Medium</span>
            <span class="m-val">{{ $s->medium }}</span>
        </div>
        <div class="m-row">
            <span class="m-label">🎓 Classes</span>
            <span class="m-val">Class {{ $s->class_from }} – {{ $s->class_to }}</span>
        </div>
        <div class="m-row">
            <span class="m-label">💰 Min Fees</span>
            <span class="m-val">₹{{ number_format($s->fee_min) }}</span>
        </div>
        <div class="m-row">
            <span class="m-label">💸 Max Fees</span>
            <span class="m-val">₹{{ number_format($s->fee_max) }}</span>
        </div>
        <div class="m-row">
            <span class="m-label">📝 Admission</span>
            <span class="m-val">
                <span style="background:{{ $adm2[0] }};color:{{ $adm2[1] }};
                             font-size:11px;font-weight:700;
                             padding:3px 8px;border-radius:100px;">
                    {{ $adm2[2] }}
                </span>
            </span>
        </div>
        @if($s->seats_available ?? false)
        <div class="m-row">
            <span class="m-label">💺 Seats</span>
            <span class="m-val"><strong>{{ $s->seats_available }}</strong> available</span>
        </div>
        @endif
        <div class="m-action">
            <a href="/schools/{{ $s->slug ?? $s->id }}"
               class="btn-view" style="width:100%;display:block;text-align:center;">
                View Details →
            </a>
        </div>
    </div>
    @endforeach
    <p style="text-align:center;font-size:12px;color:#aaa;margin-top:4px;">
        💡 Switch to desktop view for a full side-by-side comparison table.
    </p>
</div>

<div class="hint-bar d-none d-md-block">
    💡 Green cells indicate the better option &nbsp;|&nbsp;
    Add school IDs to the URL: <code>/compare?schools=1,2,3</code>
</div>

@endif

@endsection