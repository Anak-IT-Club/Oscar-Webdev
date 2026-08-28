@csrf
@isset($hadiah)
    @method('PUT')
@endisset
@php($hadiah = $hadiah ?? null)

<div class="mb-3">
    <label for="nama_hadiah" class="form-label">Nama Hadiah</label>
    <input type="text" name="nama_hadiah" id="nama_hadiah"
           class="form-control @error('nama_hadiah') is-invalid @enderror"
           value="{{ old('nama_hadiah', optional($hadiah)->nama_hadiah) }}" required autofocus>
    @error('nama_hadiah')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="poin" class="form-label">Jumlah Poin</label>
    <input type="number" name="poin" id="poin" min="0"
           class="form-control @error('poin') is-invalid @enderror"
           value="{{ old('poin', optional($hadiah)->poin ?? 0) }}" required>
    @error('poin')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
