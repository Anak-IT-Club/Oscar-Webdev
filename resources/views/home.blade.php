@extends('layouts.app')

@section('content')
    <div class="text-center reveal mb-4">
        <span class="text-uppercase fw-semibold" style="color:var(--smart-accent);letter-spacing:.08em;">Dashboard</span>
        <h2 class="section-title mt-2">Selamat datang, {{ Auth::user()->nama }}!</h2>
        <p class="section-subtitle">Sistem tong sampah pintar berbasis IoT &amp; AI untuk sekolah yang lebih hijau.</p>
    </div>

    @if (auth()->user()->role === 'admin')
        <div class="row g-4">
            <div class="col-md-4 reveal">
                <div class="feature-card p-4 text-center">
                    <i class="bi bi-people-fill" style="font-size:2rem;color:var(--smart-accent);"></i>
                    <div class="fw-bold mt-2" style="font-size:2.2rem;color:var(--smart-green-dark);">{{ $totalUsers }}</div>
                    <div class="text-muted">Total User</div>
                </div>
            </div>
            <div class="col-md-4 reveal" style="transition-delay:.1s">
                <div class="feature-card p-4 text-center">
                    <i class="bi bi-mortarboard-fill" style="font-size:2rem;color:var(--smart-accent);"></i>
                    <div class="fw-bold mt-2" style="font-size:2.2rem;color:var(--smart-green-dark);">{{ $totalSiswa }}</div>
                    <div class="text-muted">Siswa</div>
                </div>
            </div>
            <div class="col-md-4 reveal" style="transition-delay:.2s">
                <div class="feature-card p-4 text-center">
                    <i class="bi bi-coin" style="font-size:2rem;color:var(--smart-accent);"></i>
                    <div class="fw-bold mt-2" style="font-size:2.2rem;color:var(--smart-green-dark);">{{ number_format($totalPoin, 0, ',', '.') }}</div>
                    <div class="text-muted">Total Poin</div>
                </div>
            </div>
        </div>

        <div class="text-center mt-4 reveal">
            <a href="{{ route('users.index') }}" class="btn btn-cta-primary">
                <i class="bi bi-people-fill me-1"></i> Kelola User
            </a>
        </div>
    @endif
@endsection
