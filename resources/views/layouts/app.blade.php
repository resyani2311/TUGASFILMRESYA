<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">
<head>
    <title>@yield('title', 'Dashboard') | {{ config('app.name', 'FilmKu') }}</title>
    @include('partials.head')
</head>
<body>
    @include('partials.navbar', ['navSolid' => ! View::hasSection('hero') && ! View::hasSection('detail')])
    @include('partials.toasts')

    <main class="page-main">
        @yield('content')
    </main>

    @include('partials.footer')

    <script src="{{ asset('adminlte/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/cinema.js') }}?v=1"></script>
    @stack('scripts')
</body>
</html>
