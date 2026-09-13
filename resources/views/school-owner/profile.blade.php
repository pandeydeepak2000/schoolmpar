@extends('school-owner.layout')
@section('title', 'Partner Account Settings – SchoolMapr')

@section('content')

{{-- Header --}}
<div style="margin-bottom:24px;">
    <h1 style="font-size:22px; font-weight:900; color:#0f2d59; margin:0 0 4px;">
        👤 School Partner Profile & Security
    </h1>
    <p style="font-size:13px; color:#64748b; margin:0;">
        Manage your partner account credentials, campus representative name, password, and two-factor security
    </p>
</div>

@if(session('success'))
<div style="background:#ecfdf5; border:1px solid #a7f3d0; border-radius:10px; padding:12px 16px; color:#059669; font-weight:700; font-size:13px; margin-bottom:20px;">
    ✅ {{ session('success') }}
</div>
@endif

@if(isset($errors) && $errors->any())
<div style="background:#fef2f2; border:1px solid #fecaca; border-radius:10px; padding:12px 16px; color:#dc2626; font-size:13px; margin-bottom:20px;">
    <ul style="margin:0; padding-left:18px;">
        @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
        @endforeach
    </ul>
</div>
@endif

<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(320px, 1fr)); gap:20px;">

    {{-- Panel 1: Personal Details --}}
    <div style="background:#fff; border:1.5px solid #e8ecf4; border-radius:14px; padding:24px; box-shadow:0 2px 8px rgba(0,0,0,0.02);">
        <div style="margin-bottom:16px; padding-bottom:12px; border-bottom:1.5px solid #f1f5f9; display:flex; align-items:center; gap:10px;">
            <div style="width:36px; height:36px; border-radius:8px; background:#eff6ff; color:#2563eb; display:flex; align-items:center; justify-content:center; font-size:16px;">
                <i class="fas fa-id-badge"></i>
            </div>
            <div>
                <h3 style="font-size:15px; font-weight:800; color:#0f2d59; margin:0;">Partner Representative Info</h3>
                <span style="font-size:11.5px; color:#64748b;">Your official school coordinator profile</span>
            </div>
        </div>

        <form action="{{ route('school-owner.profile.update') }}" method="POST">
            @csrf
            @method('PATCH')

            <div style="margin-bottom:14px;">
                <label style="font-size:12px; font-weight:700; color:#475569; display:block; margin-bottom:5px;">Full Name / Representative Name *</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                       style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:10px 14px; font-size:14px; outline:none; box-sizing:border-box;">
            </div>

            <div style="margin-bottom:14px;">
                <label style="font-size:12px; font-weight:700; color:#475569; display:block; margin-bottom:5px;">Registered Email (Verified & Fixed)</label>
                <input type="email" value="{{ $user->email }}" disabled
                       style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:10px 14px; font-size:14px; background:#f8fafc; color:#94a3b8; outline:none; box-sizing:border-box;">
                <span style="font-size:11px; color:#94a3b8; margin-top:3px; display:block;">🔒 Partner login email cannot be changed directly.</span>
            </div>

            <div style="margin-bottom:20px;">
                <label style="font-size:12px; font-weight:700; color:#475569; display:block; margin-bottom:5px;">Direct Mobile / Contact Number</label>
                <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="e.g. +91 98765 43210"
                       style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:10px 14px; font-size:14px; outline:none; box-sizing:border-box;">
            </div>

            <button type="submit" style="background:#0f2d59; color:#fff; border:none; border-radius:8px; padding:10px 24px; font-weight:800; font-size:13.5px; cursor:pointer;">
                💾 Save Partner Changes
            </button>
        </form>
    </div>

    {{-- Panel 2: Security & Password --}}
    <div style="display:flex; flex-direction:column; gap:20px;">

        {{-- Change Password --}}
        <div style="background:#fff; border:1.5px solid #e8ecf4; border-radius:14px; padding:24px; box-shadow:0 2px 8px rgba(0,0,0,0.02);">
            <div style="margin-bottom:16px; padding-bottom:12px; border-bottom:1.5px solid #f1f5f9; display:flex; align-items:center; gap:10px;">
                <div style="width:36px; height:36px; border-radius:8px; background:#fef2f2; color:#dc2626; display:flex; align-items:center; justify-content:center; font-size:16px;">
                    <i class="fas fa-lock"></i>
                </div>
                <div>
                    <h3 style="font-size:15px; font-weight:800; color:#0f2d59; margin:0;">Partner Console Password</h3>
                    <span style="font-size:11.5px; color:#64748b;">Protect your school administration dashboard</span>
                </div>
            </div>

            <form action="{{ route('school-owner.password.update') }}" method="POST">
                @csrf
                @method('PATCH')

                <div style="margin-bottom:12px;">
                    <label style="font-size:12px; font-weight:700; color:#475569; display:block; margin-bottom:5px;">Current Password *</label>
                    <input type="password" name="current_password" required placeholder="••••••••"
                           style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:9px 14px; font-size:13.5px; outline:none; box-sizing:border-box;">
                </div>

                <div style="margin-bottom:12px;">
                    <label style="font-size:12px; font-weight:700; color:#475569; display:block; margin-bottom:5px;">New Password (Min 6 chars) *</label>
                    <input type="password" name="password" required placeholder="••••••••"
                           style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:9px 14px; font-size:13.5px; outline:none; box-sizing:border-box;">
                </div>

                <div style="margin-bottom:18px;">
                    <label style="font-size:12px; font-weight:700; color:#475569; display:block; margin-bottom:5px;">Confirm New Password *</label>
                    <input type="password" name="password_confirmation" required placeholder="••••••••"
                           style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:9px 14px; font-size:13.5px; outline:none; box-sizing:border-box;">
                </div>

                <button type="submit" style="background:#dc2626; color:#fff; border:none; border-radius:8px; padding:10px 24px; font-weight:800; font-size:13.5px; cursor:pointer;">
                    🔒 Change Password
                </button>
            </form>
        </div>

        {{-- 2FA Security Toggle --}}
        <div style="background:#fff; border:1.5px solid #e8ecf4; border-radius:14px; padding:20px; box-shadow:0 2px 8px rgba(0,0,0,0.02);">
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <div style="display:flex; align-items:center; gap:12px;">
                    <div style="width:36px; height:36px; border-radius:8px; background:#ecfdf5; color:#059669; display:flex; align-items:center; justify-content:center; font-size:16px;">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div>
                        <div style="font-size:14px; font-weight:800; color:#0f2d59;">Two-Factor Authentication (2FA)</div>
                        <div style="font-size:12px; color:#64748b;">
                            {{ $user->two_factor_enabled ? '🛡️ Enabled: Extra security verification active on login' : 'Disabled: Sign in with password only' }}
                        </div>
                    </div>
                </div>

                <form action="{{ route('school-owner.two_factor.toggle') }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="two_factor_enabled" value="{{ $user->two_factor_enabled ? '0' : '1' }}">
                    <button type="submit" style="background:{{ $user->two_factor_enabled ? '#fee2e2' : '#059669' }}; color:{{ $user->two_factor_enabled ? '#dc2626' : '#fff' }}; border:none; border-radius:8px; padding:8px 16px; font-weight:800; font-size:12.5px; cursor:pointer;">
                        {{ $user->two_factor_enabled ? 'Disable 2FA' : 'Enable 2FA' }}
                    </button>
                </form>
            </div>
        </div>

    </div>

</div>

@endsection
