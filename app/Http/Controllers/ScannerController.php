<?php

namespace App\Http\Controllers;

use App\Models\Sampah;
use App\Models\Setoran;
use App\Models\User;
use App\Services\WasteClassifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScannerController extends Controller
{
    public function index()
    {
        return view('scanner.index', [
            'aiReady' => ! empty(config('services.openrouter.key')),
        ]);
    }

    /**
     * Terima gambar, klasifikasikan dengan AI, dan kembalikan saran jenis + opsi poin.
     */
    public function analyze(Request $request, WasteClassifier $classifier)
    {
        $request->validate([
            'foto' => ['required', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
        ]);

        $file = $request->file('foto');
        $dataUri = 'data:'.$file->getMimeType().';base64,'.base64_encode(file_get_contents($file->getRealPath()));

        $result = $classifier->classify($dataUri);

        if (! ($result['ok'] ?? false)) {
            return response()->json(['ok' => false, 'message' => $result['message'] ?? 'Gagal menganalisis gambar.'], 422);
        }

        $opsi = Sampah::where('jenis_sampah', $result['jenis'])
            ->orderBy('poin')
            ->get(['id', 'nama_sampah', 'poin']);

        return response()->json([
            'ok' => true,
            'nama_barang' => $result['nama_barang'],
            'jenis' => $result['jenis'],
            'keyakinan' => $result['keyakinan'],
            'alasan' => $result['alasan'],
            'opsi' => $opsi,
        ]);
    }

    /**
     * Konfirmasi hasil scan menjadi setoran (poin masuk) untuk user yang login.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'sampah_id' => ['required', 'exists:sampah,id'],
        ]);

        $sampah = Sampah::findOrFail($data['sampah_id']);
        $userId = auth()->id();

        DB::transaction(function () use ($userId, $sampah) {
            $user = User::whereKey($userId)->lockForUpdate()->firstOrFail();

            Setoran::create([
                'user_id' => $user->id,
                'sampah_id' => $sampah->id,
                'jenis_sampah' => $sampah->jenis_sampah,
                'poin' => $sampah->poin,
                'sumber' => 'ai',
                'catatan' => 'Hasil AI Waste Scanner',
            ]);

            $user->increment('poin', $sampah->poin);
        });

        return redirect()->route('scanner.index')
            ->with('success', 'Mantap! Sampah "'.$sampah->nama_sampah.'" berhasil disetor, +'.$sampah->poin.' poin.');
    }
}
