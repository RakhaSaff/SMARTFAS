<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 fixed w-full z-50 shadow-sm">
    <div class="max-w-screen-lg mx-auto px-8 sm:px-12 lg:px-16">
<div class="flex items-center h-16 gap-8 lg:gap-10">

    <!-- Logo (tetap kiri) -->
    <a href="{{ route('home') }}" class="flex items-center gap-3 flex-shrink-0">
        <div class="w-10 h-10 bg-emerald-700 rounded-xl flex items-center justify-center text-white font-bold text-2xl shadow-md">
            S
        </div>
        <div class="font-bold text-xl md:text-2xl tracking-tight">
            <span class="text-gray-900">SMARTFAS</span>
            <span class="text-emerald-700">Saintek</span>
        </div>
    </a>

    <!-- Spacer: mendorong menu + auth ke kanan -->
    <div class="flex-1"></div>

    <!-- Desktop Menu -->
    <div class="hidden md:flex items-center gap-8 lg:gap-10 xl:gap-12 text-base font-medium text-gray-800">
        <a href="{{ route('home') }}" class="hover:text-emerald-700 transition-colors duration-200">Beranda</a>
        <a href="{{ route('laporan.create') }}" class="hover:text-emerald-700 transition-colors duration-200">Laporkan Kerusakan</a>
        <a href="#" class="hover:text-emerald-700 transition-colors duration-200">Status Laporan</a>
        <a href="#" class="hover:text-emerald-700 transition-colors duration-200">Monitoring</a>
        <a href="#" class="hover:text-emerald-700 transition-colors duration-200">Panduan</a>
    </div>

    <!-- Auth Buttons -->
    <div class="hidden md:flex items-center gap-4 lg:gap-6">
        <a href="{{ route('login') }}"
           class="px-6 py-2.5 text-gray-700 hover:text-emerald-700 font-semibold transition-colors duration-200 text-base">
            Masuk
        </a>
        <a href="{{ route('register') }}"
           class="px-8 py-3 bg-emerald-700 hover:bg-emerald-800 text-white font-semibold rounded-xl shadow-md transition-all duration-200 hover:shadow-lg text-base">
            Daftar
        </a>
    </div>

    <!-- Hamburger (mobile) -->
    <button @click="open = !open" class="md:hidden text-gray-700 text-2xl focus:outline-none focus:text-emerald-700">
        <i class="fa-solid" :class="open ? 'fa-xmark' : 'fa-bars'"></i>
    </button>

</div>

    <!-- Mobile Menu - tetap sama, tapi bisa ditambah padding jika perlu -->
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="md:hidden bg-white border-t shadow-lg">
        <div class="px-6 py-8 space-y-6 text-base font-medium text-gray-800">
            <a href="{{ route('home') }}" class="block hover:text-emerald-700 transition">Beranda</a>
            <a href="{{ route('laporan.create') }}" class="block hover:text-emerald-700 transition">Laporkan Kerusakan</a>
            <a href="#" class="block hover:text-emerald-700 transition">Status Laporan</a>
            <a href="#" class="block hover:text-emerald-700 transition">Monitoring</a>
            <a href="#" class="block hover:text-emerald-700 transition">Panduan</a>
            <div class="pt-6 border-t space-y-4">
                <a href="{{ route('login') }}"
                   class="block text-center py-3 text-gray-700 font-semibold hover:text-emerald-700 transition">
                    Masuk
                </a>
                <a href="{{ route('register') }}"
                   class="block text-center py-3 bg-emerald-700 text-white font-semibold rounded-xl hover:bg-emerald-800 transition">
                    Daftar
                </a>
            </div>
        </div>
    </div>
</nav>
