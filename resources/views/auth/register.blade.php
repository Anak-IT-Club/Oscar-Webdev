@extends('layouts.guest')

@section('title', __('Register'))

@section('content')
    <div class="auth-head">
        <span class="auth-logo"><i class="bi bi-person-plus"></i></span>
        <h1 class="auth-head-title">Register</h1>
        <p class="auth-head-sub">Buat akun Smart Site untuk mulai mengumpulkan poin.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label for="nama" class="form-label">{{ __('Nama') }}</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input id="nama" type="text"
                       class="form-control @error('nama') is-invalid @enderror"
                       name="nama" value="{{ old('nama') }}" required autocomplete="name" autofocus>
                @error('nama')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email Address') }}</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input id="email" type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       name="email" value="{{ old('email') }}" required autocomplete="email">
                @error('email')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="jurusan" class="form-label">Jurusan</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-mortarboard"></i></span>
                <select id="jurusan" name="jurusan"
                        class="form-select @error('jurusan') is-invalid @enderror" required>
                    <option value="" disabled {{ old('jurusan') ? '' : 'selected' }}>Pilih jurusan</option>
                    <option value="MPLB" {{ old('jurusan') == 'MPLB' ? 'selected' : '' }}>MPLB</option>
                    <option value="AKL" {{ old('jurusan') == 'AKL' ? 'selected' : '' }}>AKL</option>
                    <option value="TKJ" {{ old('jurusan') == 'TKJ' ? 'selected' : '' }}>TKJ</option>
                </select>
                @error('jurusan')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="kelas" class="form-label">Kelas</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-building"></i></span>
                <select id="kelas" name="kelas"
                        class="form-select @error('kelas') is-invalid @enderror" required>
                    <option value="" disabled {{ old('kelas') ? '' : 'selected' }}>Pilih jurusan dulu</option>
                    @php
                        $kelasOpts = [
                            'TKJ'  => ['10 TKJ 1', '10 TKJ 2', '11 TKJ 1', '11 TKJ 2', '12 TKJ'],
                            'MPLB' => ['10 MPLB', '11 MPLB', '12 MPLB'],
                            'AKL'  => ['10 AKL', '11 AKL', '12 AKL'],
                        ];
                    @endphp
                    @foreach ($kelasOpts as $j => $list)
                        <optgroup label="{{ $j }}">
                            @foreach ($list as $k)
                                <option value="{{ $k }}" data-jurusan="{{ $j }}" {{ old('kelas') == $k ? 'selected' : '' }}>{{ $k }}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
                @error('kelas')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">{{ __('Password') }}</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input id="password" type="password"
                       class="form-control @error('password') is-invalid @enderror"
                       name="password" required autocomplete="new-password">
                @error('password')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>

        <div class="mb-4">
            <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input id="password-confirm" type="password" class="form-control"
                       name="password_confirmation" required autocomplete="new-password">
            </div>
        </div>

        <button type="submit" class="btn btn-cta-primary w-100">
            <i class="bi bi-person-plus me-1"></i> {{ __('Register') }}
        </button>

        <div class="text-center mt-3">
            <a href="{{ route('login') }}" class="auth-link">{{ __('Sudah punya akun? Login') }}</a>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var jurusan = document.getElementById('jurusan');
            var kelas = document.getElementById('kelas');
            var oldKelas = @json(old('kelas'));

            if (oldKelas) {
                var j = oldKelas.indexOf('TKJ') > -1 ? 'TKJ'
                      : (oldKelas.indexOf('MPLB') > -1 ? 'MPLB'
                      : (oldKelas.indexOf('AKL') > -1 ? 'AKL' : null));
                if (j) jurusan.value = j;
            }

            function filterKelas(j) {
                kelas.querySelectorAll('option').forEach(function (o) {
                    if (o.value === '') { o.hidden = false; return; }
                    o.hidden = !!j && o.dataset.jurusan !== j;
                });
                var sel = oldKelas ? kelas.querySelector('option[value="' + oldKelas + '"]') : null;
                kelas.value = (sel && !sel.hidden) ? oldKelas : '';
            }

            jurusan.addEventListener('change', function () { filterKelas(this.value); });
            filterKelas(jurusan.value);
        });
    </script>
@endsection
