@extends('layouts.app')

@section('title', 'Film')

@section('content')
    <div class="container-xl">
        <div class="page-head d-flex flex-wrap justify-content-between align-items-end gap-2">
            <div>
                <h1>Semua Film</h1>
                <p class="text-muted mb-0">{{ $films->total() }} film ditemukan{{ $q !== '' ? ' untuk "'.$q.'"' : '' }}.</p>
            </div>
        </div>

        <form method="GET" action="{{ route('film.index') }}" class="filter-bar row g-2 align-items-end">
            <div class="col-md-5">
                <label for="q" class="form-label small mb-1">Cari judul</label>
                <input type="search" id="q" name="q" value="{{ $q }}" class="form-control" placeholder="Contoh: Inception">
            </div>
            <div class="col-6 col-md-3">
                <label for="genre" class="form-label small mb-1">Genre</label>
                <select id="genre" name="genre" class="form-select">
                    <option value="">Semua genre</option>
                    @foreach ($genres as $g)
                        <option value="{{ $g->id }}" @selected($genreId === $g->id)>{{ $g->nama }} ({{ $g->films_count }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-md-2">
                <label for="sort" class="form-label small mb-1">Urutkan</label>
                <select id="sort" name="sort" class="form-select">
                    <option value="terbaru" @selected($sort === 'terbaru')>Terbaru</option>
                    <option value="rating" @selected($sort === 'rating')>Rating tertinggi</option>
                    <option value="judul" @selected($sort === 'judul')>Judul A-Z</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button class="btn-cine flex-grow-1" type="submit"><i class="bi bi-search"></i> Cari</button>
                @if ($q !== '' || $genreId || $sort !== 'terbaru')
                    <a href="{{ route('film.index') }}" class="btn-ghost" title="Reset filter" aria-label="Reset filter"><i class="bi bi-x-lg"></i></a>
                @endif
            </div>
        </form>

        @if ($films->isEmpty())
            <div class="empty-state"><i class="bi bi-film"></i> Film tidak ditemukan.</div>
        @else
            <div class="film-grid fade-in">
                @foreach ($films as $film)
                    @include('partials.film-card', ['film' => $film])
                @endforeach
            </div>
            <div class="mt-4 d-flex justify-content-center">{{ $films->links() }}</div>
        @endif
    </div>
@endsection
