<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResponController extends Controller
{
    public function index()
    {
        $laporans = Laporan::whereIn('status_verifikasi', ['Diverifikasi', 'Ditolak'])
            ->orderBy('tanggal_pelaporan', 'desc')
            ->get();

        return view('respon-laporan.index', compact('laporans'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'status_penanganan' => 'required|in:Belum Ditangani,Sedang Ditangani,Sudah Ditangani',
                'deskripsi_penanganan' => 'required|string|min:10',
            ], [
                'status_penanganan.required' => 'Status penanganan harus dipilih',
                'status_penanganan.in' => 'Status penanganan tidak valid',
                'deskripsi_penanganan.required' => 'Deskripsi penanganan harus diisi',
                'deskripsi_penanganan.min' => 'Deskripsi penanganan minimal 10 karakter'
            ]);

            $laporan = Laporan::findOrFail($id);
            
            $laporan->update([
                'status_penanganan' => $request->status_penanganan,
                'deskripsi_penanganan' => $request->deskripsi_penanganan,
                'updated_at' => now()
            ]);

            return redirect()
                ->route('respon.index')
                ->with('success', 'Respon laporan berhasil diperbarui!')
                ->with('alert-type', 'success');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()
                ->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Gagal memperbarui respon laporan. Silakan periksa kembali input Anda.')
                ->with('alert-type', 'error');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui respon laporan.')
                ->with('alert-type', 'error');
        }
    }

    public function edit($id)
    {
        try {
            $laporan = Laporan::findOrFail($id);
            
            if ($laporan->status_verifikasi !== 'Diverifikasi') {
                return redirect()
                    ->route('respon.index')
                    ->with('error', 'Laporan harus diverifikasi terlebih dahulu!')
                    ->with('alert-type', 'warning');
            }

            return view('respon-Laporan.edit', compact('laporan'));

        } catch (\Exception $e) {
            return redirect()
                ->route('respon.index')
                ->with('error', 'Laporan tidak ditemukan.')
                ->with('alert-type', 'error');
        }
    }

    // Tambah method baru untuk keterangan penolakan
    public function editRejection($id)
    {
        try {
            $laporan = Laporan::findOrFail($id);
            
            if ($laporan->status_verifikasi !== 'Ditolak') {
                return redirect()
                    ->route('respon.index')
                    ->with('error', 'Hanya laporan yang ditolak yang dapat ditambah keterangan!')
                    ->with('alert-type', 'warning');
            }

            return view('respon-Laporan.edit-rejection', compact('laporan'));

        } catch (\Exception $e) {
            return redirect()
                ->route('respon.index')
                ->with('error', 'Laporan tidak ditemukan.')
                ->with('alert-type', 'error');
        }
    }

    public function updateRejection(Request $request, $id)
    {
        try {
            $request->validate([
                'deskripsi_penolakan' => 'required|string|min:10',
            ], [
                'deskripsi_penolakan.required' => 'Deskripsi penolakan harus diisi',
                'deskripsi_penolakan.min' => 'Deskripsi penolakan minimal 10 karakter'
            ]);

            $laporan = Laporan::findOrFail($id);
            
            if ($laporan->status_verifikasi !== 'Ditolak') {
                return redirect()
                    ->route('respon.index')
                    ->with('error', 'Hanya laporan yang ditolak yang dapat ditambah keterangan!')
                    ->with('alert-type', 'warning');
            }
            
            $laporan->update([
                'deskripsi_penolakan' => $request->deskripsi_penolakan,
                'updated_at' => now()
            ]);

            return redirect()
                ->route('respon.index')
                ->with('success', 'Keterangan penolakan berhasil ditambahkan!')
                ->with('alert-type', 'success');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()
                ->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Gagal menambahkan keterangan penolakan. Silakan periksa kembali input Anda.')
                ->with('alert-type', 'error');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menambahkan keterangan penolakan.')
                ->with('alert-type', 'error');
        }
    }
}