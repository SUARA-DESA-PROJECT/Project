<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengurusLingkungan;
use App\Models\Warga;
use Illuminate\Routing\Controller;

class PengurusLingkunganController extends Controller
{
    // public function showPengurus()
    // {
    //     return view('pengurus.index');
    // }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengurusData = PengurusLingkungan::all()->map(function($pengurus) {
            return [
                'username' => $pengurus->username,
                'nama_lengkap' => $pengurus->nama_lengkap,
                'nomor_telepon' => $pengurus->nomor_telepon,
                'alamat' => $pengurus->alamat
            ];
        })->toArray();
        
        return view('pengurus.index', compact('pengurusData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $nav = 'Tambah Pengurus Lingkungan';
        return view('pengurusLingkungan.create', compact('nav'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'username' => 'required|unique:pengurus_lingkungan,username',
                'password' => 'required|min:6',
                'nama_lengkap' => 'required',
                'alamat' => 'required',
                'nomor_telepon' => 'required|regex:/^[0-9]{10,15}$/'
            ]);

            // Hash the password before saving
            $validatedData['password'] = bcrypt($validatedData['password']);

            // Create new pengurus
            PengurusLingkungan::create($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Account created successfully'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating account. Please try again.'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PengurusLingkungan $pengurusLingkungan)
    {
        $nav = 'Detail Pengurus Lingkungan - ' . $pengurusLingkungan->nama;
        return view('pengurusLingkungan.show', compact('pengurusLingkungan', 'nav'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($username)
    {
        $pengurus = PengurusLingkungan::where('username', $username)->firstOrFail();
        return view('pengurus.edit', compact('pengurus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $username)
    {
        try {
            $pengurus = PengurusLingkungan::where('username', $username)->firstOrFail();
            
            $validatedData = $request->validate([
                'nama_lengkap' => 'required',
                'alamat' => 'required',
                'nomor_telepon' => 'required|regex:/^[0-9]{10,15}$/'
            ]);

            $pengurus->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Account updated successfully'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating account. Please try again.'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($username)
    {
        $pengurus = PengurusLingkungan::where('username', $username)->firstOrFail();
        $pengurus->delete();
        return redirect()->route('pengurus')->with('success', 'Account deleted successfully');
    }
}
