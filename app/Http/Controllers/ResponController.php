<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResponController extends Controller
{
    public function index()
    {
        $laporans = Laporan::where('status_verifikasi', 'Diverifikasi')
            ->orderBy('tanggal_pelaporan', 'desc')
            ->get();

        return view('respon-laporan.index', compact('laporans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status_penanganan' => 'required',
            'deskripsi_penanganan' => 'required',
        ]);

        DB::table('laporan')
            ->where('id', $id)
            ->update([
                'status_penanganan' => $request->status_penanganan,
                'deskripsi_penanganan' => $request->deskripsi_penanganan,
            ]);

        return redirect()->route('respon.index')->with('success', 'Respon Diperbarui dengan sukses!');
    }

    public function edit($id)
    {
        $laporan = DB::table('laporan')->where('id', $id)->first();
        if (!$laporan) {
            abort(404);
        }
        return view('respon-Laporan.edit', compact('laporan'));
    }
}