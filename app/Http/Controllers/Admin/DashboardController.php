<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Nanti tambah statistik: jumlah laporan, pending, selesai, dll
        $stats = [
            'total_laporan' => 245,
            'pending'       => 87,
            'selesai'       => 158,
            'admin_name'    => Auth::guard('admin')->user()->name,
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
