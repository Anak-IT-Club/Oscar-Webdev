@csrf
@isset($sampah)
    @method('PUT')
@endisset
@php($sampah = $sampah ?? null)

<div class="mb-3">
    <label for="nama_sampah" class="form-label">Nama Sampah</label>
    <input type="text" name="nama_sampah" id="nama_sampah"
           class="form-control @error('nama_sampah') is-invalid @enderror"
           value="{{ old('nama_sampah', optional($sampah)->nama_sampah) }}" required autofocus>
    @error('nama_sampah')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="jenis_sampah" class="form-label">Jenis Sampah</label>
    <select name="jenis_sampah" id="jenis_sampah"
            class="form-control @error('jenis_sampah') is-invalid @enderror" required>
        <option value="">Pilih jenis sampah</option>
        @foreach ($jenisList as $jenis)
            <option value="{{ $jenis }}" {{ old('jenis_sampah', optional($sampah)->jenis_sampah) == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
        @endforeach
    </select>
    @error('jenis_sampah')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="poin" class="form-label">Jumlah Poin</label>
    <input type="number" name="poin" id="poin" min="0"
           class="form-control @error('poin') is-invalid @enderror"
           value="{{ old('poin', optional($sampah)->poin ?? 0) }}" required>
    @error('poin')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
