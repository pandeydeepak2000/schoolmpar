<?php

namespace App\Http\Controllers\SchoolOwner;

use App\Http\Controllers\Controller;
use App\Models\AuthOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SchoolOwnerAuthController extends Controller
{
    // Register page
    public function showRegister()
    {
        if (Auth::check()) {
            return Auth::user()->hasRole('school_owner')
                ? redirect()->route('school-owner.dashboard')
                : redirect('/dashboard');
        }
        return view('school-owner.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'phone'    => 'required|string|max:20',
            'otp'      => 'required|string|size:6',
        ], [
            'email.unique'       => '⚠️ This email is already registered. Please sign in instead.',
            'email.email'        => '⚠️ Please enter a valid official email address.',
            'phone.required'     => '⚠️ Principal / Administrator contact number is required.',
            'password.min'       => '⚠️ Password must be at least 6 characters.',
            'password.confirmed' => '⚠️ Password confirmation does not match.',
            'otp.required'       => '⚠️ 6-digit verification code is required. Please click "Get OTP".',
            'otp.size'           => '⚠️ Verification code must be exactly 6 digits.',
        ]);

        $email = strtolower(trim($request->email));

        // Validate 10-digit mobile number
        $cleanedPhone = preg_replace('/[^0-9]/', '', $request->phone);
        if (strlen($cleanedPhone) < 10) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => '⚠️ Please enter a valid 10-digit mobile number.',
                ], 422);
            }
            return back()->withInput()->withErrors(['phone' => '⚠️ Please enter a valid 10-digit mobile number.']);
        }

        // Verify OTP
        $otpCheck = AuthOtp::checkAndVerify($email, $request->otp, 'register');
        if (!$otpCheck['valid']) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $otpCheck['message'],
                ], 422);
            }
            return back()->withInput()->withErrors(['otp' => $otpCheck['message']]);
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('school_owner');
        Auth::login($user, true);
        $request->session()->regenerate();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success'  => true,
                'message'  => 'Welcome to SchoolMapr! Your partner account is verified 🎉',
                'redirect' => route('school-owner.dashboard'),
            ]);
        }

        return redirect()->route('school-owner.dashboard')
                         ->with('success', 'Welcome! Your partner account is verified and ready. 🎉');
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login')->with('success', 'Logged out successfully.');
    }
}