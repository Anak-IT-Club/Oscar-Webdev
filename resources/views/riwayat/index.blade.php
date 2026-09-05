@extends('layouts.app')

@section('title', 'Riwayat Setoran')

@section('content')
    <div class="dash-head">
        <div>
            <h1 class="dash-title">Riwayat Setoran 📜</h1>
            <p class="dash-sub">Semua sampah yang kamu setor beserta status validasinya.</p>
        </div>
    </div>

    <div class="row g-3 mb-3 reveal">
        <div class="col-6 col-lg-4">
            <div class="dash-card dash-stat">
                <span class="icon"><i class="bi bi-check-circle"></i></span>
                <div>
                    <div class="num">{{ number_format($totalDisetujui, 0, ',', '.') }}</div>
                    <div class="label">Setoran Sah</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-4">
            <div class="dash-card dash-stat">
                <span class="icon"><i class="bi bi-coin"></i></span>
                <div>
                    <div class="num">{{ number_format($poinDidapat, 0, ',', '.') }}</div>
                    <div class="label">Poin dari Setoran</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="dash-card dash-stat">
                <span class="icon"><i class="bi bi-hourglass-split"></i></span>
                <div>
                    <div class="num">{{ number_format($menunggu, 0, ',', '.') }}</div>
                    <div class="label">Menunggu Validasi</div>
                </div>
            </div>
        </div>
    </div>

    <div class="dash-card p-4 reveal" style="height:auto;">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width:64px;">Foto</th>
                        <th>Jenis Sampah</th>
                        <th>Poin</th>
                        <th>Sumber</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($setorans as $s)
                        <tr>
                            <td>
                                @if ($s->foto)
                                    <a href="{{ asset('foto_setoran/'.$s->foto) }}" target="_blank" rel="noopener">
                                        <img src="{{ asset('foto_setoran/'.$s->foto) }}" alt="Foto"
                                             style="width:48px;height:48px;object-fit:cover;border-radius:8px;">
                                    </a>
                                @else
                                    <span class="text-muted"><i class="bi bi-dash"></i></span>
                                @endif
                            </td>
                            <td class="fw-semibold">{{ $s->jenis_sampah }}</td>
                            <td>
                                @if ($s->status === 'disetujui')
                                    <span class="fw-semibold" style="color:var(--smart-green-dark)">+{{ number_format($s->poin, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-muted">{{ number_format($s->poin, 0, ',', '.') }}</span>
                                @endif
                            </td>
                            <td>
                                @if ($s->sumber === 'ai')
                                    <span class="badge text-bg-info"><i class="bi bi-robot me-1"></i>Scan AI</span>
                                @elseif ($s->sumber === 'smartbin')
                                    <span class="badge text-bg-primary"><i class="bi bi-cpu me-1"></i>SmartBin</span>
                                @else
                                    <span class="badge text-bg-secondary">Petugas</span>
                                @endif
                            </td>
                            <td>
                                @if ($s->status === 'pending')
                                    <span class="badge text-bg-warning"><i class="bi bi-hourglass-split me-1"></i>Menunggu</span>
                                @elseif ($s->status === 'ditolak')
                                    <span class="badge text-bg-danger"><i class="bi bi-x-lg me-1"></i>Ditolak</span>
                                @else
                                    <span class="badge text-bg-success"><i class="bi bi-check-lg me-1"></i>Sah</span>
                                @endif
                            </td>
                            <td class="small">{{ $s->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Belum ada setoran. Yuk mulai scan sampahmu di menu <strong>Scan Sampah (AI)</strong>!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($setorans->hasPages())
            <div class="mt-3">{{ $setorans->links('pagination::bootstrap-5') }}</div>
        @endif
    </div>
@endsection
