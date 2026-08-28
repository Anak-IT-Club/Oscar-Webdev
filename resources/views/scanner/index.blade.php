@extends('layouts.app')

@section('title', 'Scan Sampah (AI)')

@section('content')
    <div class="dash-head">
        <div>
            <h1 class="dash-title">Scan Sampah <span class="badge text-bg-info align-middle"><i class="bi bi-robot me-1"></i>AI</span></h1>
            <p class="dash-sub">Foto sampahmu, biar AI yang menentukan jenis &amp; poinnya 📸</p>
        </div>
        <span class="dash-role">Poin: {{ number_format(auth()->user()->poin, 0, ',', '.') }}</span>
    </div>

    @if (session('success'))
        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
    @endif

    @unless ($aiReady)
        <div class="alert alert-warning" role="alert">
            <i class="bi bi-exclamation-triangle me-1"></i>
            AI Scanner belum aktif. Admin perlu mengisi <code>OPENROUTER_API_KEY</code> di file <code>.env</code>.
        </div>
    @endunless

    <div class="row g-3">
        <div class="col-lg-6">
            <div class="dash-card p-4 h-100">
                <h2 class="dash-title h5 mb-3">1. Ambil / Unggah Foto</h2>

                <label for="fotoInput" class="scan-drop" id="dropArea">
                    <div id="dropPlaceholder" class="text-center">
                        <i class="bi bi-camera fs-1 d-block mb-2" style="color:var(--smart-green)"></i>
                        <div class="fw-semibold">Ketuk untuk ambil foto</div>
                        <div class="small text-muted">atau pilih dari galeri (JPG/PNG/WEBP, maks 5MB)</div>
                    </div>
                    <img id="previewImg" class="scan-preview d-none" alt="Preview sampah">
                </label>
                <input type="file" id="fotoInput" class="d-none" accept="image/*" capture="environment">

                <button type="button" id="analyzeBtn" class="btn btn-cta-primary w-100 mt-3" disabled>
                    <i class="bi bi-magic me-1"></i> Analisis dengan AI
                </button>
                <div class="form-text">Foto dikirim ke layanan AI hanya untuk klasifikasi jenis sampah.</div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="dash-card p-4 h-100">
                <h2 class="dash-title h5 mb-3">2. Hasil &amp; Klaim Poin</h2>

                <div id="scanIdle" class="text-center text-muted py-4">
                    <i class="bi bi-arrow-left-circle fs-2 d-block mb-2"></i>
                    Hasil analisis akan muncul di sini.
                </div>

                <div id="scanLoading" class="text-center py-4 d-none">
                    <div class="spinner-border text-success mb-2" role="status"><span class="visually-hidden">Loading...</span></div>
                    <div class="dash-sub">AI sedang menganalisis foto…</div>
                </div>

                <div id="scanError" class="alert alert-danger d-none" role="alert"></div>

                <div id="scanResult" class="d-none">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div>
                            <div class="small text-muted">Terdeteksi</div>
                            <div class="h5 mb-0" id="resNama" style="color:var(--smart-green-dark)"></div>
                        </div>
                        <span class="badge text-bg-success fs-6" id="resJenis"></span>
                    </div>

                    <div class="mb-1 small text-muted">Tingkat keyakinan AI</div>
                    <div class="progress mb-2" style="height:10px;">
                        <div id="resConfBar" class="progress-bar bg-success" role="progressbar" style="width:0%"></div>
                    </div>
                    <div class="small text-muted fst-italic mb-3" id="resAlasan"></div>

                    <form action="{{ route('scanner.store') }}" method="POST" id="storeForm">
                        @csrf
                        <label class="form-label fw-semibold">Pilih item sampah untuk poin:</label>
                        <div id="opsiWrap" class="d-grid gap-2 mb-3"></div>
                        <button type="submit" class="btn btn-cta-primary w-100" id="claimBtn" disabled>
                            <i class="bi bi-coin me-1"></i> Setor &amp; Klaim Poin
                        </button>
                    </form>

                    <div id="noOpsi" class="alert alert-warning d-none mt-2 mb-0">
                        Belum ada master sampah untuk jenis ini. Hubungi admin untuk menambahkannya.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var input = document.getElementById('fotoInput');
            var preview = document.getElementById('previewImg');
            var placeholder = document.getElementById('dropPlaceholder');
            var analyzeBtn = document.getElementById('analyzeBtn');
            var idle = document.getElementById('scanIdle');
            var loading = document.getElementById('scanLoading');
            var errorBox = document.getElementById('scanError');
            var result = document.getElementById('scanResult');
            var opsiWrap = document.getElementById('opsiWrap');
            var claimBtn = document.getElementById('claimBtn');
            var noOpsi = document.getElementById('noOpsi');
            var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var currentFile = null;

            function show(el) { el.classList.remove('d-none'); }
            function hide(el) { el.classList.add('d-none'); }

            input.addEventListener('change', function () {
                var file = this.files[0];
                if (!file) return;
                currentFile = file;
                var reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                    hide(placeholder);
                };
                reader.readAsDataURL(file);
                analyzeBtn.disabled = false;
            });

            analyzeBtn.addEventListener('click', function () {
                if (!currentFile) return;
                hide(idle); hide(result); hide(errorBox); show(loading);
                analyzeBtn.disabled = true;

                var fd = new FormData();
                fd.append('foto', currentFile);
                fd.append('_token', token);

                fetch('{{ route('scanner.analyze') }}', {
                    method: 'POST',
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                    body: fd
                })
                .then(function (r) { return r.json().then(function (d) { return { status: r.status, data: d }; }); })
                .then(function (res) {
                    hide(loading);
                    analyzeBtn.disabled = false;
                    if (res.status === 200 && res.data.ok) {
                        renderResult(res.data);
                    } else {
                        errorBox.textContent = res.data.message || 'Gagal menganalisis gambar.';
                        show(errorBox);
                    }
                })
                .catch(function () {
                    hide(loading);
                    analyzeBtn.disabled = false;
                    errorBox.textContent = 'Terjadi kesalahan jaringan saat menghubungi AI.';
                    show(errorBox);
                });
            });

            function renderResult(d) {
                document.getElementById('resNama').textContent = d.nama_barang || 'Sampah';
                document.getElementById('resJenis').textContent = d.jenis;
                document.getElementById('resAlasan').textContent = d.alasan || '';
                var conf = Math.max(0, Math.min(100, d.keyakinan || 0));
                document.getElementById('resConfBar').style.width = conf + '%';
                document.getElementById('resConfBar').textContent = conf + '%';

                opsiWrap.innerHTML = '';
                claimBtn.disabled = true;
                hide(noOpsi);

                if (!d.opsi || d.opsi.length === 0) {
                    show(noOpsi);
                } else {
                    d.opsi.forEach(function (o, i) {
                        var id = 'opsi-' + o.id;
                        var label = document.createElement('label');
                        label.className = 'scan-opsi';
                        label.setAttribute('for', id);
                        label.innerHTML =
                            '<input type="radio" class="form-check-input me-2" name="sampah_id" id="' + id + '" value="' + o.id + '">' +
                            '<span class="fw-semibold">' + o.nama_sampah + '</span>' +
                            '<span class="ms-auto badge text-bg-success">+' + o.poin + ' poin</span>';
                        opsiWrap.appendChild(label);
                    });
                    opsiWrap.querySelectorAll('input[name="sampah_id"]').forEach(function (r) {
                        r.addEventListener('change', function () { claimBtn.disabled = false; });
                    });
                }
                show(result);
            }
        });
    </script>

    <style>
        .scan-drop {
            display: flex; align-items: center; justify-content: center;
            min-height: 220px; border: 2px dashed #bcd8c4; border-radius: 16px;
            background: var(--smart-green-light); cursor: pointer; padding: 12px;
            transition: border-color .15s ease, background .15s ease;
        }
        .scan-drop:hover { border-color: var(--smart-green); }
        .scan-preview { max-height: 260px; max-width: 100%; border-radius: 12px; object-fit: contain; }
        .scan-opsi {
            display: flex; align-items: center; gap: 6px; padding: 10px 14px;
            border: 1px solid #e6efe8; border-radius: 12px; cursor: pointer; margin: 0;
        }
        .scan-opsi:hover { border-color: var(--smart-accent); background: #f4f8f5; }
    </style>
@endsection
