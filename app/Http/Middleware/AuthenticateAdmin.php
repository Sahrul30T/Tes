<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class AuthenticateAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Mengecek apakah pengguna saat ini terotentikasi di guard 'admin'
        if (Auth::guard('admin')->check()) {
            // Jika pengguna terotentikasi, melanjutkan permintaan ke tujuan berikutnya
            return $next($request);
        }
        
        // Jika pengguna tidak terotentikasi, mengarahkan mereka ke halaman login admin
        return redirect('/admin/login');
    }
}
