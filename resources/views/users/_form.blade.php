@csrf
@isset($user)
    @method('PUT')
@endisset

<div class="mb-3">
    <label for="nisn" class="form-label">NISN</label>
    <input type="text" name="nisn" id="nisn"
           class="form-control @error('nisn') is-invalid @enderror"
           value="{{ old('nisn', optional($user)->nisn) }}">
    @error('nisn')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="nama" class="form-label">Nama</label>
    <input type="text" name="nama" id="nama"
           class="form-control @error('nama') is-invalid @enderror"
           value="{{ old('nama', optional($user)->nama) }}" required autocomplete="name" autofocus>
    @error('nama')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="kelas" class="form-label">Kelas</label>
    <input type="text" name="kelas" id="kelas"
           class="form-control @error('kelas') is-invalid @enderror"
           value="{{ old('kelas', optional($user)->kelas) }}">
    @error('kelas')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="jurusan" class="form-label">Jurusan</label>
    <input type="text" name="jurusan" id="jurusan"
           class="form-control @error('jurusan') is-invalid @enderror"
           value="{{ old('jurusan', optional($user)->jurusan) }}">
    @error('jurusan')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="no_hp" class="form-label">No. HP</label>
    <input type="text" name="no_hp" id="no_hp"
           class="form-control @error('no_hp') is-invalid @enderror"
           value="{{ old('no_hp', optional($user)->no_hp) }}">
    @error('no_hp')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="poin" class="form-label">Poin</label>
    <input type="number" name="poin" id="poin" min="0"
           class="form-control @error('poin') is-invalid @enderror"
           value="{{ old('poin', optional($user)->poin ?? 0) }}">
    @error('poin')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="role" class="form-label">Role</label>
    <select name="role" id="role"
            class="form-control @error('role') is-invalid @enderror" required>
        <option value="siswa" {{ old('role', optional($user)->role) == 'siswa' ? 'selected' : '' }}>Siswa</option>
        <option value="admin" {{ old('role', optional($user)->role) == 'admin' ? 'selected' : '' }}>Admin</option>
    </select>
    @error('role')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" name="email" id="email"
           class="form-control @error('email') is-invalid @enderror"
           value="{{ old('email', optional($user)->email) }}" required autocomplete="email">
    @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" name="password" id="password"
           class="form-control @error('password') is-invalid @enderror"
           autocomplete="new-password" @unless(isset($user)) required @endunless>
    @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    @isset($user)
        <div class="form-text">Kosongkan jika tidak ingin mengubah password.</div>
    @endisset
</div>

<div class="mb-3">
    <label for="password_confirmation" class="form-label">Confirm Password</label>
    <input type="password" name="password_confirmation" id="password_confirmation"
           class="form-control" autocomplete="new-password">
</div>
