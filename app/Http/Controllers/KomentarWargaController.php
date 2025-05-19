<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KomentarWargaController extends Controller
{
    /**
     * Display a listing of verified reports with comments.
     */
    public function index()
    {
        $verifiedReports = Laporan::where('status_verifikasi', 'Diverifikasi')
            ->orderBy('created_at', 'desc')
            ->with('komentars')
            ->get();
            
        return view('komentarwarga.index', compact('verifiedReports'));
    }
    
    /**
     * Store a newly created comment in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'laporan_id' => 'required|exists:laporan,id',
            'isi_komentar' => 'required|string',
        ]);

        // Determine user type and get username
        $tipe_user = '';
        $username = '';

        if (session('warga')) {
            $tipe_user = 'warga';
            $username = session('warga')->username;
        } elseif (session('pengurusLingkungan')) {
            $tipe_user = 'pengurus';
            $username = session('pengurusLingkungan')->username;
        } else {
            return redirect()->back()->with('error', 'Anda harus login untuk menambahkan komentar.');
        }

        Komentar::create([
            'laporan_id' => $request->laporan_id,
            'isi_komentar' => $request->isi_komentar,
            'username' => $username,
            'tipe_user' => $tipe_user,
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified comment.
     */
    public function edit(Komentar $komentar)
    {
        // Check if the user is authorized to edit this comment
        if (!$this->authorizeUser($komentar)) {
            return redirect()->back()->with('error', 'Anda tidak berhak mengedit komentar ini.');
        }

        return view('komentarwarga.edit', compact('komentar'));
    }

    /**
     * Update the specified comment in storage.
     */
    public function update(Request $request, Komentar $komentar)
    {
        // Check if the user is authorized to update this comment
        if (!$this->authorizeUser($komentar)) {
            return redirect()->back()->with('error', 'Anda tidak berhak mengubah komentar ini.');
        }

        $request->validate([
            'isi_komentar' => 'required|string',
        ]);

        $komentar->update([
            'isi_komentar' => $request->isi_komentar,
        ]);

        return redirect()->route('komentar.index')
            ->with('success', 'Komentar berhasil diperbarui.');
    }

    /**
     * Remove the specified comment from storage.
     */
    public function destroy(Komentar $komentar)
    {
        // Check if the user is authorized to delete this comment
        if (!$this->authorizeUser($komentar)) {
            return redirect()->back()->with('error', 'Anda tidak berhak menghapus komentar ini.');
        }

        $komentar->delete();

        return redirect()->route('komentar.index')
            ->with('success', 'Komentar berhasil dihapus.');
    }

    /**
     * Check if the current user is authorized to modify the comment.
     */
    private function authorizeUser(Komentar $komentar)
    {
        if (session('warga') && $komentar->tipe_user == 'warga' && $komentar->username == session('warga')->username) {
            return true;
        }

        if (session('pengurusLingkungan') && ($komentar->tipe_user == 'pengurus' && $komentar->username == session('pengurusLingkungan')->username || session('pengurusLingkungan')->role == 'admin')) {
            return true;
        }

        return false;
    }
}