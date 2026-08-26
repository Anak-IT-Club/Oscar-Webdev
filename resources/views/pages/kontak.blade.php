@extends('layouts.landing')

@section('content')
    @include('partials.navbar')

    <section id="kontak" class="bg-soft-green" style="padding-top: calc(var(--smart-navbar-h) + 56px); padding-bottom: 72px;">
        <div class="decor-layer" aria-hidden="true">
            <i class="bi bi-leaf-fill decor decor--leaf float" style="top:10%; right:5%; font-size:2.2rem; --rot:15deg;"></i>
            <i class="bi bi-envelope decor decor--recycle spin-slow" style="bottom:8%; left:3%; font-size:3rem; opacity:.07;"></i>
        </div>
        <div class="container">
            <div class="text-center reveal">
                <span class="text-uppercase fw-semibold" style="color:var(--smart-accent);letter-spacing:.08em;">Kontak</span>
                <h2 class="section-title mt-2">Hubungi Kami</h2>
                <p class="section-subtitle">Punya pertanyaan atau ingin memasang Smart Site di sekolahmu? Hubungi kami atau kirim pesan langsung.</p>
            </div>

            <div class="row g-4 mt-2 align-items-start">
                <!-- Kiri: penjelasan & info kontak -->
                <div class="col-lg-7 reveal">
                    <div class="contact-card h-100">
                        <h5 class="fw-bold mb-3" style="color:var(--smart-green-dark)">Informasi Kontak</h5>
                        <p style="color:var(--smart-muted)">
                            Smart Site adalah tong sampah pintar berbasis IoT &amp; AI yang dikembangkan oleh
                            siswa <strong>SMK Islam Malahayati</strong>. Kalau kamu punya pertanyaan, ingin
                            melihat demo, atau memasang Smart Site di sekolahmu, silakan hubungi kami lewat
                            informasi di bawah atau kirim pesan langsung.
                        </p>
                        <ul class="list-unstyled mb-0 contact-info mt-3" style="color:var(--smart-muted)">
                            <li>
                                <span class="ci-icon"><i class="bi bi-mortarboard"></i></span>
                                <div>
                                    <div class="fw-semibold" style="color:var(--smart-green-dark)">Smart Site &mdash; SMK Islam Malahayati</div>
                                    <div class="small">Proyek siswa jurusan Rekayasa Perangkat Lunak</div>
                                </div>
                            </li>
                            <li>
                                <span class="ci-icon"><i class="bi bi-geo-alt"></i></span>
                                <div>
                                    <div class="fw-semibold" style="color:var(--smart-green-dark)">Alamat</div>
                                    <div class="small">Jl. Pendidikan No. 1, Kota Contoh (placeholder)</div>
                                </div>
                            </li>
                            <li>
                                <span class="ci-icon"><i class="bi bi-envelope"></i></span>
                                <div>
                                    <div class="fw-semibold" style="color:var(--smart-green-dark)">Email</div>
                                    <div class="small">smart.site@malahayati.sch.id</div>
                                </div>
                            </li>
                            <li>
                                <span class="ci-icon"><i class="bi bi-telephone"></i></span>
                                <div>
                                    <div class="fw-semibold" style="color:var(--smart-green-dark)">WhatsApp</div>
                                    <div class="small">0812-3456-7890 (placeholder)</div>
                                </div>
                            </li>
                            <li>
                                <span class="ci-icon"><i class="bi bi-clock"></i></span>
                                <div>
                                    <div class="fw-semibold" style="color:var(--smart-green-dark)">Jam Operasional</div>
                                    <div class="small">Senin&ndash;Jumat, 07.30&ndash;15.30</div>
                                </div>
                            </li>
                        </ul>

                        <div class="social mt-3">
                            <a href="#" aria-label="Instagram" class="me-2"><i class="bi bi-instagram"></i></a>
                            <a href="#" aria-label="YouTube" class="me-2"><i class="bi bi-youtube"></i></a>
                            <a href="#" aria-label="TikTok" class="me-2"><i class="bi bi-tiktok"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Kanan: form kirim pesan (~40%) -->
                <div class="col-lg-5 reveal" style="transition-delay:.1s">
                    <div class="contact-card h-100">
                        <h5 class="fw-bold mb-3" style="color:var(--smart-green-dark)">Kirim Pesan</h5>
                        <form action="mailto:smart.site@malahayati.sch.id" method="post" enctype="text/plain">
                            <div class="mb-3">
                                <label for="cName" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="cName" name="nama" placeholder="Nama lengkap">
                            </div>
                            <div class="mb-3">
                                <label for="cEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="cEmail" name="email" placeholder="email@contoh.com">
                            </div>
                            <div class="mb-3">
                                <label for="cMsg" class="form-label">Pesan</label>
                                <textarea class="form-control" id="cMsg" name="pesan" rows="4" placeholder="Tulis pesan kamu..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-cta-primary">
                                <i class="bi bi-send me-1"></i> Kirim Pesan
                            </button>
                            <span class="small ms-2" style="color:var(--smart-muted)">Akan membuka aplikasi email kamu.</span>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('partials.footer')
@endsection
