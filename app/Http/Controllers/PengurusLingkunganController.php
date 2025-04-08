<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengurusLingkunganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nav = 'Pengurus Lingkungan';
        $pengurusLingkungan = PengurusLingkungan::all();

        return view('pengurusLingkungan.index', compact('pengurusLingkungan', 'nav'));
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
        $validatedData = $request->validate([
            'username' => 'required',
            'password' => 'required',
            'nama' => 'required',
            'email' => 'required',
            'no_hp' => 'required'
        ]);

        PengurusLingkungan::create($validatedData);
        return redirect()->route('pengurusLingkungan.index')->with('success', 'Pengurus Lingkungan berhasil ditambahkan');
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
    public function edit(PengurusLingkungan $pengurusLingkungan)
    {
        $nav = 'Edit Pengurus Lingkungan - ' . $pengurusLingkungan->nama;
        return view('pengurusLingkungan.edit', compact('pengurusLingkungan', 'nav'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PengurusLingkungan $pengurusLingkungan)
    {
        $validatedData = $request->validate([
            'username' => 'required',
            'password' => 'required',
            'nama' => 'required',
            'email' => 'required',
            'no_hp' => 'required'
        ]);

        $pengurusLingkungan->update($validatedData);
        return redirect()->route('pengurusLingkungan.index')->with('success', 'Pengurus Lingkungan berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PengurusLingkungan $pengurusLingkungan)
    {
        $pengurusLingkungan->delete();
        return redirect()->route('pengurusLingkungan.index')->with('success', 'Pengurus Lingkungan berhasil dihapus');
    }
}
