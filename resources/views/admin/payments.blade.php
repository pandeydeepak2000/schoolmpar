@extends('admin.layout')
@section('title', 'Payment History & Settlements – SchoolMapr Admin')
@section('page-title', 'Payment History & Settlements')
@section('page-sub', 'Track platform registration fees, application tokens, and transaction settlements')

@section('content')

{{-- ── 1. FINANCIAL KPI STAT CARDS ── --}}
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(210px, 1fr)); gap:16px; margin-bottom:24px;">
    
    <div class="stat-card" style="border-top:3px solid #3b82f6;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
            <span style="font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.05em;">Total Transactions</span>
            <div style="width:34px; height:34px; background:#eff6ff; border-radius:9px; display:flex; align-items:center; justify-content:center;">
                <i class="fas fa-credit-card" style="color:#3b82f6; font-size:14px;"></i>
            </div>
        </div>
        <div style="font-size:26px; font-weight:900; color:#0f172a;">{{ number_format($stats['total']) }}</div>
        <div style="font-size:11.5px; color:#64748b; margin-top:2px;">All initiated tokens</div>
    </div>

    <div class="stat-card" style="border-top:3px solid #10b981;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
            <span style="font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.05em;">Successful Payments</span>
            <div style="width:34px; height:34px; background:#ecfdf5; border-radius:9px; display:flex; align-items:center; justify-content:center;">
                <i class="fas fa-check-circle" style="color:#10b981; font-size:14px;"></i>
            </div>
        </div>
        <div style="font-size:26px; font-weight:900; color:#0f172a;">{{ number_format($stats['success']) }}</div>
        <div style="font-size:11.5px; color:#10b981; margin-top:2px; font-weight:700;">100% Verified settlements</div>
    </div>

    <div class="stat-card" style="border-top:3px solid #f59e0b;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
            <span style="font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.05em;">Pending Verification</span>
            <div style="width:34px; height:34px; background:#fffbeb; border-radius:9px; display:flex; align-items:center; justify-content:center;">
                <i class="fas fa-hourglass-half" style="color:#f59e0b; font-size:14px;"></i>
            </div>
        </div>
        <div style="font-size:26px; font-weight:900; color:#0f172a;">{{ number_format($stats['pending']) }}</div>
        <div style="font-size:11.5px; color:#d97706; margin-top:2px;">Gateway reconciliation</div>
    </div>

    <div class="stat-card" style="border-top:3px solid #8b5cf6;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
            <span style="font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase; letter-spacing:0.05em;">Total Settlement Volume</span>
            <div style="width:34px; height:34px; background:#f5f3ff; border-radius:9px; display:flex; align-items:center; justify-content:center;">
                <i class="fas fa-indian-rupee-sign" style="color:#8b5cf6; font-size:14px;"></i>
            </div>
        </div>
        <div style="font-size:26px; font-weight:900; color:#7c3aed;">₹{{ number_format($stats['revenue'], 2) }}</div>
        <div style="font-size:11.5px; color:#8b5cf6; margin-top:2px; font-weight:700;">Net platform processing</div>
    </div>

</div>

{{-- ── 2. FILTER BAR ── --}}
<div class="panel" style="margin-bottom:18px;">
    <div style="padding:14px 18px;">
        <form method="GET" action="{{ route('admin.payments') }}">
            <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
                
                {{-- Search --}}
                <div style="position:relative; flex:1; min-width:220px;">
                    <i class="fas fa-search" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:12px;"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search by user, email, Razorpay payment ID..."
                           style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:8px 12px 8px 34px; font-size:13px; outline:none; color:#1e293b; box-sizing:border-box;">
                </div>

                {{-- Status --}}
                <div style="min-width:140px;">
                    <select name="status" style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:8px 12px; font-size:13px; outline:none; color:#334155; background:#fff; box-sizing:border-box;">
                        <option value="">All Statuses</option>
                        <option value="success" {{ request('status')==='success'?'selected':'' }}>✅ Success</option>
                        <option value="pending" {{ request('status')==='pending'?'selected':'' }}>⏳ Pending</option>
                        <option value="failed"  {{ request('status')==='failed'?'selected':'' }}>❌ Failed</option>
                    </select>
                </div>

                {{-- Type --}}
                <div style="min-width:160px;">
                    <select name="type" style="width:100%; border:1.5px solid #e2e8f0; border-radius:8px; padding:8px 12px; font-size:13px; outline:none; color:#334155; background:#fff; box-sizing:border-box;">
                        <option value="">All Payment Types</option>
                        <option value="registration_fee" {{ request('type')==='registration_fee'?'selected':'' }}>Admission Registration</option>
                        <option value="visit_fee"        {{ request('type')==='visit_fee'?'selected':'' }}>Campus Visit Booking</option>
                    </select>
                </div>

                <button type="submit" style="background:#0f2d59; color:#fff; border:none; border-radius:8px; padding:9px 18px; font-size:13px; font-weight:700; cursor:pointer;">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>

                @if(request()->hasAny(['search','status','type']))
                <a href="{{ route('admin.payments') }}" style="font-size:12.5px; color:#ef4444; font-weight:700; text-decoration:none; margin-left:4px;">
                    <i class="fas fa-times me-1"></i> Clear
                </a>
                @endif

            </div>
        </form>
    </div>
</div>

{{-- ── 3. PAYMENTS TABLE ── --}}
<div class="panel">
    <div class="panel-header">
        <div class="panel-title">
            <i class="fas fa-receipt" style="color:#0f2d59;"></i>
            Transaction Ledger ({{ $payments->total() }})
        </div>
        <span style="font-size:11.5px; color:#64748b;">
            @if($payments->total() > 0)
                Showing {{ $payments->firstItem() }}–{{ $payments->lastItem() }} of {{ $payments->total() }}
            @endif
        </span>
    </div>

    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width:40px;">#</th>
                    <th>User / Payer</th>
                    <th>School Destination</th>
                    <th>Student / Purpose</th>
                    <th>Amount (₹)</th>
                    <th>Gateway Payment ID</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th style="text-align:right;">Date & Time</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $i => $payment)
                <tr>
                    <td style="color:#94a3b8; font-size:12px;">{{ $payments->firstItem() + $i }}</td>
                    
                    {{-- User --}}
                    <td>
                        <div style="font-weight:700; color:#0f172a; font-size:13px;">{{ $payment->user->name ?? 'Guest Parent' }}</div>
                        <div style="font-size:11px; color:#64748b;">{{ $payment->user->email ?? '—' }}</div>
                    </td>

                    {{-- School --}}
                    <td>
                        @if($payment->school)
                            <a href="{{ route('school.show', $payment->school->slug) }}" target="_blank" style="font-weight:700; color:#2563eb; text-decoration:none; font-size:12.5px;">
                                {{ $payment->school->name }}
                            </a>
                            <div style="font-size:10.5px; color:#94a3b8;">{{ $payment->school->city ?? 'Patna' }}</div>
                        @else
                            <span style="color:#94a3b8;">—</span>
                        @endif
                    </td>

                    {{-- Student --}}
                    <td>
                        @if($payment->admission)
                            <span style="font-weight:700; color:#334155; font-size:12.5px;">{{ $payment->admission->student_name }}</span>
                            <div style="font-size:10.5px; color:#64748b;">{{ $payment->admission->class_applying }}</div>
                        @else
                            <span style="font-size:12px; color:#64748b;">Campus Visit / Form Fee</span>
                        @endif
                    </td>

                    {{-- Amount --}}
                    <td>
                        <span style="font-size:13.5px; font-weight:900; color:#0f172a;">
                            ₹{{ number_format($payment->amount, 2) }}
                        </span>
                    </td>

                    {{-- Transaction ID --}}
                    <td>
                        <code style="font-size:11px; color:#475569; background:#f1f5f9; padding:2px 7px; border-radius:4px;">
                            {{ $payment->razorpay_payment_id ?? ($payment->razorpay_order_id ?? 'TXN-'.$payment->id) }}
                        </code>
                    </td>

                    {{-- Type --}}
                    <td>
                        <span style="font-size:10.5px; font-weight:700; padding:2px 7px; border-radius:4px; background:#eff6ff; color:#2563eb; border:1px solid #bfdbfe;">
                            {{ $payment->type === 'registration_fee' ? 'Admission Token' : 'Campus Visit' }}
                        </span>
                    </td>

                    {{-- Status --}}
                    <td>
                        @if($payment->status === 'success')
                            <span style="display:inline-block; font-size:11px; font-weight:800; background:#ecfdf5; color:#059669; border:1px solid #a7f3d0; padding:3px 10px; border-radius:999px;">
                                ● Success
                            </span>
                        @elseif($payment->status === 'pending')
                            <span style="display:inline-block; font-size:11px; font-weight:800; background:#fffbeb; color:#d97706; border:1px solid #fde68a; padding:3px 10px; border-radius:999px;">
                                ● Pending
                            </span>
                        @else
                            <span style="display:inline-block; font-size:11px; font-weight:800; background:#fef2f2; color:#dc2626; border:1px solid #fecaca; padding:3px 10px; border-radius:999px;">
                                ● Failed
                            </span>
                        @endif
                    </td>

                    {{-- Date --}}
                    <td style="text-align:right; white-space:nowrap;">
                        <div style="font-size:12px; font-weight:700; color:#0f172a;">{{ $payment->created_at->diffForHumans() }}</div>
                        <div style="font-size:10px; color:#94a3b8;">{{ $payment->created_at->format('d M Y, h:i A') }}</div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="text-align:center; padding:50px 20px;">
                        <div style="font-size:36px; margin-bottom:8px;">💳</div>
                        <div style="font-size:14px; font-weight:700; color:#334155;">No Payment Transactions Found</div>
                        <div style="font-size:12px; color:#94a3b8; margin-top:2px;">Online payments made by parents via Razorpay will be recorded here automatically.</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($payments->hasPages())
    <div style="padding:14px 20px; border-top:1px solid #f1f5f9;">
        {{ $payments->links() }}
    </div>
    @endif
</div>

@endsection