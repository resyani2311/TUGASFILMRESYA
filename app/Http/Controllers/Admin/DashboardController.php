<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Actor;
use App\Models\Cast;
use App\Models\Film;
use App\Models\Genre;
use App\Models\Kritik;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'film' => Film::count(),
            'cast' => Cast::count(),
            'genre' => Genre::count(),
            'user' => User::count(),
            'peran' => Actor::count(),
            'kritik' => Kritik::count(),
        ];

        $latestFilms = Film::with('genre')->latest()->take(5)->get();
        $latestKritiks = Kritik::with(['user', 'film'])->latest()->take(5)->get();
        $genres = Genre::withCount('films')->orderByDesc('films_count')->get();

        return view('admin.dashboard', compact('stats', 'latestFilms', 'latestKritiks', 'genres'));
    }
}
