@extends('layouts.app')

@section('title', 'Eco-Assistant')

@section('content')
    <div class="dash-head">
        <div>
            <h1 class="dash-title">Eco-Assistant <span class="badge text-bg-info align-middle"><i class="bi bi-robot me-1"></i>AI</span></h1>
            <p class="dash-sub">Tanya apa saja tentang data sekolah, jenis sampah, atau tips daur ulang 🌱</p>
        </div>
    </div>

    @unless ($aiReady)
        <div class="alert alert-warning" role="alert">
            <i class="bi bi-exclamation-triangle me-1"></i>
            AI Assistant belum aktif. Admin perlu mengisi <code>OPENROUTER_API_KEY</code> di file <code>.env</code>.
        </div>
    @endunless

    <div class="dash-card p-0" style="height:auto;overflow:hidden;">
        <div id="chatBox" style="height:52vh;min-height:320px;overflow-y:auto;padding:20px;background:#f7faf8;">
            <div class="chat-msg bot">
                <div class="bubble">Halo! Aku Eco-Assistant Smart Site 🌿 Coba tanya, misalnya: <em>"Kelas mana yang paling rajin?"</em>, <em>"Baterai bekas masuk kategori apa?"</em>, atau <em>"Hadiah apa saja yang bisa ditukar?"</em></div>
            </div>
        </div>

        <form id="chatForm" class="d-flex gap-2 p-3 border-top" style="background:#fff;">
            @csrf
            <input type="text" id="pesan" class="form-control" maxlength="500" autocomplete="off"
                   placeholder="Tulis pertanyaanmu..." {{ $aiReady ? '' : 'disabled' }}>
            <button type="submit" class="btn btn-cta-primary" id="sendBtn" {{ $aiReady ? '' : 'disabled' }}>
                <i class="bi bi-send"></i>
            </button>
        </form>
    </div>

    <div class="mt-3 d-flex flex-wrap gap-2">
        <button type="button" class="btn btn-outline-secondary btn-sm chip" @disabled(!$aiReady)>Kelas mana paling rajin?</button>
        <button type="button" class="btn btn-outline-secondary btn-sm chip" @disabled(!$aiReady)>Baterai bekas masuk kategori apa?</button>
        <button type="button" class="btn btn-outline-secondary btn-sm chip" @disabled(!$aiReady)>Tips memilah sampah plastik</button>
        <button type="button" class="btn btn-outline-secondary btn-sm chip" @disabled(!$aiReady)>Berapa total poin terkumpul?</button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var box = document.getElementById('chatBox');
            var form = document.getElementById('chatForm');
            var input = document.getElementById('pesan');
            var sendBtn = document.getElementById('sendBtn');
            var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            function esc(s) { var d = document.createElement('div'); d.textContent = s; return d.innerHTML; }
            function add(text, who, isHtml) {
                var wrap = document.createElement('div');
                wrap.className = 'chat-msg ' + who;
                var b = document.createElement('div');
                b.className = 'bubble';
                b.innerHTML = isHtml ? text : esc(text);
                wrap.appendChild(b);
                box.appendChild(wrap);
                box.scrollTop = box.scrollHeight;
                return b;
            }

            function send(text) {
                if (!text.trim()) return;
                add(text, 'user');
                input.value = '';
                sendBtn.disabled = true;
                var typing = add('<span class="dot"></span><span class="dot"></span><span class="dot"></span>', 'bot', true);

                fetch('{{ route('asisten.ask') }}', {
                    method: 'POST',
                    headers: { 'Accept': 'application/json', 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': token },
                    body: JSON.stringify({ pesan: text })
                })
                .then(function (r) { return r.json().then(function (d) { return { status: r.status, data: d }; }); })
                .then(function (res) {
                    typing.parentNode.remove();
                    if (res.status === 200 && res.data.ok) add(res.data.answer, 'bot');
                    else add(res.data.message || 'Maaf, terjadi kesalahan.', 'bot');
                    sendBtn.disabled = false;
                })
                .catch(function () { typing.parentNode.remove(); add('Terjadi kesalahan jaringan.', 'bot'); sendBtn.disabled = false; });
            }

            form.addEventListener('submit', function (e) { e.preventDefault(); send(input.value); });
            document.querySelectorAll('.chip').forEach(function (c) {
                c.addEventListener('click', function () { if (!input.disabled) send(c.textContent.trim()); });
            });
        });
    </script>

    <style>
        .chat-msg { display: flex; margin-bottom: 12px; }
        .chat-msg.user { justify-content: flex-end; }
        .chat-msg .bubble {
            max-width: 78%; padding: 10px 14px; border-radius: 14px; line-height: 1.5;
            white-space: pre-wrap; word-break: break-word; font-size: .95rem;
        }
        .chat-msg.bot .bubble { background: #fff; border: 1px solid #e6efe8; color: var(--smart-text); border-top-left-radius: 4px; }
        .chat-msg.user .bubble { background: var(--smart-green); color: #fff; border-top-right-radius: 4px; }
        .dot { display: inline-block; width: 7px; height: 7px; margin: 0 2px; border-radius: 50%; background: var(--smart-green); opacity: .4; animation: blink 1.2s infinite both; }
        .dot:nth-child(2) { animation-delay: .2s; } .dot:nth-child(3) { animation-delay: .4s; }
        @keyframes blink { 0%, 80%, 100% { opacity: .2; } 40% { opacity: 1; } }
    </style>
@endsection
