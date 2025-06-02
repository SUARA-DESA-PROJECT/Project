<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Komentar;
use App\Models\Laporan;

class KomentarPengurusController extends Controller
{
    public function index()
    {
        $verifiedReports = Laporan::where('status_verifikasi', 'Diverifikasi')
            ->with('komentars')
            ->orderBy('tanggal_pelaporan', 'desc')
            ->get();

        return view('komentarpengurus.index', compact('verifiedReports'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'laporan_id' => 'required|exists:laporan,id',
            'isi_komentar' => 'required|string',
        ]);

        // Get the pengurus data from session
        $pengurus = session('pengurusLingkungan');
        
        if (!$pengurus) {
            // If session doesn't exist, redirect with error
            return redirect()->back()->with('error', 'Sesi pengurus tidak ditemukan. Silakan login kembali.');
        }
        
        try {
            // Insert the comment into the database
            DB::table('komentar')->insert([
                'laporan_id' => $request->laporan_id,
                'username' => $pengurus->username,
                'tipe_user' => 'pengurus',
                'isi_komentar' => $request->isi_komentar,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            return redirect()->route('komentarpengurus.index')->with('success', 'Komentar berhasil ditambahkan');
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error saving comment: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan komentar: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'isi_komentar' => 'required|string',
        ]);

        $komentar = DB::table('komentar')->where('id', $id)->first();
        
        if (!$komentar || $komentar->tipe_user != 'pengurus' || $komentar->username != session('pengurusLingkungan')->username) {
            return redirect()->route('komentarpengurus.index')->with('error', 'Anda tidak memiliki akses untuk mengedit komentar ini');
        }

        DB::table('komentar')
            ->where('id', $id)
            ->update([
                'isi_komentar' => $request->isi_komentar,
                'updated_at' => now(),
            ]);

        return redirect()->route('komentarpengurus.index')->with('success', 'Komentar berhasil diperbarui');
    }

    public function destroy($id)
    {
        $komentar = DB::table('komentar')->where('id', $id)->first();
        
        if (!$komentar || $komentar->tipe_user != 'pengurus' || $komentar->username != session('pengurusLingkungan')->username) {
            return redirect()->route('komentarpengurus.index')->with('error', 'Anda tidak memiliki akses untuk menghapus komentar ini');
        }

        DB::table('komentar')->where('id', $id)->delete();

        return redirect()->route('komentarpengurus.index')->with('success', 'Komentar berhasil dihapus');
    }

    public function edit($id)
    {
        $komentar = DB::table('komentar')->where('id', $id)->first();
        
        if (!$komentar || $komentar->tipe_user != 'pengurus' || $komentar->username != session('pengurusLingkungan')->username) {
            return redirect()->route('komentarpengurus.index')->with('error', 'Anda tidak memiliki akses untuk mengedit komentar ini');
        }

        return view('komentarpengurus.edit', compact('komentar'));
    }
}