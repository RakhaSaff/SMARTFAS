<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RekapanController extends Controller
{
    /**
     * Tampilkan halaman rekapan perbaikan
     */
    public function index(Request $request)
    {
        $query = Laporan::with('user')
                        ->where('status', 'selesai')
                        ->orderByDesc('updated_at');

        // Filter bulan & tahun
        if ($request->bulan) {
            $query->whereMonth('updated_at', $request->bulan);
        }
        if ($request->tahun) {
            $query->whereYear('updated_at', $request->tahun);
        } else {
            $query->whereYear('updated_at', date('Y'));
        }

        $laporans        = $query->paginate(15);
        $totalRekapan    = Laporan::where('status', 'selesai')->count();
        $rekapanBulanIni = Laporan::where('status', 'selesai')
                                  ->whereMonth('updated_at', now()->month)
                                  ->whereYear('updated_at', now()->year)
                                  ->count();
        $akanHapus       = Laporan::where('status', 'selesai')
                                  ->where('updated_at', '<', now()->subMonths(3))
                                  ->count();

        return view('admin.rekapan', compact(
            'laporans', 'totalRekapan', 'rekapanBulanIni', 'akanHapus'
        ));
    }

    /**
     * Hapus satu rekapan
     */
    public function hapus($id)
    {
        $laporan = Laporan::findOrFail($id);

        // Hapus foto dari storage
        $sisi = ['atas', 'bawah', 'kanan', 'kiri', 'depan', 'belakang'];
        foreach ($sisi as $s) {
            $field = 'foto_' . $s;
            if ($laporan->$field) {
                \Storage::disk('public')->delete($laporan->$field);
            }
        }

        $laporan->delete();

        return back()->with('success', 'Rekapan berhasil dihapus.');
    }

    /**
     * Hapus otomatis rekapan yang sudah lebih dari 3 bulan
     */
    public function hapusOtomatis()
    {
        $laporans = Laporan::where('status', 'selesai')
                           ->where('updated_at', '<', now()->subMonths(3))
                           ->get();

        $count = $laporans->count();

        foreach ($laporans as $laporan) {
            $sisi = ['atas', 'bawah', 'kanan', 'kiri', 'depan', 'belakang'];
            foreach ($sisi as $s) {
                $field = 'foto_' . $s;
                if ($laporan->$field) {
                    \Storage::disk('public')->delete($laporan->$field);
                }
            }
            $laporan->delete();
        }

        return back()->with('success', "{$count} rekapan yang sudah lebih dari 3 bulan berhasil dihapus.");
    }
}