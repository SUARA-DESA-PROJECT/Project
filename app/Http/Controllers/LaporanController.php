<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use Illuminate\Support\Facades\Route;
use App\Models\Kategori;

class LaporanController extends Controller
{
    public function __construct()
    {
        // Bind route model untuk Laporan
        $this->middleware(function ($request, $next) {
            Route::bind('laporan', function ($value) {
                return Laporan::where('id_laporan', $value)->firstOrFail();
            });
            return $next($request);
        });
    }

    public function index()
    {
        $laporans = Laporan::all();
        $nav = 'Laporan';

        return view('inputlaporan.index', compact('laporans', 'nav'));
    }

    public function create()
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $nav = 'Tambah Laporan';
        return view('inputlaporan.create', compact('kategoris', 'nav'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul_laporan' => 'required',
            'deskripsi_laporan' => 'required',
            'tanggal_pelaporan' => 'required',
            'tempat_kejadian' => 'required',
            'status_verifikasi' => 'required',
            'status_penanganan' => 'required',
            'deskripsi_penanganan' => 'required',
            'tipe_pelapor' => 'required',
            'pengurus_lingkungan_username' => 'required',
            'warga_username' => 'required',
            'kategori_laporan' => 'required',
            'time_laporan' => 'required',
        ]);

        Laporan::create($validatedData);
        return redirect()->route('laporan.create')->with('success', 'Laporan berhasil ditambahkan');
    }

    public function show(Laporan $laporan)
    {
        $nav = 'Detail Laporan - ' . $laporan->judul_laporan;
        return view('inputlaporan.show', compact('laporan', 'nav'));
    }

    public function edit(Laporan $laporan)
    {
        $nav = 'Edit Laporan - ' . $laporan->judul_laporan;
        return view('inputlaporan.edit', compact('laporan', 'nav'));
    }

    public function update(Request $request, Laporan $laporan)
    {
        $validatedData = $request->validate([
            'judul_laporan' => 'required',
            'deskripsi_laporan' => 'required',
            'tanggal_pelaporan' => 'required',
            'tempat_kejadian' => 'required',
            'status_verifikasi' => 'required',
            'status_penanganan' => 'required',
            'deskripsi_penanganan' => 'required',
            'tipe_pelapor' => 'required',
            'pengurus_lingkungan_username' => 'required',
            'warga_username' => 'required',
            'kategori_laporan' => 'required'
        ]);

        $laporan->update($validatedData);
        return redirect()->route('inputlaporan.index')->with('success', 'Laporan berhasil diubah');
    }

    public function destroy(Laporan $laporan)
    {
        $laporan->delete();
        return redirect()->route('inputlaporan.index')->with('success', 'Laporan berhasil dihapus');
    }
}