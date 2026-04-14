<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;

class LaporanController extends Controller
{
    public function create()
    {
        return view('laporan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang'  => 'required|string|max:30',
            'jenis_barang' => 'required|in:elektronik,non-elektronik',
            'tempat_utama' => 'required|string',
            'sub_lokasi'   => 'nullable|string',
            'lantai_kelas' => 'nullable|string|max:100',
            'deskripsi'    => 'required|string|max:250',
            'foto_atas'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'foto_bawah'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'foto_kanan'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'foto_kiri'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'foto_depan'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'foto_belakang'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ], [
            'nama_barang.required'  => 'Nama barang wajib diisi.',
            'nama_barang.max'       => 'Nama barang maksimal 30 karakter.',
            'jenis_barang.required' => 'Jenis barang wajib dipilih.',
            'tempat_utama.required' => 'Pilihan tempat wajib dipilih.',
            'deskripsi.required'    => 'Deskripsi kerusakan wajib diisi.',
            'deskripsi.max'         => 'Deskripsi maksimal 250 karakter.',
        ]);

        $sisi = ['atas', 'bawah', 'kanan', 'kiri', 'depan', 'belakang'];
        $fotoPaths = [];

        // Simpan foto dari file picker
        foreach ($sisi as $s) {
            $key = 'foto_' . $s;
            if ($request->hasFile($key)) {
                $fotoPaths[$key] = $request->file($key)->store('laporan', 'public');
            }
        }

        // Simpan foto dari webcam (base64)
        foreach ($sisi as $s) {
            $key = 'foto_' . $s;
            $base64Key = 'base64_foto_' . $s;
            if (!isset($fotoPaths[$key]) && $request->filled($base64Key)) {
                $imageData = $request->input($base64Key);
                $imageData = str_replace('data:image/jpeg;base64,', '', $imageData);
                $imageData = base64_decode($imageData);
                $filename = 'laporan/' . uniqid() . '.jpg';
                \Storage::disk('public')->put($filename, $imageData);
                $fotoPaths[$key] = $filename;
            }
        }

        // Validasi minimal 3 foto
        if (count($fotoPaths) < 3) {
            return back()->withInput()
                         ->withErrors(['foto_atas' => 'Minimal 3 foto kerusakan harus diunggah.']);
        }

        $tempatLabel = $request->tempat_utama;
        if ($request->sub_lokasi) {
            $tempatLabel .= ' - ' . $request->sub_lokasi;
        }
        if ($request->lantai_kelas) {
            $tempatLabel .= ' (' . $request->lantai_kelas . ')';
        }

        Laporan::create([
            'user_id'       => auth()->id(),
            'nama_barang'   => $request->nama_barang,
            'jenis_barang'  => $request->jenis_barang,
            'tempat_utama'  => $request->tempat_utama,
            'sub_lokasi'    => $request->sub_lokasi,
            'lantai_kelas'  => $request->lantai_kelas,
            'tempat_label'  => $tempatLabel,
            'deskripsi'     => $request->deskripsi,
            'foto_atas'     => $fotoPaths['foto_atas'] ?? null,
            'foto_bawah'    => $fotoPaths['foto_bawah'] ?? null,
            'foto_kanan'    => $fotoPaths['foto_kanan'] ?? null,
            'foto_kiri'     => $fotoPaths['foto_kiri'] ?? null,
            'foto_depan'    => $fotoPaths['foto_depan'] ?? null,
            'foto_belakang' => $fotoPaths['foto_belakang'] ?? null,
            'status'        => 'menunggu',
            'nomor_tiket'   => 'SMF-' . strtoupper(uniqid()),
        ]);

        return redirect()->route('laporan.create')
                         ->with('success', 'Laporan berhasil dikirim! Tim kami akan segera menindaklanjuti.');
    }

    public function success($id)
    {
        $laporan = Laporan::findOrFail($id);
        return view('laporan.success', compact('laporan'));
    }

    public function index()
    {
        $laporans = Laporan::where('user_id', auth()->id())
                           ->orderByDesc('created_at')
                           ->paginate(10);
        return view('laporan.index', compact('laporans'));
    }

    public function laporanSaya(Request $request)
    {
        $query = Laporan::where('user_id', auth()->id())
                        ->orderByDesc('created_at');

        if ($request->tiket) {
            $query->where('nomor_tiket', 'like', '%' . $request->tiket . '%');
        }

        $laporans = $query->paginate(5);
        return view('laporan.laporan-saya', compact('laporans'));
    }

    public function edit($id)
    {
        $laporan = Laporan::where('user_id', auth()->id())->findOrFail($id);

        if ($laporan->status !== 'menunggu') {
            return redirect()->route('laporan.saya')
                             ->with('error', 'Laporan yang sudah diverifikasi tidak dapat diedit.');
        }

        return view('laporan.edit', compact('laporan'));
    }

    public function update(Request $request, $id)
    {
        $laporan = Laporan::where('user_id', auth()->id())->findOrFail($id);

        if ($laporan->status !== 'menunggu') {
            return redirect()->route('laporan.saya')
                             ->with('error', 'Laporan yang sudah diverifikasi tidak dapat diedit.');
        }

        $request->validate([
            'nama_barang'  => 'required|string|max:30',
            'jenis_barang' => 'required|in:elektronik,non-elektronik',
            'tempat_utama' => 'required|string',
            'sub_lokasi'   => 'nullable|string',
            'deskripsi'    => 'required|string|max:250',
            'foto_atas'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'foto_bawah'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'foto_kanan'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'foto_kiri'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'foto_depan'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'foto_belakang'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $sisi = ['atas', 'bawah', 'kanan', 'kiri', 'depan', 'belakang'];
        $fotoPaths = [];

        foreach ($sisi as $s) {
            $key = 'foto_' . $s;
            if ($request->hasFile($key)) {
                if ($laporan->$key) {
                    \Storage::disk('public')->delete($laporan->$key);
                }
                $fotoPaths[$key] = $request->file($key)->store('laporan', 'public');
            }
        }

        $tempatLabel = $request->tempat_utama;
        if ($request->sub_lokasi) {
            $tempatLabel .= ' - ' . $request->sub_lokasi;
        }

        $laporan->update(array_merge([
            'nama_barang'  => $request->nama_barang,
            'jenis_barang' => $request->jenis_barang,
            'tempat_utama' => $request->tempat_utama,
            'sub_lokasi'   => $request->sub_lokasi,
            'tempat_label' => $tempatLabel,
            'deskripsi'    => $request->deskripsi,
        ], $fotoPaths));

        return redirect()->route('laporan.saya')
                         ->with('success', 'Laporan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $laporan = Laporan::where('user_id', auth()->id())->findOrFail($id);

        if ($laporan->status !== 'menunggu') {
            return redirect()->route('laporan.saya')
                             ->with('error', 'Laporan yang sudah diverifikasi tidak dapat dihapus.');
        }

        $sisi = ['atas', 'bawah', 'kanan', 'kiri', 'depan', 'belakang'];
        foreach ($sisi as $s) {
            $field = 'foto_' . $s;
            if ($laporan->$field) {
                \Storage::disk('public')->delete($laporan->$field);
            }
        }

        $laporan->delete();

        return redirect()->route('laporan.saya')
                         ->with('success', 'Laporan berhasil dihapus.');
    }
}