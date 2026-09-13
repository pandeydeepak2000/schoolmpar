@extends('admin.layout')
@section('title', 'All Users – SchoolMapr Admin')
@section('page-title', 'Platform Users & Roles')
@section('page-sub', 'Manage registered parents, school partners, and administrator privileges')

@section('content')

<!-- Search & Top Action Strip -->
<div class="panel" style="margin-bottom:16px; overflow:visible;">
    <div style="padding:14px 18px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
        <form method="GET" action="{{ route('admin.users') }}" style="flex:1; min-width:280px;">
            <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
                <div style="position:relative; flex:1; min-width:200px;">
                    <i class="fas fa-search" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:12px;"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search by name, email, or phone..."
                        style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:8px 12px 8px 34px; font-size:13px; outline:none; color:#1e293b; box-sizing:border-box;">
                </div>
                <select name="role" style="border:1.5px solid #e2e8f0; border-radius:8px; padding:8px 12px; font-size:13px; outline:none; color:#334155; background:#fff; min-width:140px; box-sizing:border-box;">
                    <option value="">All Roles</option>
                    @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                        @if($role->name === 'school_owner')
                            School Partner
                        @elseif($role->name === 'admin')
                            Super Admin
                        @elseif($role->name === 'parent')
                            Parent
                        @else
                            {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                        @endif
                    </option>
                    @endforeach
                </select>
                <button type="submit" style="background:#0f2d59; color:#fff; border:none; border-radius:8px; padding:9px 18px; font-size:13px; font-weight:700; cursor:pointer;">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>
                @if(request('search') || request('role'))
                <a href="{{ route('admin.users') }}" style="font-size:12.5px; color:#ef4444; font-weight:700; text-decoration:none; margin-left:4px;">
                    <i class="fas fa-times me-1"></i> Clear
                </a>
                @endif
            </div>
        </form>

        <a href="{{ route('admin.users.create') }}"
           style="background:linear-gradient(135deg, #0f2d59 0%, #1e40af 100%); color:#fff; border:none; border-radius:8px; padding:9px 18px; font-size:13px; font-weight:800; text-decoration:none; display:inline-flex; align-items:center; gap:6px; box-shadow:0 2px 6px rgba(15,45,89,0.25); white-space:nowrap;">
            <i class="fas fa-user-plus"></i> Add New User
        </a>
    </div>
</div>

<!-- Table -->
<div class="panel">
    <div class="panel-header">
        <div class="panel-title">
            <i class="fas fa-users" style="color:#0f2d59; font-size:13px;"></i>
            Registered User Accounts ({{ $users->total() }})
        </div>
        <span style="font-size:11.5px; color:#64748b;">
            Showing {{ $users->firstItem() ?? 0 }}–{{ $users->lastItem() ?? 0 }} of {{ $users->total() }}
        </span>
    </div>

    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width:40px;">#</th>
                    <th>User Details</th>
                    <th>Email & Contact</th>
                    <th>Assigned Role</th>
                    <th>Joined Date</th>
                    <th style="text-align:right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $i => $user)
                <tr>
                    <td style="color:#94a3b8; font-size:12px;">{{ $users->firstItem() + $i }}</td>
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div style="width:34px; height:34px; background:linear-gradient(135deg,#0f2d59,#1e40af); border-radius:50%; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:800; font-size:13px; flex-shrink:0;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight:700; color:#0f172a; font-size:13.5px;">{{ $user->name }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div style="color:#0f172a; font-size:13px; font-weight:600;">{{ $user->email }}</div>
                        @if($user->phone)
                        <div style="color:#64748b; font-size:11.5px; margin-top:2px;">
                            <a href="tel:{{ $user->phone }}" style="color:#64748b; text-decoration:none;">
                                📞 {{ $user->phone }}
                            </a>
                        </div>
                        @endif
                    </td>
                    <td>
                        @forelse($user->roles as $role)
                            @if($role->name == 'admin')
                                <span class="badge badge-red">● Super Admin</span>
                            @elseif($role->name == 'school_owner')
                                <span class="badge badge-yellow">● School Partner</span>
                            @elseif($role->name == 'parent')
                                <span class="badge badge-green">● Parent</span>
                            @else
                                <span class="badge badge-green">● {{ ucfirst(str_replace('_', ' ', $role->name)) }}</span>
                            @endif
                        @empty
                            <span class="badge badge-gray">No Role</span>
                        @endforelse
                    </td>
                    <td style="color:#64748b; font-size:12.5px;">{{ $user->created_at->format('d M Y') }}</td>
                    <td style="text-align:right;">
                        <a href="/admin/users/{{ $user->id }}/edit"
                            style="background:#eff6ff; color:#2563eb; border-radius:6px; padding:5px 12px; font-size:11.5px; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:4px;">
                            <i class="fas fa-pen" style="font-size:10px;"></i> Edit / Password
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding:40px 20px; color:#94a3b8;">
                        No users found matching your filter criteria.
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