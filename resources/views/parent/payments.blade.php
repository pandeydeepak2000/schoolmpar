@extends('layouts.parent')
@section('title', 'My Payments & Receipts – SchoolMapr')

@section('content')
<div class="container-fluid p-0">

    {{-- Header Banner --}}
    <div class="card border-0 rounded-4 shadow-sm mb-4" style="background:linear-gradient(135deg, #0f2d59 0%, #1e4a85 100%);color:#fff;">
        <div class="card-body p-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <span class="badge bg-warning text-dark fw-bold px-3 py-1 mb-2" style="font-size:11px;">Billing & Receipts</span>
                    <h3 class="fw-bold mb-1">Payment History</h3>
                    <p class="mb-0 text-white-50 small">Track all your admission registration fees, tokens, and verified digital receipts.</p>
                </div>
                <div class="text-end">
                    <span class="small text-white-50 d-block">Total Successful Payments</span>
                    <h3 class="fw-bold mb-0 text-warning">₹{{ number_format($totalSpent, 2) }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Transactions Card --}}
    <div class="card border-0 rounded-4 shadow-sm">
        <div class="card-body p-4">
            <h5 class="fw-bold text-dark mb-3">Transaction Records ({{ $payments->total() }})</h5>

            @if($payments->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr style="font-size:12px;text-transform:uppercase;letter-spacing:0.5px;">
                            <th>#</th>
                            <th>School Destination</th>
                            <th>Purpose / Student</th>
                            <th>Amount (₹)</th>
                            <th>Transaction ID</th>
                            <th>Payment Status</th>
                            <th>Date & Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $i => $payment)
                        <tr>
                            <td class="text-muted small">{{ $payments->firstItem() + $i }}</td>
                            <td>
                                @if($payment->school)
                                    <strong class="d-block text-dark">{{ $payment->school->name }}</strong>
                                    <span class="text-muted small">{{ $payment->school->city ?? 'Patna' }}</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                @if($payment->admission)
                                    <span class="fw-bold text-primary">{{ $payment->admission->student_name }}</span>
                                    <span class="badge bg-light text-dark border ms-1">{{ $payment->admission->class_applying }}</span>
                                @else
                                    <span class="text-dark small">Registration Fee</span>
                                @endif
                            </td>
                            <td>
                                <strong class="text-dark fs-6">₹{{ number_format($payment->amount, 2) }}</strong>
                            </td>
                            <td>
                                <code class="small bg-light px-2 py-1 rounded text-dark">
                                    {{ $payment->razorpay_payment_id ?? ($payment->razorpay_order_id ?? 'TXN-'.$payment->id) }}
                                </code>
                            </td>
                            <td>
                                @if($payment->status === 'success')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill">
                                        ● Paid Successfully
                                    </span>
                                @elseif($payment->status === 'pending')
                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1 rounded-pill">
                                        ● Pending Verification
                                    </span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 rounded-pill">
                                        ● Failed
                                    </span>
                                @endif
                            </td>
                            <td class="small text-muted">
                                {{ $payment->created_at->format('d M Y, h:i A') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($payments->hasPages())
            <div class="mt-4">
                {{ $payments->links() }}
            </div>
            @endif

            @else
            <div class="text-center py-5">
                <div class="display-6 mb-3">💳</div>
                <h6 class="fw-bold text-dark">No Payment Transactions Yet</h6>
                <p class="text-muted small mb-0">When you pay admission registration fees or tokens online, your official receipts will appear here.</p>
            </div>
            @endif

        </div>
    </div>

</div>
@endsection
