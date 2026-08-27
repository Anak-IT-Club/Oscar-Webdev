@extends('layouts.app')

@section('title', 'Profil')

@section('content')
    <div class="dash-head">
        <div>
            <h1 class="dash-title">Profil Saya</h1>
            <p class="dash-sub">Data akun kamu.</p>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-4">
            <div class="dash-card p-4 text-center">
                <div class="profile-avatar" id="avatarWrap">
                    @if ($user->foto)
                        <img id="avatarImg" src="{{ asset('foto_profil/'.$user->foto) }}" alt="Foto profil" class="rounded-circle">
                    @else
                        <div id="avatarImg" class="profile-initials rounded-circle">{{ strtoupper(substr($user->nama, 0, 1)) }}</div>
                    @endif
                    <div class="avatar-actions">
                        <label class="avatar-edit" title="Ubah foto profil">
                            <i class="bi bi-pencil-fill"></i>
                            <input type="file" id="fotoInput" class="d-none" accept="image/*">
                        </label>
                        <button type="button" class="avatar-del {{ $user->foto ? '' : 'd-none' }}" id="deletePhoto" title="Hapus foto profil">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </div>
                </div>
                <h2 class="dash-title h5 mb-1 mt-3">{{ $user->nama }}</h2>
                <span class="dash-role">{{ ucfirst($user->role) }}</span>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="dash-card p-4">
                <h2 class="dash-title h5 mb-3">Informasi Akun</h2>
                <table class="table table-borderless mb-0 profile-info">
                    <tr>
                        <th style="width:160px;">NISN</th>
                        <td>{{ $user->nisn ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Kelas</th>
                        <td>{{ $user->kelas ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Jurusan</th>
                        <td>{{ $user->jurusan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>No. HP</th>
                        <td>{{ $user->no_hp ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>Poin</th>
                        <td>{{ number_format($user->poin, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Role</th>
                        <td>{{ ucfirst($user->role) }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var input = document.getElementById('fotoInput');
            var delBtn = document.getElementById('deletePhoto');

            function setAvatar(url) {
                var wrap = document.getElementById('avatarWrap');
                var old = document.getElementById('avatarImg');
                if (old && old.tagName === 'IMG') {
                    old.src = url;
                } else if (old) {
                    var ni = document.createElement('img');
                    ni.id = 'avatarImg';
                    ni.src = url;
                    ni.className = 'rounded-circle';
                    wrap.replaceChild(ni, old);
                }
                var side = document.getElementById('sideAvatar');
                if (side) {
                    side.innerHTML = '<img src="' + url + '" alt="Foto" class="rounded-circle" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">';
                }
                if (delBtn) { delBtn.classList.remove('d-none'); }
            }

            function setDefaultAvatar() {
                var side = document.getElementById('sideAvatar');
                var initial = side ? side.getAttribute('data-initial') : '';
                var wrap = document.getElementById('avatarWrap');
                var old = document.getElementById('avatarImg');
                if (old) {
                    var div = document.createElement('div');
                    div.id = 'avatarImg';
                    div.className = 'profile-initials rounded-circle';
                    div.textContent = initial;
                    wrap.replaceChild(div, old);
                }
                if (side) { side.textContent = initial; }
                if (delBtn) { delBtn.classList.add('d-none'); }
            }

            if (input) {
                input.addEventListener('change', function () {
                    var file = this.files[0];
                    if (!file) return;

                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var img = new Image();
                        img.onerror = function () { alert('Gagal memuat gambar.'); };
                        img.onload = function () {
                            var size = Math.min(img.width, img.height);
                            var sx = (img.width - size) / 2;
                            var sy = (img.height - size) / 2;
                            var canvas = document.createElement('canvas');
                            canvas.width = 128;
                            canvas.height = 128;
                            var ctx = canvas.getContext('2d');
                            ctx.drawImage(img, sx, sy, size, size, 0, 0, 256, 256);

                            var mime = (file.type && file.type.indexOf('png') !== -1) ? 'image/png' : 'image/jpeg';
                            var dataUrl = canvas.toDataURL(mime, 0.9);

                            var fd = new FormData();
                            fd.append('_token', '{{ csrf_token() }}');
                            fd.append('foto', dataUrl);

                            fetch('{{ route('profile.photo') }}', {
                                method: 'POST',
                                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                                body: fd
                            })
                            .then(function (r) {
                                return r.json().then(function (data) { return { status: r.status, data: data }; });
                            })
                            .then(function (res) {
                                if (res.status === 200 && res.data.ok) {
                                    setAvatar(res.data.url + '?t=' + Date.now());
                                } else {
                                    var msg = 'Gagal mengunggah foto.';
                                    if (res.data && res.data.errors && res.data.errors.foto) {
                                        msg = res.data.errors.foto[0];
                                    } else if (res.data && res.data.message) {
                                        msg = res.data.message;
                                    }
                                    alert(msg);
                                }
                            })
                            .catch(function () { alert('Terjadi kesalahan saat mengunggah foto.'); });
                        };
                        img.src = e.target.result;
                    };
                    reader.readAsDataURL(file);

                    this.value = '';
                });
            }

            if (delBtn) {
                delBtn.addEventListener('click', function () {
                    if (!confirm('Hapus foto profil?')) return;

                    var fd = new FormData();
                    fd.append('_token', '{{ csrf_token() }}');

                    fetch('{{ route('profile.photo.delete') }}', {
                        method: 'POST',
                        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                        body: fd
                    })
                    .then(function (r) {
                        return r.json().then(function (data) { return { status: r.status, data: data }; });
                    })
                    .then(function (res) {
                        if (res.status === 200 && res.data.ok) {
                            setDefaultAvatar();
                        } else {
                            alert('Gagal menghapus foto.');
                        }
                    })
                    .catch(function () { alert('Terjadi kesalahan saat menghapus foto.'); });
                });
            }
        });
    </script>
@endsection
