@extends('layouts.public')
@section('title', 'Complete Payment – SchoolMapr')

@push('styles')
<style>
.pay-wrap { max-width:520px;margin:0 auto;padding:40px 16px 60px; }
.pay-card { background:#fff;border-radius:20px;border:1.5px solid #edf1f7;box-shadow:0 8px 28px rgba(20,32,60,.07);overflow:hidden; }
.pay-head  { background:linear-gradient(135deg,#1d3557,#e63946);padding:24px;text-align:center; }
.pay-head h2 { color:#fff;font-size:20px;font-weight:900;margin:0 0 4px; }
.pay-head p  { color:rgba(255,255,255,.75);font-size:13px;margin:0; }
.pay-body  { padding:26px; }
.pay-detail-row {
    display:flex;justify-content:space-between;align-items:center;
    padding:12px 0;border-bottom:1px solid #f3f4f6;font-size:14px;
}
.pay-detail-row:last-child { border-bottom:none; }
.pay-detail-label { color:#6b7280;font-weight:600; }
.pay-detail-val   { color:#1d3557;font-weight:800; }
.pay-total {
    background:linear-gradient(135deg,#1d3557,#2d5282);
    border-radius:12px;padding:16px 18px;
    display:flex;justify-content:space-between;align-items:center;margin:16px 0;
}
.pay-total-label { color:rgba(255,255,255,.75);font-size:13px;font-weight:700; }
.pay-total-amount { color:#fff;font-size:22px;font-weight:900; }
.pay-btn {
    width:100%;padding:16px;background:#e63946;color:#fff;border:none;border-radius:12px;
    font-size:15px;font-weight:800;cursor:pointer;transition:background .2s;font-family:inherit;
    display:flex;align-items:center;justify-content:center;gap:8px;
}
.pay-btn:hover { background:#c1121f; }
.pay-secure { text-align:center;font-size:11px;color:#9ca3af;margin-top:12px;display:flex;align-items:center;justify-content:center;gap:5px; }
</style>
@endpush

@section('content')

<div style="background:linear-gradient(135deg,#1d3557,#457b9d);padding:40px 0 32px;text-align:center;margin-bottom:0;">
    <div class="container">
        <div style="font-size:40px;margin-bottom:10px;">💳</div>
        <h1 style="color:#fff;font-size:clamp(20px,3vw,30px);font-weight:900;margin:0 0 6px;">Complete Your Payment</h1>
        <p style="color:rgba(255,255,255,.75);font-size:14px;margin:0;">Secure payment via Razorpay</p>
    </div>
</div>

<div class="pay-wrap">
    <div class="pay-card">
        <div class="pay-head">
            <h2>Registration Fee</h2>
            <p>{{ $school->name }}</p>
        </div>
        <div class="pay-body">

            <div class="pay-detail-row">
                <span class="pay-detail-label">Student Name</span>
                <span class="pay-detail-val">{{ $admission->student_name }}</span>
            </div>
            <div class="pay-detail-row">
                <span class="pay-detail-label">Class Applying</span>
                <span class="pay-detail-val">{{ $admission->class_applying }}</span>
            </div>
            <div class="pay-detail-row">
                <span class="pay-detail-label">School</span>
                <span class="pay-detail-val">{{ $school->name }}</span>
            </div>
            <div class="pay-detail-row">
                <span class="pay-detail-label">Board</span>
                <span class="pay-detail-val">{{ $school->board }}</span>
            </div>
            <div class="pay-detail-row">
                <span class="pay-detail-label">Application ID</span>
                <span class="pay-detail-val">#{{ str_pad($admission->id, 6, '0', STR_PAD_LEFT) }}</span>
            </div>

            <div class="pay-total">
                <span class="pay-total-label">Registration Fee</span>
                <span class="pay-total-amount">₹{{ number_format($amount) }}</span>
            </div>

            <button id="payBtn" class="pay-btn">
                <span>🔒</span>
                <span>Pay ₹{{ number_format($amount) }} Securely</span>
            </button>

            <div class="pay-secure">
                🔒 Secured by Razorpay &nbsp;|&nbsp; 100% Safe & Encrypted
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
document.getElementById('payBtn').addEventListener('click', function () {
    const options = {
        key:         '{{ config("services.razorpay.key") }}',
        amount:      {{ $amount * 100 }},
        currency:    'INR',
        name:        'SchoolMapr',
        description: 'Registration Fee – {{ $school->name }}',
        order_id:    '{{ $order->id }}',
        prefill: {
            name:    '{{ auth()->user()->name }}',
            email:   '{{ auth()->user()->email }}',
            contact: '{{ $admission->parent_phone }}',
        },
        theme: { color: '#e63946' },
        handler: function (response) {
            // Verify karo
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("payment.verify") }}';
            const fields = {
                '_token':               '{{ csrf_token() }}',
                'razorpay_order_id':    response.razorpay_order_id,
                'razorpay_payment_id':  response.razorpay_payment_id,
                'razorpay_signature':   response.razorpay_signature,
                'admission_id':         '{{ $admission->id }}',
            };
            Object.entries(fields).forEach(([k, v]) => {
                const input = document.createElement('input');
                input.type  = 'hidden';
                input.name  = k;
                input.value = v;
                form.appendChild(input);
            });
            document.body.appendChild(form);
            form.submit();
        },
        modal: {
            ondismiss: function () {
                console.log('Payment dismissed');
            }
        }
    };
    const rzp = new Razorpay(options);
    rzp.open();
});
</script>
@endpush