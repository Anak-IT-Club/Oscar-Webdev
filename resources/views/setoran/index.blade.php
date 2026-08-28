@extends('layouts.app')

@section('title', 'Setoran Sampah')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3 reveal">
        <div>
            <span class="text-uppercase fw-semibold" style="color:var(--smart-accent);letter-spacing:.08em;">Transaksi</span>
            <h2 class="section-title mt-1 mb-0">Setoran Sampah</h2>
        </div>
        <a href="{{ route('setoran.create') }}" class="btn btn-cta-primary">
            <i class="bi bi-plus-lg me-1"></i> Catat Setoran
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
    @endif

    <div class="row g-3 mb-3 reveal">
        <div class="col-sm-6 col-xl-4">
            <div class="dash-card dash-stat">
                <span class="icon"><i class="bi bi-recycle"></i></span>
                <div>
                    <div class="num">{{ number_format($setorans->total(), 0, ',', '.') }}</div>
                    <div class="label">Total Setoran</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-4">
            <div class="dash-card dash-stat">
                <span class="icon"><i class="bi bi-coin"></i></span>
                <div>
                    <div class="num">{{ number_format($totalPoinHariIni, 0, ',', '.') }}</div>
                    <div class="label">Poin Hari Ini</div>
                </div>
            </div>
        </div>
    </div>

    <div class="contact-card p-4 reveal">
        <form method="GET" class="row g-2 align-items-end mb-3">
            <div class="col-12 col-md-5">
                <label class="form-label small text-muted mb-1">Cari Siswa</label>
                <div class="input-group">
                    <button type="submit" class="input-group-text" style="cursor:pointer;"><i class="bi bi-search"></i></button>
                    <input type="text" name="search" class="form-control" placeholder="Nama atau NISN..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-12 col-md-4">
                <label class="form-label small text-muted mb-1">Jenis</label>
                <select name="jenis" class="form-select">
                    <option value="">Semua</option>
                    @foreach ($jenisList as $item)
                        <option value="{{ $item }}" @selected(request('jenis') === $item)>{{ $item }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-cta-primary flex-fill"><i class="bi bi-funnel me-1"></i> Filter</button>
                <a href="{{ route('setoran.index') }}" class="btn btn-outline-secondary" title="Reset"><i class="bi bi-arrow-counterclockwise"></i></a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width:40px;">#</th>
                        <th>Siswa</th>
                        <th>Jenis Sampah</th>
                        <th>Poin</th>
                        <th>Sumber</th>
                        <th>Waktu</th>
                        <th class="text-end" style="width:80px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($setorans as $setoran)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="fw-semibold">{{ $setoran->user->nama ?? '-' }}</div>
                                <div class="small text-muted">{{ $setoran->user->nisn ?? '-' }}</div>
                            </td>
                            <td>{{ $setoran->jenis_sampah }}</td>
                            <td><span class="fw-semibold" style="color:var(--smart-green-dark)">+{{ number_format($setoran->poin, 0, ',', '.') }}</span></td>
                            <td>
                                @if ($setoran->sumber === 'ai')
                                    <span class="badge text-bg-info"><i class="bi bi-robot me-1"></i>AI</span>
                                @elseif ($setoran->sumber === 'smartbin')
                                    <span class="badge text-bg-primary"><i class="bi bi-cpu me-1"></i>SmartBin</span>
                                @else
                                    <span class="badge text-bg-secondary">Manual</span>
                                @endif
                            </td>
                            <td class="small">{{ $setoran->created_at->format('d M Y, H:i') }}</td>
                            <td class="text-end">
                                <form action="{{ route('setoran.destroy', $setoran) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus setoran ini? Poin siswa akan dikurangi kembali.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-3">Belum ada setoran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($setorans->hasPages())
            <div class="mt-3">
                {{ $setorans->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection
