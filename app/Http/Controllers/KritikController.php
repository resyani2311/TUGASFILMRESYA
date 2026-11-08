<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Kritik;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Komentar/kritik film. Route dilindungi middleware "role:user"; pengecekan
 * ditambahkan lagi di sini sebagai lapis kedua (defense in depth).
 */
class KritikController extends Controller
{
    public function store(Request $request, Film $film): RedirectResponse
    {
        abort_if($request->user()->isAdmin(), 403, 'Administrator tidak diperbolehkan memberikan komentar.');

        $validated = $request->validate([
            'content' => ['required', 'string', 'min:3', 'max:1000'],
            'point' => ['required', 'integer', 'between:1,5'],
        ], [
            'content.required' => 'Komentar wajib diisi.',
            'content.min' => 'Komentar minimal 3 karakter.',
            'point.required' => 'Pilih rating bintang 1 sampai 5.',
        ]);

        // user_id selalu dari akun yang login (bukan dari input). Satu user = satu komentar per film.
        $kritik = Kritik::updateOrCreate(
            ['user_id' => $request->user()->id, 'film_id' => $film->id],
            ['content' => $validated['content'], 'point' => $validated['point']],
        );

        return redirect()
            ->to(route('film.show', $film).'#komentar')
            ->with('success', $kritik->wasRecentlyCreated ? 'Komentar berhasil dikirim.' : 'Komentar Anda berhasil diperbarui.');
    }

    public function destroy(Request $request, Kritik $kritik): RedirectResponse
    {
        abort_if($request->user()->isAdmin(), 403, 'Administrator tidak diperbolehkan mengelola komentar.');
        abort_unless($kritik->user_id === $request->user()->id, 403, 'Anda hanya dapat menghapus komentar milik sendiri.');

        $film = $kritik->film;
        $kritik->delete();

        return redirect()->to(route('film.show', $film).'#komentar')->with('success', 'Komentar berhasil dihapus.');
    }
}
