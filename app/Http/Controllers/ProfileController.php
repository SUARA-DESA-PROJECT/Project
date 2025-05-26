<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $warga = session('warga');
        if (!$warga) {
            return redirect()->route('login-masyarakat')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Get fresh data from database
        $warga = Warga::where('username', $warga->username)->first();
        if (!$warga) {
            return redirect()->route('login-masyarakat')->with('error', 'Data warga tidak ditemukan.');
        }

        return view('homepage.edit-profile', compact('warga'));
    }

    public function update(Request $request)
    {
        $warga = session('warga');
        if (!$warga) {
            return redirect()->route('login-masyarakat')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Get fresh data from database
        $warga = Warga::where('username', $warga->username)->first();
        if (!$warga) {
            return redirect()->route('login-masyarakat')->with('error', 'Data warga tidak ditemukan.');
        }
        
        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:warga,email,' . $warga->username . ',username',
            'nomor_telepon' => 'required|string|max:15',
            'alamat' => 'required|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $warga->nama_lengkap = $validatedData['nama_lengkap'];
        $warga->email = $validatedData['email'];
        $warga->nomor_telepon = $validatedData['nomor_telepon'];
        $warga->alamat = $validatedData['alamat'];

        if ($request->filled('password')) {
            $warga->password = Hash::make($validatedData['password']);
        }

        $warga->save();

        // Update session data
        session(['warga' => $warga]);

        return redirect()->back()->with('success', 'Profile updated successfully');
    }
}