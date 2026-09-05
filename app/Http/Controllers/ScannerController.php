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

    public function store(Request $request)
    {
        $data = $request->validate([
            'sampah_id' => ['required', 'exists:sampah,id'],
            'foto' => ['required', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
        ]);

        $sampah = Sampah::findOrFail($data['sampah_id']);

        $dir = public_path('foto_setoran');
        if (! file_exists($dir)) {
            mkdir($dir, 0755, true);
        }
        $file = $request->file('foto');
        $ext = $file->getClientOriginalExtension() ?: 'jpg';
        $filename = 'setoran-'.auth()->id().'-'.time().'.'.$ext;
        $file->move($dir, $filename);

        Setoran::create([
            'user_id' => auth()->id(),
            'sampah_id' => $sampah->id,
            'jenis_sampah' => $sampah->jenis_sampah,
            'poin' => $sampah->poin,
            'sumber' => 'ai',
            'status' => 'pending',
            'foto' => $filename,
            'catatan' => 'Hasil AI Waste Scanner',
        ]);

        return response()->json([
            'ok' => true,
            'message' => 'Setoran terkirim! Menunggu validasi petugas sebelum poin masuk.',
        ]);
    }
}
