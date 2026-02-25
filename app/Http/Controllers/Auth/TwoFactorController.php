<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorController extends Controller
{
    protected $google2fa;

    public function __construct()
    {
        $this->google2fa = new Google2FA();
    }

    // Show OTP verification page
    public function showVerifyForm()
    {
        return view('auth.2fa_verify');
    }

    // Verify OTP
    public function verify(Request $request)
    {
        $request->validate([
            'one_time_password' => 'required|digits:6',
        ]);

        $user = Auth::user();
        $valid = $this->google2fa->verifyKey($user->google2fa_secret, $request->one_time_password);

        if ($valid) {
            $request->session()->put('2fa_passed', true);
            return redirect()->intended('dashboard');
        }

        return back()->withErrors(['one_time_password' => 'Invalid one-time password']);
    }

    // Show 2FA setup page in profile
    public function showSetupForm()
    {
        $user = Auth::user();
        $secret = $user->google2fa_secret ?? $this->google2fa->generateSecretKey();
        $qrCodeUrl = $this->google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $secret
        );

        return view('auth.2fa_setup', compact('secret', 'qrCodeUrl'));
    }

    // Enable 2FA
    public function enable(Request $request)
    {
        $request->validate([
            'one_time_password' => 'required|digits:6',
            'secret' => 'required|string',
        ]);

        $user = Auth::user();
        $valid = $this->google2fa->verifyKey($request->secret, $request->one_time_password);

        if ($valid) {
            $user->update([
                'google2fa_secret' => $request->secret,
                'two_factor_enabled' => true,
            ]);

            return redirect()->back()->with('success', 'Two-factor authentication enabled successfully.');
        }

        return back()->withErrors(['one_time_password' => 'Invalid OTP.']);
    }

    // Disable 2FA
    public function disable(Request $request)
    {
        $user = Auth::user();
        $user->update([
            'google2fa_secret' => null,
            'two_factor_enabled' => false,
        ]);

        return redirect()->back()->with('success', 'Two-factor authentication disabled.');
    }
}
