@extends('layouts.public')
@section('title', 'Payment Failed – SchoolMapr')

@section('content')

<div style="min-height:60vh; display:flex; align-items:center; justify-content:center; padding:40px 16px;">
    <div style="max-width:440px; width:100%; text-align:center;">

        {{-- Icon --}}
        <div style="width:80px; height:80px; background:#fff1f2; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 20px; border:3px solid #fecdd3;">
            <span style="font-size:36px;">❌</span>
        </div>

        <h1 style="font-size:24px; font-weight:900; color:#0f1729; margin:0 0 8px;">Payment Failed</h1>
        <p style="font-size:14px; color:#64748b; margin:0 0 24px; line-height:1.6;">
            Tumhara payment process nahi ho saka. Koi amount deduct nahi hua hai.<br>
            Please dobara try karo.
        </p>

        @if(session('error'))
        <div style="background:#fff1f2; border:1px solid #fecdd3; border-radius:10px; padding:12px 16px; margin-bottom:20px; font-size:13px; color:#be123c;">
            {{ session('error') }}
        </div>
        @endif

        <div style="display:flex; flex-direction:column; gap:10px;">
            <a href="{{ url()->previous() }}"
               style="background:#e63946; color:#fff; border-radius:10px; padding:13px 20px; font-size:14px; font-weight:700; text-decoration:none; display:block;">
                🔄 Try Again
            </a>
            <a href="{{ route('parent.dashboard') }}"
               style="background:#f1f5f9; color:#64748b; border-radius:10px; padding:13px 20px; font-size:14px; font-weight:700; text-decoration:none; display:block;">
                🏠 Go to Dashboard
            </a>
        </div>

        <p style="font-size:11px; color:#94a3b8; margin-top:20px;">
            Problem ho rahi hai? Helpline: <a href="tel:+918893112323" style="color:#0f2d59;font-weight:700;text-decoration:none;">+91 88931 12323</a> • support@schoolmapr.com
        </p>
    </div>
</div>

@endsection