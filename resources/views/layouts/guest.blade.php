<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">
<head>
    <title>@yield('title', 'Login') | {{ config('app.name', 'FilmKu') }}</title>
    @include('partials.head')
</head>
<body>
    @php($bgPosters = \App\Models\Film::query()->whereNotNull('poster')->inRandomOrder()->take(24)->get())
    <div class="auth-page">
        <div class="auth-bg" aria-hidden="true">
            <div class="posters">
                @foreach ($bgPosters as $bg)
                    <img src="{{ $bg->poster_url }}" alt="" loading="lazy">
                @endforeach
            </div>
        </div>

        <div class="auth-card">
            <a class="cn-brand" href="{{ route('login') }}"><i class="bi bi-film"></i> FILMKU</a>
            @include('partials.toasts')
            @yield('content')
        </div>
    </div>

    <script src="{{ asset('adminlte/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/cinema.js') }}?v=1"></script>
    @stack('scripts')
</body>
</html>
