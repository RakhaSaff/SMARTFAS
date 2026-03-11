@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Dashboard Admin</h1>
            <p class="text-gray-600 mt-2">Selamat datang, {{ Auth::guard('admin')->user()->name }} • {{ Auth::guard('admin')->user()->jabatan }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
                <div class="text-emerald-700 text-4xl font-bold mb-2">245</div>
                <div class="text-gray-600">Total Laporan</div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
                <div class="text-orange-600 text-4xl font-bold mb-2">87</div>
                <div class="text-gray-600">Menunggu Penanganan</div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
                <div class="text-emerald-600 text-4xl font-bold mb-2">158</div>
                <div class="text-gray-600">Sudah Selesai</div>
            </div>
        </div>

        <!-- Nanti tambah tabel laporan terbaru, chart, dll -->
    </div>
</div>
@endsection
