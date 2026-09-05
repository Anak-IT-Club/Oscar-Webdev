@extends('layouts.app')

@section('title', 'Validasi Setoran')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3 reveal">
        <div>
            <span class="text-uppercase fw-semibold" style="color:var(--smart-accent);letter-spacing:.08em;">Verifikasi Petugas</span>
            <h2 class="section-title mt-1 mb-0">Validasi Setoran Siswa</h2>
        </div>
        <span class="dash-role">{{ number_format($pendingCount, 0, ',', '.') }} menunggu</span>
    </div>

    @if (session('success'))
        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
    @endif

    <div class="alert alert-light border" role="alert">
        <i class="bi bi-info-circle me-1"></i>
        Setoran hasil <strong>Scan AI</strong> dari siswa perlu diperiksa dulu. Lihat fotonya, pastikan sampah benar-benar disetor,
        lalu <strong>Setujui</strong> (poin masuk) atau <strong>Tolak</strong> (poin tidak masuk).
    </div>

    <div class="row g-3">
        @forelse ($pendings as $p)
            <div class="col-sm-6 col-lg-4">
                <div class="dash-card p-0 h-100" style="overflow:hidden;">
                    @if ($p->foto)
                        <a href="{{ asset('foto_setoran/'.$p->foto) }}" target="_blank" rel="noopener">
                            <img src="{{ asset('foto_setoran/'.$p->foto) }}" alt="Foto setoran"
                                 style="width:100%;height:190px;object-fit:cover;display:block;">
                        </a>
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-body-secondary" style="height:190px;">
                            <i class="bi bi-image text-muted" style="font-size:2rem;"></i>
                        </div>
                    @endif
                    <div class="p-3">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <div>
                                <div class="fw-semibold">{{ $p->user->nama ?? '-' }}</div>
                                <div class="small text-muted">{{ $p->user->kelas ?? '-' }} @if($p->user && $p->user->nisn) · {{ $p->user->nisn }} @endif</div>
                            </div>
                            <span class="badge text-bg-info"><i class="bi bi-robot me-1"></i>AI</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge text-bg-success">{{ $p->jenis_sampah }}</span>
                            <span class="fw-semibold" style="color:var(--smart-green-dark)">+{{ number_format($p->poin, 0, ',', '.') }} poin</span>
                        </div>
                        <div class="small text-muted mb-3"><i class="bi bi-clock me-1"></i>{{ $p->created_at->format('d M Y, H:i') }}</div>
                        <div class="d-flex gap-2">
                            <form action="{{ route('setoran.approve', $p) }}" method="POST" class="flex-fill"
                                  onsubmit="return confirm('Setujui setoran {{ $p->jenis_sampah }} (+{{ $p->poin }} poin) untuk {{ $p->user->nama ?? '' }}?');">
                                @csrf
                                <button class="btn btn-cta-primary w-100"><i class="bi bi-check-lg me-1"></i>Setujui</button>
                            </form>
                            <form action="{{ route('setoran.reject', $p) }}" method="POST"
                                  onsubmit="return confirm('Tolak setoran ini? Poin tidak akan diberikan.');">
                                @csrf
                                <button class="btn btn-outline-danger"><i class="bi bi-x-lg"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="dash-card p-5 text-center text-muted">
                    <i class="bi bi-check2-circle d-block mb-2" style="font-size:2.5rem;color:var(--smart-green)"></i>
                    Tidak ada setoran yang menunggu validasi. 🎉
                </div>
            </div>
        @endforelse
    </div>

    @if ($pendings->hasPages())
        <div class="mt-3">{{ $pendings->links('pagination::bootstrap-5') }}</div>
    @endif
@endsection
