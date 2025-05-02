<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\Kategori;

class LaporanPengurusController extends Controller
{
    public function create()
    {
        $pengurus = session('pengurusLingkungan');
        if (!$pengurus) {
            return redirect()->route('login-kepaladesa')->with('error', 'Silakan login terlebih dahulu.');
        }

        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $nav = 'Tambah Laporan';
        return view('inputlaporan.create-pengurus', compact('kategoris', 'nav', 'pengurus'));
    }

    public function store(Request $request)
    {
        $pengurus = session('pengurusLingkungan');
        if (!$pengurus) {
            return redirect()->route('login-kepaladesa')->with('error', 'Silakan login terlebih dahulu.');
        }

        $validatedData = $request->validate([
            'judul_laporan' => 'required',
            'deskripsi_laporan' => 'required',
            'tanggal_pelaporan' => 'required',
            'tempat_kejadian' => 'required',
            'status_penanganan' => 'required',
            'deskripsi_penanganan' => 'required',
            'kategori_laporan' => 'required',
            'status_verifikasi' => 'required'
        ]);

        // Add automatic data
        $validatedData['tipe_pelapor'] = 'Pengurus';
        $validatedData['pengurus_lingkungan_username'] = $pengurus->username;
        $validatedData['warga_username'] = null;
        $validatedData['time_laporan'] = now();

        Laporan::create($validatedData);
        return redirect()->route('homepage')->with('success', 'Laporan berhasil ditambahkan');
    }

    public function show(Laporan $laporan)
    {
        $nav = 'Detail Laporan - ' . $laporan->judul_laporan;
        return view('inputlaporan.show', compact('laporan', 'nav'));
    }

    public function edit(Laporan $laporan)
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $nav = 'Edit Laporan - ' . $laporan->judul_laporan;
        return view('inputlaporan.edit-pengurus', compact('laporan', 'kategoris', 'nav'));
    }

    public function update(Request $request, Laporan $laporan)
    {
        $pengurus = session('pengurusLingkungan');
        if (!$pengurus) {
            return redirect()->route('login-kepaladesa')->with('error', 'Silakan login terlebih dahulu.');
        }

        $validatedData = $request->validate([
            'judul_laporan' => 'required',
            'deskripsi_laporan' => 'required',
            'tanggal_pelaporan' => 'required',
            'tempat_kejadian' => 'required',
            'status_verifikasi' => 'required',
            'status_penanganan' => 'required',
            'deskripsi_penanganan' => 'required',
            'kategori_laporan' => 'required'
        ]);

        $laporan->update($validatedData);
        return redirect()->route('homepage')->with('success', 'Laporan berhasil diubah');
    }

    public function destroy(Laporan $laporan)
    {
        $laporan->delete();
        return redirect()->route('homepage')->with('success', 'Laporan berhasil dihapus');
    }
} 