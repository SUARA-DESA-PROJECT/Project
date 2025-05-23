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
        $user = auth()->user();
        
        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:wargas,email,' . $user->id,
            'nomor_telepon' => 'required|string|max:15',
            'alamat' => 'required|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->nama_lengkap = $validatedData['nama_lengkap'];
        $user->email = $validatedData['email'];
        $user->nomor_telepon = $validatedData['nomor_telepon'];
        $user->alamat = $validatedData['alamat'];

        if ($request->filled('password')) {
            $user->password = Hash::make($validatedData['password']);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully');
    }
}