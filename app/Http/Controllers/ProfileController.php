<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function showParentProfile()
    {
        $user = Auth::user();
        return view('parent.profile', compact('user'));
    }

    public function showSchoolOwnerProfile()
    {
        $user = Auth::user();
        return view('school-owner.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update([
            'name'  => $request->name,
            'phone' => $request->phone,
        ]);

        return back()->with('success', 'Profile information updated successfully! ✅');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'password'         => ['required', 'confirmed', 'min:6'],
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Your current password does not match our records.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Security password changed successfully! 🔒');
    }

    public function toggleTwoFactor(Request $request)
    {
        $user = Auth::user();
        $enabled = $request->boolean('two_factor_enabled');

        $user->update([
            'two_factor_enabled' => $enabled,
            'two_factor_code'    => null,
            'two_factor_expires_at' => null,
        ]);

        $msg = $enabled 
            ? 'Two-Factor Authentication (2FA) is now enabled for your account! 🛡️'
            : 'Two-Factor Authentication has been disabled.';

        return back()->with('success', $msg);
    }
}
