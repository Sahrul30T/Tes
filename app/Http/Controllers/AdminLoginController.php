<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            // Jika autentikasi berhasil, redirect ke dashboard admin
            return redirect()->intended('/admin/dashboard');
        }

        // Jika autentikasi gagal, kembali ke halaman login dengan pesan error
        return redirect()->route('admin.login')->with('error', 'Login failed. Please check your credentials.');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }
}
