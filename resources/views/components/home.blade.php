@extends('templates.index')

@section('title', 'Beranda')

@push('style')
<link href="{{ asset('template/css/jquery.slidey.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<!-- banner -->
<div id="slidey" style="display:none;">
  <ul>
    @foreach ($filmSlidey as $film)
      <li><img src="{{ asset($film->poster) }}" alt="{{ $film->title }}">
        <p class='title'>{{ $film->title }}</p>
        <p class='description'>{{ $film->sinopsis }}</p>
      </li>
    @endforeach
  </ul>
</div>
<script src="{{ asset('template/js/jquery.slidey.js') }}"></script>
<script src="{{ asset('template/js/jquery.dotdotdot.min.js') }}"></script>
<script type="text/javascript">
  $("#slidey").slidey({ interval: 8000, listCount: 5, autoplay: false, showList: true });
  $(".slidey-list-description").dotdotdot();
</script>
<!-- //banner -->

<!-- banner-bottom -->
<div class="banner-bottom home-recommendations">
  <h4 class="latest-text w3_latest_text">Rekomendasi Film</h4>
  <div class="container">
    <div class="w3_agile_banner_bottom_grid">
      <div id="owl-demo" class="owl-carousel owl-theme">
        @foreach ($films as $f)
          <div class="item">
            @include('partials.film-card', ['f' => $f, 'col' => 'w3l-movie-gride-agile1'])
          </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
<!-- //banner-bottom -->

<!-- general -->
<div class="general">
  <h4 class="latest-text w3_latest_text">Daftar Film</h4>
  <div class="container">
    <div class="bs-example bs-example-tabs" role="tabpanel">
      <ul id="myTab" class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">Terbaru</a></li>
        <li role="presentation"><a href="#imdb" role="tab" id="imdb-tab" data-toggle="tab" aria-controls="imdb" aria-expanded="false">Baru Ditambahkan</a></li>
      </ul>
      <div id="myTabContent" class="tab-content">
        <div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab">
          <div class="w3_agile_featured_movies">
            @foreach ($filmFutured as $f)
              @include('partials.film-card', ['f' => $f])
            @endforeach
            <div class="clearfix"> </div>
          </div>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="imdb" aria-labelledby="imdb-tab">
          <div class="w3_agile_featured_movies">
            @foreach ($filmRecentAdded as $f)
              @include('partials.film-card', ['f' => $f])
            @endforeach
            <div class="clearfix"> </div>
          </div>
        </div>
      </div>
    </div>
    <p style="text-align:center;margin:25px 0 5px"><a href="{{ route('movies') }}" class="btn btn-danger">Lihat semua film &raquo;</a></p>
  </div>
</div>
<!-- //general -->
@endsection
