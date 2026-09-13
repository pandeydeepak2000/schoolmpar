@extends('admin.layout')
@section('title', 'Razorpay Gateway Settings – Admin')
@section('page-title', 'Payment Gateway Settings')
@section('page-sub', 'Configure live vs test mode, API Keys, and digital admission token settlement parameters')

@section('content')

@if(session('success'))
<div class="alert-success">
    {{ session('success') }}
</div>
@endif

@if(isset($errors) && $errors->any())
<div class="alert-error">
    <ul style="margin:0; padding-left:16px;">
        @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
        @endforeach
    </ul>
</div>
@endif

<div style="display:grid; grid-template-columns:1.2fr 0.8fr; gap:20px;">

    {{-- Configuration Form --}}
    <div class="panel">
        <div class="panel-header">
            <div class="panel-title">
                <i class="fas fa-credit-card" style="color:#0f2d59;"></i>
                Razorpay API Credentials
            </div>
            <span style="font-size:11.5px; font-weight:800; background:{{ $mode === 'live' ? '#ecfdf5' : '#fffbeb' }}; color:{{ $mode === 'live' ? '#059669' : '#d97706' }}; border:1px solid {{ $mode === 'live' ? '#a7f3d0' : '#fde68a' }}; padding:3px 10px; border-radius:999px; text-transform:uppercase;">
                ● {{ $mode }} Mode Active
            </span>
        </div>

        <form action="{{ route('admin.settings.payments.update') }}" method="POST" style="padding:22px;">
            @csrf
            @method('POST')

            {{-- Mode Selector --}}
            <div style="margin-bottom:18px;">
                <label style="font-size:12px; font-weight:700; color:#334155; display:block; margin-bottom:6px;">
                    Gateway Environment Mode *
                </label>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                    <label style="display:flex; align-items:center; gap:10px; border:1.5px solid {{ $mode === 'test' ? '#3b82f6' : '#e2e8f0' }}; background:{{ $mode === 'test' ? '#eff6ff' : '#fff' }}; border-radius:10px; padding:12px 16px; cursor:pointer;">
                        <input type="radio" name="razorpay_mode" value="test" {{ $mode === 'test' ? 'checked' : '' }} style="accent-color:#2563eb;">
                        <div>
                            <strong style="font-size:13.5px; color:#1e293b; display:block;">🟡 Sandbox / Test Mode</strong>
                            <span style="font-size:11px; color:#64748b;">Simulate payments with dummy cards (rzp_test_...)</span>
                        </div>
                    </label>

                    <label style="display:flex; align-items:center; gap:10px; border:1.5px solid {{ $mode === 'live' ? '#10b981' : '#e2e8f0' }}; background:{{ $mode === 'live' ? '#ecfdf5' : '#fff' }}; border-radius:10px; padding:12px 16px; cursor:pointer;">
                        <input type="radio" name="razorpay_mode" value="live" {{ $mode === 'live' ? 'checked' : '' }} style="accent-color:#10b981;">
                        <div>
                            <strong style="font-size:13.5px; color:#1e293b; display:block;">🟢 Production / Live Mode</strong>
                            <span style="font-size:11px; color:#64748b;">Accept real parent payments via UPI, Cards & Netbanking</span>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Key ID --}}
            <div style="margin-bottom:16px;">
                <label style="font-size:12px; font-weight:700; color:#334155; display:block; margin-bottom:5px;">
                    Razorpay Key ID (Client Key) *
                </label>
                <input type="text" name="razorpay_key" value="{{ old('razorpay_key', $keyId) }}" required
                       placeholder="rzp_test_... or rzp_live_..."
                       style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:10px 14px; font-size:13.5px; outline:none; box-sizing:border-box; font-family:monospace;">
            </div>

            {{-- Key Secret --}}
            <div style="margin-bottom:16px;">
                <label style="font-size:12px; font-weight:700; color:#334155; display:block; margin-bottom:5px;">
                    Razorpay Key Secret (Server Secret) *
                </label>
                <input type="password" name="razorpay_secret" value="{{ old('razorpay_secret', $keySecret) }}" required
                       placeholder="Enter secret key..."
                       style="width:100%; border:1.5px solid #cbd5e1; border-radius:8px; padding:10px 14px; font-size:13.5px; outline:none; box-sizing:border-box;">
            </div>

            {{-- Currency --}}
            <div style="margin-bottom:22px;">
                <label style="font-size:12px; font-weight:700; color:#334155; display:block; margin-bottom:5px;">
                    Default Currency
                </label>
                <input type="text" name="payment_currency" value="{{ old('payment_currency', $currency) }}" readonly
                       style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:10px 14px; font-size:13.5px; background:#f8fafc; color:#64748b; outline:none; box-sizing:border-box;">
            </div>

            <button type="submit" style="background:#0f2d59; color:#fff; border:none; border-radius:8px; padding:12px 28px; font-weight:800; font-size:14px; cursor:pointer;">
                💾 Save Gateway Settings
            </button>
        </form>
    </div>

    {{-- Guide & Instructions Panel --}}
    <div style="display:flex; flex-direction:column; gap:16px;">
        <div style="background:#fff; border:1.5px solid #e8ecf4; border-radius:14px; padding:20px;">
            <strong style="font-size:14px; color:#0f2d59; display:block; margin-bottom:10px;">
                📖 How to get Razorpay API Keys
            </strong>
            <ol style="margin:0; padding-left:18px; font-size:12.5px; color:#475569; line-height:1.7;">
                <li>Log in to your <strong>Razorpay Dashboard</strong> (<a href="https://dashboard.razorpay.com" target="_blank" style="color:#2563eb; font-weight:700;">dashboard.razorpay.com</a>).</li>
                <li>Go to <strong>Settings</strong> ➔ <strong>API Keys</strong> tab.</li>
                <li>Click <strong>Generate Key</strong> to create your <code>Key ID</code> and <code>Key Secret</code>.</li>
                <li>Copy and paste the credentials here and click <strong>Save Settings</strong>.</li>
            </ol>
        </div>

        <div style="background:#eff6ff; border:1.5px solid #bfdbfe; border-radius:14px; padding:18px;">
            <strong style="font-size:13px; color:#1e40af; display:block; margin-bottom:6px;">
                🔒 Bank-Grade Security
            </strong>
            <p style="font-size:12px; color:#1e3a8a; margin:0; line-height:1.6;">
                Razorpay keys are encrypted in the application database and transmitted over HTTPS. Webhook signature validation protects against replay attacks.
            </p>
        </div>
    </div>

</div>

@endsection
