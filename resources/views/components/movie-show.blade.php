@extends('templates.index')

@section('title', $film->title)

@section('content')
<div class="container">
  <br />
  <div class="agileits-single-top">
    <ol class="breadcrumb">
      <li><a href="{{ route('home') }}">Home</a></li>
      <li><a href="{{ route('movies') }}">Movies</a></li>
      <li class="active">{{ $film->title }}</li>
    </ol>
  </div>
  <div class="single-page-agile-info">
    <div class="show-top-grids-w3lagile">
      <div class="col-sm-8 single-left">
        <div class="song">
          <div class="single-right-grids">
            <div class="col-md-4 single-right-grid-left">
              <img src="{{ asset($film->poster) }}" alt="{{ $film->title }}" />
            </div>
            <div class="col-md-8 single-right-grid-right">
              <div class="song-info">
                <h2>{{ $film->title }}</h2>
                <div class="film-meta">
                  {{ $film->year }}
                  @if ($film->genre)
                    <a href="{{ route('genre', $film->genre_id) }}" class="label-genre">{{ $film->genre->name }}</a>
                  @endif
                  <span style="margin-left:10px">
                    <i class="fa fa-star"></i>
                    {{ $film->rating_avg ? number_format($film->rating_avg, 1) : '-' }}/5
                    <small style="color:#aaa">({{ $film->kritiks_count }} ulasan)</small>
                  </span>
                </div>
                <p class="views">{{ $film->sinopsis }}</p>
              </div>
              <h5 style="color:#f5a623;margin-top:20px">Pemeran</h5>
              @if ($perans->isEmpty())
                <p class="empty-note" style="text-align:left;padding:6px 0">Data pemeran belum tersedia.</p>
              @else
                <table class="cast-table">
                  <thead><tr><th>Cast</th><th>Peran</th></tr></thead>
                  <tbody>
                    @foreach ($perans as $peran)
                      <tr>
                        <td>{{ $peran->cast?->name }}</td>
                        <td>{{ $peran->actor }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              @endif
            </div>
            <div class="clearfix"> </div>
          </div>
        </div>
        <div class="clearfix"> </div>

        <div class="all-comments" id="komentar">
          <div class="all-comments-info">
            <a href="#komentar">Komentar & Kritik ({{ $film->kritiks_count }})</a>
            <div class="comment-form">
              @guest
                <p class="notice">Silakan <a href="{{ route('login') }}">login</a> atau <a href="{{ route('register') }}">daftar</a> untuk memberikan komentar.</p>
              @else
                @if (auth()->user()->isAdmin())
                  <p class="notice"><i class="fa fa-info-circle"></i> Administrator tidak dapat memberikan komentar pada film.</p>
                @else
                  <form action="{{ route('kritik.store', $film) }}" method="post">
                    @csrf
                    <div style="margin-bottom:10px">
                      <label style="color:#ccc">Rating:</label>
                      <select name="rating" class="form-control" required>
                        @for ($i = 5; $i >= 1; $i--)
                          <option value="{{ $i }}" @selected(old('rating', 5) == $i)>{{ str_repeat('★', $i) }}{{ str_repeat('☆', 5 - $i) }} ({{ $i }})</option>
                        @endfor
                      </select>
                    </div>
                    <textarea name="comment" placeholder="Tulis komentar/kritik Anda untuk film ini..." required>{{ old('comment') }}</textarea>
                    @error('comment')<div style="color:#ff6b6b;margin:6px 0">{{ $message }}</div>@enderror
                    @error('rating')<div style="color:#ff6b6b;margin:6px 0">{{ $message }}</div>@enderror
                    <button type="submit" class="btn-red" style="margin-top:10px">Kirim</button>
                  </form>
                @endif
              @endguest
            </div>
          </div>
          <div class="media-grids">
            @forelse ($comments as $comment)
              <div class="kritik-item">
                <img src="{{ asset('template/images/user.jpg') }}" alt="">
                <div>
                  <span class="who">{{ $comment->user?->name ?? 'Pengguna' }}</span>
                  <span class="when">{{ $comment->created_at?->diffForHumans() }}</span>
                  <div class="stars">@include('partials.stars', ['rating' => $comment->rating])</div>
                  <p>{{ $comment->comment }}</p>
                </div>
              </div>
            @empty
              <p class="empty-note">Belum ada komentar. Jadilah yang pertama!</p>
            @endforelse
          </div>
        </div>
      </div>

      <div class="col-md-4 single-right">
        <h3>Film Serupa (Genre {{ $film->genre?->name }})</h3>
        @foreach ($filmByGenre as $similar)
          <div class="single-grid-right">
            <div class="single-right-grids">
              <div class="col-md-4 single-right-grid-left">
                <a href="{{ route('movies.show', $similar->id) }}"><img src="{{ asset($similar->poster) }}" alt="" /></a>
              </div>
              <div class="col-md-8 single-right-grid-right">
                <a href="{{ route('movies.show', $similar->id) }}" class="title">{{ $similar->title }}</a>
                <p class="author"><a href="#" class="author">{{ $similar->year }}</a></p>
                <p class="views" style="text-align: justify; margin-right: 10px">{{ \Illuminate\Support\Str::limit($similar->sinopsis, 90) }}</p>
              </div>
              <div class="clearfix"> </div>
            </div>
          </div>
        @endforeach
      </div>
      <div class="clearfix"> </div>
    </div>

    @if ($filmByRelease->isNotEmpty())
      <h4 class="latest-text w3_latest_text" style="margin-top:30px">Rilis {{ now()->year }}</h4>
      <div class="w3_agile_banner_bottom_grid">
        <div id="owl-demo" class="owl-carousel owl-theme">
          @foreach ($filmByRelease as $f)
            <div class="item">
              @include('partials.film-card', ['f' => $f, 'col' => 'w3l-movie-gride-agile1'])
            </div>
          @endforeach
        </div>
      </div>
    @endif
  </div>
</div>
@endsection
