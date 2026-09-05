<?php

namespace App\Http\Controllers;

use App\Services\EcoAssistant;
use Illuminate\Http\Request;

class AsistenController extends Controller
{
    public function index()
    {
        return view('asisten.index', [
            'aiReady' => ! empty(config('services.openrouter.key')),
        ]);
    }

    public function ask(Request $request, EcoAssistant $assistant)
    {
        $data = $request->validate([
            'pesan' => ['required', 'string', 'max:500'],
        ]);

        $result = $assistant->ask($data['pesan']);

        if (! ($result['ok'] ?? false)) {
            return response()->json(['ok' => false, 'message' => $result['message'] ?? 'Gagal memproses.'], 422);
        }

        return response()->json(['ok' => true, 'answer' => $result['answer']]);
    }
}
