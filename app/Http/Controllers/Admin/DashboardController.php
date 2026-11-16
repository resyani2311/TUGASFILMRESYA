<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Cast, Film, Genre, Kritik, Peran, User};

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'Film'   => ['count' => Film::count(),   'icon' => 'fa-film',    'route' => 'admin.films.index'],
            'Cast'   => ['count' => Cast::count(),   'icon' => 'fa-male',    'route' => 'admin.casts.index'],
            'Genre'  => ['count' => Genre::count(),  'icon' => 'fa-tags',    'route' => 'admin.genres.index'],
            'Peran'  => ['count' => Peran::count(),  'icon' => 'fa-users',   'route' => 'admin.perans.index'],
            'User'   => ['count' => User::count(),   'icon' => 'fa-user',    'route' => 'admin.users.index'],
            'Komentar' => ['count' => Kritik::count(), 'icon' => 'fa-comments', 'route' => null],
        ];
        $latestKritiks = Kritik::with('user', 'film')->latest('id')->limit(8)->get();

        return view('admin.dashboard', compact('stats', 'latestKritiks'));
    }
}
