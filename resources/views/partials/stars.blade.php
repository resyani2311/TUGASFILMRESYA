@php
  $r = round(((float) ($rating ?? 0)) * 2) / 2;
@endphp
<ul class="w3l-ratings" title="{{ $rating ? number_format($rating, 1).' / 5' : 'Belum ada rating' }}">
  @for ($i = 1; $i <= 5; $i++)
    <li><a href="javascript:void(0)"><i class="fa {{ $r >= $i ? 'fa-star' : ($r >= $i - 0.5 ? 'fa-star-half-o' : 'fa-star-o') }}" aria-hidden="true"></i></a></li>
  @endfor
</ul>
