<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use App\Models\PengurusLingkungan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    // Controller login masyarakat
    public function showLoginFormMasyarakat()
    {
        return view('Login.loginmasyarakat');
    }

    public function loginMasyarakat(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $warga = Warga::where('email', $credentials['email'])->first();

        if ($warga && Hash::check($credentials['password'], $warga->password)) {
            // Store warga data in session
            session(['warga' => $warga]);
            
            return redirect()->route('homepage')->with('success', 'Login berhasil!');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function logoutMasyarakat()
    {
        session()->forget('warga');
        return redirect()->route('login-masyarakat')->with('success', 'Anda telah berhasil logout.');
    }


    // Controller login pengurus desa
    public function showLoginFormKepdes()
    {
        return view('Login.loginpengurus');
    }

    public function loginPengurus(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $pengurusLingkungan = PengurusLingkungan::where('username', $credentials['username'])->first();

        if ($pengurusLingkungan && Hash::check($credentials['password'], $pengurusLingkungan->password)) {
            // Store warga data in session
            session(['pengurusLingkungan' => $pengurusLingkungan]);
            
            return redirect()->route('homepage')->with('success', 'Login berhasil!');
        }

        return back()->withErrors([
            'username' => 'Username atau password yang Anda masukkan salah.',
        ])->onlyInput('username');
    }

    public function logoutPengurus()
    {
        session()->forget('pengurusLingkungan');
        return redirect()->route('login-kepaladesa')->with('success', 'Anda telah berhasil logout.');
    }

} 