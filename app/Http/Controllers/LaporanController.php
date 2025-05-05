<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Laporan;
use Illuminate\Support\Facades\Route;
use App\Models\Kategori;

class LaporanController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // Tidak perlu custom binding jika pakai id default
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
        
        // Get logged in user information
        $warga = session('warga');
        if (!$warga) {
            return redirect()->route('login-masyarakat')->with('error', 'Silakan login terlebih dahulu.');
        }

        return view('inputlaporan.create-warga', compact('kategoris', 'nav', 'warga'));
    }

    public function store(Request $request)
    {
        // Get logged in user information
        $warga = session('warga');
        if (!$warga) {
            return redirect()->route('login-masyarakat')->with('error', 'Silakan login terlebih dahulu.');
        }

        $validatedData = $request->validate([
            'judul_laporan' => 'required',
            'deskripsi_laporan' => 'required',
            'tanggal_pelaporan' => 'required',
            'tempat_kejadian' => 'required',
            'kategori_laporan' => 'required'
        ]);

        // Add automatic data
        $validatedData['status_verifikasi'] = 'Belum Terverifikasi';
        $validatedData['status_penanganan'] = 'Belum Ditangani';
        $validatedData['deskripsi_penanganan'] = null;
        $validatedData['tipe_pelapor'] = 'Warga';
        $validatedData['warga_username'] = $warga->username;
        $validatedData['time_laporan'] = now();

        Laporan::create($validatedData);
        return redirect()->route('homepage-warga')->with('success', 'Laporan berhasil ditambahkan');
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

    public function getReportStatistics()
    {
        $sixMonthsAgo = now()->subMonths(5)->startOfMonth();
        
        $reports = DB::table('laporan')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total_reports'),
                DB::raw('SUM(CASE WHEN status_verifikasi = "Terverifikasi" THEN 1 ELSE 0 END) as verified_reports')
            )
            ->where('created_at', '>=', $sixMonthsAgo)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month')
            ->get();

        // Initialize arrays with zeros for all months
        $months = [];
        $totalReports = array_fill(0, 6, 0);
        $verifiedReports = array_fill(0, 6, 0);

        // Get last 6 months
        for ($i = 5; $i >= 0; $i--) {
            $months[] = now()->subMonths($i)->format('M');
        }

        // Fill in actual data
        foreach ($reports as $report) {
            $monthIndex = array_search(date('M', mktime(0, 0, 0, $report->month, 1)), $months);
            if ($monthIndex !== false) {
                $totalReports[$monthIndex] = $report->total_reports;
                $verifiedReports[$monthIndex] = $report->verified_reports;
            }
        }

        return response()->json([
            'labels' => $months,
            'totalReports' => $totalReports,
            'verifiedReports' => $verifiedReports
        ]);
    }

    public function getReportStatisticsWarga(Request $request)
    {
        // Get the username from the request
        $username = $request->query('username');
        
        if (!$username) {
            // If no username provided, try to get from session
            $warga = session('warga');
            if ($warga) {
                $username = $warga->username;
            } else {
                return response()->json([
                    'error' => 'No username provided and no user logged in'
                ], 400);
            }
        }
        
        $sixMonthsAgo = now()->subMonths(5)->startOfMonth();
        
        // Filter reports by username
        $reports = DB::table('laporan')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total_reports'),
                DB::raw('SUM(CASE WHEN status_verifikasi = "Terverifikasi" THEN 1 ELSE 0 END) as verified_reports')
            )
            ->where('created_at', '>=', $sixMonthsAgo)
            ->where('warga_username', $username) // Filter by username
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month')
            ->get();

        // Initialize arrays with zeros for all months
        $months = [];
        $totalReports = array_fill(0, 6, 0);
        $verifiedReports = array_fill(0, 6, 0);

        // Get last 6 months
        for ($i = 5; $i >= 0; $i--) {
            $months[] = now()->subMonths($i)->format('M');
        }

        // Fill in actual data
        foreach ($reports as $report) {
            $monthIndex = array_search(date('M', mktime(0, 0, 0, $report->month, 1)), $months);
            if ($monthIndex !== false) {
                $totalReports[$monthIndex] = $report->total_reports;
                $verifiedReports[$monthIndex] = $report->verified_reports;
            }
        }

        return response()->json([
            'labels' => $months,
            'totalReports' => $totalReports,
            'verifiedReports' => $verifiedReports
        ]);
    }

    public function indexVerifikasi(Request $request)
    {
        $status = $request->query('status');
        $query = Laporan::query();
    
        if ($status) {
            $query->where('status_verifikasi', $status);
        }
    
        $laporans = $query->get();
        return view('verifikasilap.index', compact('laporans'));
    }

    public function verify($id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->status_verifikasi = 'Diverifikasi';
        $laporan->save();
        return redirect()->route('verifikasilap.index')->with('success', 'Laporan berhasil diverifikasi.');
    }

    public function unverify($id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->status_verifikasi = 'Belum Diverifikasi';
        $laporan->save();
        return redirect()->route('verifikasilap.index')->with('success', 'Status verifikasi laporan berhasil dihapus.');
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'status_verifikasi' => 'required|string|in:Belum Diverifikasi,Diverifikasi'
        ]);
    
        $laporan = Laporan::find($request->id);
        if (!$laporan) {
            return response()->json(['success' => false, 'message' => 'Laporan not found'], 404);
        }
    
        $laporan->status_verifikasi = $request->status_verifikasi;
        $laporan->save();
    
        return response()->json(['success' => true]);
    }

    public function riwayatLaporan(Request $request)
    {
        $warga = session('warga');
        if (!$warga) {
            return redirect()->route('login-masyarakat')->with('error', 'Silakan login terlebih dahulu.');
        }

        $query = Laporan::where('warga_username', $warga->username)
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
        $nav = 'Riwayat Laporan';

        return view('riwayatlap.index', compact('laporans', 'nav'));
    }
}
