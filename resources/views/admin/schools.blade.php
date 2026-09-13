@extends('admin.layout')
@section('title', 'All Schools Directory – SchoolMapr Admin')
@section('page-title', 'All Listed Schools')
@section('page-sub', 'Manage verified school profiles, admissions, and partner ownership across Patna & Bihar')

@section('content')

{{-- ── 1. KPI STAT CARDS ── --}}
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(210px, 1fr)); gap:16px; margin-bottom:24px;">
    
    <div class="stat-card" style="border-top:3px solid #3b82f6;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
            <span style="font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.05em;">Total Schools</span>
            <div style="width:34px; height:34px; background:#eff6ff; border-radius:9px; display:flex; align-items:center; justify-content:center;">
                <i class="fas fa-school" style="color:#3b82f6; font-size:14px;"></i>
            </div>
        </div>
        <div style="font-size:26px; font-weight:900; color:#0f172a;">{{ number_format($stats['total']) }}</div>
        <div style="font-size:11.5px; color:#64748b; margin-top:2px;">Across all Patna localities</div>
    </div>

    <div class="stat-card" style="border-top:3px solid #10b981;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
            <span style="font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.05em;">Live & Approved</span>
            <div style="width:34px; height:34px; background:#ecfdf5; border-radius:9px; display:flex; align-items:center; justify-content:center;">
                <i class="fas fa-check-circle" style="color:#10b981; font-size:14px;"></i>
            </div>
        </div>
        <div style="font-size:26px; font-weight:900; color:#0f172a;">{{ number_format($stats['approved']) }}</div>
        <div style="font-size:11.5px; color:#10b981; margin-top:2px; font-weight:700;">Visible to parents</div>
    </div>

    <div class="stat-card" style="border-top:3px solid #f59e0b;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
            <span style="font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.05em;">Pending Review</span>
            <div style="width:34px; height:34px; background:#fffbeb; border-radius:9px; display:flex; align-items:center; justify-content:center;">
                <i class="fas fa-hourglass-half" style="color:#f59e0b; font-size:14px;"></i>
            </div>
        </div>
        <div style="font-size:26px; font-weight:900; color:#0f172a;">{{ number_format($stats['pending']) }}</div>
        <div style="font-size:11.5px; color:#d97706; margin-top:2px; font-weight:700;">Needs verification</div>
    </div>

    <div class="stat-card" style="border-top:3px solid #6366f1;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
            <span style="font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.05em;">Admin Managed</span>
            <div style="width:34px; height:34px; background:#eef2ff; border-radius:9px; display:flex; align-items:center; justify-content:center;">
                <i class="fas fa-user-shield" style="color:#6366f1; font-size:14px;"></i>
            </div>
        </div>
        <div style="font-size:26px; font-weight:900; color:#0f172a;">{{ number_format($stats['no_owner']) }}</div>
        <div style="font-size:11.5px; color:#6366f1; margin-top:2px;">Direct Central handling</div>
    </div>

</div>

{{-- ── 2. A–Z ALPHABET FILTER BAR ── --}}
<div style="background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:10px 14px; margin-bottom:14px; display:flex; flex-wrap:wrap; gap:4px; align-items:center;">
    <span style="font-size:10px; font-weight:800; color:#64748b; margin-right:6px; text-transform:uppercase; letter-spacing:.06em;">A–Z INDEX:</span>
    <a href="{{ route('admin.schools', request()->except('letter')) }}"
       style="padding:4px 10px; border-radius:6px; font-size:12px; font-weight:800; text-decoration:none;
              background:{{ !request('letter') ? '#0f2d59' : '#f1f5f9' }};
              color:{{ !request('letter') ? '#fff' : '#475569' }};">ALL</a>
    @foreach(range('A','Z') as $letter)
    <a href="{{ route('admin.schools', array_merge(request()->except('letter'), ['letter' => $letter])) }}"
       style="padding:4px 9px; border-radius:6px; font-size:12px; font-weight:700; text-decoration:none;
              background:{{ request('letter') === $letter ? '#0f2d59' : '#f8fafc' }};
              color:{{ request('letter') === $letter ? '#fff' : '#64748b' }};">{{$letter}}</a>
    @endforeach
</div>

{{-- ── 3. SEARCH & FILTERS PANEL ── --}}
<div class="panel" style="margin-bottom:18px;">
    <div style="padding:14px 18px;">
        <form method="GET" action="{{ route('admin.schools') }}">
            @if(request('letter'))
                <input type="hidden" name="letter" value="{{ request('letter') }}">
            @endif
            <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">

                {{-- Search --}}
                <div style="position:relative; flex:1; min-width:200px;">
                    <i class="fas fa-search" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:12px;"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search school name or locality..."
                           style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:8px 12px 8px 34px; font-size:13px; outline:none; color:#1e293b; box-sizing:border-box;">
                </div>

                {{-- Locality / City --}}
                <div style="min-width:140px;">
                    <select name="city" style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:8px 12px; font-size:13px; outline:none; color:#334155; background:#fff; box-sizing:border-box;">
                        <option value="">All Localities</option>
                        @foreach($cities as $city)
                        <option value="{{$city}}" {{ request('city')===$city ? 'selected':'' }}>{{$city}}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Board --}}
                <div style="min-width:130px;">
                    <select name="board" style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:8px 12px; font-size:13px; outline:none; color:#334155; background:#fff; box-sizing:border-box;">
                        <option value="">All Boards</option>
                        <option value="CBSE"  {{ request('board')==='CBSE'  ? 'selected':'' }}>CBSE</option>
                        <option value="ICSE"  {{ request('board')==='ICSE'  ? 'selected':'' }}>ICSE</option>
                        <option value="State" {{ request('board')==='State' ? 'selected':'' }}>State Board</option>
                    </select>
                </div>

                {{-- Status --}}
                <div style="min-width:130px;">
                    <select name="status" style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:8px 12px; font-size:13px; outline:none; color:#334155; background:#fff; box-sizing:border-box;">
                        <option value="">All Status</option>
                        <option value="approved" {{ request('status')==='approved' ? 'selected':'' }}>✅ Approved</option>
                        <option value="pending"  {{ request('status')==='pending'  ? 'selected':'' }}>⏳ Pending</option>
                        <option value="inactive" {{ request('status')==='inactive' ? 'selected':'' }}>⛔ Inactive</option>
                        <option value="rejected" {{ request('status')==='rejected' ? 'selected':'' }}>❌ Rejected</option>
                    </select>
                </div>

                {{-- Owner --}}
                <div style="min-width:130px;">
                    <select name="owner" style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:8px 12px; font-size:13px; outline:none; color:#334155; background:#fff; box-sizing:border-box;">
                        <option value="">All Ownership</option>
                        <option value="has" {{ request('owner')==='has' ? 'selected':'' }}>✅ Partner Claimed</option>
                        <option value="no"  {{ request('owner')==='no'  ? 'selected':'' }}>🏛️ Admin Managed</option>
                    </select>
                </div>

                <button type="submit" style="background:#0f2d59; color:#fff; border:none; border-radius:8px; padding:9px 18px; font-size:13px; font-weight:700; cursor:pointer;">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>

                @if(request()->hasAny(['search','city','board','status','owner','letter']))
                <a href="{{ route('admin.schools') }}" style="font-size:12.5px; color:#ef4444; font-weight:700; text-decoration:none; margin-left:4px;">
                    <i class="fas fa-times me-1"></i> Clear
                </a>
                @endif

            </div>
        </form>
    </div>
</div>

{{-- ── 4. SCHOOLS DATA TABLE ── --}}
<div class="panel">
    <div class="panel-header">
        <div class="panel-title">
            <i class="fas fa-school" style="color:#0f2d59;"></i>
            Listed School Profiles ({{ $schools->total() }})
        </div>
        <a href="{{ route('admin.schools.crud.create') }}"
           style="background:#0f2d59; color:#fff; font-size:12.5px; font-weight:800; text-decoration:none; padding:8px 18px; border-radius:8px; display:inline-flex; align-items:center; gap:6px;">
            <i class="fas fa-plus" style="font-size:11px;"></i> Add New School
        </a>
    </div>

    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width:40px;">#</th>
                    <th>School Profile</th>
                    <th>Locality / Board</th>
                    <th>Ownership</th>
                    <th>Verified Annual Fee</th>
                    <th>Admissions</th>
                    <th>Visits</th>
                    <th>Status</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($schools as $i => $school)
            <tr>
                <td style="color:#94a3b8; font-size:12px;">{{ $schools->firstItem() + $i }}</td>

                {{-- School --}}
                <td>
                    <div style="display:flex; align-items:center; gap:10px;">
                        <div style="width:38px; height:38px; border-radius:8px; overflow:hidden; background:#e2e8f0; flex-shrink:0;">
                            <img src="{{ $school->featured_image_url }}" alt="{{ $school->name }}" style="width:100%; height:100%; object-fit:cover;">
                        </div>
                        <div>
                            <div style="font-weight:800; color:#0f172a; font-size:13.5px;">{{ $school->name }}</div>
                            <div style="font-size:11px; color:#64748b; margin-top:1px;">{{ Str::limit($school->address, 32) }}</div>
                        </div>
                    </div>
                </td>

                {{-- City / Board --}}
                <td>
                    <div style="font-size:13px; font-weight:700; color:#1e293b;">{{ $school->city ?? 'Patna' }}</div>
                    <span class="badge {{ $school->board == 'CBSE' ? 'badge-blue' : ($school->board == 'ICSE' ? 'badge-green' : 'badge-yellow') }}"
                          style="margin-top:3px; font-size:9.5px;">
                        {{ $school->board }}
                    </span>
                </td>

                {{-- Owner --}}
                <td>
                    @if($school->owner)
                        <div style="font-size:12px; font-weight:800; color:#059669;">{{ $school->owner->name }}</div>
                        <div style="font-size:10.5px; color:#64748b;">{{ $school->owner->email }}</div>
                        <span style="font-size:9.5px; background:#ecfdf5; color:#059669; border:1px solid #a7f3d0; padding:1px 6px; border-radius:4px; font-weight:700; display:inline-block; margin-top:2px;">
                            ✅ Partner Managed
                        </span>
                    @else
                        <span style="font-size:10px; background:#f1f5f9; color:#475569; border:1px solid #e2e8f0; padding:2px 7px; border-radius:4px; font-weight:700; display:inline-block;">
                            🏛️ Admin Managed
                        </span>
                    @endif
                </td>

                {{-- Fees --}}
                <td style="font-size:13px; color:#0f172a; font-weight:700;">
                    @if($school->fee_min && $school->fee_max)
                        ₹{{ number_format($school->fee_min/1000) }}K – ₹{{ number_format($school->fee_max/1000) }}K
                    @else
                        <span style="color:#94a3b8; font-size:12px;">—</span>
                    @endif
                </td>

                {{-- Admissions Count --}}
                <td style="text-align:center;">
                    <div style="font-size:16px; font-weight:900; color:#2563eb;">{{ $school->admissions_count }}</div>
                    <div style="font-size:10px; color:#94a3b8;">leads</div>
                </td>

                {{-- Visits Count --}}
                <td style="text-align:center;">
                    <div style="font-size:16px; font-weight:900; color:#7c3aed;">{{ $school->visit_bookings_count }}</div>
                    <div style="font-size:10px; color:#94a3b8;">tours</div>
                </td>

                {{-- Status & Admission --}}
                <td>
                    <div style="display:flex; flex-direction:column; gap:4px; align-items:flex-start;">
                        @if($school->status === 'approved' && $school->is_active)
                            <span class="badge badge-green">● Active</span>
                        @elseif($school->status === 'pending')
                            <span class="badge badge-yellow">● Pending</span>
                        @elseif($school->status === 'rejected')
                            <span class="badge badge-red">● Rejected</span>
                        @else
                            <span class="badge badge-gray">● Inactive</span>
                        @endif

                        @if(($school->admission_status ?? 'open') === 'open')
                            <span style="font-size:9.5px; background:#ecfdf5; color:#15803d; border:1px solid #86efac; padding:1px 6px; border-radius:4px; font-weight:800; white-space:nowrap;">
                                🟢 Open 2026-27
                            </span>
                        @elseif($school->admission_status === 'coming_soon')
                            <span style="font-size:9.5px; background:#fffbeb; color:#b45309; border:1px solid #fde68a; padding:1px 6px; border-radius:4px; font-weight:800; white-space:nowrap;">
                                🟡 Opening Soon
                            </span>
                        @else
                            <span style="font-size:9.5px; background:#fef2f2; color:#b91c1c; border:1px solid #fecaca; padding:1px 6px; border-radius:4px; font-weight:800; white-space:nowrap;">
                                🔴 Closed
                            </span>
                        @endif

                        @if($school->is_featured)
                            <div style="font-size:9.5px; color:#f59e0b; font-weight:800;">⭐ Featured</div>
                        @endif
                    </div>
                </td>

                {{-- Actions --}}
                <td style="text-align:right;">
                    <div style="display:inline-flex; flex-direction:column; gap:4px; align-items:flex-end;">
                        {{-- Manage --}}
                        <a href="{{ route('admin.schools.manage', $school->id) }}"
                           style="background:#0f2d59; color:#fff; border-radius:6px; padding:4px 10px; font-size:11.5px; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:4px;">
                            <i class="fas fa-sliders" style="font-size:10px;"></i> Manage
                        </a>

                        <div style="display:inline-flex; gap:4px;">
                            {{-- View Live --}}
                            <a href="{{ route('school.show', $school->slug) }}" target="_blank" title="View Public Page"
                               style="background:#eff6ff; color:#2563eb; border-radius:6px; padding:4px 8px; font-size:11px; font-weight:700; text-decoration:none;">
                                <i class="fas fa-external-link-alt"></i>
                            </a>

                            {{-- Edit --}}
                            <a href="{{ route('admin.schools.crud.edit', $school->id) }}" title="Edit Details & Photos"
                               style="background:#ecfdf5; color:#059669; border-radius:6px; padding:4px 8px; font-size:11px; font-weight:700; text-decoration:none;">
                                <i class="fas fa-pen"></i>
                            </a>

                            {{-- Toggle --}}
                            <form action="/admin/schools/{{ $school->id }}/toggle" method="POST" style="display:inline;">
                                @csrf @method('PATCH')
                                <button title="{{ $school->status === 'approved' ? 'Deactivate School' : 'Activate School' }}"
                                        style="background:{{ $school->status==='approved' ? '#fef2f2' : '#ecfdf5' }};
                                               color:{{ $school->status==='approved' ? '#dc2626' : '#059669' }};
                                               border:none; border-radius:6px; padding:4px 7px; font-size:10.5px; font-weight:700; cursor:pointer;">
                                    {{ $school->status === 'approved' ? 'Off' : 'On' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="text-align:center; padding:60px 20px; color:#94a3b8;">
                    <i class="fas fa-school" style="font-size:32px; display:block; margin-bottom:10px; color:#cbd5e1;"></i>
                    <div style="font-size:14px; font-weight:700; color:#334155;">No schools found matching your search</div>
                    @if(request()->hasAny(['search','city','board','status','owner','letter']))
                        <div style="margin-top:6px;"><a href="{{ route('admin.schools') }}" style="color:#2563eb; font-size:13px; font-weight:700;">Clear all search filters</a></div>
                    @endif
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    @if($schools->hasPages())
    <div style="padding:14px 18px; border-top:1px solid #f1f5f9;">
        {{ $schools->links() }}
    </div>
    @endif
</div>

@endsection