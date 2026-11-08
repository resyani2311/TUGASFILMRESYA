@php($value = (int) round((float) ($value ?? 0)))
<span class="stars" role="img" aria-label="Rating {{ $value }} dari 5">@for ($i = 1; $i <= 5; $i++)<span class="{{ $i <= $value ? '' : 'off' }}" aria-hidden="true">&#9733;</span>@endfor</span>
