@extends('layouts.app')

@section('title', 'SMARTFAS Saintek | Pelaporan Fasilitas Cepat')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap');

    .hero-section * {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Pulse dot animation */
    @keyframes pulse-dot {
        0%, 100% { opacity: 1; transform: scale(1); }
        50%      { opacity: 0.5; transform: scale(1.4); }
    }
    .animate-pulse-dot {
        animation: pulse-dot 2s ease-in-out infinite;
    }

    /* Fade in up animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(40px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-up-1 { animation: fadeInUp 0.8s 0.1s  both; }
    .fade-up-2 { animation: fadeInUp 0.8s 0.2s  both; }
    .fade-up-3 { animation: fadeInUp 0.8s 0.35s both; }
    .fade-up-4 { animation: fadeInUp 0.8s 0.5s  both; }
    .fade-up-5 { animation: fadeInUp 0.8s 0.65s both; }

    /* Arrow hover effect */
    .btn-primary .arrow {
        display: inline-block;
        transition: transform 0.25s ease;
    }
    .btn-primary:hover .arrow {
        transform: translateX(8px);
    }
</style>
<!-- Hero Section -->
<section
    class="hero-section relative min-h-screen flex items-center justify-center pt-20 md:pt-24 overflow-hidden"
    style="background: linear-gradient(135deg, #10b981 0%, #34d399 40%, #f59e0b 100%);"
>
    <!-- Decorative blobs -->
    <div class="absolute top-10 rounded-full pointer-events-none"
         style="left:-80px; width:24rem; height:24rem; background:rgba(110,231,183,0.35); filter:blur(80px);"></div>
    <div class="absolute bottom-10 rounded-full pointer-events-none"
         style="right:-80px; width:20rem; height:20rem; background:rgba(251,191,36,0.35); filter:blur(80px);"></div>
    <div class="absolute rounded-full pointer-events-none"
         style="top:50%; left:50%; transform:translate(-50%,-50%); width:700px; height:400px; background:rgba(255,255,255,0.08); filter:blur(60px);"></div>

    <div class="relative z-10 max-w-5xl mx-auto px-6 lg:px-8 text-center" style="color:#111827;">
        <div class="max-w-4xl mx-auto">

            <!-- Badge -->
            <div class="fade-up-1 inline-flex items-center gap-3 mb-10"
                 style="background:rgba(255,255,255,0.80); backdrop-filter:blur(8px);
                        padding:0.75rem 1.5rem; border-radius:9999px;
                        border:1px solid rgba(255,255,255,0.40);
                        box-shadow:0 4px 16px rgba(0,0,0,0.08);
                        font-size:0.875rem; font-weight:600;">
                <span class="animate-pulse-dot"
                      style="width:12px; height:12px; background:#10b981; border-radius:50%; display:inline-block;"></span>
                FAKULTAS SAINS &amp; TEKNOLOGI — UIN SUNAN AMPEL SURABAYA
            </div>

            <!-- Judul -->
            <h1 class="fade-up-2"
                style="font-size:clamp(2.8rem,7vw,4.5rem); font-weight:900;
                       line-height:1.1; letter-spacing:-0.02em; margin-bottom:1.5rem;">
                Kerusakan Fasilitas?<br>
                <span style="color:#b45309;">Laporkan Sekarang</span>
            </h1>

            <!-- Deskripsi -->
            <p class="fade-up-3"
               style="font-size:1.15rem; color:#1f2937; max-width:42rem;
                      margin:0 auto 3rem; line-height:1.75;">
                Aplikasi khusus Fakultas Saintek UINSA.<br>
                Foto via Android → Prioritas dibantu AI → Penugasan teknisi → Progres real-time → Arsip otomatis.
            </p>

            <!-- CTA Buttons -->
            <div class="fade-up-4" style="display:flex; flex-wrap:wrap; justify-content:center; gap:1.5rem; margin-bottom:4rem;">

                <a href="{{ route('laporan.create') }}"
                   class="btn-primary"
                   style="display:inline-flex; align-items:center; justify-content:center;
                          padding:1.25rem 3rem; background:#ffffff; color:#065f46;
                          font-weight:800; font-size:1.15rem; border-radius:9999px;
                          box-shadow:0 8px 30px rgba(0,0,0,0.15); text-decoration:none;
                          transition: transform 0.2s, box-shadow 0.2s;"
                   onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 12px 40px rgba(0,0,0,0.2)';"
                   onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 30px rgba(0,0,0,0.15)';">
                    LAPORKAN KERUSAKAN
                    <span class="arrow" style="margin-left:0.75rem;">→</span>
                </a>

                <a href="#cara-kerja"
                   style="display:inline-flex; align-items:center; justify-content:center;
                          padding:1.25rem 3rem; background:transparent;
                          border:2px solid #111827; color:#111827;
                          font-weight:800; font-size:1.15rem; border-radius:9999px;
                          text-decoration:none; transition: background 0.2s, color 0.2s;"
                   onmouseover="this.style.background='#111827'; this.style.color='#ffffff';"
                   onmouseout="this.style.background='transparent'; this.style.color='#111827';">
                    Lihat Cara Kerja
                </a>
            </div>

            <!-- Trust icons -->
            <div class="fade-up-5" style="display:flex; flex-wrap:wrap; justify-content:center; gap:2rem;">

                <div style="display:flex; align-items:center; gap:1rem;
                            background:rgba(255,255,255,0.60); backdrop-filter:blur(8px);
                            padding:1rem 1.5rem; border-radius:1rem;
                            box-shadow:0 4px 16px rgba(0,0,0,0.08);">
                    <div style="width:3.5rem; height:3.5rem; border-radius:0.75rem;
                                background:#059669; color:#fff; display:flex;
                                align-items:center; justify-content:center;
                                font-size:1.75rem; box-shadow:0 2px 8px rgba(0,0,0,0.15);">
                        📸
                    </div>
                    <span style="font-weight:600;">Foto via Android</span>
                </div>

                <div style="display:flex; align-items:center; gap:1rem;
                            background:rgba(255,255,255,0.60); backdrop-filter:blur(8px);
                            padding:1rem 1.5rem; border-radius:1rem;
                            box-shadow:0 4px 16px rgba(0,0,0,0.08);">
                    <div style="width:3.5rem; height:3.5rem; border-radius:0.75rem;
                                background:#d97706; color:#fff; display:flex;
                                align-items:center; justify-content:center;
                                font-size:1.75rem; box-shadow:0 2px 8px rgba(0,0,0,0.15);">
                        🛠️
                    </div>
                    <span style="font-weight:600;">Proses Cepat + AI</span>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection