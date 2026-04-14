<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;

class LaporanMasukController extends Controller
{
    public function index(Request $request)
    {
        $query = Laporan::with('user')->orderByDesc('created_at');

        if ($request->tingkat) {
            $query->where('tingkat_kerusakan', $request->tingkat);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nama_barang', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($u) use ($request) {
                      $u->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $laporan = $query->paginate(15);
        return view('admin.laporan-masuk', compact('laporan'));
    }

    public function show($id)
    {
        $laporan = Laporan::with('user')->findOrFail($id);
        return view('admin.laporan-masuk-detail', compact('laporan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,selesai',
        ]);

        $laporan = Laporan::findOrFail($id);
        $laporan->status = $request->status;
        $laporan->save();

        return redirect()->route('admin.laporan-masuk.index')
                         ->with('success', 'Status laporan berhasil diperbarui.');
    }

    public function verifikasi($id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->update(['status' => 'diproses']);
        return back()->with('success', 'Laporan berhasil diverifikasi.');
    }
}