@extends('layouts.app')

@section('title', 'Edit Sampah')

@section('content')
    <div class="contact-card p-4 mx-auto reveal" style="max-width:720px;">
        <h3 class="section-title mb-3">
            <i class="bi bi-pencil-square me-2"></i> Edit Sampah
        </h3>

        <form action="{{ route('sampah.update', $sampah) }}" method="POST">
            @include('sampah.form')

            <div class="d-flex gap-2 mt-3">
                <a href="{{ route('sampah.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
                <button type="submit" class="btn btn-cta-primary">
                    <i class="bi bi-save me-1"></i> Update
                </button>
            </div>
        </form>
    </div>
@endsection
