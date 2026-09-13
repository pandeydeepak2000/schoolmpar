<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\Payment;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

class PaymentController extends Controller
{
    // ─────────────────────────────────────────────
    // 💳 Payment Checkout Page
    // ─────────────────────────────────────────────
    public function create(Request $request)
    {
        $request->validate([
            'admission_id' => 'required|integer|exists:admissions,id',
        ]);

        // 🔒 Sirf apni admission — dusre ki nahi
        $admission = Admission::with('school')
            ->where('id', $request->admission_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $school = $admission->school;
        $amount = $school->admission_fee;

        // Fee nahi → redirect
        if (!$amount || $amount <= 0) {
            return redirect()->route('admission.status', $admission->id)
                ->with('info', 'Is school me koi admission fee nahi hai.');
        }

        // Already paid check
        if ($admission->payment_id) {
            return redirect()->route('admission.status', $admission->id)
                ->with('info', 'Payment already completed hai.');
        }

        // Already pending payment exist karta hai?
        $existingPayment = Payment::where('user_id', auth()->id())
            ->where('school_id', $school->id)
            ->where('status', 'pending')
            ->whereHas('admission', fn($q) => $q->where('id', $admission->id))
            ->latest()
            ->first();

        if ($existingPayment) {
            // Purana order reuse karo
            $api   = $this->getRazorpayApi();
            $order = $api->order->fetch($existingPayment->razorpay_order_id);
            $payment = $existingPayment;
        } else {
            // Naya Razorpay Order banao
            $api = $this->getRazorpayApi();

            $order = $api->order->create([
                'receipt'  => 'adm_' . $admission->id . '_' . time(),
                'amount'   => (int) ($amount * 100), // paise
                'currency' => 'INR',
                'notes'    => [
                    'admission_id' => $admission->id,
                    'school_id'    => $school->id,
                    'user_id'      => auth()->id(),
                ],
            ]);

            // Pending payment save karo
           $payment = Payment::create([
    'user_id'           => auth()->id(),
    'school_id'         => $school->id,
    'razorpay_order_id' => $order->id,
    'amount'            => (int) ($amount * 100), // ✅ SAHI — paise store karo
    'type'              => 'registration_fee',
    'status'            => 'pending',
]);
        }

        return view('payment.checkout', compact(
            'admission', 'school', 'payment', 'order', 'amount'
        ));
    }

    // ─────────────────────────────────────────────
    // ✅ Verify Payment — Razorpay Callback
    // ─────────────────────────────────────────────
    public function verify(Request $request)
    {
        $request->validate([
            'razorpay_order_id'   => 'required|string|max:255',
            'razorpay_payment_id' => 'required|string|max:255',
            'razorpay_signature'  => 'required|string|max:500',
            'admission_id'        => 'required|integer|exists:admissions,id',
        ]);

        // 🔒 Admission must belong to logged in user
        $admission = Admission::where('id', $request->admission_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // 🔒 Payment must belong to logged in user
        $payment = Payment::where('razorpay_order_id', $request->razorpay_order_id)
            ->where('user_id', auth()->id()) // 🔒 security
            ->where('status', 'pending')
            ->firstOrFail();

        // Already verified check
        if ($admission->payment_id) {
            return redirect()
                ->route('admission.status', $admission->id)
                ->with('info', 'Payment already verified hai.');
        }

        try {
            $api = $this->getRazorpayApi();

            // 🔒 Signature verify — tamper-proof
            $api->utility->verifyPaymentSignature([
                'razorpay_order_id'   => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature'  => $request->razorpay_signature,
            ]);

            // ✅ Payment success
            $payment->update([
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature'  => $request->razorpay_signature,
                'status'              => 'success',
            ]);

            // ✅ Admission update
            $admission->update([
                'payment_id' => $payment->id,
                'status'     => 'reviewing',
            ]);

            Log::info('Payment verified', [
                'user_id'      => auth()->id(),
                'admission_id' => $admission->id,
                'payment_id'   => $payment->id,
                'rzp_pay_id'   => $request->razorpay_payment_id,
            ]);

            return redirect()
                ->route('admission.status', $admission->id)
                ->with('success', '🎉 Payment successful! Application submitted for review.');

        } catch (SignatureVerificationError $e) {
            // 🔴 Signature mismatch — tampered request
            Log::warning('Razorpay signature mismatch', [
                'user_id'      => auth()->id(),
                'order_id'     => $request->razorpay_order_id,
                'admission_id' => $request->admission_id,
                'error'        => $e->getMessage(),
            ]);

            $payment->update(['status' => 'failed']);

            return redirect()
                ->route('payment.failed')
                ->with('error', 'Payment verification failed. Signature mismatch. Koi amount deduct nahi hua.');

        } catch (\Exception $e) {
            // 🔴 Generic error
            Log::error('Razorpay verify error', [
                'user_id' => auth()->id(),
                'error'   => $e->getMessage(),
            ]);

            $payment->update(['status' => 'failed']);

            return redirect()
                ->route('payment.failed')
                ->with('error', 'Payment process me error aaya. Please contact support.');
        }
    }

    // ─────────────────────────────────────────────
    // ❌ Payment Failed Page
    // ─────────────────────────────────────────────
    public function failed()
    {
        return view('payment.failed');
    }

    // ─────────────────────────────────────────────
    // 🔒 Private — Razorpay API instance
    // ─────────────────────────────────────────────
    private function getRazorpayApi(): Api
    {
        $key    = \App\Models\SystemSetting::get('razorpay_key', config('services.razorpay.key', 'rzp_test_sample'));
        $secret = \App\Models\SystemSetting::get('razorpay_secret', config('services.razorpay.secret', 'sample_secret'));

        return new Api($key, $secret);
    }
}