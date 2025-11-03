<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt login with remember me option
        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            $admin = Auth::guard('admin')->user();

            // Check if email is verified
            if (!$admin->hasVerifiedEmail()) {
                Auth::guard('admin')->logout();

                // Send verification email automatically
                try {
                    $admin->sendEmailVerificationNotification();
                    \Log::info('Verification email sent to: ' . $admin->email);
                } catch (\Exception $e) {
                    \Log::error('Failed to send verification email: ' . $e->getMessage());
                }

                // Store email in session for verification page
                session(['admin_email' => $request->email]);

                return back()
                    ->withInput($request->only('email', 'remember'))
                    ->withErrors([
                        'email' => 'Your email address is not verified. We have sent you a verification link. Please check your email.',
                    ])
                    ->with('show_resend', true);
            }

            $request->session()->regenerate();

            // Update last login
            $admin->update(['last_login_at' => now()]);

            // Redirect to intended URL if set, otherwise to dashboard
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withInput($request->only('email', 'remember'))->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    /**
     * Display the password reset request form.
     */
    public function showForgotPasswordForm()
    {
        return view('admin.auth.forgot-password');
    }

    /**
     * Handle password reset request.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Send password reset link using the admin broker
        $status = Password::broker('admins')->sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Display the password reset form.
     */
    public function showResetPasswordForm(Request $request, string $token)
    {
        return view('admin.auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /**
     * Handle password reset.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Reset the password using the admin broker
        $status = Password::broker('admins')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($admin, $password) {
                $admin->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($admin));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('admin.login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    /**
     * Display the email verification notice.
     */
    public function showVerificationNotice()
    {
        return view('admin.auth.verify-email');
    }

    /**
     * Handle email verification.
     */
    public function verifyEmail(Request $request)
    {
        $admin = Admin::findOrFail($request->route('id'));

        if (!hash_equals((string) $request->route('hash'), sha1($admin->getEmailForVerification()))) {
            return redirect()->route('admin.login')
                ->withErrors(['email' => 'Invalid verification link.']);
        }

        if ($admin->hasVerifiedEmail()) {
            return redirect()->route('admin.login')
                ->with('status', 'Your email is already verified. You can now log in.');
        }

        $admin->markEmailAsVerified();

        return redirect()->route('admin.login')
            ->with('status', 'Your email has been verified successfully! You can now log in.');
    }

    /**
     * Resend the email verification notification.
     */
    public function resendVerificationEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins,email',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin) {
            return back()->withErrors(['email' => 'Admin not found with this email address.']);
        }

        if ($admin->hasVerifiedEmail()) {
            return back()->with('status', 'Your email is already verified. You can log in now.');
        }

        try {
            $admin->sendEmailVerificationNotification();

            // Store email in session for next time
            session(['admin_email' => $request->email]);

            return back()->with('status', 'Verification link has been sent to your email address. Please check your inbox.');
        } catch (\Exception $e) {
            \Log::error('Failed to send verification email: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Failed to send verification email. Please try again later.']);
        }
    }
}
