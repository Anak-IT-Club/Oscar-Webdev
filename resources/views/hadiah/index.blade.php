@extends('layouts.app')

@section('title', 'Manajemen Hadiah')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3 reveal">
        <div>
            <span class="text-uppercase fw-semibold" style="color:var(--smart-accent);letter-spacing:.08em;">Manajemen</span>
            <h2 class="section-title mt-1 mb-0">Daftar Hadiah</h2>
        </div>
        <a href="{{ route('hadiah.create') }}" class="btn btn-cta-primary">
            <i class="bi bi-plus-lg me-1"></i> Tambah Hadiah
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
    @endif

    <div class="contact-card p-4 reveal">
        <form method="GET" class="row g-2 align-items-end mb-3">
            <div class="col-12 col-md-5">
                <label class="form-label small text-muted mb-1">Cari</label>
                <div class="input-group">
                    <button type="submit" class="input-group-text" style="cursor:pointer;"><i class="bi bi-search"></i></button>
                    <input type="text" name="search" class="form-control" placeholder="Nama hadiah..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-12 col-md-4">
                <label class="form-label small text-muted mb-1">Poin</label>
                <select name="poin" class="form-select">
                    <option value="">Semua</option>
                    <option value="low" @selected(request('poin') === 'low')>≤ 25</option>
                    <option value="mid" @selected(request('poin') === 'mid')>26 – 50</option>
                    <option value="high" @selected(request('poin') === 'high')>> 50</option>
                </select>
            </div>
            <div class="col-12 col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-cta-primary flex-fill"><i class="bi bi-funnel me-1"></i> Filter</button>
                <a href="{{ route('hadiah.index') }}" class="btn btn-outline-secondary" title="Reset"><i class="bi bi-arrow-counterclockwise"></i></a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width:40px;">#</th>
                        <th>Nama Hadiah</th>
                        <th>Jumlah Poin</th>
                        <th class="text-end" style="width:120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($hadiahs as $hadiah)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $hadiah->nama_hadiah }}</td>
                            <td>{{ number_format($hadiah->poin, 0, ',', '.') }}</td>
                            <td class="text-end">
                                <a href="{{ route('hadiah.edit', $hadiah) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('hadiah.destroy', $hadiah) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus hadiah {{ $hadiah->nama_hadiah }}?');">
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
                            <td colspan="4" class="text-center text-muted py-3">Belum ada data hadiah.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($hadiahs->hasPages())
            <div class="mt-3">
                {{ $hadiahs->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection
