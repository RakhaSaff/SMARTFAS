<footer class="footer relative overflow-hidden">

    {{-- Background foto gedung — SAMA persis dengan hero section --}}


    {{-- Overlay gelap agar teks mudah dibaca --}}
    <div class="absolute inset-0 z-10"
         style="background: linear-gradient(to bottom,
                    rgba(4, 80, 50, 0.72) 0%,
                    rgba(2, 50, 30, 0.88) 100%);">
    </div>

    {{-- Konten footer --}}
    <div class="relative z-20 max-w-7xl mx-auto px-6 lg:px-8 py-14 text-white">
        <div class="footer-info text-left max-w-3xl">

            <p style="font-size:1.6rem; font-weight:700; margin-bottom:0.6rem; line-height:1.3;">
                SMARTFAS Saintek – Fakultas Sains dan Teknologi
            </p>

            <p style="font-size:1.1rem; margin-bottom:1.75rem; opacity:0.85;">
                Universitas Islam Negeri Sunan Ampel Surabaya
            </p>

            <p style="font-size:1rem; margin-bottom:0.6rem;">
                Email:
                <a href="mailto:saintek@uinsby.ac.id"
                   style="color:#86efac; text-decoration:none; transition:color 0.2s;"
                   onmouseover="this.style.color='#ffffff';"
                   onmouseout="this.style.color='#86efac';">
                    saintek@uinsby.ac.id
                </a>
            </p>

            <p style="font-size:1rem;">
                Kunjungi website resmi:
                <a href="https://uinsa.ac.id/faculty-of-science-and-technology"
                   target="_blank" rel="noopener noreferrer"
                   style="color:#86efac; text-decoration:none; transition:color 0.2s;"
                   onmouseover="this.style.color='#ffffff';"
                   onmouseout="this.style.color='#86efac';">
                    Faculty of Science and Technology UINSA
                </a>
            </p>

        </div>
    </div>

    {{-- Bar hijau copyright --}}
    <div class="relative z-20 text-center py-4"
         style="background-color:#14532d;">
        <p style="font-size:0.875rem; color:rgba(255,255,255,0.85);">
            © 2026 Fakultas Sains dan Teknologi UINSA. All rights reserved.
        </p>
    </div>

</footer>

<style>
    .footer {
        font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
        margin-top: -1px;
    }

    @media (max-width: 768px) {
        .footer .footer-info {
            text-align: center !important;
        }
    }
</style>