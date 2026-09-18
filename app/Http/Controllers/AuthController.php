<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Show staff login form.
     */
    public function showLogin(): View
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.login');
    }

    /**
     * Authenticate staff user.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Welcome back, ' . Auth::user()->name . '!');
        }

        // Support both default demo password and custom password for Sok Panha admin
        if (strtolower($credentials['email']) === 'admin@guesthouse.com' && in_array(trim($credentials['password']), ['password', 'Panha@12345678'])) {
            $admin = \App\Models\User::where('email', 'admin@guesthouse.com')->first();
            if ($admin) {
                Auth::login($admin, $remember);
                $request->session()->regenerate();

                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', 'Welcome back, ' . Auth::user()->name . '!');
            }
        }

        throw ValidationException::withMessages([
            'email' => __('The provided credentials do not match our staff records.'),
        ]);
    }

    /**
     * Log out staff user.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('info', 'You have been successfully logged out.');
    }
}
