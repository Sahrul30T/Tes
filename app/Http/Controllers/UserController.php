<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    

    public function login(Request $request)
    {
        // Validasi formulir login
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Lakukan proses login di sini (gunakan fungsi Auth Laravel)
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            // Jika login berhasil, redirect ke halaman pengguna
            return redirect()->route('user.home');
        }

        // Jika login gagal, redirect kembali ke halaman login dengan pesan error
        return redirect()->route('user.home')->with('error', 'Incorrect email or password.');
    }

    public function logout()
    {
        // Lakukan proses logout (gunakan fungsi Auth Laravel)
        Auth::logout();

        // Redirect ke halaman login atau halaman lain yang sesuai
        return redirect()->route('user.home');
    }

    public function register()
    {
        return view('user.register');
    }

    public function store(Request $request)
    {
        // Validasi formulir pendaftaran
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Buat pengguna baru
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Redirect ke halaman setelah pendaftaran sukses
        return redirect()->route('user.home')->with('success', 'Pendaftaran berhasil. Selamat datang!');
    }

    public function edit()
    {
        $user = Auth::user();
        return view('user.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi formulir edit data pengguna
        $request->validate([
            'name' => 'required|string|max:255',
            'no' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // Update data pengguna
        $user->update([
            'name' => $request->name,
            'no' => $request->no,
            'address' => $request->address,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        // Redirect ke halaman setelah update sukses
        return redirect()->route('user.home')->with('success', 'Data pengguna berhasil diperbarui.');
    }
}
