<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\AuthOtpMail;
use App\Mail\WelcomeParentMail;
use App\Models\AuthOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function registerForm()
    {
        if (Auth::check()) {
            return $this->authenticatedRedirect(Auth::user());
        }
        return view('auth.register');
    }

    /**
     * Send OTP to Email or WhatsApp for account creation or verification
     */
    public function sendOtp(Request $request)
    {
        $channel = $request->input('channel', 'email'); // 'email' or 'whatsapp'
        $type    = $request->input('type', 'register');
        $name    = $request->input('name', 'User');

        if ($channel === 'whatsapp') {
            $request->validate([
                'phone' => 'required|string|min:10|max:20',
            ], [
                'phone.required' => '⚠️ Please enter your 10-digit WhatsApp mobile number.',
                'phone.min'      => '⚠️ Please enter a valid 10-digit mobile number.',
            ]);

            $cleanPhone = preg_replace('/[^0-9]/', '', $request->phone);
            if (strlen($cleanPhone) < 10) {
                return response()->json([
                    'success' => false,
                    'message' => '⚠️ Please enter a valid 10-digit mobile number.',
                ], 422);
            }

            // Check if phone number is already registered if registering
            if ($type === 'register' && User::where('phone', $cleanPhone)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => '⚠️ This mobile number is already registered. Please sign in instead.',
                ], 422);
            }

            // Generate 6-digit OTP for phone
            $otp = AuthOtp::generate($cleanPhone, $type, 'whatsapp', 10);

            // Send via Vextro WhatsApp API
            \App\Services\VextroWhatsAppService::sendOtp($cleanPhone, $otp, 'Registration');

            return response()->json([
                'success'  => true,
                'channel'  => 'whatsapp',
                'message'  => "✅ 6-digit OTP sent to WhatsApp number (+91 {$cleanPhone})! Please check your WhatsApp messages.",
                'demo_otp' => config('app.debug') ? $otp : null,
            ]);
        }

        // Default: Email channel
        $request->validate([
            'email' => 'required|email|max:255',
        ], [
            'email.required' => '⚠️ Please enter your email address.',
            'email.email'    => '⚠️ Please enter a valid email address (e.g. yourname@gmail.com).',
        ]);

        $email = strtolower(trim($request->email));

        // If registration, ensure email is not already registered
        if ($type === 'register' && User::where('email', $email)->exists()) {
            return response()->json([
                'success' => false,
                'message' => '⚠️ This email is already registered. Please sign in to your existing account.',
            ], 422);
        }

        // Generate 6-digit OTP for email
        $otp = AuthOtp::generate($email, $type, 'email', 10);

        try {
            \App\Services\DynamicMailConfig::apply();

            Mail::to($email)->send(new AuthOtpMail(
                otp: $otp,
                email: $email,
                name: $name,
                purpose: ($type === 'register' ? 'Account Registration' : 'Verification')
            ));

            return response()->json([
                'success' => true,
                'channel' => 'email',
                'message' => "✅ 6-digit OTP sent to {$email}! Please check your Gmail/Inbox (and spam folder).",
            ]);
        } catch (\Throwable $e) {
            Log::error('OTP email failed to send: ' . $e->getMessage());

            return response()->json([
                'success'  => true,
                'channel'  => 'email',
                'message'  => "✅ Verification code generated for {$email}!",
                'demo_otp' => config('app.debug') ? $otp : null,
            ]);
        }
    }

    /**
     * Complete Registration with Email or WhatsApp OTP verification
     */
    public function register(Request $request)
    {
        $verifyChannel = $request->input('verify_channel', 'email'); // 'email' or 'whatsapp'

        $rules = [
            'name'                 => 'required|string|max:255',
            'email'                => 'required|email|max:255|unique:users,email',
            'password'             => 'required|min:6|confirmed',
            'otp'                  => 'required|string|size:6',
            'role'                 => 'nullable|in:parent,school_owner',
            'g-recaptcha-response' => [new \App\Rules\RecaptchaRule],
        ];

        if ($verifyChannel === 'whatsapp') {
            $rules['phone'] = 'required|string|min:10|max:20';
        } else {
            $rules['phone'] = 'nullable|string|max:20';
        }

        $request->validate($rules, [
            'name.required'      => '⚠️ Please enter your full name.',
            'email.required'     => '⚠️ Email address is required.',
            'email.unique'       => '⚠️ This email address is already registered. Please sign in instead.',
            'email.email'        => '⚠️ Please enter a valid email address.',
            'phone.required'     => '⚠️ WhatsApp mobile number is required for WhatsApp verification.',
            'password.min'       => '⚠️ Password must be at least 6 characters long.',
            'password.confirmed' => '⚠️ Password confirmation does not match.',
            'otp.required'       => '⚠️ 6-digit verification code is required. Please click "Get OTP".',
            'otp.size'           => '⚠️ Verification code must be exactly 6 digits.',
        ]);

        $email = strtolower(trim($request->email));
        $phone = $request->filled('phone') ? preg_replace('/[^0-9]/', '', $request->phone) : null;

        // Determine verification identifier based on selected channel
        $identifier = ($verifyChannel === 'whatsapp') ? $phone : $email;

        // Verify OTP
        $otpCheck = AuthOtp::checkAndVerify($identifier, $request->otp, 'register');
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
            'name'              => $request->name,
            'email'             => $email,
            'phone'             => $phone,
            'email_verified_at' => now(),
            'password'          => Hash::make($request->password),
        ]);

        $role = ($request->role === 'school_owner') ? 'school_owner' : 'parent';
        $user->assignRole($role);

        // Send Welcome Mail if mail available
        try {
            Mail::to($user->email)->send(new WelcomeParentMail($user));
        } catch (\Throwable $e) {
            Log::warning('Welcome email could not be sent: ' . $e->getMessage());
        }

        Auth::login($user, true);
        if ($request->hasSession()) {
            $request->session()->regenerate();
        }

        $redirectUrl = ($role === 'school_owner')
            ? route('school-owner.dashboard')
            : route('parent.dashboard');

        $welcomeMsg = ($role === 'school_owner')
            ? 'Welcome to SchoolMapr! List your school to connect with parents 🏫'
            : 'Welcome to SchoolMapr! Your account is verified and ready 🎉';

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success'  => true,
                'message'  => $welcomeMsg,
                'redirect' => $redirectUrl,
            ]);
        }

        return redirect($redirectUrl)->with('success', $welcomeMsg);
    }

    public function loginForm()
    {
        if (Auth::check()) {
            return $this->authenticatedRedirect(Auth::user());
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'                => 'required|email',
            'password'             => 'required',
            'g-recaptcha-response' => [new \App\Rules\RecaptchaRule],
        ]);

        if (!Auth::attempt(
            ['email' => $request->email, 'password' => $request->password],
            $request->boolean('remember', true)
        )) {
            return back()
                ->withErrors(['email' => 'Invalid email or password. Please check your credentials.'])
                ->withInput();
        }

        $request->session()->regenerate();
        $user = Auth::user();

        return $this->authenticatedRedirect($user);
    }

    public function redirectToGoogle(Request $request)
    {
        $role = $request->query('role', 'parent');
        session(['oauth_intended_role' => in_array($role, ['parent', 'school_owner']) ? $role : 'parent']);

        $clientId     = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');

        if (!empty($clientId) && !empty($clientSecret)) {
            try {
                return Socialite::driver('google')->redirect();
            } catch (\Throwable $e) {
                Log::error('Google OAuth redirect error: ' . $e->getMessage());
                return redirect()->route('login')->with('error', 'Google Sign-In connection error: ' . $e->getMessage());
            }
        }

        return redirect()->route('login')->with('error', '⚠️ Google Sign-In is not configured yet. Please sign in with your Email & Password or Register a new account.');
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $email = strtolower(trim($googleUser->getEmail() ?? ''));

            if (empty($email)) {
                return redirect()->route('login')->with('error', '⚠️ Could not retrieve a verified email address from your Google account.');
            }

            $intendedRole = session()->pull('oauth_intended_role', 'parent');
            
            $user = User::where('google_id', $googleUser->getId())
                        ->orWhere('email', $email)
                        ->first();

            $isNew = false;
            if (!$user) {
                $isNew = true;
                $user = User::create([
                    'name'              => $googleUser->getName() ?: 'Google User',
                    'email'             => $email,
                    'google_id'         => $googleUser->getId(),
                    'avatar'            => $googleUser->getAvatar(),
                    'email_verified_at' => now(),
                    'password'          => Hash::make(Str::random(32)),
                ]);
                $user->assignRole(in_array($intendedRole, ['parent', 'school_owner']) ? $intendedRole : 'parent');
            } else {
                $user->update([
                    'google_id'         => $googleUser->getId(),
                    'avatar'            => $googleUser->getAvatar() ?? $user->avatar,
                    'email_verified_at' => $user->email_verified_at ?? now(),
                ]);
            }

            if ($isNew) {
                try {
                    Mail::to($user->email)->send(new WelcomeParentMail($user));
                } catch (\Throwable $e) {
                    Log::warning('Welcome email could not be sent: ' . $e->getMessage());
                }
            }

            Auth::login($user, true);
            request()->session()->regenerate();

            return $this->authenticatedRedirect($user);
        } catch (\Throwable $e) {
            Log::error('Google callback error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', '⚠️ Google sign-in was cancelled or failed: ' . $e->getMessage());
        }
    }

    private function authenticatedRedirect($user)
    {
        if ($user->hasRole('super-admin') || $user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->hasRole('school_owner')) {
            return redirect()->route('school-owner.dashboard');
        }

        return redirect()->route('parent.dashboard')
                         ->with('success', 'Welcome back to SchoolMapr! 👋');
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login')->with('success', 'You have been logged out successfully.');
    }
}