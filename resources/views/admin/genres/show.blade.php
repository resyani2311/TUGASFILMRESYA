@extends('layouts.admin')

@section('title', $genre->nama)
@section('crumb', 'Data Genre › Detail')

@section('content')
    <div class="adm-title">
        <div><h1>{{ $genre->nama }}</h1><p>{{ $genre->films->count() }} film pada genre ini.</p></div>
        <a href="{{ route('admin.genre.edit', $genre) }}" class="btn-cine"><i class="bi bi-pencil"></i> Edit</a>
    </div>

    <div class="adm-card">
        <div class="adm-card-head"><h2>Film dalam genre</h2></div>
        <div class="table-responsive">
            <table class="table adm-table">
                <thead><tr><th>Judul</th><th>Tahun</th></tr></thead>
                <tbody>
                    @forelse ($genre->films as $film)
                        <tr><td><a href="{{ route('admin.film.show', $film) }}">{{ $film->judul }}</a></td><td>{{ $film->tahun }}</td></tr>
                    @empty
                        <tr><td colspan="2" class="text-center text-muted py-4">Belum ada film.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
