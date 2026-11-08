@extends('layouts.admin')

@section('title', $film->judul)
@section('crumb', 'Data Film › Detail')

@section('content')
    <div class="adm-title">
        <div><h1>{{ $film->judul }}</h1><p>Detail data film.</p></div>
        <div class="d-flex gap-2">
            <a href="{{ route('film.show', $film) }}" class="btn-ghost"><i class="bi bi-box-arrow-up-right"></i> Lihat di website</a>
            <a href="{{ route('admin.film.edit', $film) }}" class="btn-cine"><i class="bi bi-pencil"></i> Edit</a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-4 col-lg-3">
            <img src="{{ $film->poster_url }}" class="img-fluid rounded-3 w-100" alt="Poster {{ $film->judul }}">
        </div>
        <div class="col-md-8 col-lg-9">
            <div class="adm-card mb-3">
                <div class="adm-card-body">
                    <div class="info-row"><span>Judul</span><span>{{ $film->judul }}</span></div>
                    <div class="info-row"><span>Tahun</span><span>{{ $film->tahun }}</span></div>
                    <div class="info-row"><span>Genre</span><span><span class="badge-soft red">{{ $film->genre->nama }}</span></span></div>
                    <div class="info-row"><span>Rating</span><span>{{ $film->kritiks_count ? number_format($film->rating_avg, 1).' / 5 ('.$film->kritiks_count.' komentar)' : 'Belum ada' }}</span></div>
                    <div class="info-row"><span>Sinopsis</span><span style="max-width:70%">{{ $film->ringkasan }}</span></div>
                </div>
            </div>

            <div class="adm-card">
                <div class="adm-card-head"><h2>Pemeran &amp; Peran</h2><a href="{{ route('admin.actor.create') }}" class="small">+ Tambah peran</a></div>
                <div class="table-responsive">
                    <table class="table adm-table">
                        <thead><tr><th>Cast</th><th>Peran</th><th>Umur</th></tr></thead>
                        <tbody>
                            @forelse ($film->perans as $peran)
                                <tr><td>{{ $peran->cast->nama }}</td><td>{{ $peran->nama }}</td><td>{{ $peran->cast->umur }}</td></tr>
                            @empty
                                <tr><td colspan="3" class="text-center text-muted py-4">Belum ada peran.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
