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
            'kategori_laporan' => 'required',
        ]);

        // Add automatic data
        $validatedData['status_verifikasi'] = 'Terverifikasi';
        $validatedData['status_penanganan'] = 'Sedang Ditangani';
        $validatedData['deskripsi_penanganan'] = 'Ditangani oleh pengurus lingkungan';
        $validatedData['tipe_pelapor'] = 'Pengurus';
        $validatedData['pengurus_lingkungan_username'] = $pengurus->username;
        $validatedData['warga_username'] = '-';
        $validatedData['time_laporan'] = now();

        Laporan::create($validatedData);
        return redirect()->route('laporan.create-pengurus')->with('success', 'Laporan berhasil ditambahkan');
    }
} 