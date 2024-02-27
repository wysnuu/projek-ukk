<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\RouteRegistrar;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
{
    // Jika pengguna sudah login
    if (Auth::check()) {
        $user = Auth::user();
        
        // Jika level pengguna adalah Admin, arahkan ke dashboard admin
        if ($user->level === 'Admin') {
            return redirect('/admin/dashboard');
        }
        
        // Jika level pengguna adalah Kasir, arahkan ke halaman transaksi kasir
        if ($user->level === 'Kasir') {
            return redirect('/kasir/transaksi');
        }
    }

    return $next($request);
}
}
