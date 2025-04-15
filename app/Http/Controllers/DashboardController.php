<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Get total reports
        $totalReports = Laporan::count();
        
        // Get reports by status
        $inProcessCount = Laporan::where('status_penanganan', 'Sudah ditangani')->count();
        $unverifiedCount = Laporan::where('status_verifikasi', 'Belum terverifikasi')->count();

        // Get category distribution with positive/negative counts
        $verifiedCount = Laporan::where('status_verifikasi', 'Terverifikasi')->count();
    
        // Get reports by category
        $reportsByCategory = Laporan::select('kategori_laporan', DB::raw('count(*) as total'))
            ->groupBy('kategori_laporan')
            ->get();

        // Get reports by location
        $reportsByLocation = Laporan::select('tempat_kejadian as lokasi', DB::raw('count(*) as total'))
            ->groupBy('tempat_kejadian')
            ->get();

        // Get last 7 days reports
        $lastSevenDays = Laporan::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->whereBetween('created_at', [Carbon::now()->subDays(6), Carbon::now()])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('dashboard.index', compact(
            'totalReports',
            'inProcessCount',
            'unverifiedCount',
            'reportsByCategory',
            'reportsByLocation',
            'lastSevenDays',
            'verifiedCount',
            'unverifiedCount'
        ));
    }
}