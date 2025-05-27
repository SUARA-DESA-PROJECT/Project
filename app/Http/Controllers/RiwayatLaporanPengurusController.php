<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Application; 
use Illuminate\Foundation\Configuration\Exceptions; 
use Illuminate\Foundation\Configuration\Middleware;

class RiwayatLaporanPengurusController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $pengurus = session('pengurusLingkungan');
        if (!$pengurus) {
            return redirect()->back()->with('error', 'Akses tidak diizinkan.');
        }

        $query = Laporan::where('pengurus_lingkungan_username', $pengurus->username)
            ->join('kategori', 'laporan.kategori_laporan', '=', 'kategori.nama_kategori')
            ->select('laporan.*', 'kategori.jenis_kategori');

        // Filter by status if provided
        if ($request->has('status')) {
            $query->where('status_verifikasi', $request->status);
        }

        // Filter by jenis if provided
        if ($request->has('jenis')) {
            $jenis = $request->jenis;
            if ($jenis === 'Laporan Positif') {
                $query->where('kategori.jenis_kategori', 'Positif');
            } elseif ($jenis === 'Laporan Negatif') {
                $query->where('kategori.jenis_kategori', 'Negatif');
            }
        }

        // Filter by status_penanganan if provided
        if ($request->has('status_penanganan')) {
            $query->where('laporan.status_penanganan', $request->status_penanganan);
        }

        $laporans = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('laporanpengurus.index', compact('laporans'));
    }

    public function edit($id)
    {
        $pengurus = session('pengurusLingkungan');
        if (!$pengurus) {
            return redirect()->back()->with('error', 'Akses tidak diizinkan.');
        }

        $laporan = Laporan::where('id', $id)
            ->where('pengurus_lingkungan_username', $pengurus->username)
            ->firstOrFail();
        
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        return view('laporanpengurus.edit', compact('laporan', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $pengurus = session('pengurusLingkungan');
        if (!$pengurus) {
            return redirect()->back()->with('error', 'Akses tidak diizinkan.');
        }

        $laporan = Laporan::where('id', $id)
            ->where('pengurus_lingkungan_username', $pengurus->username)
            ->firstOrFail();

        $validatedData = $request->validate([
            'judul_laporan' => 'required',
            'deskripsi_laporan' => 'required',
            'tanggal_pelaporan' => 'required|date',
            'time_laporan' => 'required',
            'tempat_kejadian' => 'required',
            'kategori_laporan' => 'required'
        ]);

        try {
            $laporan->update($validatedData);
            return redirect()->route('pengurus.kelola-laporan.index')
                ->with('success', 'Laporan berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui laporan.');
        }
    }

    public function destroy($id)
    {
        $pengurus = session('pengurusLingkungan');
        if (!$pengurus) {
            return redirect()->back()->with('error', 'Akses tidak diizinkan.');
        }

        $laporan = Laporan::where('id', $id)
            ->where('pengurus_lingkungan_username', $pengurus->username)
            ->firstOrFail();

        $laporan->delete();
        return redirect()->route('pengurus.kelola-laporan.index')
            ->with('success', 'Laporan berhasil dihapus');
    }
}