<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('homepage.edit-profile');
    }

    public function update(Request $request)
    {
        $sessionWarga = session('warga');
        if (!$sessionWarga) {
            return redirect()->route('login-masyarakat')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Fetch the user from the database using username
        $user = \App\Models\Warga::where('username', $sessionWarga->username)->first();

        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:warga,email,' . $user->username . ',username',
            'nomor_telepon' => 'required|string|max:15',
            'alamat' => 'required|string',
            'new_password' => 'nullable|min:6|confirmed',
        ]);

        $user->nama_lengkap = $validatedData['nama_lengkap'];
        $user->email = $validatedData['email'];
        $user->nomor_telepon = $validatedData['nomor_telepon'];
        $user->alamat = $validatedData['alamat'];

        // Update password if provided
        if ($request->filled('new_password')) {
            $user->password = bcrypt($validatedData['new_password']);
        }

        $user->save();

        // Update session data
        session(['warga' => $user]);

        return redirect()->back()->with('success', 'Profile berhasil diperbarui');
    }
}