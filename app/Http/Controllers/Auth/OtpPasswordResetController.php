<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\PasswordResetService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class OtpPasswordResetController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }
    /**
     * Handle an incoming password reset link request and send OTP.
     */
    public function sendOtp(Request $request, PasswordResetService $service): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $service->sendResetPin($request->email);

        // Always redirect to verification to avoid email enumeration
        return redirect()->route('password.verify.notice')->with('reset_email', $request->email);
    }

    /**
     * Show the OTP verification form.
     */
    public function showVerifyForm(Request $request): View|RedirectResponse
    {
        if (!$request->session()->has('reset_email')) {
            return redirect()->route('password.request');
        }

        return view('auth.verify-code', ['email' => $request->session()->get('reset_email')])->with('reset_email', $request->session()->get('reset_email'));
    }

    /**
     * Verify the OTP provided by the user.
     */
    public function verifyOtp(Request $request, PasswordResetService $service): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'pin' => ['required', 'string', 'size:6'],
        ]);

        if ($service->validatePin($request->email, $request->pin)) {
            // Keep the email and pin in session for the next step
            $request->session()->put('verified_reset_email', $request->email);
            $request->session()->put('verified_reset_pin', $request->pin);

            return redirect()->route('password.reset.custom');
        }

        return back()->withErrors(['pin' => 'El código proporcionado es inválido o ha expirado.'])->with('reset_email', $request->email);
    }

    /**
     * Show the custom reset password form.
     */
    public function showResetForm(Request $request): View|RedirectResponse
    {
        if (!$request->session()->has('verified_reset_email')) {
            return redirect()->route('password.request');
        }

        return view('auth.reset-password-custom', [
            'email' => $request->session()->get('verified_reset_email'),
            'pin' => $request->session()->get('verified_reset_pin'),
        ]);
    }

    /**
     * Complete the password reset process.
     */
    public function resetPassword(Request $request, PasswordResetService $service): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'pin' => ['required', 'string'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $success = $service->resetPassword($request->email, $request->pin, $request->password);

        if ($success) {
            $request->session()->forget(['reset_email', 'verified_reset_email', 'verified_reset_pin']);

            return redirect()->route('login')->with('status', 'Tu contraseña ha sido restablecida exitosamente.');
        }

        return redirect()->route('password.request')->withErrors(['email' => 'El proceso de recuperación ha fallado o expirado. Intenta de nuevo.']);
    }
}
