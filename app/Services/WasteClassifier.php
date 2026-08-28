<?php

namespace App\Services;

use App\Models\Sampah;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class WasteClassifier
{
    /**
     * Klasifikasikan gambar sampah menjadi salah satu jenis pada Sampah::JENIS_SAMPAH
     * menggunakan model vision via OpenRouter.
     *
     * @param  string  $dataUri  Gambar dalam bentuk data URI (data:image/...;base64,....)
     * @return array{ok:bool, message?:string, nama_barang?:string, jenis?:string, keyakinan?:int, alasan?:string}
     */
    public function classify(string $dataUri): array
    {
        $key = config('services.openrouter.key');

        if (empty($key)) {
            return [
                'ok' => false,
                'message' => 'AI Scanner belum dikonfigurasi. Isi OPENROUTER_API_KEY pada file .env.',
            ];
        }

        $jenisList = implode(', ', Sampah::JENIS_SAMPAH);

        $prompt = "Kamu adalah asisten pemilah sampah untuk sistem bank sampah sekolah. "
            ."Lihat gambar berikut dan tentukan jenis sampahnya. "
            ."Jenis HARUS salah satu dari: {$jenisList}. "
            ."Jawab HANYA dalam format JSON valid tanpa teks lain, dengan struktur: "
            .'{"nama_barang": string singkat bahasa Indonesia, "jenis": salah satu dari daftar di atas, '
            .'"keyakinan": angka 0-100, "alasan": kalimat singkat bahasa Indonesia}. '
            .'Jika gambar bukan sampah atau tidak jelas, set keyakinan rendah dan jenis "Residu".';

        try {
            $response = Http::withToken($key)
                ->withHeaders([
                    'HTTP-Referer' => config('app.url'),
                    'X-Title' => config('app.name', 'Smart Site'),
                ])
                ->timeout(45)
                ->post(rtrim(config('services.openrouter.base_url'), '/').'/chat/completions', [
                    'model' => config('services.openrouter.model'),
                    'messages' => [[
                        'role' => 'user',
                        'content' => [
                            ['type' => 'text', 'text' => $prompt],
                            ['type' => 'image_url', 'image_url' => ['url' => $dataUri]],
                        ],
                    ]],
                    'max_tokens' => 300,
                    'temperature' => 0.1,
                ]);
        } catch (\Throwable $e) {
            return ['ok' => false, 'message' => 'Gagal menghubungi layanan AI: '.$e->getMessage()];
        }

        if (! $response->successful()) {
            return [
                'ok' => false,
                'message' => 'Layanan AI menolak permintaan (HTTP '.$response->status().'). Periksa API key/model.',
            ];
        }

        $content = data_get($response->json(), 'choices.0.message.content');

        if (! is_string($content) || $content === '') {
            return ['ok' => false, 'message' => 'Respons AI kosong atau tidak terbaca.'];
        }

        $parsed = $this->extractJson($content);

        if ($parsed === null) {
            return ['ok' => false, 'message' => 'Respons AI tidak dalam format yang diharapkan.'];
        }

        $jenis = $this->normalizeJenis($parsed['jenis'] ?? '');

        if ($jenis === null) {
            return ['ok' => false, 'message' => 'AI tidak mengenali jenis sampah pada gambar.'];
        }

        return [
            'ok' => true,
            'nama_barang' => Str::limit((string) ($parsed['nama_barang'] ?? 'Sampah'), 60, ''),
            'jenis' => $jenis,
            'keyakinan' => (int) max(0, min(100, (int) ($parsed['keyakinan'] ?? 0))),
            'alasan' => Str::limit((string) ($parsed['alasan'] ?? ''), 160, ''),
        ];
    }

    /**
     * Ambil objek JSON pertama dari string (model kadang membungkus dengan ```json).
     */
    private function extractJson(string $text): ?array
    {
        $start = strpos($text, '{');
        $end = strrpos($text, '}');

        if ($start === false || $end === false || $end <= $start) {
            return null;
        }

        $json = substr($text, $start, $end - $start + 1);
        $data = json_decode($json, true);

        return is_array($data) ? $data : null;
    }

    /**
     * Cocokkan jenis dari AI ke salah satu Sampah::JENIS_SAMPAH (case-insensitive).
     */
    private function normalizeJenis(string $value): ?string
    {
        $value = trim($value);

        foreach (Sampah::JENIS_SAMPAH as $jenis) {
            if (strcasecmp($jenis, $value) === 0) {
                return $jenis;
            }
        }

        return null;
    }
}
