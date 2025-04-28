<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class WargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wargas = Warga::all();
        $nav = 'Warga';

        return view('warga.index', compact('wargas', 'nav'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $nav = 'Tambah Warga';
        return view('warga.create', compact('nav'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|unique:warga,username',
            'password' => 'required|min:6',
            'email' =>'required|email|unique:warga,email',
            'nama_lengkap' => 'required',
            'nomor_telepon' => 'required|numeric',
            'alamat' => 'required'
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']);

        try {
            Warga::create($validatedData);
            return redirect()->back()->with('success', 'Registrasi berhasil!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Warga $warga)
    {
        $nav = 'Detail Warga - ' . $warga->nama;
        return view('warga.show', compact('warga', 'nav'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Warga $warga)
    {
        $nav = 'Edit Warga - ' . $warga->nama;
        return view('warga.edit', compact('warga', 'nav'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Warga $warga)
    {
        $validatedData = $request->validate([
            'username' => 'required',
            'password' => 'required',
            'nama' => 'required',
            'email' => 'required',
            'no_hp' => 'required'
        ]);

        $warga->update($validatedData);
        return redirect()->route('warga.index')->with('success', 'Warga berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warga $warga)
    {
        $warga->delete();
        return redirect()->route('warga.index')->with('success', 'Warga berhasil dihapus');
    }

    /**
     * Display a listing of warga accounts for verification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function verifikasiIndex(Request $request)
    {
        $status = $request->query('status');
        
        $query = Warga::query();
        
        if ($status) {
            $query->where('status_verifikasi', $status);
        }
        
        $wargas = $query->get();
        
        return view('verifikasiAkun.index', compact('wargas'));
    }
    
    /**
     * Verify a warga account.
     *
     * @param  string  $username
     * @return \Illuminate\Http\Response
     */
    public function verifyWarga($username)
    {
        $warga = Warga::where('username', $username)->firstOrFail();
        $warga->status_verifikasi = 'Terverifikasi';
        $warga->save();
        
        return redirect()->route('warga.verifikasi')
            ->with('success', 'Akun berhasil diverifikasi.');
    }
    
    /**
     * Remove verification from a warga account.
     *
     * @param  string  $username
     * @return \Illuminate\Http\Response
     */
    public function unverifyWarga($username)
    {
        $warga = Warga::where('username', $username)->firstOrFail();
        $warga->status_verifikasi = 'Belum diverifikasi';
        $warga->save();
        
        return redirect()->route('warga.verifikasi')
            ->with('success', 'Status verifikasi akun berhasil dihapus.');
    }
}
