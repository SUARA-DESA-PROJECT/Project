<?php

namespace App\Http\Controllers;

use App\Models\PengurusLingkungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ProfilePengurusController extends Controller
{
    public function edit()
    {
        $pengurus = session('pengurusLingkungan');
        if (!$pengurus) {
            return redirect()->route('login-kepaladesa')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Get fresh data from database
        $pengurus = PengurusLingkungan::where('username', $pengurus->username)->first();
        if (!$pengurus) {
            return redirect()->route('login-kepaladesa')->with('error', 'Data pengurus tidak ditemukan.');
        }

        return view('homepage.edit-profile-pengurus', compact('pengurus'));
    }

    public function update(Request $request)
    {
        try {
            DB::beginTransaction();

            $pengurus = session('pengurusLingkungan');
            if (!$pengurus) {
                return redirect()->route('login-kepaladesa')->with('error', 'Silakan login terlebih dahulu.');
            }

            // Get fresh data from database
            $pengurus = PengurusLingkungan::where('username', $pengurus->username)->first();
            if (!$pengurus) {
                return redirect()->route('login-kepaladesa')->with('error', 'Data pengurus tidak ditemukan.');
            }
            
            $validatedData = $request->validate([
                'nama_lengkap' => 'required|string|max:255',
                'nomor_telepon' => 'required|string|max:15',
                'alamat' => 'required|string',
                'password' => 'nullable|string|min:8|confirmed',
            ]);

            $pengurus->nama_lengkap = $validatedData['nama_lengkap'];
            $pengurus->nomor_telepon = $validatedData['nomor_telepon'];
            $pengurus->alamat = $validatedData['alamat'];

            if ($request->filled('password')) {
                $pengurus->password = Hash::make($validatedData['password']);
            }

            $pengurus->save();

            // Update session data
            session(['pengurusLingkungan' => $pengurus]);

            DB::commit();
            return redirect()->route('profile-pengurus.edit')->with('success', 'Profile updated successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }
} 