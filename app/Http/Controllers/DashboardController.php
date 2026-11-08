<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Genre;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $base = fn () => Film::query()->with('genre')->withRatings();

        $terbaru = $base()->orderByDesc('tahun')->orderByDesc('id')->take(12)->get();

        $populer = $base()->orderByDesc('kritiks_count')->orderByDesc('rating_avg')->take(12)->get();

        $rekomendasi = $base()->whereHas('kritiks')
            ->orderByDesc('rating_avg')->orderByDesc('kritiks_count')->take(12)->get();

        $semuaFilm = $base()->orderBy('judul')->get();

        // Film unggulan hero: rating tertinggi yang punya backdrop, kalau tidak ada ambil film terbaru.
        $featured = $rekomendasi->first(fn ($f) => $f->backdrop)
            ?? $terbaru->first(fn ($f) => $f->backdrop)
            ?? $terbaru->first();

        $genres = Genre::query()->withCount('films')->orderBy('nama')->get();

        return view('dashboard', compact('featured', 'terbaru', 'populer', 'rekomendasi', 'semuaFilm', 'genres'));
    }
}
