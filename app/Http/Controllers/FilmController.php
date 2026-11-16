<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFilmRequest;
use App\Http\Requests\UpdateFilmRequest;
use App\Models\Film;
use App\Models\Genre;
use App\Models\Kritik;
use App\Models\Peran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FilmController extends Controller
{
    /* =====================================================
     |  HALAMAN PUBLIK / USER BIASA
     ===================================================== */

    /** Dashboard: daftar film (dengan pencarian ?q=). */
    public function movies(Request $request)
    {
        $genreFilm = null;
        $keyword = trim((string) $request->query('q', ''));

        $films = Film::select('id', 'title', 'poster', 'year')
            ->withAvg('kritiks as rating_avg', 'rating')
            ->when($keyword !== '', fn ($q) => $q->where('title', 'like', "%{$keyword}%"))
            ->orderByDesc('year')
            ->orderBy('id')
            ->paginate(18)
            ->withQueryString();

        return view('components.movies', compact('films', 'genreFilm', 'keyword'));
    }

    public function show(Film $film)
    {
        $film->load('genre')->loadAvg('kritiks as rating_avg', 'rating')->loadCount('kritiks');

        $filmByGenre = Film::select('id', 'title', 'poster', 'year', 'sinopsis')
            ->where('genre_id', $film->genre_id)
            ->where('id', '!=', $film->id)
            ->orderBy('id')
            ->limit(5)
            ->get();
        $filmByRelease = Film::select('id', 'title', 'poster', 'year')
            ->withAvg('kritiks as rating_avg', 'rating')
            ->where('year', Carbon::now()->format('Y'))
            ->orderBy('id')
            ->limit(9)
            ->get();
        $comments = Kritik::with('user.profile')
            ->where('film_id', $film->id)
            ->latest('id')
            ->limit(15)
            ->get();
        $perans = Peran::with('cast')->where('film_id', $film->id)->get();

        return view('components.movie-show', compact('film', 'filmByGenre', 'filmByRelease', 'comments', 'perans'));
    }

    public function movieHome()
    {
        $base = fn () => Film::select('id', 'title', 'poster', 'year')->withAvg('kritiks as rating_avg', 'rating');

        $films = $base()->orderBy('id')->limit(9)->get();
        $filmFutured = $base()->orderByDesc('year')->orderBy('id')->limit(6)->get();
        $filmRecentAdded = $base()->orderByDesc('id')->limit(6)->get();
        $filmSlidey = Film::select('id', 'title', 'poster', 'sinopsis')
            ->orderByDesc('year')->orderBy('id')->limit(6)->get();

        return view('components.home', compact('filmSlidey', 'films', 'filmFutured', 'filmRecentAdded'));
    }

    public function moviesByGenre($genre)
    {
        $genreFilm = Genre::findOrFail($genre);
        $keyword = '';
        $films = Film::select('id', 'title', 'poster', 'year')
            ->withAvg('kritiks as rating_avg', 'rating')
            ->where('genre_id', $genre)
            ->orderByDesc('year')
            ->orderBy('id')
            ->paginate(18);

        return view('components.movies', compact('films', 'genreFilm', 'keyword'));
    }

    /* =====================================================
     |  ADMIN : CRUD FILM
     ===================================================== */

    public function index(Request $request)
    {
        $keyword = trim((string) $request->query('q', ''));
        $films = Film::with('genre')
            ->when($keyword !== '', fn ($q) => $q->where('title', 'like', "%{$keyword}%"))
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.films.index', compact('films', 'keyword'));
    }

    public function create()
    {
        return view('admin.films.form', ['film' => new Film(), 'genres' => Genre::orderBy('name')->get()]);
    }

    public function store(StoreFilmRequest $request)
    {
        $data = $request->safe()->except('poster');
        $data['poster'] = $this->storePoster($request);
        Film::create($data);

        return redirect()->route('admin.films.index')->with('success', 'Film berhasil ditambahkan.');
    }

    public function edit(Film $film)
    {
        return view('admin.films.form', ['film' => $film, 'genres' => Genre::orderBy('name')->get()]);
    }

    public function update(UpdateFilmRequest $request, Film $film)
    {
        $data = $request->safe()->except('poster');
        if ($request->hasFile('poster')) {
            $old = $film->poster;
            $data['poster'] = $this->storePoster($request);
            $this->deletePosterIfUnused($old, $film->id);
        }
        $film->update($data);

        return redirect()->route('admin.films.index')->with('success', 'Film berhasil diperbarui.');
    }

    public function destroy(Film $film)
    {
        // hapus data turunan (komentar & peran) agar tidak melanggar foreign key
        $film->kritiks()->delete();
        $film->perans()->delete();
        $poster = $film->poster;
        $film->delete();
        $this->deletePosterIfUnused($poster, $film->id);

        return redirect()->route('admin.films.index')->with('success', 'Film berhasil dihapus.');
    }

    /* ---------- helper ---------- */

    private function storePoster(Request $request): string
    {
        // disimpan di storage/app/public/images -> diakses lewat public/storage/images
        $file = $request->file('poster');
        $name = 'film-'.Str::random(16).'.'.$file->extension();

        return 'storage/'.$file->storeAs('images', $name, 'public');
    }

    private function deletePosterIfUnused(?string $poster, int $exceptId): void
    {
        // poster seeder dipakai banyak film, hanya hapus file jika tak dipakai film lain
        if ($poster && str_starts_with($poster, 'storage/images/film-')
            && ! Film::where('poster', $poster)->where('id', '!=', $exceptId)->exists()) {
            Storage::disk('public')->delete(substr($poster, strlen('storage/')));
        }
    }
}
