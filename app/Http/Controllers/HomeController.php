<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $pengurus = session('pengurusLingkungan');
        if (!$pengurus) {
            return redirect()->route('login-kepaladesa')->with('error', 'Silakan login terlebih dahulu.');
        }

        $totalReports = DB::table('laporan')->count();
        $verifiedReports = DB::table('laporan')
            ->where('status_verifikasi', 'Terverifikasi')
            ->count();
        $totalUsers = DB::table('warga')->count();

        $recentReports = DB::table('laporan')
            ->select('judul_laporan', 'created_at', 'status_verifikasi')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('homepage.homepage', compact('pengurus', 'totalReports', 'verifiedReports', 'totalUsers', 'recentReports'));
    }

    public function index_warga()
    {
        $warga = session('warga');
        if (!$warga) {
            return redirect()->route('login-masyarakat')->with('error', 'Silakan login terlebih dahulu.');
        }

        $totalReports = DB::table('laporan')->count();
        $verifiedReports = DB::table('laporan')
            ->where('status_verifikasi', 'Terverifikasi')
            ->count();
        $totalUsers = DB::table('warga')->count();

        // Get all reports to check if there are any in the database
        $allReports = DB::table('laporan')->get();
        
        // Filter recent reports by the logged-in user's username
        $recentReports = DB::table('laporan')
            ->select('judul_laporan', 'created_at', 'status_verifikasi', 'warga_username')
            ->where('warga_username', $warga->username)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Add debugging information
        $debug = [
            'current_username' => $warga->username,
            'total_reports_in_db' => count($allReports),
            'reports_for_user' => count($recentReports),
        ];

        return view('homepage.homepage-warga', compact('warga', 'totalReports', 'verifiedReports', 'totalUsers', 'recentReports'));
    }

    public function petaPersebaran()
    {
        $reports = DB::table('laporan')
            ->select('id', 'judul_laporan', 'lokasi', 'status_verifikasi', 'created_at')
            ->get();
            
        return view('peta.persebaran', compact('reports'));
    }

    public function petaPersebaranWarga()
    {
        return view('peta.persebaran-warga');
    }
}