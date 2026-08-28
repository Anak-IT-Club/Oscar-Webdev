@extends('layouts.app')

@section('title', 'Manajemen Sampah')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3 reveal">
        <div>
            <span class="text-uppercase fw-semibold" style="color:var(--smart-accent);letter-spacing:.08em;">Manajemen</span>
            <h2 class="section-title mt-1 mb-0">Daftar Sampah</h2>
        </div>
        <a href="{{ route('sampah.create') }}" class="btn btn-cta-primary">
            <i class="bi bi-plus-lg me-1"></i> Tambah Sampah
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
                    <input type="text" name="search" class="form-control" placeholder="Nama sampah..." value="{{ request('search') }}">
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
                <a href="{{ route('sampah.index') }}" class="btn btn-outline-secondary" title="Reset"><i class="bi bi-arrow-counterclockwise"></i></a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width:40px;">#</th>
                        <th>Nama Sampah</th>
                        <th>Jenis</th>
                        <th>Poin</th>
                        <th class="text-end" style="width:120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sampahs as $sampah)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $sampah->nama_sampah }}</td>
                            <td>{{ $sampah->jenis_sampah }}</td>
                            <td>{{ number_format($sampah->poin, 0, ',', '.') }}</td>
                            <td class="text-end">
                                <a href="{{ route('sampah.edit', $sampah) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('sampah.destroy', $sampah) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus sampah {{ $sampah->nama_sampah }}?');">
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
                            <td colspan="5" class="text-center text-muted py-3">Belum ada data sampah.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($sampahs->hasPages())
            <div class="mt-3">
                {{ $sampahs->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection
