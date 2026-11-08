@extends('layouts.app')

@section('title', 'Dashboard')
@section('hero', '1')

@section('content')
    {{-- HERO --}}
    <section class="hero">
        @if ($featured && $featured->backdrop_url)
            <div class="hero-bg" style="background-image:url('{{ $featured->backdrop_url }}')"></div>
        @elseif ($featured)
            <div class="hero-bg" style="background-image:url('{{ $featured->poster_url }}'); filter: blur(30px) brightness(.6); transform: scale(1.3)"></div>
        @else
            <div class="hero-bg fallback"></div>
        @endif

        <div class="container-xl">
            <div class="hero-inner">
                <span class="hero-eyebrow">Halo, {{ \Illuminate\Support\Str::before(auth()->user()->name, ' ') }} &mdash; selamat datang di FilmKu</span>

                @if ($featured)
                    <h1>{{ $featured->judul }}</h1>
                    <div class="hero-meta">
                        <span class="genre-chip">{{ $featured->genre->nama }}</span>
                        <span>{{ $featured->tahun }}</span>
                        @if ($featured->kritiks_count > 0)
                            <span class="stars" aria-hidden="true">&#9733;</span>
                            <strong>{{ number_format($featured->rating_avg, 1) }}</strong>
                            <span class="text-muted">({{ $featured->kritiks_count }} ulasan)</span>
                        @endif
                    </div>
                    <p class="lead">{{ $featured->ringkasan }}</p>
                    <div class="hero-actions">
                        <a href="{{ route('film.show', $featured) }}" class="btn-cine"><i class="bi bi-play-fill"></i> Lihat Detail</a>
                        <a href="{{ route('film.index') }}" class="btn-ghost"><i class="bi bi-collection-play"></i> Jelajahi Semua Film</a>
                    </div>
                @else
                    <h1>Katalog Film Pilihan</h1>
                    <p class="lead">Belum ada film yang ditambahkan. Administrator dapat menambahkan film dari panel admin.</p>
                    @if (auth()->user()->isAdmin())
                        <div class="hero-actions"><a href="{{ route('admin.film.create') }}" class="btn-cine"><i class="bi bi-plus-lg"></i> Tambah Film</a></div>
                    @endif
                @endif
            </div>
        </div>
    </section>

    <div class="container-xl">
        {{-- Intro + genre --}}
        <section class="section">
            <p class="text-muted mb-3">Temukan film favoritmu, baca detail pemeran dan perannya, lalu bagikan komentar dan penilaianmu.</p>
            <div class="genre-bar">
                @foreach ($genres as $genre)
                    <a href="{{ route('film.index', ['genre' => $genre->id]) }}">{{ $genre->nama }} <small>{{ $genre->films_count }}</small></a>
                @endforeach
            </div>
        </section>

        @if ($rekomendasi->isNotEmpty())
            <section class="section">
                <div class="section-head">
                    <h2 class="section-title">Rekomendasi Film</h2>
                    <a href="{{ route('film.index') }}" class="section-link">Lihat semua <i class="bi bi-chevron-right"></i></a>
                </div>
                <div class="rail">
                    @foreach ($rekomendasi as $film)
                        @include('partials.film-card', ['film' => $film])
                    @endforeach
                </div>
            </section>
        @endif

        @if ($terbaru->isNotEmpty())
            <section class="section">
                <div class="section-head"><h2 class="section-title">Film Terbaru</h2></div>
                <div class="rail">
                    @foreach ($terbaru as $film)
                        @include('partials.film-card', ['film' => $film])
                    @endforeach
                </div>
            </section>

            <section class="section">
                <div class="section-head"><h2 class="section-title">Film Populer</h2></div>
                <div class="rail">
                    @foreach ($populer as $film)
                        @include('partials.film-card', ['film' => $film, 'rank' => $loop->iteration])
                    @endforeach
                </div>
            </section>
        @endif

        <section class="section" id="semua-film">
            <div class="section-head">
                <h2 class="section-title">Semua Film</h2>
                <span class="text-muted small">{{ $semuaFilm->count() }} film</span>
            </div>

            @if ($semuaFilm->isEmpty())
                <div class="empty-state"><i class="bi bi-film"></i> Belum ada film.</div>
            @else
                <div class="film-grid">
                    @foreach ($semuaFilm as $film)
                        @include('partials.film-card', ['film' => $film])
                    @endforeach
                </div>
            @endif
        </section>
    </div>
@endsection
