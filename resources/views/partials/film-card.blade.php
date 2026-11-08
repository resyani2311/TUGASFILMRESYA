@php($rating = round((float) ($film->rating_avg ?? 0), 1))
<a href="{{ route('film.show', $film) }}" class="film-card" title="{{ $film->judul }}">
    @isset($rank)<span class="rank-num">{{ $rank }}</span>@endisset
    <div class="film-poster">
        <img src="{{ $film->poster_url }}" alt="Poster {{ $film->judul }}" loading="lazy">
        @if ($rating > 0)
            <span class="film-rating-badge">&#9733; {{ number_format($rating, 1) }}</span>
        @endif
        <div class="film-overlay">
            <p>{{ \Illuminate\Support\Str::limit($film->ringkasan, 110) }}</p>
            <span class="btn-cine"><i class="bi bi-play-fill"></i> Lihat Detail</span>
        </div>
    </div>
    <div class="film-info">
        <h3 class="film-title">{{ $film->judul }}</h3>
        <div class="film-sub">
            <span>{{ $film->tahun }}</span>
            <span>&bull;</span>
            <span class="text-truncate">{{ $film->genre->nama ?? '-' }}</span>
        </div>
    </div>
</a>
