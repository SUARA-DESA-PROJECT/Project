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
}
