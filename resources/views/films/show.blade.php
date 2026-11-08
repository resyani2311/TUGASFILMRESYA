@extends('layouts.app')

@section('title', $film->judul)
@section('detail', '1')

@section('content')
    @php($rating = round((float) ($film->rating_avg ?? 0), 1))

    <section class="detail-hero">
        @if ($film->backdrop_url)
            <div class="detail-bg" style="background-image:url('{{ $film->backdrop_url }}')"></div>
        @else
            <div class="detail-bg" style="background-image:url('{{ $film->poster_url }}'); filter: blur(30px) brightness(.5); transform: scale(1.3)"></div>
        @endif

        <div class="container-xl">
            <a href="{{ route('film.index') }}" class="text-muted small d-inline-flex align-items-center gap-1 mb-3"><i class="bi bi-arrow-left"></i> Kembali ke daftar film</a>
            <div class="row g-4 g-lg-5 align-items-start">
                <div class="col-8 col-sm-5 col-md-4 col-lg-3 mx-auto mx-md-0">
                    <img class="detail-poster" src="{{ $film->poster_url }}" alt="Poster {{ $film->judul }}">
                </div>
                <div class="col-md-8 col-lg-9 fade-in">
                    <a href="{{ route('film.index', ['genre' => $film->genre_id]) }}" class="genre-chip lg">{{ $film->genre->nama }}</a>
                    <h1 class="detail-title">{{ $film->judul }}</h1>
                    <div class="detail-stats">
                        <span><i class="bi bi-calendar3"></i> {{ $film->tahun }}</span>
                        <span class="score">
                            @include('partials.stars', ['value' => $rating])
                            {{ $rating > 0 ? number_format($rating, 1) : '-' }}<small class="text-muted fw-normal">/5</small>
                        </span>
                        <span><i class="bi bi-chat-square-text"></i> {{ $film->kritiks_count }} komentar</span>
                        <span><i class="bi bi-people"></i> {{ $film->perans->count() }} pemeran</span>
                    </div>
                    <h2 class="h6 text-uppercase text-muted" style="letter-spacing:.15em">Sinopsis</h2>
                    <p class="lead fs-6" style="max-width:760px;color:#e4e4e7;white-space:pre-line">{{ $film->ringkasan }}</p>
                </div>
            </div>
        </div>
    </section>

    <div class="container-xl pb-5">
        @if ($film->trailer_url)
            <section class="section">
                <div class="section-head"><h2 class="section-title">Trailer</h2></div>
                <div class="trailer-wrap"><video controls preload="metadata" poster="{{ $film->backdrop_url ?? $film->poster_url }}"><source src="{{ $film->trailer_url }}">Browser Anda tidak mendukung pemutar video.</video></div>
            </section>
        @endif

        <section class="section">
            <div class="section-head"><h2 class="section-title">Cast &amp; Peran</h2></div>
            @if ($film->perans->isEmpty())
                <div class="empty-state"><i class="bi bi-people"></i> Data pemeran belum tersedia.</div>
            @else
                <div class="row g-3">
                    @foreach ($film->perans as $peran)
                        <div class="col-sm-6 col-lg-4 col-xl-3">
                            <div class="cast-item">
                                <span class="cast-ava">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($peran->cast->nama, 0, 1)) }}</span>
                                <div>
                                    <strong>{{ $peran->cast->nama }}</strong>
                                    <span>sebagai {{ $peran->nama }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

        <section class="section" id="komentar">
            <div class="section-head">
                <h2 class="section-title">Komentar &amp; Kritik</h2>
                <span class="text-muted small">{{ $kritiks->count() }} komentar</span>
            </div>

            <div class="row g-4">
                <div class="col-lg-5 order-lg-2">
                    {{-- Form komentar hanya untuk user biasa; admin tidak melihatnya (dan ditolak juga di backend). --}}
                    @if (auth()->user()->isRegularUser())
                        <div class="panel">
                            <h3 class="panel-title">{{ $myKritik ? 'Ubah Komentar Anda' : 'Tulis Komentar' }}</h3>
                            <form action="{{ route('kritik.store', $film) }}" method="POST" novalidate>
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label d-block">Rating</label>
                                    <div class="star-input">
                                        @for ($i = 5; $i >= 1; $i--)
                                            <input type="radio" id="star{{ $i }}" name="point" value="{{ $i }}" @checked((int) old('point', $myKritik->point ?? 0) === $i)>
                                            <label for="star{{ $i }}" title="{{ $i }} bintang" aria-label="{{ $i }} bintang">&#9733;</label>
                                        @endfor
                                    </div>
                                    @error('point')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                </div>
                                <div class="mb-3">
                                    <label for="content" class="form-label">Komentar / kritik</label>
                                    <textarea id="content" name="content" rows="4" maxlength="1000" placeholder="Bagikan pendapatmu tentang film ini..."
                                              class="form-control @error('content') is-invalid @enderror">{{ old('content', $myKritik->content ?? '') }}</textarea>
                                    @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <button type="submit" class="btn-cine w-100" data-loading="Mengirim..."><i class="bi bi-send"></i> {{ $myKritik ? 'Perbarui Komentar' : 'Kirim Komentar' }}</button>
                            </form>
                        </div>
                    @else
                        <div class="panel text-muted small">
                            <i class="bi bi-shield-lock text-white"></i>
                            Akun Administrator tidak dapat memberikan komentar. Anda hanya dapat melihat komentar penonton.
                        </div>
                    @endif
                </div>

                <div class="col-lg-7 order-lg-1">
                    <div class="panel">
                        @forelse ($kritiks as $kritik)
                            @php($mine = auth()->id() === $kritik->user_id)
                            <article class="review {{ $mine ? 'mine' : '' }}">
                                @if ($kritik->user->avatar_url)
                                    <img class="review-ava" src="{{ $kritik->user->avatar_url }}" alt="">
                                @else
                                    <span class="review-ava">{{ $kritik->user->initial }}</span>
                                @endif
                                <div class="flex-grow-1">
                                    <div class="d-flex flex-wrap justify-content-between gap-2">
                                        <strong>{{ $kritik->user->name }} @if ($mine)<span class="role-pill user ms-1">Anda</span>@endif</strong>
                                        <small class="text-muted">{{ $kritik->created_at->diffForHumans() }}</small>
                                    </div>
                                    @include('partials.stars', ['value' => $kritik->point])
                                    <p>{{ $kritik->content }}</p>
                                    @if ($mine)
                                        <button type="button" class="btn btn-sm p-0 text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                data-action="{{ route('kritik.destroy', $kritik) }}" data-name="komentar Anda pada {{ $film->judul }}"><i class="bi bi-trash3"></i> Hapus</button>
                                    @endif
                                </div>
                            </article>
                        @empty
                            <div class="empty-state"><i class="bi bi-chat-square-dots"></i> Belum ada komentar. Jadilah yang pertama!</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>
    </div>

    @include('partials.delete-modal')
@endsection
