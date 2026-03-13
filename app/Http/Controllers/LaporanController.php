<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;

class LaporanController extends Controller
{
    /**
     * Tampilkan form buat laporan
     */
    public function create()
    {
        return view('laporan.create');
    }

    /**
     * Simpan laporan kerusakan
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang'  => 'required|string|max:30',
            'jenis_barang' => 'required|in:elektronik,non-elektronik',
            'tempat_utama' => 'required|string',
            'sub_lokasi'   => 'nullable|string',
            'lantai_kelas' => 'nullable|string|max:100',
            'deskripsi'    => 'required|string|max:250',
            'foto_atas'      => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'foto_bawah'     => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'foto_kanan'     => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'foto_kiri'      => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'foto_depan'     => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'foto_belakang'  => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ], [
            'nama_barang.required'   => 'Nama barang wajib diisi.',
            'nama_barang.max'        => 'Nama barang maksimal 30 karakter.',
            'jenis_barang.required'  => 'Jenis barang wajib dipilih.',
            'tempat_utama.required'  => 'Pilihan tempat wajib dipilih.',
            'deskripsi.required'     => 'Deskripsi kerusakan wajib diisi.',
            'deskripsi.max'          => 'Deskripsi maksimal 250 karakter.',
            'foto_atas.required'     => 'Foto sisi atas wajib diunggah.',
            'foto_bawah.required'    => 'Foto sisi bawah wajib diunggah.',
            'foto_kanan.required'    => 'Foto sisi kanan wajib diunggah.',
            'foto_kiri.required'     => 'Foto sisi kiri wajib diunggah.',
            'foto_depan.required'    => 'Foto sisi depan wajib diunggah.',
            'foto_belakang.required' => 'Foto sisi belakang wajib diunggah.',
        ]);

        // Simpan foto ke storage/app/public/laporan
        $sisi = ['atas', 'bawah', 'kanan', 'kiri', 'depan', 'belakang'];
        $fotoPaths = [];

        foreach ($sisi as $s) {
            $key = 'foto_' . $s;
            if ($request->hasFile($key)) {
                $fotoPaths[$key] = $request->file($key)->store('laporan', 'public');
            }
        }

        // Gabungkan nama tempat
        $tempatLabel = $request->tempat_utama;
        if ($request->sub_lokasi) {
            $tempatLabel .= ' - ' . $request->sub_lokasi;
        }
        if ($request->lantai_kelas) {
            $tempatLabel .= ' (' . $request->lantai_kelas . ')';
        }

        // Simpan ke database
        $laporan = Laporan::create([
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

        return redirect()->route('laporan.success', $laporan->id)
                         ->with('success', 'Laporan berhasil dikirim!');
    }

    /**
     * Halaman sukses setelah laporan terkirim
     */
    public function success($id)
    {
        $laporan = Laporan::findOrFail($id);
        return view('laporan.success', compact('laporan'));
    }

    /**
     * Daftar laporan milik user
     */
    public function index()
    {
        $laporans = Laporan::where('user_id', auth()->id())
                           ->orderByDesc('created_at')
                           ->paginate(10);
        return view('laporan.index', compact('laporans'));
    }
}
