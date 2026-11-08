<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\View\View;

/** Film untuk pengguna: hanya melihat daftar dan detail (pengelolaan ada di Admin\FilmController). */
class FilmController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));
        $genreId = $request->integer('genre') ?: null;
        $sort = $request->query('sort', 'terbaru');

        $films = Film::query()
            ->with('genre')
            ->withRatings()
            ->when($q !== '', fn ($query) => $query->where('judul', 'like', '%'.$q.'%'))
            ->when($genreId, fn ($query) => $query->where('genre_id', $genreId))
            ->when($sort === 'rating', fn ($query) => $query->orderByDesc('rating_avg')->orderByDesc('kritiks_count'))
            ->when($sort === 'judul', fn ($query) => $query->orderBy('judul'))
            ->when(! in_array($sort, ['rating', 'judul'], true), fn ($query) => $query->orderByDesc('tahun')->orderByDesc('id'))
            ->paginate(12)
            ->withQueryString();

        $genres = Genre::query()->withCount('films')->orderBy('nama')->get();

        return view('films.index', compact('films', 'genres', 'q', 'genreId', 'sort'));
    }

    public function show(Request $request, Film $film): View
    {
        $film->load(['genre', 'perans.cast'])->loadCount('kritiks')->loadAvg('kritiks as rating_avg', 'point');

        $kritiks = $film->kritiks()->with('user')->latest()->get();

        $user = $request->user();
        $myKritik = $user->isRegularUser() ? $kritiks->firstWhere('user_id', $user->id) : null;

        return view('films.show', compact('film', 'kritiks', 'myKritik'));
    }
}
