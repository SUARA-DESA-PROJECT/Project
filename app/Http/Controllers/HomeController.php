<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
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

        return view('homepage.homepage', compact('totalReports', 'verifiedReports', 'totalUsers', 'recentReports'));
    }
}