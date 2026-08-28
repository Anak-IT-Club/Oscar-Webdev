<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return view('profile.index', compact('user'));
    }

    public function photo(Request $request)
    {
        $request->validate([
            'foto' => ['required', 'string', 'regex:/^data:image\/(jpeg|jpg|png|gif|webp);base64,/'],
        ]);

        $user = auth()->user();

        $path = public_path('foto_profil');
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        $payload = $request->input('foto');
        $segments = explode(';base64,', $payload, 2);
        $meta = $segments[0];
        $binary = base64_decode($segments[1], true);

        if ($binary === false) {
            return response()->json(['ok' => false, 'message' => 'Data foto tidak valid.'], 422);
        }

        $ext = 'jpg';
        if (str_contains($meta, 'png')) {
            $ext = 'png';
        } elseif (str_contains($meta, 'webp')) {
            $ext = 'webp';
        } elseif (str_contains($meta, 'gif')) {
            $ext = 'gif';
        }

        $filename = 'user-'.$user->id.'-'.time().'.'.$ext;
        file_put_contents($path.'/'.$filename, $binary);

        if ($user->foto && file_exists($path.'/'.$user->foto)) {
            @unlink($path.'/'.$user->foto);
        }

        $user->update(['foto' => $filename]);

        return response()->json([
            'ok' => true,
            'url' => asset('foto_profil/'.$filename),
        ]);
    }

    public function deletePhoto(Request $request)
    {
        $user = auth()->user();

        if ($user->foto && file_exists(public_path('foto_profil/'.$user->foto))) {
            @unlink(public_path('foto_profil/'.$user->foto));
        }

        $user->update(['foto' => null]);

        return response()->json(['ok' => true]);
    }
}
