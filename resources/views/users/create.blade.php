@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
    <div class="contact-card p-4 mx-auto reveal" style="max-width:720px;">
        <h3 class="section-title mb-3">
            <i class="bi bi-person-plus-fill me-2"></i> Tambah User
        </h3>

        <form action="{{ route('users.store') }}" method="POST">
            @include('users._form', ['user' => null])

            <div class="d-flex gap-2 mt-3">
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
                <button type="submit" class="btn btn-cta-primary">
                    <i class="bi bi-save me-1"></i> Simpan User
                </button>
            </div>
        </form>
    </div>
@endsection
