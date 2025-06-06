<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Laporan;
use App\Models\Kategori;
use Illuminate\Http\Request;

class LaporanPengurusController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            return $next($request);
        });
    }

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
            return response()->json([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu.'
            ], 401);
        }

        try {
            $validatedData = $request->validate([
                'judul_laporan' => 'required',
                'deskripsi_laporan' => 'required',
                'tanggal_pelaporan' => 'required',
                'tempat_kejadian' => 'required',
                'kategori_laporan' => 'required',
                'time_laporan' => 'required',
                'status_penanganan' => 'required',
                'deskripsi_penanganan' => 'required',
                'status_verifikasi' => 'required',
                'latitude' => 'nullable|numeric|between:-90,90',
                'longitude' => 'nullable|numeric|between:-180,180'
            ]);

            // Add automatic data
            $validatedData['tipe_pelapor'] = 'Pengurus';
            $validatedData['pengurus_lingkungan_username'] = $pengurus->username;
            $validatedData['warga_username'] = null;
            
            // Add coordinates if provided
            $validatedData['latitude'] = $request->latitude;
            $validatedData['longitude'] = $request->longitude;

            $laporan = Laporan::create($validatedData);
            
            return response()->json([
                'success' => true,
                'message' => 'Laporan berhasil ditambahkan',
                'data' => $laporan
            ]);
                
        } catch (\Exception $e) {
            \Log::error('Error saving laporan: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan laporan'
            ], 500);
        }
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

    public function exportPDF(Request $request)
    {
        $query = Laporan::join('kategori', 'laporan.kategori_laporan', '=', 'kategori.nama_kategori')
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
        
        // Filter by warga username if user is logged in
        $warga = session('warga');
        if ($warga) {
            $query->where('warga_username', $warga->username);
        }
        
        $laporans = $query->get();
        
        $pdf = app('dompdf.wrapper');
        $pdf->setPaper('a4', 'landscape');
        $pdf->loadView('pdf.riwayat-laporan', ['laporans' => $laporans]);
        return $pdf->download('EXPORT-LAPORAN-'.now()->timestamp.'.pdf');
    }
}