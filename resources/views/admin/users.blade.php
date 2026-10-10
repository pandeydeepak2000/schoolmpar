@extends('admin.layout')
@section('title', 'User Directory & Roles – SchoolMapr Admin')
@section('page-title', 'User Directory & Access Control')
@section('page-sub', 'Manage parent accounts, verified school partners, and administrator privileges')

@section('content')

{{-- ── 1. SAAS KPI METRIC CARDS ── --}}
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:16px; margin-bottom:20px;">
    
    {{-- Total Users --}}
    <a href="{{ route('admin.users') }}" style="text-decoration:none; color:inherit;">
        <div class="stat-card" style="border-top:3px solid #2563eb; cursor:pointer;">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
                <span style="font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.05em;">Total Accounts</span>
                <div style="width:34px; height:34px; background:#eff6ff; border-radius:9px; display:flex; align-items:center; justify-content:center;">
                    <i class="fas fa-users" style="color:#2563eb; font-size:14px;"></i>
                </div>
            </div>
            <div style="font-size:26px; font-weight:900; color:#0f172a;">{{ number_format($stats['all'] ?? $users->total()) }}</div>
            <div style="font-size:11.5px; color:#64748b; margin-top:2px;">All registered platform users</div>
        </div>
    </a>

    {{-- Parents --}}
    <a href="{{ route('admin.users', ['role' => 'parent']) }}" style="text-decoration:none; color:inherit;">
        <div class="stat-card" style="border-top:3px solid #10b981; cursor:pointer; {{ request('role') === 'parent' ? 'box-shadow:0 0 0 2px #10b981;' : '' }}">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
                <span style="font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.05em;">Parents & Guardians</span>
                <div style="width:34px; height:34px; background:#ecfdf5; border-radius:9px; display:flex; align-items:center; justify-content:center;">
                    <i class="fas fa-user-friends" style="color:#10b981; font-size:14px;"></i>
                </div>
            </div>
            <div style="font-size:26px; font-weight:900; color:#0f172a;">{{ number_format($stats['parent'] ?? 0) }}</div>
            <div style="font-size:11.5px; color:#10b981; margin-top:2px; font-weight:700;">Admission seekers & parents</div>
        </div>
    </a>

    {{-- School Partners --}}
    <a href="{{ route('admin.users', ['role' => 'school_owner']) }}" style="text-decoration:none; color:inherit;">
        <div class="stat-card" style="border-top:3px solid #8b5cf6; cursor:pointer; {{ request('role') === 'school_owner' ? 'box-shadow:0 0 0 2px #8b5cf6;' : '' }}">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
                <span style="font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.05em;">School Partners</span>
                <div style="width:34px; height:34px; background:#f5f3ff; border-radius:9px; display:flex; align-items:center; justify-content:center;">
                    <i class="fas fa-school" style="color:#8b5cf6; font-size:14px;"></i>
                </div>
            </div>
            <div style="font-size:26px; font-weight:900; color:#0f172a;">{{ number_format($stats['school_owner'] ?? 0) }}</div>
            <div style="font-size:11.5px; color:#8b5cf6; margin-top:2px; font-weight:700;">Verified institution owners</div>
        </div>
    </a>

    {{-- Super Admins --}}
    <a href="{{ route('admin.users', ['role' => 'admin']) }}" style="text-decoration:none; color:inherit;">
        <div class="stat-card" style="border-top:3px solid #e11d48; cursor:pointer; {{ request('role') === 'admin' ? 'box-shadow:0 0 0 2px #e11d48;' : '' }}">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
                <span style="font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.05em;">System Admins</span>
                <div style="width:34px; height:34px; background:#fff1f2; border-radius:9px; display:flex; align-items:center; justify-content:center;">
                    <i class="fas fa-shield-alt" style="color:#e11d48; font-size:14px;"></i>
                </div>
            </div>
            <div style="font-size:26px; font-weight:900; color:#0f172a;">{{ number_format($stats['admin'] ?? 0) }}</div>
            <div style="font-size:11.5px; color:#e11d48; margin-top:2px; font-weight:700;">Portal administrative control</div>
        </div>
    </a>

</div>

{{-- ── 2. SAAS ROLE TABS & ACTIONS STRIP ── --}}
<div class="panel" style="margin-bottom:16px;">
    <div style="padding:14px 18px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
        
        {{-- Clean Pill Tabs --}}
        <div style="display:flex; gap:6px; flex-wrap:wrap; align-items:center;">
            @php
                $activeRole = request('role');
            @endphp

            {{-- All Tab --}}
            <a href="{{ route('admin.users', array_merge(request()->except(['role', 'page']), [])) }}"
               style="text-decoration:none; display:inline-flex; align-items:center; gap:8px; padding:7px 14px; border-radius:8px; font-size:12.5px; font-weight:700; transition:all 0.15s;
               {{ empty($activeRole) ? 'background:#2563eb; color:#fff;' : 'background:#f8fafc; color:#64748b; border:1px solid #e2e8f0;' }}">
                <i class="fas fa-users" style="font-size:12px;"></i> All Users
                <span style="font-size:11px; padding:2px 7px; border-radius:100px; font-weight:800; {{ empty($activeRole) ? 'background:rgba(255,255,255,0.22); color:#fff;' : 'background:#e2e8f0; color:#475569;' }}">
                    {{ $stats['all'] ?? 0 }}
                </span>
            </a>

            {{-- Parents Tab --}}
            <a href="{{ route('admin.users', array_merge(request()->except(['page']), ['role' => 'parent'])) }}"
               style="text-decoration:none; display:inline-flex; align-items:center; gap:8px; padding:7px 14px; border-radius:8px; font-size:12.5px; font-weight:700; transition:all 0.15s;
               {{ $activeRole === 'parent' ? 'background:#10b981; color:#fff;' : 'background:#f8fafc; color:#64748b; border:1px solid #e2e8f0;' }}">
                <i class="fas fa-user-friends" style="font-size:12px;"></i> Parents
                <span style="font-size:11px; padding:2px 7px; border-radius:100px; font-weight:800; {{ $activeRole === 'parent' ? 'background:rgba(255,255,255,0.22); color:#fff;' : 'background:#dcfce7; color:#15803d;' }}">
                    {{ $stats['parent'] ?? 0 }}
                </span>
            </a>

            {{-- School Partners Tab --}}
            <a href="{{ route('admin.users', array_merge(request()->except(['page']), ['role' => 'school_owner'])) }}"
               style="text-decoration:none; display:inline-flex; align-items:center; gap:8px; padding:7px 14px; border-radius:8px; font-size:12.5px; font-weight:700; transition:all 0.15s;
               {{ $activeRole === 'school_owner' ? 'background:#8b5cf6; color:#fff;' : 'background:#f8fafc; color:#64748b; border:1px solid #e2e8f0;' }}">
                <i class="fas fa-school" style="font-size:12px;"></i> School Partners
                <span style="font-size:11px; padding:2px 7px; border-radius:100px; font-weight:800; {{ $activeRole === 'school_owner' ? 'background:rgba(255,255,255,0.22); color:#fff;' : 'background:#ede9fe; color:#6d28d9;' }}">
                    {{ $stats['school_owner'] ?? 0 }}
                </span>
            </a>

            {{-- Admins Tab --}}
            <a href="{{ route('admin.users', array_merge(request()->except(['page']), ['role' => 'admin'])) }}"
               style="text-decoration:none; display:inline-flex; align-items:center; gap:8px; padding:7px 14px; border-radius:8px; font-size:12.5px; font-weight:700; transition:all 0.15s;
               {{ $activeRole === 'admin' ? 'background:#e11d48; color:#fff;' : 'background:#f8fafc; color:#64748b; border:1px solid #e2e8f0;' }}">
                <i class="fas fa-shield-alt" style="font-size:12px;"></i> Administrators
                <span style="font-size:11px; padding:2px 7px; border-radius:100px; font-weight:800; {{ $activeRole === 'admin' ? 'background:rgba(255,255,255,0.22); color:#fff;' : 'background:#ffe4e6; color:#be123c;' }}">
                    {{ $stats['admin'] ?? 0 }}
                </span>
            </a>
        </div>

        {{-- Add User Action Button --}}
        <a href="{{ route('admin.users.create') }}"
           style="background:linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color:#fff; border:none; border-radius:8px; padding:9px 18px; font-size:13px; font-weight:800; text-decoration:none; display:inline-flex; align-items:center; gap:7px; box-shadow:0 2px 6px rgba(37,99,235,0.25); white-space:nowrap;">
            <i class="fas fa-user-plus"></i> Add New User
        </a>
    </div>

    {{-- Search and Filter Form --}}
    <div style="padding:12px 18px; background:#fafbfc; border-bottom:1px solid #f1f5f9;">
        <form method="GET" action="{{ route('admin.users') }}">
            <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
                
                {{-- Keep Active Tab Role Filter --}}
                @if(request('role'))
                    <input type="hidden" name="role" value="{{ request('role') }}">
                @endif

                <div style="position:relative; flex:1; min-width:240px;">
                    <i class="fas fa-search" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:12px;"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search by name, email, or mobile..."
                        style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:8px 12px 8px 34px; font-size:13px; outline:none; color:#1e293b; box-sizing:border-box; background:#fff;">
                </div>

                @if(!request('role'))
                <select name="role" style="border:1.5px solid #e2e8f0; border-radius:8px; padding:8px 12px; font-size:13px; outline:none; color:#334155; background:#fff; min-width:150px; box-sizing:border-box;">
                    <option value="">Filter by Role (All)</option>
                    @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                        @if($role->name === 'school_owner')
                            🏫 School Partner
                        @elseif($role->name === 'admin')
                            🛡️ Super Admin
                        @elseif($role->name === 'parent')
                            👨‍👩‍👧 Parent
                        @else
                            {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                        @endif
                    </option>
                    @endforeach
                </select>
                @endif

                <button type="submit" style="background:#2563eb; color:#fff; border:none; border-radius:8px; padding:9px 18px; font-size:13px; font-weight:700; cursor:pointer; box-shadow:0 1px 3px rgba(37,99,235,0.3);">
                    <i class="fas fa-filter me-1"></i> Search
                </button>

                @if(request('search') || request('role'))
                <a href="{{ route('admin.users') }}" style="font-size:12.5px; color:#ef4444; font-weight:700; text-decoration:none; margin-left:4px;">
                    <i class="fas fa-times me-1"></i> Reset Filters
                </a>
                @endif
            </div>
        </form>
    </div>
</div>

{{-- ── 3. DATA TABLE ── --}}
<div class="panel">
    <div class="panel-header">
        <div class="panel-title">
            <i class="fas fa-id-badge" style="color:#2563eb; font-size:14px;"></i>
            @if(request('role') === 'parent')
                Registered Parents ({{ $users->total() }})
            @elseif(request('role') === 'school_owner')
                School Partners & Institution Owners ({{ $users->total() }})
            @elseif(request('role') === 'admin')
                Super Administrators ({{ $users->total() }})
            @else
                All User Accounts ({{ $users->total() }})
            @endif
        </div>
        <span style="font-size:11.5px; color:#64748b;">
            @if($users->total() > 0)
                Showing {{ $users->firstItem() }}–{{ $users->lastItem() }} of {{ $users->total() }} accounts
            @endif
        </span>
    </div>

    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width:40px;">#</th>
                    <th>User Profile</th>
                    <th>Email & Contact</th>
                    <th>Assigned Role</th>
                    <th>Connected Records</th>
                    <th>Joined Date</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $i => $user)
                @php
                    $isUserAdmin = $user->hasRole('admin');
                    $isUserOwner = $user->hasRole('school_owner');
                    $isUserParent = $user->hasRole('parent');

                    $avatarBg = $isUserAdmin 
                        ? 'linear-gradient(135deg, #e11d48, #be123c)' 
                        : ($isUserOwner 
                            ? 'linear-gradient(135deg, #7c3aed, #4f46e5)' 
                            : 'linear-gradient(135deg, #059669, #0284c7)');
                @endphp
                <tr>
                    <td style="color:#94a3b8; font-size:12px;">{{ $users->firstItem() + $i }}</td>
                    
                    {{-- User Profile --}}
                    <td>
                        <div style="display:flex; align-items:center; gap:11px;">
                            <div style="width:36px; height:36px; background:{{ $avatarBg }}; border-radius:50%; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:800; font-size:13.5px; flex-shrink:0; box-shadow:0 2px 5px rgba(0,0,0,0.12);">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight:700; color:#0f172a; font-size:13.5px; display:flex; align-items:center; gap:6px;">
                                    {{ $user->name }}
                                    @if($user->id === auth()->id())
                                        <span style="background:#eff6ff; color:#2563eb; font-size:10px; font-weight:800; padding:1px 6px; border-radius:4px; border:1px solid #bfdbfe;">YOU</span>
                                    @endif
                                </div>
                                <div style="font-size:11px; color:#94a3b8; font-family:monospace;">ID: #{{ $user->id }}</div>
                            </div>
                        </div>
                    </td>

                    {{-- Contact Info --}}
                    <td>
                        <div style="color:#0f172a; font-size:13px; font-weight:600; display:flex; align-items:center; gap:5px;">
                            <i class="far fa-envelope" style="color:#94a3b8; font-size:11px;"></i>
                            <a href="mailto:{{ $user->email }}" style="color:#0f172a; text-decoration:none;">{{ $user->email }}</a>
                        </div>
                        @if($user->phone)
                        <div style="color:#64748b; font-size:11.5px; margin-top:3px; display:flex; align-items:center; gap:5px;">
                            <i class="fas fa-phone-alt" style="color:#10b981; font-size:10.5px;"></i>
                            <a href="tel:{{ $user->phone }}" style="color:#475569; text-decoration:none; font-weight:500;">
                                {{ $user->phone }}
                            </a>
                        </div>
                        @else
                        <span style="font-size:11px; color:#cbd5e1;">No phone linked</span>
                        @endif
                    </td>

                    {{-- Assigned Role --}}
                    <td>
                        @forelse($user->roles as $role)
                            @if($role->name === 'admin')
                                <span class="badge" style="background:#fff1f2; color:#e11d48; border:1px solid #fecdd3; font-weight:800; font-size:11px;">
                                    🛡️ Super Admin
                                </span>
                            @elseif($role->name === 'school_owner')
                                <span class="badge" style="background:#f5f3ff; color:#7c3aed; border:1px solid #ddd6fe; font-weight:800; font-size:11px;">
                                    🏫 School Partner
                                </span>
                            @elseif($role->name === 'parent')
                                <span class="badge" style="background:#ecfdf5; color:#059669; border:1px solid #a7f3d0; font-weight:800; font-size:11px;">
                                    👨‍👩‍👧 Parent
                                </span>
                            @else
                                <span class="badge badge-gray font-weight:700;">
                                    {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                </span>
                            @endif
                        @empty
                            <span class="badge badge-gray">No Role</span>
                        @endforelse
                    </td>

                    {{-- Connected Records --}}
                    <td>
                        <div style="display:flex; flex-direction:column; gap:2px; font-size:11.5px; color:#64748b;">
                            @if($isUserOwner)
                                <span style="font-weight:600; color:#475569;">
                                    <i class="fas fa-school" style="color:#8b5cf6; width:14px;"></i> {{ $user->schools_count ?? 0 }} Schools Managed
                                </span>
                            @endif
                            @if($isUserParent)
                                <span>
                                    <i class="fas fa-graduation-cap" style="color:#2563eb; width:14px;"></i> {{ $user->admissions_count ?? 0 }} Admissions
                                </span>
                                <span>
                                    <i class="fas fa-envelope-open-text" style="color:#f59e0b; width:14px;"></i> {{ $user->enquiries_count ?? 0 }} Inquiries
                                </span>
                            @endif
                            @if($isUserAdmin)
                                <span style="color:#94a3b8; font-style:italic;">Full Administrator Access</span>
                            @endif
                        </div>
                    </td>

                    {{-- Joined Date --}}
                    <td style="color:#64748b; font-size:12.5px; white-space:nowrap;">
                        <span style="font-weight:600; color:#334155;">{{ $user->created_at->format('d M Y') }}</span>
                        <div style="font-size:11px; color:#94a3b8;">{{ $user->created_at->diffForHumans() }}</div>
                    </td>

                    {{-- Actions --}}
                    <td style="text-align:right;">
                        <div style="display:inline-flex; align-items:center; gap:6px;">
                            <a href="{{ route('admin.users.edit', $user->id) }}"
                                style="background:#eff6ff; color:#2563eb; border:1px solid #bfdbfe; border-radius:6px; padding:6px 12px; font-size:11.5px; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:5px; transition:all 0.15s;"
                                title="Edit user profile & change password">
                                <i class="fas fa-pen" style="font-size:10px;"></i> Edit
                            </a>

                            @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                  onsubmit="return confirm('⚠️ Are you sure you want to permanently delete user account: {{ addslashes($user->name) }} ({{ $user->email }})?');"
                                  style="margin:0; display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        style="background:#fff1f2; color:#e11d48; border:1px solid #fecdd3; border-radius:6px; padding:6px 10px; font-size:11.5px; font-weight:700; cursor:pointer; display:inline-flex; align-items:center; gap:4px;"
                                        title="Delete this user account">
                                    <i class="fas fa-trash-alt" style="font-size:10px;"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center; padding:60px 20px; color:#94a3b8;">
                        <div style="width:54px; height:54px; background:#f1f5f9; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 12px;">
                            <i class="fas fa-user-slash" style="font-size:22px; color:#cbd5e1;"></i>
                        </div>
                        <div style="font-size:14px; font-weight:700; color:#475569;">No users found matching your filters</div>
                        <div style="font-size:12px; color:#94a3b8; margin-top:4px;">Try clearing your search query or switching role tabs.</div>
                        <a href="{{ route('admin.users') }}" style="display:inline-block; margin-top:12px; background:#2563eb; color:#fff; border-radius:6px; padding:7px 16px; font-size:12px; font-weight:700; text-decoration:none;">
                            Clear All Filters
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
    <div style="padding:14px 18px; border-top:1px solid #f1f5f9;">
        {{ $users->links() }}
    </div>
    @endif
</div>

@endsection