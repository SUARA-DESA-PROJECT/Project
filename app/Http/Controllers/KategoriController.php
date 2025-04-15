<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategoris = Kategori::all();
        $nav = 'Data Kategori';
        
        return view('kategori.index', compact('kategoris', 'nav'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $nav = 'Tambah Kategori';
        return view('kategori.create', compact('nav'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_kategori' => 'required|unique:kategori,nama_kategori',
            'deskripsi_kategori' => 'required',
            'jenis_kategori' => 'required|in:Positif,Negatif'
        ]);

        Kategori::create($validatedData);
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kategori $kategori)
    {
        $nav = 'Detail Kategori - ' . $kategori->nama_kategori;
        return view('kategori.show', compact('kategori', 'nav'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($nama_kategori)
    {
        $kategori = Kategori::where('nama_kategori', $nama_kategori)->firstOrFail();
        $nav = 'Edit Kategori - ' . $kategori->nama_kategori;
        return view('kategori.edit', compact('kategori', 'nav'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $nama_kategori)
    {
        $kategori = Kategori::where('nama_kategori', $nama_kategori)->firstOrFail();
        
        $validatedData = $request->validate([
            'nama_kategori' => 'required|unique:kategori,nama_kategori,' . $nama_kategori . ',nama_kategori',
            'deskripsi_kategori' => 'required',
            'jenis_kategori' => 'required|in:Positif,Negatif'
        ]);

        $kategori->update($validatedData);
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori)
    {
        $kategori->delete();
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus');
    }
}
