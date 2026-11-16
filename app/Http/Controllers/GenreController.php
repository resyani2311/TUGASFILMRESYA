<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenreRequest;
use App\Models\Genre;

class GenreController extends Controller
{
    public function index()
    {
        $genres = Genre::withCount('films')->orderBy('name')->paginate(20);

        return view('admin.genres.index', compact('genres'));
    }

    public function create()
    {
        return view('admin.genres.form', ['genre' => new Genre()]);
    }

    public function store(GenreRequest $request)
    {
        Genre::create($request->validated());

        return redirect()->route('admin.genres.index')->with('success', 'Genre berhasil ditambahkan.');
    }

    public function edit(Genre $genre)
    {
        return view('admin.genres.form', compact('genre'));
    }

    public function update(GenreRequest $request, Genre $genre)
    {
        $genre->update($request->validated());

        return redirect()->route('admin.genres.index')->with('success', 'Genre berhasil diperbarui.');
    }

    public function destroy(Genre $genre)
    {
        if ($genre->films()->exists()) {
            return back()->with('error', 'Genre masih dipakai oleh '.$genre->films()->count().' film, tidak dapat dihapus.');
        }
        $genre->delete();

        return redirect()->route('admin.genres.index')->with('success', 'Genre berhasil dihapus.');
    }
}
