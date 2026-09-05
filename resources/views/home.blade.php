@extends('layouts.app')

@section('content')
<div class="reveal">
    <div class="dash-head">
        <div>
            <h1 class="dash-title">Dashboard</h1>
            <p class="dash-sub">Halo, {{ Auth::user()->nama }} 👋</p>
        </div>
        <span class="dash-role">{{ ucfirst(Auth::user()->role) }}</span>
    </div>

    @if (auth()->user()->role === 'admin')
        <div class="row g-3">
            <div class="col-sm-6 col-xl-4">
                <div class="dash-card dash-stat">
                    <span class="icon"><i class="bi bi-people-fill"></i></span>
                    <div>
                        <div class="num">{{ $totalUsers }}</div>
                        <div class="label">Total User</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-4">
                <div class="dash-card dash-stat">
                    <span class="icon"><i class="bi bi-mortarboard-fill"></i></span>
                    <div>
                        <div class="num">{{ $totalSiswa }}</div>
                        <div class="label">Siswa</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-4">
                <div class="dash-card dash-stat">
                    <span class="icon"><i class="bi bi-coin"></i></span>
                    <div>
                        <div class="num">{{ number_format($totalPoin, 0, ',', '.') }}</div>
                        <div class="label">Total Poin</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mt-1">
            <div class="col-lg-8">
                <div class="dash-card p-4">
                    <h2 class="dash-title h5">Selamat datang di Smart Site</h2>
                    <p class="dash-sub mb-3">Kelola pengguna dan pantau progres kebersihan sekolah lewat sistem tong sampah pintar berbasis IoT &amp; AI.</p>
                    <a href="{{ route('users.index') }}" class="btn btn-cta-primary">
                        <i class="bi bi-people-fill me-1"></i> Kelola User
                    </a>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="dash-card green p-4 d-flex flex-column justify-content-center">
                    <div class="dash-sub">Poin terkumpul</div>
                    <div class="num">{{ number_format($totalPoin, 0, ',', '.') }}</div>
                    <div class="dash-sub">dari seluruh siswa 🎉</div>
                </div>
            </div>
        </div>

        <div class="row g-3 mt-1">
            <div class="col-lg-5">
                <div class="dash-card p-4 h-100">
                    <h2 class="dash-title h6 mb-3">Poin per Jenis Sampah</h2>
                    <div style="position:relative; height:260px;">
                        <canvas id="chartJenis"
                                data-labels='@json($jenisLabels)' data-values='@json($jenisData)'></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="dash-card p-4 h-100">
                    <h2 class="dash-title h6 mb-3">Tren Setoran 7 Hari Terakhir</h2>
                    <div style="position:relative; height:260px;">
                        <canvas id="chartTren"
                                data-labels='@json($trenLabels)' data-values='@json($trenData)'></canvas>
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                if (typeof window.Chart === 'undefined') return;
                var green = '#1f7a3d', accent = '#34a853';

                var cj = document.getElementById('chartJenis');
                if (cj) {
                    new window.Chart(cj, {
                        type: 'doughnut',
                        data: {
                            labels: JSON.parse(cj.dataset.labels),
                            datasets: [{
                                data: JSON.parse(cj.dataset.values),
                                backgroundColor: ['#34a853', '#1f7a3d', '#0f4821', '#8bc34a'],
                                borderWidth: 0
                            }]
                        },
                        options: {
                            maintainAspectRatio: false,
                            plugins: { legend: { position: 'bottom' } },
                            cutout: '62%'
                        }
                    });
                }

                var ct = document.getElementById('chartTren');
                if (ct) {
                    new window.Chart(ct, {
                        type: 'bar',
                        data: {
                            labels: JSON.parse(ct.dataset.labels),
                            datasets: [{
                                label: 'Poin',
                                data: JSON.parse(ct.dataset.values),
                                backgroundColor: accent,
                                borderRadius: 6,
                                maxBarThickness: 42
                            }]
                        },
                        options: {
                            maintainAspectRatio: false,
                            plugins: { legend: { display: false } },
                            scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
                        }
                    });
                }
            });
        </script>
        @endpush
    @else
        <div class="row g-3">
            <div class="col-sm-6 col-xl-4">
                <div class="dash-card dash-stat">
                    <span class="icon"><i class="bi bi-coin"></i></span>
                    <div>
                        <div class="num">{{ number_format(Auth::user()->poin, 0, ',', '.') }}</div>
                        <div class="label">Poin Saya</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-4">
                <div class="dash-card dash-stat">
                    <span class="icon"><i class="bi bi-mortarboard-fill"></i></span>
                    <div>
                        <div class="num">{{ Auth::user()->kelas }}</div>
                        <div class="label">Kelas</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-4">
                <div class="dash-card dash-stat">
                    <span class="icon"><i class="bi bi-diagram-3-fill"></i></span>
                    <div>
                        <div class="num">{{ Auth::user()->jurusan }}</div>
                        <div class="label">Jurusan</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mt-1">
            <div class="col-lg-8">
                <div class="dash-card p-4">
                    <h2 class="dash-title h5">Yuk buang sampah dengan benar 🌱</h2>
                    <p class="dash-sub mb-3">Setiap kali kamu memilah sampah di tong pintar, poin otomatis bertambah. Terus jaga lingkungan sekolah!</p>
                    <a href="{{ route('cara-kerja') }}" class="btn btn-cta-ghost">Cara kerja tong pintar</a>
                    <a href="{{ route('redeem.index') }}" class="btn btn-cta-primary">Tukar Poin</a>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="dash-card green p-4 d-flex flex-column justify-content-center">
                    <div class="dash-sub">Status</div>
                    <div class="num" style="font-size:2rem">Aktif</div>
                    <div class="dash-sub">keep it up! 💚</div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
