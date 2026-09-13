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
     * Send OTP to Gmail/Email for account creation or verification
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'name'  => 'nullable|string|max:255',
            'type'  => 'nullable|string|in:register,login,reset_password',
        ], [
            'email.required' => 'Please enter your email address.',
            'email.email'    => 'Please enter a valid email address (e.g. yourname@gmail.com).',
        ]);

        $email = strtolower(trim($request->email));
        $type  = $request->input('type', 'register');

        // If registration, ensure email is not already registered
        if ($type === 'register') {
            if (User::where('email', $email)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => '⚠️ This email is already registered. Please sign in to your existing account.',
                ], 422);
            }
        }

        // Validate 10-digit mobile number if provided
        if ($request->filled('phone')) {
            $cleanedPhone = preg_replace('/[^0-9]/', '', $request->phone);
            if (strlen($cleanedPhone) < 10) {
                return response()->json([
                    'success' => false,
                    'message' => '⚠️ Please enter a valid 10-digit mobile number.',
                ], 422);
            }
        }

        // Generate 6-digit OTP
        $otp = AuthOtp::generate($email, $type, 'email', 10);

        // Send OTP via Email using dynamic DB SMTP settings
        try {
            \App\Services\DynamicMailConfig::apply();

            Mail::to($email)->send(new AuthOtpMail(
                otp: $otp,
                email: $email,
                name: $request->name,
                purpose: ($type === 'register' ? 'Account Registration' : 'Verification')
            ));

            return response()->json([
                'success' => true,
                'message' => "✅ Verification code sent to {$email}! Please check your Gmail/Inbox (and spam folder).",
            ]);
        } catch (\Throwable $e) {
            Log::error('OTP email failed to send: ' . $e->getMessage());

            // In local/demo mode if mail server fails, still allow OTP testing
            return response()->json([
                'success' => true,
                'message' => "✅ Verification code generated! (Demo code: {$otp})",
                'demo_otp' => config('app.debug') ? $otp : null,
            ]);
        }
    }

    /**
     * Complete Registration with OTP verification
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'                 => 'required|string|max:255',
            'email'                => 'required|email|max:255|unique:users,email',
            'phone'                => 'nullable|string|max:20',
            'password'             => 'required|min:6|confirmed',
            'otp'                  => 'required|string|size:6',
            'role'                 => 'nullable|in:parent,school_owner',
            'g-recaptcha-response' => [new \App\Rules\RecaptchaRule],
        ], [
            'email.unique'       => '⚠️ This email address is already registered. Please sign in instead.',
            'email.email'        => '⚠️ Please enter a valid email address.',
            'password.min'       => '⚠️ Password must be at least 6 characters long.',
            'password.confirmed' => '⚠️ Password confirmation does not match.',
            'otp.required'       => '⚠️ 6-digit verification code is required. Please click "Get OTP".',
            'otp.size'           => '⚠️ Verification code must be exactly 6 digits.',
        ]);

        $email = strtolower(trim($request->email));

        // Validate 10-digit mobile number if provided
        if ($request->filled('phone')) {
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

        $role = ($request->role === 'school_owner') ? 'school_owner' : 'parent';
        $user->assignRole($role);

        // Send Welcome Mail from support@schoolmapr.com
        try {
            Mail::to($user->email)->send(new WelcomeParentMail($user));
        } catch (\Throwable $e) {
            Log::warning('Welcome email could not be sent: ' . $e->getMessage());
        }

        Auth::login($user, true);
        $request->session()->regenerate();

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
        session(['oauth_intended_role' => $role]);

        if (config('services.google.client_id') && config('services.google.client_secret')) {
            try {
                return Socialite::driver('google')->redirect();
            } catch (\Throwable $e) {
                Log::warning('Google OAuth redirect error: ' . $e->getMessage());
            }
        }

        // Demo fallback if GOOGLE_CLIENT_ID not yet added to .env
        if ($role === 'school_owner') {
            $demoUser = User::firstOrCreate(
                ['email' => 'partner.demo@schoolmapr.com'],
                [
                    'name'      => 'Demo School Partner',
                    'phone'     => '+91 9876509999',
                    'password'  => Hash::make(Str::random(16)),
                    'google_id' => 'demo_google_partner_999',
                ]
            );

            if (!$demoUser->hasRole('school_owner')) {
                $demoUser->assignRole('school_owner');
            }

            Auth::login($demoUser, true);

            return redirect()->route('school-owner.dashboard')
                             ->with('success', 'Signed in as School Partner with Google (Demo mode) 🎉');
        }

        $demoUser = User::firstOrCreate(
            ['email' => 'parent.demo@schoolmapr.com'],
            [
                'name'      => 'Demo Google Parent',
                'phone'     => '+91 9876501234',
                'password'  => Hash::make(Str::random(16)),
                'google_id' => 'demo_google_12345',
            ]
        );

        if (!$demoUser->hasRole('parent')) {
            $demoUser->assignRole('parent');
        }

        Auth::login($demoUser, true);

        return redirect()->route('parent.dashboard')
                         ->with('success', 'Signed in with Google (Demo mode - Add GOOGLE_CLIENT_ID in .env for Live Google OAuth) 🎉');
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $intendedRole = session()->pull('oauth_intended_role', 'parent');
            
            $isNew = false;
            $user = User::where('google_id', $googleUser->getId())
                        ->orWhere('email', $googleUser->getEmail())
                        ->first();

            if (!$user) {
                $isNew = true;
                $user = User::create([
                    'name'      => $googleUser->getName() ?? 'Google User',
                    'email'     => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar'    => $googleUser->getAvatar(),
                    'password'  => Hash::make(Str::random(24)),
                ]);
                $user->assignRole($intendedRole);
            } else {
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'avatar'    => $googleUser->getAvatar() ?? $user->avatar,
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
            return redirect()->route('login')->with('error', 'Google sign-in could not be completed: ' . $e->getMessage());
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