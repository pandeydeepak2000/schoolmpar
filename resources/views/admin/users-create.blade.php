@extends('admin.layout')
@section('title', 'Add New User – SchoolMapr Admin')
@section('page-title', 'Create User Account')
@section('page-sub', 'Register a new Parent, School Partner, or Super Administrator')

@section('content')

<div style="max-width:620px;">

    <div class="panel">
        <div class="panel-header">
            <div class="panel-title">
                <i class="fas fa-user-plus" style="color:#0f2d59; font-size:13px;"></i>
                New User Details
            </div>
            <a href="{{ route('admin.users') }}" style="font-size:12.5px; color:#64748b; font-weight:700; text-decoration:none;">
                <i class="fas fa-arrow-left me-1"></i> Back to All Users
            </a>
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

            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <!-- Full Name -->
                <div style="margin-bottom:16px;">
                    <label style="font-size:12px; font-weight:700; color:#374151; display:block; margin-bottom:6px; text-transform:uppercase; letter-spacing:0.04em;">
                        Full Name <span style="color:#ef4444;">*</span>
                    </label>
                    <div style="position:relative;">
                        <i class="fas fa-user" style="position:absolute; left:13px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:12px;"></i>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Ramesh Kumar" required autofocus
                            style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:10px 14px 10px 36px; font-size:13.5px; outline:none; color:#0f172a; transition:border 0.15s; background:#fff; box-sizing:border-box;">
                    </div>
                </div>

                <!-- Email Address -->
                <div style="margin-bottom:16px;">
                    <label style="font-size:12px; font-weight:700; color:#374151; display:block; margin-bottom:6px; text-transform:uppercase; letter-spacing:0.04em;">
                        Email Address <span style="color:#ef4444;">*</span>
                    </label>
                    <div style="position:relative;">
                        <i class="fas fa-envelope" style="position:absolute; left:13px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:12px;"></i>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="e.g. ramesh@example.com" required
                            style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:10px 14px 10px 36px; font-size:13.5px; outline:none; color:#0f172a; transition:border 0.15s; background:#fff; box-sizing:border-box;">
                    </div>
                </div>

                <!-- Phone Number -->
                <div style="margin-bottom:16px;">
                    <label style="font-size:12px; font-weight:700; color:#374151; display:block; margin-bottom:6px; text-transform:uppercase; letter-spacing:0.04em;">
                        Phone / Mobile Number
                    </label>
                    <div style="position:relative;">
                        <i class="fas fa-phone-alt" style="position:absolute; left:13px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:12px;"></i>
                        <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="e.g. 9876543210"
                            style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:10px 14px 10px 36px; font-size:13.5px; outline:none; color:#0f172a; transition:border 0.15s; background:#fff; box-sizing:border-box;">
                    </div>
                </div>

                <!-- Account Role -->
                <div style="margin-bottom:20px;">
                    <label style="font-size:12px; font-weight:700; color:#374151; display:block; margin-bottom:6px; text-transform:uppercase; letter-spacing:0.04em;">
                        Assign Account Role <span style="color:#ef4444;">*</span>
                    </label>
                    <div style="position:relative;">
                        <i class="fas fa-shield-alt" style="position:absolute; left:13px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:12px; z-index:1;"></i>
                        <select name="role" required
                            style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:10px 36px 10px 36px; font-size:13.5px; outline:none; color:#0f172a; background:#fff; appearance:none; cursor:pointer; transition:border 0.15s; box-sizing:border-box;">
                            <option value="">-- Select Role --</option>
                            @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ old('role', 'parent') == $role->name ? 'selected' : '' }}>
                                @if($role->name === 'parent')
                                    Parent (Student applications, campus visits & enquiry)
                                @elseif($role->name === 'school_owner')
                                    School Partner (Manage school profiles & fee details)
                                @elseif($role->name === 'admin')
                                    Super Admin (Full administrative access)
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

                <!-- Password Section -->
                <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:16px; margin-bottom:22px;">
                    <div style="font-weight:800; font-size:13.5px; color:#0f2d59; margin-bottom:4px; display:flex; align-items:center; gap:6px;">
                        <i class="fas fa-key text-warning"></i> Set Account Password
                    </div>
                    <p style="font-size:12px; color:#64748b; margin-bottom:14px;">
                        Minimum 6 characters. The user can log in using this password.
                    </p>

                    <div style="margin-bottom:12px;">
                        <label style="font-size:11.5px; font-weight:700; color:#475569; display:block; margin-bottom:5px;">
                            Password <span style="color:#ef4444;">*</span>
                        </label>
                        <div style="position:relative;">
                            <i class="fas fa-lock" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:12px;"></i>
                            <input type="password" name="password" placeholder="Enter password (min 6 characters)" required
                                style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:9px 14px 9px 34px; font-size:13px; outline:none; background:#fff; box-sizing:border-box;">
                        </div>
                    </div>

                    <div>
                        <label style="font-size:11.5px; font-weight:700; color:#475569; display:block; margin-bottom:5px;">
                            Confirm Password <span style="color:#ef4444;">*</span>
                        </label>
                        <div style="position:relative;">
                            <i class="fas fa-lock" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:12px;"></i>
                            <input type="password" name="password_confirmation" placeholder="Confirm password" required
                                style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:9px 14px 9px 34px; font-size:13px; outline:none; background:#fff; box-sizing:border-box;">
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div style="display:flex; gap:10px; flex-wrap:wrap;">
                    <button type="submit"
                        style="flex:1; background:#0f2d59; color:#fff; border:none; border-radius:8px; padding:12px; font-weight:800; font-size:14px; cursor:pointer; transition:background 0.15s; display:flex; align-items:center; justify-content:center; gap:7px;">
                        <i class="fas fa-user-plus"></i> Create Account
                    </button>
                    <a href="{{ route('admin.users') }}"
                        style="background:#f1f5f9; color:#64748b; border-radius:8px; padding:12px 22px; font-weight:700; font-size:13.5px; text-decoration:none; display:flex; align-items:center; gap:6px;">
                        <i class="fas fa-arrow-left" style="font-size:11px;"></i> Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>

</div>

@endsection
