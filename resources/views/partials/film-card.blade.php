<div class="{{ $col ?? 'col-md-2' }} w3l-movie-gride-agile">
  <a href="{{ route('movies.show', $f->id) }}" class="hvr-shutter-out-horizontal"><img src="{{ asset($f->poster) }}" title="{{ $f->title }}" alt="{{ $f->title }}" />
    <div class="w3l-action-icon"><i class="fa fa-play-circle" aria-hidden="true"></i></div>
  </a>
  <div class="mid-1">
    <div class="w3l-movie-text">
      <h6><a href="{{ route('movies.show', $f->id) }}">{{ $f->title }}</a></h6>
    </div>
    <div class="mid-2">
      <p>{{ $f->year }}</p>
      <div class="block-stars">@include('partials.stars', ['rating' => $f->rating_avg])</div>
      <div class="clearfix"></div>
    </div>
  </div>
  @if ($f->year == now()->year)
    <div class="ribben two"><p>NEW</p></div>
  @endif
</div>
