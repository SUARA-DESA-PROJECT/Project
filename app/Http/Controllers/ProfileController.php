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

        $sessionWarga = session('warga');
        if (!$sessionWarga) {
            return redirect()->route('login-masyarakat')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Fetch the user from the database using username
        $warga = \App\Models\Warga::where('username', $sessionWarga->username)->first();

        if (!$warga) {
            return redirect()->route('login-masyarakat')->with('error', 'Data warga tidak ditemukan.');
        }

        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:warga,email,' . $warga->username . ',username',
            'nomor_telepon' => 'required|string|max:15',
            'alamat' => 'required|string',
            'new_password' => 'nullable|min:6|confirmed',
        ]);

        $warga->nama_lengkap = $validatedData['nama_lengkap'];
        $warga->email = $validatedData['email'];
        $warga->nomor_telepon = $validatedData['nomor_telepon'];
        $warga->alamat = $validatedData['alamat'];

        if ($request->filled('new_password')) {
            $warga->password = bcrypt($validatedData['new_password']);
        }

        $warga->save();

        // Update session data with the potentially updated warga object
        session(['warga' => $warga]);

        return redirect()->back()->with('success', 'Profile berhasil diperbarui');
    }
}