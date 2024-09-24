<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAuthorized
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $role = Auth::user()->role;

            // Arahkan ke dashboard berdasarkan peran pengguna
            switch ($role) {
                case 'admin':
                    return redirect('/admin/dashboard');
                case 'owner':
                    return redirect('/owner/dashboard');
                case 'karyawan':
                    return redirect('/karyawan/dashboard');
                default:
                    return redirect('/');
            }
        }

        return $next($request);
    }
}
