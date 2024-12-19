<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckMemberStatus
{
    public function handle(Request $request, Closure $next)
    {
        // Periksa apakah pengguna sedang login
        if (Auth::check()) {
            $user = Auth::user();

            // Cari member terkait user
            $member = $user->member; // Pastikan relasi member ada di model User

            // Jika member ada dan statusnya 'Inactive', logout dan tampilkan pesan
            if ($member && $member->status === 'Inactive') {
                Auth::logout(); // Logout pengguna

                // Redirect ke halaman login dengan pesan error
                return redirect()->route('login')->withErrors([
                    'status' => 'Akun Anda tidak aktif.',
                ]);
            }
        }

        return $next($request);
    }
}
