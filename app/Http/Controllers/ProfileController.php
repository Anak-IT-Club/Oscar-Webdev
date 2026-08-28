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
            'foto' => ['required', 'image', 'mimes:jpeg,jpg,png,gif,webp', 'max:2048'],
        ]);

        $user = auth()->user();

        $path = public_path('foto_profil');
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        // hapus foto lama
        if ($user->foto && file_exists($path.'/'.$user->foto)) {
            @unlink($path.'/'.$user->foto);
        }

        $file = $request->file('foto');
        $ext = $file->getClientOriginalExtension() ?: 'jpg';
        $filename = 'user-'.$user->id.'-'.time().'.'.$ext;
        $file->move($path, $filename);

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
