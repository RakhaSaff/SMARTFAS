<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;

class ManajemenPerbaikanController extends Controller
{
    public function index()
    {
        $laporan      = Laporan::with(['user'])
                               ->where('status', 'diproses')
                               ->orWhere('status', 'selesai')
                               ->orderByDesc('updated_at')
                               ->paginate(15);
        $countDiproses = Laporan::where('status', 'diproses')->count();
        $countSelesai  = Laporan::where('status', 'selesai')->count();

        return view('admin.manajemen-perbaikan', compact('laporan', 'countDiproses', 'countSelesai'));
    }

    public function selesai($id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->update(['status' => 'selesai']);
        return back()->with('success', 'Status laporan diubah menjadi selesai.');
    }

    public function storePerbaikan(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);

        $data = $request->validate([
            'nama_teknisi'      => 'required|string',
            'tanggal_perbaikan' => 'required|date',
            'barang_diperbaiki' => 'required|string',
            'keterangan'        => 'required|string',
            'status_perbaikan'  => 'required|in:diproses,selesai',
            'bukti_foto'        => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('bukti_foto')) {
            $data['bukti_foto'] = $request->file('bukti_foto')->store('perbaikan', 'public');
        }

        $data['laporan_id'] = $laporan->id;

        // Simpan atau update data perbaikan
        if ($laporan->perbaikan) {
            $laporan->perbaikan->update($data);
        } else {
            \App\Models\Perbaikan::create($data);
        }

        return back()->with('success', 'Data perbaikan berhasil disimpan.');
    }
}