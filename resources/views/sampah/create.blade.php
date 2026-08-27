@extends('layouts.app')

@section('title', 'Tambah Sampah')

@section('content')
    <div class="contact-card p-4 mx-auto reveal" style="max-width:720px;">
        <h3 class="section-title mb-3">
            <i class="bi bi-recycle me-2"></i> Tambah Sampah
        </h3>

        <form action="{{ route('sampah.store') }}" method="POST">
            @include('sampah.form')

            <div class="d-flex gap-2 mt-3">
                <a href="{{ route('sampah.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
                <button type="submit" class="btn btn-cta-primary">
                    <i class="bi bi-save me-1"></i> Simpan
                </button>
            </div>
        </form>
    </div>
@endsection
