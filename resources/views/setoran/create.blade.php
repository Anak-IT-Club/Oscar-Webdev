@extends('layouts.app')

@section('title', 'Catat Setoran')

@section('content')
    <div class="contact-card p-4 mx-auto reveal" style="max-width:720px;">
        <h3 class="section-title mb-3">
            <i class="bi bi-recycle me-2"></i> Catat Setoran Sampah
        </h3>
        <p class="dash-sub mb-4">Pilih siswa dan jenis sampah yang disetor. Poin akan otomatis ditambahkan ke akun siswa.</p>

        @if (session('error'))
            <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
        @endif

        <form action="{{ route('setoran.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="user_id" class="form-label">Siswa</label>
                <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                    <option value="" disabled {{ old('user_id') ? '' : 'selected' }}>Pilih siswa</option>
                    @foreach ($siswaList as $siswa)
                        <option value="{{ $siswa->id }}" {{ old('user_id') == $siswa->id ? 'selected' : '' }}>
                            {{ $siswa->nama }} @if($siswa->nisn) ({{ $siswa->nisn }}) @endif — {{ $siswa->kelas ?? '-' }}
                        </option>
                    @endforeach
                </select>
                @error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="sampah_id" class="form-label">Jenis Sampah</label>
                <select name="sampah_id" id="sampah_id" class="form-select @error('sampah_id') is-invalid @enderror" required>
                    <option value="" disabled {{ old('sampah_id') ? '' : 'selected' }}>Pilih sampah</option>
                    @foreach ($sampahList as $sampah)
                        <option value="{{ $sampah->id }}" data-poin="{{ $sampah->poin }}" data-jenis="{{ $sampah->jenis_sampah }}"
                                {{ old('sampah_id') == $sampah->id ? 'selected' : '' }}>
                            {{ $sampah->nama_sampah }} ({{ $sampah->jenis_sampah }}) — {{ $sampah->poin }} poin
                        </option>
                    @endforeach
                </select>
                @error('sampah_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="dash-card green p-3 mb-3 d-flex align-items-center justify-content-between" id="poinPreview" style="display:none !important;">
                <span class="dash-sub mb-0">Poin yang akan ditambahkan</span>
                <span class="num" id="poinPreviewValue" style="font-size:1.8rem;">0</span>
            </div>

            <div class="mb-3">
                <label for="catatan" class="form-label">Catatan <span class="text-muted small">(opsional)</span></label>
                <input type="text" name="catatan" id="catatan" class="form-control @error('catatan') is-invalid @enderror"
                       value="{{ old('catatan') }}" placeholder="mis. setoran pagi, lomba kebersihan, dll.">
                @error('catatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex gap-2 mt-4">
                <a href="{{ route('setoran.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
                <button type="submit" class="btn btn-cta-primary">
                    <i class="bi bi-save me-1"></i> Simpan &amp; Tambah Poin
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var sampah = document.getElementById('sampah_id');
            var preview = document.getElementById('poinPreview');
            var value = document.getElementById('poinPreviewValue');

            function update() {
                var opt = sampah.options[sampah.selectedIndex];
                var poin = opt ? opt.getAttribute('data-poin') : null;
                if (poin) {
                    value.textContent = '+' + poin;
                    preview.style.setProperty('display', 'flex', 'important');
                } else {
                    preview.style.setProperty('display', 'none', 'important');
                }
            }

            sampah.addEventListener('change', update);
            update();
        });
    </script>
@endsection
