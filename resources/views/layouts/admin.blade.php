<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">
<head>
    <title>@yield('title', 'Admin') | Admin {{ config('app.name', 'FilmKu') }}</title>
    @include('partials.head')
</head>
<body>
    <div class="adm">
        @include('partials.admin-sidebar')
        <div class="adm-backdrop" id="admBackdrop"></div>

        <div class="adm-main">
            <header class="adm-top">
                <button class="toggle" id="admToggle" type="button" aria-label="Buka menu"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M4 6h16M4 12h16M4 18h16"/></svg></button>
                <div class="crumb">Admin &rsaquo; <strong>@yield('crumb', 'Dashboard')</strong></div>
            </header>

            @include('partials.toasts')

            <div class="adm-body">
                @yield('content')
            </div>
        </div>
    </div>

    @include('partials.delete-modal')

    <script src="{{ asset('adminlte/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/cinema.js') }}?v=1"></script>
    @stack('scripts')
</body>
</html>
