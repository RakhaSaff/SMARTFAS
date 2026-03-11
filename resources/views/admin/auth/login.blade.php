@extends('layouts.admin')  <!-- buat layout khusus admin nanti -->

@section('content')
<div class="min-h-screen bg-gradient-to-br from-emerald-50 via-white to-orange-50 flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 border border-emerald-100">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-emerald-700 text-white rounded-xl text-3xl font-bold mb-4 shadow-md">
                A
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Admin SMARTFAS Saintek</h1>
            <p class="text-gray-600 mt-2">Akses panel pengelolaan fasilitas</p>
        </div>

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                <input type="text" name="username" required autofocus
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                       placeholder="admin.saintek" />
                @error('username') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mb-8">
                <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input type="password" name="password" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition" />
                @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <button type="submit"
                    class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-semibold py-3 rounded-lg transition shadow-md hover:shadow-lg">
                Masuk ke Dashboard
            </button>
        </form>

        <div class="mt-6 text-center text-sm text-gray-600">
            Belum punya akun admin?
            <a href="{{ route('admin.register') }}" class="text-emerald-700 hover:underline font-medium">Daftar</a>
        </div>
    </div>
</div>
@endsection
