<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Film;
use App\Models\Genre;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class FilmController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));

        $films = Film::query()
            ->with('genre')
            ->withCount(['kritiks', 'perans'])
            ->when($q !== '', fn ($query) => $query->where('judul', 'like', '%'.$q.'%'))
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.films.index', compact('films', 'q'));
    }

    public function create(): View
    {
        return view('admin.films.create', ['genres' => Genre::orderBy('nama')->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules($request), [], $this->attributes());

        $data = $this->prepareData($request, $validated);

        $data['poster'] = $request->file('poster')->store('posters', 'public');
        foreach (['backdrop' => 'backdrops', 'trailer' => 'trailers'] as $field => $dir) {
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store($dir, 'public');
            }
        }

        Film::create($data);

        return redirect()->route('admin.film.index')->with('success', 'Film berhasil ditambahkan.');
    }

    public function show(Film $film): View
    {
        $film->load(['genre', 'perans.cast'])->loadCount('kritiks')->loadAvg('kritiks as rating_avg', 'point');

        return view('admin.films.show', compact('film'));
    }

    public function edit(Film $film): View
    {
        return view('admin.films.edit', ['film' => $film, 'genres' => Genre::orderBy('nama')->get()]);
    }

    public function update(Request $request, Film $film): RedirectResponse
    {
        $validated = $request->validate($this->rules($request, $film), [], $this->attributes());

        $data = $this->prepareData($request, $validated);

        foreach (['poster' => 'posters', 'backdrop' => 'backdrops', 'trailer' => 'trailers'] as $field => $dir) {
            if ($request->hasFile($field)) {
                if ($film->{$field}) {
                    Storage::disk('public')->delete($film->{$field});
                }
                $data[$field] = $request->file($field)->store($dir, 'public');
            }
        }

        foreach (['backdrop', 'trailer'] as $field) {
            if ($request->boolean('remove_'.$field) && ! $request->hasFile($field) && $film->{$field}) {
                Storage::disk('public')->delete($film->{$field});
                $data[$field] = null;
            }
        }

        $film->update($data);

        return redirect()->route('admin.film.index')->with('success', 'Film berhasil diperbarui.');
    }

    public function destroy(Film $film): RedirectResponse
    {
        foreach (['poster', 'backdrop', 'trailer'] as $field) {
            if ($film->{$field}) {
                Storage::disk('public')->delete($film->{$field});
            }
        }

        // Komentar dan peran film ikut terhapus lewat foreign key cascade.
        $film->delete();

        return redirect()->route('admin.film.index')->with('success', 'Film berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function rules(Request $request, ?Film $film = null): array
    {
        return [
            'judul' => [
                'required', 'string', 'max:45',
                Rule::unique('films', 'judul')->where('tahun', $request->input('tahun'))->ignore($film?->id),
            ],
            'tahun' => ['required', 'integer', 'min:1888', 'max:'.(date('Y') + 5)],
            'genre_id' => ['required_without:genre_baru', 'nullable', 'exists:genres,id'],
            'genre_baru' => ['required_without:genre_id', 'nullable', 'string', 'min:3', 'max:45'],
            'ringkasan' => ['required', 'string'],
            'poster' => [$film ? 'nullable' : 'required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'backdrop' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'trailer' => ['nullable', 'mimes:mp4,mov,avi,webm', 'max:20480'],
        ];
    }

    /**
     * @return array<string, string>
     */
    private function attributes(): array
    {
        return ['genre_baru' => 'genre baru', 'genre_id' => 'genre'];
    }

    /**
     * @param  array<string, mixed>  $validated
     * @return array<string, mixed>
     */
    private function prepareData(Request $request, array $validated): array
    {
        // Jika admin mengetik genre baru, pakai/buat genre tersebut (tanpa duplikat).
        $genreId = ! empty($validated['genre_baru'])
            ? Genre::firstOrCreate(['nama' => trim($validated['genre_baru'])])->id
            : (int) $validated['genre_id'];

        return [
            'judul' => $validated['judul'],
            'tahun' => $validated['tahun'],
            'ringkasan' => $validated['ringkasan'],
            'genre_id' => $genreId,
        ];
    }
}
