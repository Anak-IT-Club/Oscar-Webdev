<?php

namespace App\Services;

use App\Models\Hadiah;
use App\Models\Sampah;
use App\Models\Setoran;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class EcoAssistant
{
    /**
     * Jawab pertanyaan pengguna dengan konteks data Smart Site (grounded)
     * menggunakan model bahasa via OpenRouter.
     *
     * @return array{ok:bool, answer?:string, message?:string}
     */
    public function ask(string $question): array
    {
        $key = config('services.openrouter.key');

        if (empty($key)) {
            return ['ok' => false, 'message' => 'AI Assistant belum dikonfigurasi. Isi OPENROUTER_API_KEY pada file .env.'];
        }

        $system = "Kamu adalah \"Eco-Assistant\", asisten ramah pada aplikasi bank sampah sekolah bernama Smart Site. "
            ."Tugasmu: (1) menjawab pertanyaan tentang data sekolah berdasarkan DATA di bawah, "
            ."(2) memberi edukasi pemilahan sampah (Organik, Non-Organik, B3, Residu) dan tips daur ulang, "
            ."(3) memotivasi siswa memilah sampah. "
            ."Jawab singkat, jelas, dan ramah dalam Bahasa Indonesia. "
            ."Jika pertanyaan tentang data yang tidak tersedia, katakan dengan jujur. Jangan mengarang angka.\n\n"
            ."=== DATA SMART SITE (terkini) ===\n".$this->context();

        try {
            $response = Http::withToken($key)
                ->withHeaders([
                    'HTTP-Referer' => config('app.url'),
                    'X-Title' => config('app.name', 'Smart Site'),
                ])
                ->timeout(45)
                ->post(rtrim(config('services.openrouter.base_url'), '/').'/chat/completions', [
                    'model' => config('services.openrouter.model'),
                    'messages' => [
                        ['role' => 'system', 'content' => $system],
                        ['role' => 'user', 'content' => $question],
                    ],
                    'max_tokens' => 600,
                    'temperature' => 0.4,
                ]);
        } catch (\Throwable $e) {
            return ['ok' => false, 'message' => 'Gagal menghubungi layanan AI: '.$e->getMessage()];
        }

        if (! $response->successful()) {
            return ['ok' => false, 'message' => 'Layanan AI menolak permintaan (HTTP '.$response->status().').'];
        }

        $answer = data_get($response->json(), 'choices.0.message.content');

        if (! is_string($answer) || trim($answer) === '') {
            return ['ok' => false, 'message' => 'Respons AI kosong.'];
        }

        return ['ok' => true, 'answer' => trim($answer)];
    }

    /** Ringkasan data sekolah yang disuntikkan sebagai konteks ke model. */
    private function context(): string
    {
        $kurs = (int) config('smartsite.poin_to_rupiah', 100);
        $totalSiswa = User::where('role', 'siswa')->count();
        $totalSetoran = Setoran::where('status', 'disetujui')->count();
        $totalPoin = (int) Setoran::where('status', 'disetujui')->sum('poin');

        $perJenis = Setoran::where('status', 'disetujui')
            ->selectRaw('jenis_sampah, SUM(poin) as total, COUNT(*) as jml')
            ->groupBy('jenis_sampah')->get()
            ->map(fn ($r) => "- {$r->jenis_sampah}: {$r->total} poin ({$r->jml} setoran)")
            ->implode("\n");

        $topSiswa = User::where('role', 'siswa')
            ->withSum(['setoran as p' => fn ($q) => $q->where('status', 'disetujui')], 'poin')
            ->orderByDesc('p')->take(5)->get()
            ->values()
            ->map(fn ($u, $i) => ($i + 1).". {$u->nama} (".($u->kelas ?? '-').") - ".(int) $u->p.' poin')
            ->implode("\n");

        $kelas = User::where('role', 'siswa')
            ->withSum(['setoran as p' => fn ($q) => $q->where('status', 'disetujui')], 'poin')->get()
            ->filter(fn ($u) => filled($u->kelas) && $u->kelas !== '-')
            ->groupBy('kelas')
            ->map(fn ($g, $k) => [$k, (int) $g->sum('p')])
            ->sortByDesc(fn ($v) => $v[1])->take(5)
            ->map(fn ($v) => "- {$v[0]}: {$v[1]} poin")->implode("\n");

        $sampah = Sampah::get()
            ->map(fn ($s) => "- {$s->nama_sampah} ({$s->jenis_sampah}): {$s->poin} poin")
            ->implode("\n");

        $hadiah = Hadiah::get()
            ->map(fn ($h) => "- {$h->nama_hadiah}: {$h->poin} poin")
            ->implode("\n");

        return "Ringkasan umum: {$totalSiswa} siswa, {$totalSetoran} setoran, {$totalPoin} total poin terkumpul. "
            ."Kurs: 1 poin = Rp {$kurs}.\n\n"
            ."Poin per jenis sampah:\n{$perJenis}\n\n"
            ."Peringkat kelas (top 5):\n{$kelas}\n\n"
            ."Peringkat siswa (top 5):\n{$topSiswa}\n\n"
            ."Master jenis sampah & poin:\n{$sampah}\n\n"
            ."Daftar hadiah & poin yang dibutuhkan:\n{$hadiah}";
    }
}
