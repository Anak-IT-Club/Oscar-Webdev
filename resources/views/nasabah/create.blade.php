@extends('layouts.app')

@section('title', 'Tambah Nasabah')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="bi bi-person-plus-fill me-2"></i>
                Tambah Nasabah
            </h3>
        </div>

        <form action="{{ route('nasabah.store') }}" method="POST">
            @csrf

            <div class="card-body">
                <div class="mb-3">
                    <label for="nis" class="form-label">NIS</label>
                    <input
                        type="text"
                        name="nis"
                        id="nis"
                        class="form-control"
                        value="{{ old('nis') }}"
                        placeholder="Contoh: 1234"
                        required
                    >

                    @error('nis')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input
                        type="text"
                        name="nama"
                        id="nama"
                        class="form-control"
                        value="{{ old('nama') }}"
                        placeholder="Contoh: Nama"
                        required
                    >

                    @error('nama')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="no_hp" class="form-label">No. HP</label>
                    <input
                        type="text"
                        name="no_hp"
                        id="no_hp"
                        class="form-control"
                        value="{{ old('no_hp') }}"
                        placeholder="Contoh: 081234567890"
                    >

                    @error('no_hp')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="card-footer">
                <a href="{{ route('nasabah.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Kembali
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>
                    Simpan Nasabah
                </button>
            </div>
        </form>
    </div>
@endsection
