<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // return redirect()->intended(route('dashboard', absolute: false));

        // Dapatkan user yang sedang login
        $user = $request->user();

        // Cek role dan arahkan pengguna sesuai role mereka
        if ($user->hasRole('SuperAdmin')) {
            return redirect()->intended(route('dashboard', absolute: false));
        } elseif ($user->hasRole('Jemaat')) {
            return redirect()->intended(route('portal', absolute: false));
        }

        // Jika tidak ada role yang sesuai kembali ke halaman welcome
        return redirect()->intended('/');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
