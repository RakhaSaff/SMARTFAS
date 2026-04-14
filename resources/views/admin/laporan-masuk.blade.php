@extends('layouts.admin')

@section('title', 'Laporan Masuk — SMARTFAS Admin')
@section('page-title', 'Laporan Masuk')
@section('page-subtitle', 'Kelola & verifikasi laporan kerusakan fasilitas')

@section('content')

{{-- Filter & Search --}}
<div class="card mb-6 fade-in fade-in-1">
    <div class="p-5 flex flex-wrap gap-3 items-center justify-between">
        <div class="flex flex-wrap gap-3">
            {{-- Filter Tingkat --}}
            <select name="tingkat" onchange="this.form.submit()"
                    class="text-sm border border-gray-200 rounded-lg px-3 py-2 text-gray-600 focus:outline-none focus:border-emerald-400 bg-white">
                <option value="">Semua Tingkat</option>
                <option value="rendah" {{ request('tingkat') == 'rendah' ? 'selected' : '' }}>Rendah</option>
                <option value="sedang" {{ request('tingkat') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                <option value="tinggi" {{ request('tingkat') == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
            </select>

            {{-- Filter Status --}}
            <select name="status" onchange="this.form.submit()"
                    class="text-sm border border-gray-200 rounded-lg px-3 py-2 text-gray-600 focus:outline-none focus:border-emerald-400 bg-white">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
        </div>

        {{-- Search --}}
        <form method="GET" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari laporan..."
                   class="text-sm border border-gray-200 rounded-lg px-3 py-2 w-56 focus:outline-none focus:border-emerald-400">
            <button type="submit"
                    class="px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm font-semibold hover:bg-emerald-700 transition">
                <i class="fa-solid fa-search"></i>
            </button>
        </form>
    </div>
</div>

{{-- Table --}}
<div class="card fade-in fade-in-2">
    <div class="card-header">
        <div>
            <p class="card-title">Daftar Laporan Masuk</p>
            <p class="text-xs text-gray-400 mt-0.5">Total {{ $laporan->total() ?? 0 }} laporan</p>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Pelapor</th>
                    <th>Fasilitas / Barang</th>
                    <th>Lokasi</th>
                    <th>Foto</th>
                    <th>Tingkat Kerusakan</th>
                    <th>Status</th>
                    <th>Waktu Upload</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporan ?? [] as $item)
                <tr>
                    <td class="text-gray-400 text-xs font-mono">{{ $loop->iteration }}</td>
                    <td>
                        <div class="font-semibold text-sm text-gray-800">{{ $item->user->name }}</div>
                        <div class="text-xs text-gray-400">{{ $item->user->email }}</div>
                    </td>
                    <td>
                        <div class="font-medium text-gray-800">{{ $item->nama_barang }}</div>
                        <div class="text-xs text-gray-400">{{ $item->jenis_barang }}</div>
                    </td>
                    <td class="text-sm text-gray-600">
                        {{ ucwords(str_replace('_', ' ', $item->tempat_label ?? $item->tempat_utama ?? '-')) }}
                    </td>
                    <td>
                        @php
                            $fotoPreview = $item->foto_atas ?? $item->foto_depan ?? $item->foto_kanan ??
                                           $item->foto_kiri ?? $item->foto_bawah ?? $item->foto_belakang ?? null;
                        @endphp
                        @if($fotoPreview)
                            <img src="{{ asset('storage/' . $fotoPreview) }}"
                                 class="w-14 h-10 object-cover rounded-lg border cursor-pointer hover:opacity-80 transition"
                                 onclick="openPhoto('{{ asset('storage/' . $fotoPreview) }}')">
                        @else
                            <span class="text-gray-300 text-xs">—</span>
                        @endif
                    </td>
                    <td>
                        @if($item->tingkat_kerusakan === 'tinggi')
                            <span class="badge badge-tinggi"><i class="fa-solid fa-circle-exclamation"></i> Tinggi</span>
                        @elseif($item->tingkat_kerusakan === 'sedang')
                            <span class="badge badge-sedang"><i class="fa-solid fa-triangle-exclamation"></i> Sedang</span>
                        @else
                            <span class="badge badge-rendah"><i class="fa-solid fa-circle-info"></i> Rendah</span>
                        @endif
                    </td>
                    <td>
                        @if($item->status === 'pending')
                            <span class="badge badge-pending">Pending</span>
                        @elseif($item->status === 'diproses')
                            <span class="badge badge-diproses">Diproses</span>
                        @else
                            <span class="badge badge-selesai">Selesai</span>
                        @endif
                    </td>
                    <td class="text-xs text-gray-500">
                        <div class="font-medium">{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</div>
                        <div class="text-gray-400">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y, H:i') }}</div>
                    </td>
                    <td>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.laporan-masuk.show', $item->id) }}"
                               class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg transition">
                                <i class="fa-solid fa-eye"></i> Detail
                            </a>
                            @if($item->status === 'pending')
                            <form method="POST" action="{{ route('admin.laporan-masuk.verifikasi', $item->id) }}">
                                @csrf @method('PATCH')
                                <button type="submit"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold bg-emerald-50 hover:bg-emerald-100 text-emerald-700 rounded-lg transition">
                                    <i class="fa-solid fa-check"></i> Verifikasi
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-14 text-gray-400">
                        <i class="fa-solid fa-inbox text-4xl mb-3 block"></i>
                        <p class="font-medium">Belum ada laporan masuk</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if(isset($laporan) && $laporan->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $laporan->links() }}
    </div>
    @endif
</div>

{{-- Modal Photo --}}
<div id="photoModal" onclick="closePhoto()"
     class="fixed inset-0 bg-black/70 z-[200] hidden items-center justify-center p-6">
    <img id="photoModalImg" src="" class="max-w-2xl max-h-[80vh] rounded-xl shadow-2xl object-contain">
</div>

@endsection

@push('scripts')
<script>
function openPhoto(src) {
    document.getElementById('photoModalImg').src = src;
    document.getElementById('photoModal').classList.remove('hidden');
    document.getElementById('photoModal').classList.add('flex');
}
function closePhoto() {
    document.getElementById('photoModal').classList.add('hidden');
    document.getElementById('photoModal').classList.remove('flex');
}
</script>
@endpush