@extends('school-owner.layout')
@section('title', 'Campus Fee Ledger & Settlements – SchoolMapr Partner')

@section('content')
<div style="max-width:1100px;">

    {{-- Header --}}
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:12px;">
        <div>
            <h2 style="font-size:22px; font-weight:800; color:#0f2d59; margin:0;">Fee Collections & Token Settlements</h2>
            <p style="font-size:13px; color:#64748b; margin:4px 0 0;">
                Online registration tokens and admission fees paid directly by parents for your campus
            </p>
        </div>
        <div style="background:#ecfdf5; border:1px solid #a7f3d0; border-radius:10px; padding:10px 18px; text-align:right;">
            <div style="font-size:11px; font-weight:800; color:#059669; text-transform:uppercase; letter-spacing:0.5px;">Verified Collections</div>
            <div style="font-size:22px; font-weight:900; color:#065f46;">₹{{ number_format($totalRevenue, 2) }}</div>
        </div>
    </div>

    {{-- Transactions Panel --}}
    <div style="background:#fff; border:1.5px solid #e8ecf4; border-radius:14px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.02);">
        <div style="padding:16px 20px; border-bottom:1px solid #f1f5f9; display:flex; justify-content:space-between; align-items:center;">
            <strong style="font-size:14px; color:#0f2d59;">Transaction Records ({{ $payments->total() }})</strong>
            <span style="font-size:12px; color:#64748b;">Direct Razorpay Settlements</span>
        </div>

        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse; text-align:left;">
                <thead>
                    <tr style="background:#f8fafc; border-bottom:1.5px solid #eef2f6;">
                        <th style="padding:12px 16px; font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase;">#</th>
                        <th style="padding:12px 16px; font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase;">Student / Purpose</th>
                        <th style="padding:12px 16px; font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase;">Parent Details</th>
                        <th style="padding:12px 16px; font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase;">Campus</th>
                        <th style="padding:12px 16px; font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase;">Amount (₹)</th>
                        <th style="padding:12px 16px; font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase;">Payment ID</th>
                        <th style="padding:12px 16px; font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase;">Status</th>
                        <th style="padding:12px 16px; font-size:11px; font-weight:800; color:#64748b; text-transform:uppercase; text-align:right;">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $i => $p)
                    <tr style="border-bottom:1px solid #f1f5f9;">
                        <td style="padding:13px 16px; font-size:12px; color:#94a3b8;">{{ $payments->firstItem() + $i }}</td>
                        <td style="padding:13px 16px;">
                            @if($p->admission)
                                <strong style="color:#0f2d59; font-size:13px;">{{ $p->admission->student_name }}</strong>
                                <span style="display:inline-block; font-size:10.5px; background:#eff6ff; color:#2563eb; padding:2px 6px; border-radius:4px; font-weight:700; margin-left:4px;">
                                    {{ $p->admission->class_applying }}
                                </span>
                            @else
                                <span style="font-size:12.5px; color:#334155;">Campus Registration</span>
                            @endif
                        </td>
                        <td style="padding:13px 16px;">
                            <div style="font-weight:700; color:#1e293b; font-size:13px;">{{ $p->user->name ?? 'Parent' }}</div>
                            <div style="font-size:11px; color:#64748b;">{{ $p->user->email ?? '—' }}</div>
                        </td>
                        <td style="padding:13px 16px; font-size:12.5px; color:#334155;">
                            {{ $p->school->name ?? '—' }}
                        </td>
                        <td style="padding:13px 16px;">
                            <strong style="font-size:14px; color:#0f2d59;">₹{{ number_format($p->amount, 2) }}</strong>
                        </td>
                        <td style="padding:13px 16px;">
                            <code style="font-size:11px; background:#f1f5f9; padding:2px 6px; border-radius:4px; color:#475569;">
                                {{ $p->razorpay_payment_id ?? ($p->razorpay_order_id ?? 'TXN-'.$p->id) }}
                            </code>
                        </td>
                        <td style="padding:13px 16px;">
                            @if($p->status === 'success')
                                <span style="font-size:11px; font-weight:800; background:#ecfdf5; color:#059669; border:1px solid #a7f3d0; padding:3px 9px; border-radius:999px;">
                                    ● Paid
                                </span>
                            @elseif($p->status === 'pending')
                                <span style="font-size:11px; font-weight:800; background:#fffbeb; color:#d97706; border:1px solid #fde68a; padding:3px 9px; border-radius:999px;">
                                    ● Pending
                                </span>
                            @else
                                <span style="font-size:11px; font-weight:800; background:#fef2f2; color:#dc2626; border:1px solid #fecaca; padding:3px 9px; border-radius:999px;">
                                    ● Failed
                                </span>
                            @endif
                        </td>
                        <td style="padding:13px 16px; text-align:right; font-size:12px; color:#64748b;">
                            {{ $p->created_at->format('d M Y, h:i A') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align:center; padding:50px 20px;">
                            <div style="font-size:32px; margin-bottom:8px;">💳</div>
                            <div style="font-size:14px; font-weight:700; color:#334155;">No Payment Collections Recorded Yet</div>
                            <div style="font-size:12px; color:#94a3b8; margin-top:2px;">Online parent payments for registration tokens will appear in this ledger.</div>
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

</div>
@endsection
