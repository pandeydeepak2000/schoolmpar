@extends('admin.layout')
@section('title', 'Edit User – SchoolMapr Admin')
@section('page-title', 'Edit User Account')
@section('page-sub', 'Update name, email, phone, role, or reset password')

@section('content')

<div style="max-width:620px;">

    <!-- User Header Card -->
    <div class="panel" style="margin-bottom:16px;">
        <div style="padding:18px 20px; display:flex; align-items:center; gap:14px; flex-wrap:wrap;">
            <div style="width:52px; height:52px; background:linear-gradient(135deg,#0f2d59,#1e40af); border-radius:50%; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:900; font-size:20px; flex-shrink:0;">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <div style="font-size:16px; font-weight:800; color:#0f172a;">{{ $user->name }}</div>
                <div style="font-size:12.5px; color:#64748b; margin-top:2px;">{{ $user->email }}</div>
                <div style="margin-top:6px;">
                    @foreach($user->roles as $role)
                        @if($role->name == 'admin')
                            <span class="badge badge-red">● Super Admin</span>
                        @elseif($role->name == 'school_owner')
                            <span class="badge badge-yellow">● School Partner</span>
                        @elseif($role->name == 'parent')
                            <span class="badge badge-green">● Parent</span>
                        @else
                            <span class="badge badge-green">● {{ ucfirst(str_replace('_', ' ', $role->name)) }}</span>
                        @endif
                    @endforeach
                </div>
            </div>
            <div style="margin-left:auto;">
                <div style="font-size:11px; color:#94a3b8;">Member since</div>
                <div style="font-size:12px; font-weight:700; color:#334155; margin-top:2px;">{{ $user->created_at->format('d M Y') }}</div>
            </div>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="panel" style="margin-bottom:16px;">
        <div class="panel-header">
            <div class="panel-title">
                <i class="fas fa-user-edit" style="color:#0f2d59; font-size:13px;"></i>
                Edit Account Details & Password
            </div>
        </div>

        <div style="padding:22px;">

            @if(isset($errors) && $errors->any())
            <div style="background:#fff1f2; border:1px solid #fecdd3; color:#be123c; border-radius:9px; padding:12px 14px; font-size:12.5px; margin-bottom:18px;">
                <div style="font-weight:700; margin-bottom:4px;"><i class="fas fa-exclamation-circle me-1"></i> Please fix the following errors:</div>
                <ul style="margin:0; padding-left:20px;">
                    @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="/admin/users/{{ $user->id }}" method="POST">
                @csrf
                @method('PATCH')

                <!-- Name -->
                <div style="margin-bottom:16px;">
                    <label style="font-size:12px; font-weight:700; color:#374151; display:block; margin-bottom:6px; text-transform:uppercase; letter-spacing:0.04em;">
                        Full Name <span style="color:#ef4444;">*</span>
                    </label>
                    <div style="position:relative;">
                        <i class="fas fa-user" style="position:absolute; left:13px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:12px;"></i>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                            style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:10px 14px 10px 36px; font-size:13.5px; outline:none; color:#0f172a; transition:border 0.15s; background:#fff; box-sizing:border-box;">
                    </div>
                </div>

                <!-- Email -->
                <div style="margin-bottom:16px;">
                    <label style="font-size:12px; font-weight:700; color:#374151; display:block; margin-bottom:6px; text-transform:uppercase; letter-spacing:0.04em;">
                        Email Address <span style="color:#ef4444;">*</span>
                    </label>
                    <div style="position:relative;">
                        <i class="fas fa-envelope" style="position:absolute; left:13px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:12px;"></i>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                            style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:10px 14px 10px 36px; font-size:13.5px; outline:none; color:#0f172a; transition:border 0.15s; background:#fff; box-sizing:border-box;">
                    </div>
                </div>

                <!-- Phone -->
                <div style="margin-bottom:16px;">
                    <label style="font-size:12px; font-weight:700; color:#374151; display:block; margin-bottom:6px; text-transform:uppercase; letter-spacing:0.04em;">
                        Phone Number
                    </label>
                    <div style="position:relative;">
                        <i class="fas fa-phone-alt" style="position:absolute; left:13px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:12px;"></i>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="e.g. +91 9876543210"
                            style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:10px 14px 10px 36px; font-size:13.5px; outline:none; color:#0f172a; transition:border 0.15s; background:#fff; box-sizing:border-box;">
                    </div>
                </div>

                <!-- Role -->
                <div style="margin-bottom:20px;">
                    <label style="font-size:12px; font-weight:700; color:#374151; display:block; margin-bottom:6px; text-transform:uppercase; letter-spacing:0.04em;">
                        Account Role <span style="color:#ef4444;">*</span>
                    </label>
                    <div style="position:relative;">
                        <i class="fas fa-shield-alt" style="position:absolute; left:13px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:12px; z-index:1;"></i>
                        <select name="role" required
                            style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:10px 36px 10px 36px; font-size:13.5px; outline:none; color:#0f172a; background:#fff; appearance:none; cursor:pointer; transition:border 0.15s; box-sizing:border-box;">
                            @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                @if($role->name === 'school_owner')
                                    School Partner (Manage verified schools)
                                @elseif($role->name === 'admin')
                                    Super Admin (Full administrative access)
                                @elseif($role->name === 'parent')
                                    Parent (Student applications & visits)
                                @else
                                    {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                @endif
                            </option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down" style="position:absolute; right:13px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:11px; pointer-events:none;"></i>
                    </div>
                </div>

                <hr style="border:none; border-top:1px dashed #e2e8f0; margin:22px 0;">

                <!-- Password Change Section -->
                <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:16px; margin-bottom:22px;">
                    <div style="font-weight:800; font-size:13.5px; color:#0f2d59; margin-bottom:4px; display:flex; align-items:center; gap:6px;">
                        <i class="fas fa-key text-warning"></i> Reset / Change Password
                    </div>
                    <p style="font-size:12px; color:#64748b; margin-bottom:14px;">
                        Leave blank if you do not want to change this user's current password.
                    </p>

                    <div style="margin-bottom:12px;">
                        <label style="font-size:11.5px; font-weight:700; color:#475569; display:block; margin-bottom:5px;">
                            New Password (min. 6 characters)
                        </label>
                        <div style="position:relative;">
                            <i class="fas fa-lock" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:12px;"></i>
                            <input type="password" name="password" placeholder="Enter new password (optional)"
                                style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:9px 14px 9px 34px; font-size:13px; outline:none; background:#fff; box-sizing:border-box;">
                        </div>
                    </div>

                    <div>
                        <label style="font-size:11.5px; font-weight:700; color:#475569; display:block; margin-bottom:5px;">
                            Confirm New Password
                        </label>
                        <div style="position:relative;">
                            <i class="fas fa-lock" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:12px;"></i>
                            <input type="password" name="password_confirmation" placeholder="Confirm new password"
                                style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:9px 14px 9px 34px; font-size:13px; outline:none; background:#fff; box-sizing:border-box;">
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div style="display:flex; gap:10px; flex-wrap:wrap;">
                    <button type="submit"
                        style="flex:1; background:#0f2d59; color:#fff; border:none; border-radius:8px; padding:12px; font-weight:800; font-size:14px; cursor:pointer; transition:background 0.15s; display:flex; align-items:center; justify-content:center; gap:7px;">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                    <a href="/admin/users"
                        style="background:#f1f5f9; color:#64748b; border-radius:8px; padding:12px 22px; font-weight:700; font-size:13.5px; text-decoration:none; display:flex; align-items:center; gap:6px;">
                        <i class="fas fa-arrow-left" style="font-size:11px;"></i> Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>

    <!-- Danger Zone: Delete User (if not self) -->
    @if($user->id !== auth()->id())
    <div class="panel" style="border-color:#fee2e2;">
        <div style="padding:16px 20px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
            <div>
                <div style="font-size:13.5px; font-weight:800; color:#991b1b;"><i class="fas fa-trash-alt me-1"></i> Delete User Account</div>
                <div style="font-size:12px; color:#64748b; margin-top:2px;">Permanently remove this account and revoke platform access.</div>
            </div>
            <form action="/admin/users/{{ $user->id }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete user {{ $user->name }} ({{ $user->email }})?')">
                @csrf
                @method('DELETE')
                <button type="submit" style="background:#fee2e2; color:#dc2626; border:1px solid #fca5a5; border-radius:8px; padding:8px 16px; font-size:12px; font-weight:800; cursor:pointer;">
                    Delete Account
                </button>
            </form>
        </div>
    </div>
    @endif

</div>

@endsection