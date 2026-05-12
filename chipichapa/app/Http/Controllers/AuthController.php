<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ===================== REGISTER =====================
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|min:3|max:40',
            'email'        => 'required|email|unique:users,email|regex:/^[a-zA-Z0-9._%+\-]+@gmail\.com$/',
            'password'     => 'required|string|min:6|max:12|confirmed',
            'nomor_hp'     => 'required|string|regex:/^08/',
        ], [
            'email.regex'    => 'Email harus menggunakan @gmail.com.',
            'nomor_hp.regex' => 'Nomor HP harus diawali dengan 08.',
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
            'nomor_hp'     => $request->nomor_hp,
            'role'         => 'user',
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    // ===================== LOGIN =====================
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (auth()->user()->isAdmin()) {
                return redirect()->route('admin.barang.index');
            }
            return redirect()->route('user.barang.index');
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }

    // ===================== LOGOUT =====================
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
