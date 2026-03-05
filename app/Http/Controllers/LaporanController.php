<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function create()
    {
        // Nanti tampilkan form laporan di sini
        return view('laporan.create');  // buat view ini nanti
    }

    public function store(Request $request)
    {
        // Validasi & simpan data laporan nanti
    }
}