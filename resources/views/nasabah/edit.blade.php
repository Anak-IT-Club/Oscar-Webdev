@extends('layouts.app')

@section('title', 'Edit Nasabah')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="bi bi-pencil-square me-2"></i> Edit Nasabah
            </h3>
        </div>

        <div class="card-body">
            <form action="{{ route('nasabah.update', $nasabah) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nis" class="form-label">NIS</label>
                    <input
                        type="text"
                        name="nis"
                        id="nis"
                        class="form-control @error('nis') is-invalid @enderror"
                        value="{{ old('nis', $nasabah->nis) }}"
                        required
                    >

                    @error('nis')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input
                        type="text"
                        name="nama"
                        id="nama"
                        class="form-control @error('nama') is-invalid @enderror"
                        value="{{ old('nama', $nasabah->nama) }}"
                        required
                    >

                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="no_hp" class="form-label">No. HP</label>
                    <input
                        type="text"
                        name="no_hp"
                        id="no_hp"
                        class="form-control @error('no_hp') is-invalid @enderror"
                        value="{{ old('no_hp', $nasabah->no_hp) }}"
                    >

                    @error('no_hp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('nasabah.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
