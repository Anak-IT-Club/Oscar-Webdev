@extends('layouts.app')

@section('title', 'Tabungan Sampah')

@section('content')
    <div class="dash-head">
        <div>
            <h1 class="dash-title">Tabungan Sampah 💰</h1>
            <p class="dash-sub">Ubah poin hasil memilah sampah jadi saldo yang bisa dicairkan.</p>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
    @endif

    <div class="row g-3">
        <div class="col-lg-5">
            <div class="dash-card green p-4 mb-3" style="height:auto;">
                <div class="dash-sub">Saldo kamu</div>
                <div class="num" style="font-size:2.4rem;">Rp {{ number_format($user->saldoRupiah(), 0, ',', '.') }}</div>
                <div class="dash-sub">{{ number_format($user->poin, 0, ',', '.') }} poin &middot; 1 poin = Rp {{ number_format($kurs, 0, ',', '.') }}</div>
            </div>

            <div class="dash-card p-4" style="height:auto;">
                <h2 class="dash-title h5 mb-3">Ajukan Pencairan</h2>
                <form action="{{ route('tabungan.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="poin" class="form-label">Jumlah poin dicairkan</label>
                        <input type="number" name="poin" id="poin" min="50" max="{{ $user->poin }}" step="10"
                               class="form-control @error('poin') is-invalid @enderror"
                               value="{{ old('poin') }}" placeholder="min. 50 poin" required>
                        @error('poin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text">Setara <strong id="nominalPreview">Rp 0</strong></div>
                    </div>
                    <div class="mb-3">
                        <label for="metode" class="form-label">Metode pencairan</label>
                        <select name="metode" id="metode" class="form-select @error('metode') is-invalid @enderror" required>
                            <option value="" disabled {{ old('metode') ? '' : 'selected' }}>Pilih metode</option>
                            @foreach ($metodeList as $m)
                                <option value="{{ $m }}" {{ old('metode') === $m ? 'selected' : '' }}>{{ $m }}</option>
                            @endforeach
                        </select>
                        @error('metode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="tujuan" class="form-label">Keterangan tujuan <span class="text-muted small">(opsional)</span></label>
                        <input type="text" name="tujuan" id="tujuan" class="form-control @error('tujuan') is-invalid @enderror"
                               value="{{ old('tujuan') }}" placeholder="mis. nama/nomor e-wallet, kelas, dll.">
                        @error('tujuan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-cta-primary w-100">
                        <i class="bi bi-cash-coin me-1"></i> Ajukan Pencairan
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="dash-card p-4 h-100">
                <h2 class="dash-title h5 mb-3">Riwayat Pencairan</h2>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Poin</th>
                                <th>Nominal</th>
                                <th>Metode</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($riwayat as $p)
                                <tr>
                                    <td class="small">{{ $p->created_at->format('d M Y, H:i') }}</td>
                                    <td>{{ number_format($p->poin, 0, ',', '.') }}</td>
                                    <td class="fw-semibold">Rp {{ number_format($p->nominal, 0, ',', '.') }}</td>
                                    <td class="small">{{ $p->metode }}</td>
                                    <td>
                                        @if ($p->status === 'disetujui')
                                            <span class="badge text-bg-success">Disetujui</span>
                                        @elseif ($p->status === 'ditolak')
                                            <span class="badge text-bg-danger" @if($p->catatan_admin) title="{{ $p->catatan_admin }}" @endif>Ditolak</span>
                                        @else
                                            <span class="badge text-bg-warning">Menunggu</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted py-3">Belum ada pengajuan pencairan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var kurs = {{ (int) $kurs }};
            var poin = document.getElementById('poin');
            var prev = document.getElementById('nominalPreview');
            function upd() {
                var v = parseInt(poin.value || '0', 10) || 0;
                prev.textContent = 'Rp ' + (v * kurs).toLocaleString('id-ID');
            }
            poin.addEventListener('input', upd);
            upd();
        });
    </script>
@endsection
