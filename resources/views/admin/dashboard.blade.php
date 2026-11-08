@extends('layouts.admin')

@section('title', 'Dashboard')
@section('crumb', 'Dashboard')

@section('content')
    <div class="adm-title">
        <div>
            <h1>Dashboard Administrator</h1>
            <p>Ringkasan data FilmKu hari ini.</p>
        </div>
        <a href="{{ route('admin.film.create') }}" class="btn-cine"><i class="bi bi-plus-lg"></i> Tambah Film</a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6 col-xl-3">
            <a href="{{ route('admin.film.index') }}" class="stat-card">
                <span class="stat-icon"><i class="bi bi-film"></i></span>
                <div><div class="num">{{ $stats['film'] }}</div><div class="lbl">Total Film</div></div>
            </a>
        </div>
        <div class="col-6 col-xl-3">
            <a href="{{ route('admin.cast.index') }}" class="stat-card">
                <span class="stat-icon"><i class="bi bi-people"></i></span>
                <div><div class="num">{{ $stats['cast'] }}</div><div class="lbl">Total Cast</div></div>
            </a>
        </div>
        <div class="col-6 col-xl-3">
            <a href="{{ route('admin.genre.index') }}" class="stat-card">
                <span class="stat-icon"><i class="bi bi-tags"></i></span>
                <div><div class="num">{{ $stats['genre'] }}</div><div class="lbl">Total Genre</div></div>
            </a>
        </div>
        <div class="col-6 col-xl-3">
            <a href="{{ route('admin.users.index') }}" class="stat-card">
                <span class="stat-icon"><i class="bi bi-person-lines-fill"></i></span>
                <div><div class="num">{{ $stats['user'] }}</div><div class="lbl">Total User</div></div>
            </a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-sm-6">
            <a href="{{ route('admin.actor.index') }}" class="stat-card">
                <span class="stat-icon"><i class="bi bi-person-video3"></i></span>
                <div><div class="num">{{ $stats['peran'] }}</div><div class="lbl">Total Peran</div></div>
            </a>
        </div>
        <div class="col-sm-6">
            <div class="stat-card">
                <span class="stat-icon"><i class="bi bi-chat-square-text"></i></span>
                <div><div class="num">{{ $stats['kritik'] }}</div><div class="lbl">Total Komentar Penonton</div></div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-7">
            <div class="adm-card mb-3">
                <div class="adm-card-head">
                    <h2>Film Terbaru Ditambahkan</h2>
                    <a href="{{ route('admin.film.index') }}" class="small">Lihat semua</a>
                </div>
                <div class="table-responsive">
                    <table class="table adm-table table-hover">
                        <thead><tr><th>Film</th><th>Genre</th><th>Tahun</th><th>Ditambahkan</th></tr></thead>
                        <tbody>
                            @forelse ($latestFilms as $film)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="{{ $film->poster_url }}" class="thumb" alt="">
                                            <a href="{{ route('admin.film.show', $film) }}" class="fw-semibold">{{ $film->judul }}</a>
                                        </div>
                                    </td>
                                    <td><span class="badge-soft red">{{ $film->genre->nama }}</span></td>
                                    <td>{{ $film->tahun }}</td>
                                    <td class="text-muted small">{{ $film->created_at->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-4">Belum ada film.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="adm-card">
                <div class="adm-card-head"><h2>Komentar Terbaru</h2></div>
                <div class="adm-card-body py-2">
                    @forelse ($latestKritiks as $kritik)
                        <div class="mini-item">
                            <span class="review-ava" style="width:38px;height:38px">{{ $kritik->user->initial }}</span>
                            <div class="flex-fill" style="min-width:0">
                                <div class="small"><strong>{{ $kritik->user->name }}</strong> pada <a href="{{ route('admin.film.show', $kritik->film) }}">{{ $kritik->film->judul }}</a> &middot; @include('partials.stars', ['value' => $kritik->point])</div>
                                <div class="text-muted small text-truncate">{{ $kritik->content }}</div>
                            </div>
                            <small class="text-muted text-nowrap">{{ $kritik->created_at->diffForHumans() }}</small>
                        </div>
                    @empty
                        <p class="text-muted text-center py-3 mb-0">Belum ada komentar.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="adm-card">
                <div class="adm-card-head"><h2>Film per Genre</h2></div>
                <div class="adm-card-body">
                    @php($max = max(1, $genres->max('films_count') ?? 1))
                    @forelse ($genres as $genre)
                        <div class="bar-row">
                            <div class="top"><span>{{ $genre->nama }}</span><span class="text-muted">{{ $genre->films_count }} film</span></div>
                            <div class="bar-track"><div class="bar-fill" style="width: {{ round($genre->films_count / $max * 100) }}%"></div></div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Belum ada genre.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
