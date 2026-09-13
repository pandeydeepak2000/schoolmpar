<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class PaymentSettingsController extends Controller
{
    public function index()
    {
        $mode       = SystemSetting::get('razorpay_mode', config('services.razorpay.mode', 'test'));
        $keyId      = SystemSetting::get('razorpay_key', config('services.razorpay.key', ''));
        $keySecret  = SystemSetting::get('razorpay_secret', config('services.razorpay.secret', ''));
        $currency   = SystemSetting::get('payment_currency', 'INR');

        return view('admin.payment-settings', compact('mode', 'keyId', 'keySecret', 'currency'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'razorpay_mode'   => 'required|in:test,live',
            'razorpay_key'    => 'required|string|max:255',
            'razorpay_secret' => 'required|string|max:255',
        ]);

        SystemSetting::set('razorpay_mode', $request->razorpay_mode);
        SystemSetting::set('razorpay_key', trim($request->razorpay_key));
        SystemSetting::set('razorpay_secret', trim($request->razorpay_secret));
        SystemSetting::set('payment_currency', $request->payment_currency ?? 'INR');

        return back()->with('success', '✅ Razorpay Gateway settings updated successfully! Platform is now operating in ' . strtoupper($request->razorpay_mode) . ' mode.');
    }
}
