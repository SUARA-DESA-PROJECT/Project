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

        // Tambahkan filter untuk pengurus yang login
        $query = Laporan::join('kategori', 'laporan.kategori_laporan', '=', 'kategori.nama_kategori')
            ->where('laporan.pengurus_lingkungan_username', $pengurus->username) // Filter berdasarkan pengurus login
            ->select('laporan.*', 'kategori.jenis_kategori');

        // Filter by status if provided
        if ($request->has('status')) {
            $query->where('laporan.status_verifikasi', $request->status);
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

        $laporans = $query->orderBy('laporan.created_at', 'desc')->paginate(10);
        return view('laporanpengurus.index', compact('laporans'));
    }

    public function edit($id)
    {
        try {
            $pengurus = session('pengurusLingkungan');
            if (!$pengurus) {
                return redirect()->back()->with('error', 'Akses tidak diizinkan.');
            }

            // Debug: Log informasi
            \Log::info('Edit request - ID: ' . $id . ', Pengurus: ' . $pengurus->username);

            $laporan = Laporan::where('id', $id)
                ->where('pengurus_lingkungan_username', $pengurus->username)
                ->first(); // Gunakan first() bukan firstOrFail()
            
            if (!$laporan) {
                \Log::error('Laporan not found or access denied - ID: ' . $id);
                return redirect()->route('pengurus.kelola-laporan.index')
                    ->with('error', 'Laporan tidak ditemukan atau Anda tidak memiliki akses.');
            }
            
            $kategoris = Kategori::orderBy('nama_kategori')->get();
            return view('laporanpengurus.edit', compact('laporan', 'kategoris'));
            
        } catch (\Exception $e) {
            \Log::error('Error in edit method: ' . $e->getMessage());
            return redirect()->route('pengurus.kelola-laporan.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $pengurus = session('pengurusLingkungan');
            if (!$pengurus) {
                return redirect()->back()->with('error', 'Akses tidak diizinkan.');
            }

            $laporan = Laporan::where('id', $id)
                ->where('pengurus_lingkungan_username', $pengurus->username)
                ->first();
                
            if (!$laporan) {
                return redirect()->route('pengurus.kelola-laporan.index')
                    ->with('error', 'Laporan tidak ditemukan atau Anda tidak memiliki akses.');
            }

            $validatedData = $request->validate([
                'judul_laporan' => 'required|string|max:255',
                'deskripsi_laporan' => 'required|string',
                'tanggal_pelaporan' => 'required|date',
                'time_laporan' => 'required',
                'tempat_kejadian' => 'required|string|max:255',
                'kategori_laporan' => 'required|string|max:255'
            ]);

            $laporan->update($validatedData);
            
            return redirect()->route('pengurus.kelola-laporan.index')
                ->with('success', 'Laporan berhasil diperbarui.');
                
        } catch (\Exception $e) {
            \Log::error('Error updating laporan: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui laporan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $pengurus = session('pengurusLingkungan');
            if (!$pengurus) {
                return redirect()->back()->with('error', 'Akses tidak diizinkan.');
            }

            $laporan = Laporan::where('id', $id)
                ->where('pengurus_lingkungan_username', $pengurus->username)
                ->first();
                
            if (!$laporan) {
                return redirect()->route('pengurus.kelola-laporan.index')
                    ->with('error', 'Laporan tidak ditemukan atau Anda tidak memiliki akses.');
            }

            $laporan->delete();
            
            return redirect()->route('pengurus.kelola-laporan.index')
                ->with('success', 'Laporan berhasil dihapus');
                
        } catch (\Exception $e) {
            \Log::error('Error deleting laporan: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus laporan.');
        }
    }
}