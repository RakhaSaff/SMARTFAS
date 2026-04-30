<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Dashboard Admin - SMARTFAS Saintek</title>
    <!-- Gunakan CDN Tailwind untuk cepat tes (atau pakai vite kalau sudah setup) -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen antialiased">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- Header -->
        <div class="mb-10">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900">
                Dashboard Admin SMARTFAS
            </h1>
            <p class="mt-2 text-lg text-gray-600">
                Selamat datang, {{ $admin_name ?? 'Admin Preview' }} • {{ $jabatan ?? 'Developer (Preview Mode)' }}
            </p>
        </div>

        <!-- Statistik Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow border border-gray-200 p-6 hover:shadow-lg transition">
                <div class="text-emerald-600 text-5xl font-bold mb-2">{{ $stats['total_laporan'] ?? '0' }}</div>
                <div class="text-gray-700 font-medium">Total Laporan Kerusakan</div>
            </div>

            <div class="bg-white rounded-xl shadow border border-gray-200 p-6 hover:shadow-lg transition">
                <div class="text-orange-600 text-5xl font-bold mb-2">{{ $stats['pending'] ?? '0' }}</div>
                <div class="text-gray-700 font-medium">Menunggu Penanganan</div>
            </div>

            <div class="bg-white rounded-xl shadow border border-gray-200 p-6 hover:shadow-lg transition">
                <div class="text-emerald-700 text-5xl font-bold mb-2">{{ $stats['selesai'] ?? '0' }}</div>
                <div class="text-gray-700 font-medium">Sudah Selesai</div>
            </div>
        </div>

        <!-- Placeholder untuk konten lain (nanti tambah tabel/chart) -->
        <div class="mt-10 bg-white rounded-xl shadow border p-8">
            <h2 class="text-2xl font-semibold mb-4">Laporan Terbaru (Preview)</h2>
            <p class="text-gray-500">Belum ada data real. Ini hanya tampilan preview.</p>
        </div>
    </div>

</body>
</html>
