<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class GenreController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));

        $genres = Genre::query()
            ->withCount('films')
            ->when($q !== '', fn ($query) => $query->where('nama', 'like', '%'.$q.'%'))
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        return view('admin.genres.index', compact('genres', 'q'));
    }

    public function create(): View
    {
        return view('admin.genres.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Genre::create($this->validated($request));

        return redirect()->route('admin.genre.index')->with('success', 'Genre berhasil ditambahkan.');
    }

    public function show(Genre $genre): View
    {
        $genre->load(['films' => fn ($query) => $query->orderBy('judul')]);

        return view('admin.genres.show', compact('genre'));
    }

    public function edit(Genre $genre): View
    {
        return view('admin.genres.edit', compact('genre'));
    }

    public function update(Request $request, Genre $genre): RedirectResponse
    {
        $genre->update($this->validated($request, $genre));

        return redirect()->route('admin.genre.index')->with('success', 'Genre berhasil diperbarui.');
    }

    public function destroy(Genre $genre): RedirectResponse
    {
        // Relasi films -> genres memakai cascade, jadi menghapus genre berisi film akan ikut
        // menghapus film. Dicegah supaya data film tidak hilang tanpa sengaja.
        if ($genre->films()->exists()) {
            return redirect()->route('admin.genre.index')
                ->with('error', 'Genre "'.$genre->nama.'" masih dipakai oleh film. Pindahkan atau hapus film tersebut terlebih dahulu.');
        }

        $genre->delete();

        return redirect()->route('admin.genre.index')->with('success', 'Genre berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request, ?Genre $genre = null): array
    {
        return $request->validate([
            'nama' => ['required', 'string', 'min:3', 'max:45', Rule::unique('genres', 'nama')->ignore($genre?->id)],
        ]);
    }
}
