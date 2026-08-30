<footer id="footer" class="landing-footer mt-auto">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-5">
                <a href="{{ url('/') }}" class="d-inline-flex align-items-center gap-2 fw-bold fs-4 text-white text-decoration-none mb-2">
                    <span class="brand-badge" style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,var(--smart-accent),var(--smart-green-dark));color:#fff;display:inline-flex;align-items:center;justify-content:center;"><i class="bi bi-recycle"></i></span>
                    Smart Site
                </a>
                <p class="mb-0" style="color:rgba(255,255,255,.7)">
             Smart Site adalah aplikasi web yang dikembangkan oleh siswa SMK Islam Malahayati sebagai penghubung antara tong sampah pintar SMARTBIN dengan pengguna.
                </p>
                <p class="mt-2 mb-0">
                    <a href="https://smk.malahayatiislamicschool.sch.id/" target="_blank" rel="noopener noreferrer" class="footer-link">
                        <i class="bi bi-geo-alt-fill me-2"></i> SMK Islam Malahayati
                    </a>
                </p>
            </div>

            <div class="col-6 col-lg-3">
                <h6 class="fw-bold text-white">Menu</h6>
                <ul class="list-unstyled mb-0">
                    <li><a href="{{ route('tentang') }}">Tentang</a></li>
                    <li><a href="{{ route('cara-kerja') }}">Cara Kerja</a></li>
                    <li><a href="{{ route('kontak') }}">Kontak</a></li>
                    @auth
                        <li><a href="{{ route('home') }}">Dashboard</a></li>
                    @else
                        <li><a href="{{ route('login') }}">Login</a></li>
                    @endauth
                </ul>
            </div>

            <div class="col-6 col-lg-4">
                <h6 class="fw-bold text-white">Ikuti Kami</h6>
                <div class="social mb-3">
                    <a href="https://www.instagram.com/itclubsmk?igsi=MWdueWpsYnduZHBsMQ==" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    <a href="https://www.tiktok.com/@itclubsmk?_r=1&amp;_t=ZS-99ETsfIeCPA" target="_blank" rel="noopener noreferrer" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
                </div>
                <p class="mb-0" style="color:rgba(255,255,255,.7)">Team IT Club - SMK Islam Malahayati</p>
            </div>
        </div>

        <hr style="border-color:rgba(255,255,255,.15)">

        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
            <small style="color:rgba(255,255,255,.6)">&copy; {{ date('Y') }} Smart Site &middot; SMK Islam Malahayati. All rights reserved.</small>
            <small style="color:rgba(255,255,255,.6)">Dibangun untuk lingkungan yang lebih baik.</small>
        </div>
    </div>
</footer>
