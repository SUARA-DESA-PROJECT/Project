<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
=======
use App\Models\Warga;
>>>>>>> fbdb894 (SDP-1 fitur registrasi)
use Illuminate\Http\Request;

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
<<<<<<< HEAD
            'username' => 'required',
            'password' => 'required',
            'nama' => 'required',
            'email' => 'required',
            'no_hp' => 'required'
        ]);

        Warga::create($validatedData);
        return redirect()->route('warga.index')->with('success', 'Warga berhasil ditambahkan');
=======
            'username' => 'required|unique:warga,username',
            'password' => 'required|min:6',
            'nama_lengkap' => 'required',
            'nomor_telepon' => 'required|numeric',
            'alamat' => 'required'
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']);

        try {
            Warga::create($validatedData);
            return redirect('/')->with('success', 'Registrasi berhasil! Silakan login.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
>>>>>>> fbdb894 (SDP-1 fitur registrasi)
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
}
