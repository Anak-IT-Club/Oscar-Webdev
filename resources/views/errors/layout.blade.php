<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('code') · Smart Site</title>
    <style>
        :root{
            --smart-green:#1f7a3d; --smart-green-dark:#155f2c; --smart-green-darker:#0f4821;
            --smart-green-light:#e8f5e9; --smart-accent:#34a853; --smart-text:#1b2b22; --smart-muted:#5b6b60;
        }
        *{box-sizing:border-box;margin:0;padding:0;}
        body{
            min-height:100vh; display:flex; align-items:center; justify-content:center; padding:24px;
            font-family:"Segoe UI",system-ui,-apple-system,Roboto,Helvetica,Arial,sans-serif;
            color:var(--smart-text); position:relative; overflow:hidden;
            background:radial-gradient(1200px 500px at 85% -10%, rgba(52,168,83,.18), transparent 60%),
                       linear-gradient(180deg, var(--smart-green-light) 0%, #ffffff 100%);
        }
        .blob{position:absolute;border-radius:50%;filter:blur(6px);opacity:.5;z-index:0;}
        .blob-1{width:340px;height:340px;background:rgba(52,168,83,.14);top:-120px;left:-90px;}
        .blob-2{width:300px;height:300px;background:rgba(21,95,44,.10);bottom:-110px;right:-70px;}
        .card{
            position:relative; z-index:1; width:100%; max-width:520px; text-align:center;
            background:#fff; border:1px solid #e6efe8; border-radius:24px; padding:48px 36px;
            box-shadow:0 30px 70px -30px rgba(21,95,44,.35);
        }
        .logo{
            width:64px;height:64px;border-radius:18px;display:inline-flex;align-items:center;justify-content:center;
            background:linear-gradient(135deg,var(--smart-accent),var(--smart-green-dark));
            box-shadow:0 14px 28px -10px rgba(21,95,44,.6); margin-bottom:22px;
        }
        .logo svg{width:34px;height:34px;fill:#fff;}
        .code{
            font-size:clamp(4.5rem,16vw,7rem); font-weight:800; line-height:1;
            background:linear-gradient(135deg,var(--smart-accent),var(--smart-green-dark));
            -webkit-background-clip:text;background-clip:text;-webkit-text-fill-color:transparent;
            letter-spacing:-2px;
        }
        .title{font-size:1.6rem;font-weight:800;color:var(--smart-green-dark);margin:6px 0 10px;}
        .msg{color:var(--smart-muted);font-size:1.02rem;line-height:1.6;margin-bottom:28px;}
        .actions{display:flex;gap:12px;justify-content:center;flex-wrap:wrap;}
        .btn{
            display:inline-flex;align-items:center;gap:8px;border-radius:999px;padding:.7rem 1.5rem;
            font-weight:600;font-size:.95rem;text-decoration:none;border:1px solid transparent;cursor:pointer;
            transition:background .15s ease,color .15s ease,border-color .15s ease;
        }
        .btn-primary{background:var(--smart-green);color:#fff;border-color:var(--smart-green);}
        .btn-primary:hover{background:var(--smart-green-dark);border-color:var(--smart-green-dark);}
        .btn-ghost{background:transparent;color:var(--smart-green-dark);border-color:var(--smart-green);}
        .btn-ghost:hover{background:var(--smart-green-light);}
        .brand{margin-top:26px;font-size:.85rem;color:var(--smart-muted);}
        .brand b{color:var(--smart-green-dark);}
    </style>
</head>
<body>
    <span class="blob blob-1"></span>
    <span class="blob blob-2"></span>

    <div class="card">
        <span class="logo" aria-hidden="true">
            <svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><path d="M9.302 1.256a1.5 1.5 0 0 0-2.604 0l-1.704 2.98a.5.5 0 0 0 .869.497l1.703-2.981a.5.5 0 0 1 .868 0l2.54 4.444-1.256-.337a.5.5 0 1 0-.26.966l2.415.647a.5.5 0 0 0 .613-.353l.647-2.415a.5.5 0 1 0-.966-.259l-.333 1.242zM2.973 7.773l-1.255.337a.5.5 0 1 1-.26-.966l2.416-.647a.5.5 0 0 1 .612.353l.647 2.415a.5.5 0 0 1-.966.259l-.333-1.242-2.545 4.454a.5.5 0 0 0 .434.748H5a.5.5 0 0 1 0 1H1.723A1.5 1.5 0 0 1 .421 12.24zm10.89 1.463a.5.5 0 1 0-.868.496l1.716 3.004a.5.5 0 0 1-.434.748H9.5a.5.5 0 0 0 0 1h4.777a1.5 1.5 0 0 0 1.302-2.244z"/></svg>
        </span>

        <div class="code">@yield('code')</div>
        <h1 class="title">@yield('title')</h1>
        <p class="msg">@yield('message')</p>

        <div class="actions">
            <a href="{{ url('/') }}" class="btn btn-primary">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354z"/></svg>
                Kembali ke Beranda
            </a>
            <a href="javascript:history.back()" class="btn btn-ghost">Halaman Sebelumnya</a>
        </div>

        <div class="brand">♻️ <b>Smart Site</b> - Bank Sampah Digital</div>
    </div>
</body>
</html>
