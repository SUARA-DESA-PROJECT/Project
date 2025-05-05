<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get total reports
        $totalReports = Laporan::count();
        
        // Get reports by verification status
        $verifiedCount = Laporan::where('status_verifikasi', 'Diverifikasi')->count();
        $unverifiedCount = Laporan::where('status_verifikasi', 'Belum terverifikasi')->count();
        $inProcessCount = Laporan::where('status_penanganan', 'Sudah ditangani')->count();
    
        // Get reports by location
        $reportsByLocation = Laporan::select('tempat_kejadian as lokasi', DB::raw('count(*) as total'))
            ->groupBy('tempat_kejadian')
            ->get();

        // Get weekly reports data
        $weeklyReports = DB::table('laporan')
            ->select(DB::raw('YEAR(tanggal_pelaporan) as year, 
                             WEEK(tanggal_pelaporan) as week, 
                             COUNT(*) as total'))
            ->whereYear('tanggal_pelaporan', date('Y'))
            ->groupBy('year', 'week')
            ->orderBy('year')
            ->orderBy('week')
            ->get();

        // Get daily reports data
        $dailyReports = DB::table('laporan')
            ->select(DB::raw('DATE(tanggal_pelaporan) as date'), DB::raw('COUNT(*) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Get category distribution
        $categoryDistribution = DB::table('laporan')
            ->select('kategori_laporan', DB::raw('COUNT(*) as total'))
            ->groupBy('kategori_laporan')
            ->get();

        return view('dashboard.index', compact(
            'totalReports',
            'verifiedCount',
            'unverifiedCount',
            'inProcessCount',
            'reportsByLocation',
            'weeklyReports',
            'dailyReports',
            'categoryDistribution'
        ));
    }
}