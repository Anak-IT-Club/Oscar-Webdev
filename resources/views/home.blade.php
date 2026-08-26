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
