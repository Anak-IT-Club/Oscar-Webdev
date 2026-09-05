@extends('layouts.app')

@section('title', 'Pencairan Poin')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3 reveal">
        <div>
            <span class="text-uppercase fw-semibold" style="color:var(--smart-accent);letter-spacing:.08em;">Bank Sampah Digital</span>
            <h2 class="section-title mt-1 mb-0">Pengajuan Pencairan</h2>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
    @endif

    <div class="row g-3 mb-3 reveal">
        <div class="col-6 col-lg-4">
            <div class="dash-card dash-stat">
                <span class="icon"><i class="bi bi-hourglass-split"></i></span>
                <div>
                    <div class="num">{{ number_format($pending, 0, ',', '.') }}</div>
                    <div class="label">Menunggu Persetujuan</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-4">
            <div class="dash-card dash-stat">
                <span class="icon"><i class="bi bi-cash-stack"></i></span>
                <div>
                    <div class="num" style="font-size:1.5rem;">Rp {{ number_format($totalDisetujui, 0, ',', '.') }}</div>
                    <div class="label">Total Dicairkan</div>
                </div>
            </div>
        </div>
    </div>

    <div class="contact-card p-4 reveal">
        <form method="GET" class="row g-2 align-items-end mb-3">
            <div class="col-12 col-md-4">
                <label class="form-label small text-muted mb-1">Status</label>
                <select name="status" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua</option>
                    <option value="pending" @selected(request('status')==='pending')>Menunggu</option>
                    <option value="disetujui" @selected(request('status')==='disetujui')>Disetujui</option>
                    <option value="ditolak" @selected(request('status')==='ditolak')>Ditolak</option>
                </select>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Siswa</th>
                        <th>Poin</th>
                        <th>Nominal</th>
                        <th>Metode</th>
                        <th>Tujuan</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pencairans as $p)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $p->user->nama ?? '-' }}</div>
                                <div class="small text-muted">{{ $p->user->kelas ?? '-' }}</div>
                            </td>
                            <td>{{ number_format($p->poin, 0, ',', '.') }}</td>
                            <td class="fw-semibold" style="color:var(--smart-green-dark)">Rp {{ number_format($p->nominal, 0, ',', '.') }}</td>
                            <td class="small">{{ $p->metode }}</td>
                            <td class="small">{{ $p->tujuan ?? '-' }}</td>
                            <td>
                                @if ($p->status === 'disetujui')
                                    <span class="badge text-bg-success">Disetujui</span>
                                @elseif ($p->status === 'ditolak')
                                    <span class="badge text-bg-danger">Ditolak</span>
                                @else
                                    <span class="badge text-bg-warning">Menunggu</span>
                                @endif
                            </td>
                            <td class="small">{{ $p->created_at->format('d M Y, H:i') }}</td>
                            <td class="text-end">
                                @if ($p->status === 'pending')
                                    <form action="{{ route('pencairan.approve', $p) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Setujui pencairan Rp {{ number_format($p->nominal, 0, ',', '.') }} untuk {{ $p->user->nama ?? '' }}?');">
                                        @csrf
                                        <button class="btn btn-sm btn-success" title="Setujui"><i class="bi bi-check-lg"></i></button>
                                    </form>
                                    <form action="{{ route('pencairan.reject', $p) }}" method="POST" class="d-inline reject-form">
                                        @csrf
                                        <input type="hidden" name="catatan_admin" class="reject-note">
                                        <button type="submit" class="btn btn-sm btn-danger" title="Tolak"><i class="bi bi-x-lg"></i></button>
                                    </form>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted py-3">Belum ada pengajuan pencairan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($pencairans->hasPages())
            <div class="mt-3">{{ $pencairans->links('pagination::bootstrap-5') }}</div>
        @endif
    </div>

    <script>
        document.querySelectorAll('.reject-form').forEach(function (f) {
            f.addEventListener('submit', function (e) {
                var alasan = prompt('Alasan penolakan (opsional). Poin akan dikembalikan ke siswa.');
                if (alasan === null) { e.preventDefault(); return; }
                f.querySelector('.reject-note').value = alasan;
            });
        });
    </script>
@endsection
