@csrf
@isset($user)
    @method('PUT')
@endisset

<div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input type="text" name="name" id="name"
           class="form-control @error('name') is-invalid @enderror"
           value="{{ old('name', optional($user)->name) }}" required autocomplete="name" autofocus>
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" name="email" id="email"
           class="form-control @error('email') is-invalid @enderror"
           value="{{ old('email', optional($user)->email) }}" required autocomplete="email">
    @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div> -->

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
