<!DOCTYPE html>
<html lang="id">
<head>
  <title>@yield('title', 'Admin') - {{ config('app.name') }} Admin</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="{{ asset('template/css/bootstrap.css') }}" rel="stylesheet">
  <link href="{{ asset('template/css/font-awesome.min.css') }}" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300" rel="stylesheet">
  <link href="{{ asset('css/app-extra.css') }}" rel="stylesheet">
  <script src="{{ asset('template/js/jquery-2.1.4.min.js') }}"></script>
  <script src="{{ asset('template/js/bootstrap.min.js') }}"></script>
</head>
<body class="admin-body">
<div class="admin-wrap">
  <aside class="admin-side">
    <a href="{{ route('admin.dashboard') }}" class="brand">One<span>Movies</span><small>Administrator</small></a>
    <ul>
      <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="{{ request()->routeIs('admin.films.*') ? 'active' : '' }}"><a href="{{ route('admin.films.index') }}"><i class="fa fa-film"></i> Film</a></li>
      <li class="{{ request()->routeIs('admin.casts.*') ? 'active' : '' }}"><a href="{{ route('admin.casts.index') }}"><i class="fa fa-male"></i> Cast</a></li>
      <li class="{{ request()->routeIs('admin.genres.*') ? 'active' : '' }}"><a href="{{ route('admin.genres.index') }}"><i class="fa fa-tags"></i> Genre</a></li>
      <li class="{{ request()->routeIs('admin.perans.*') ? 'active' : '' }}"><a href="{{ route('admin.perans.index') }}"><i class="fa fa-users"></i> Peran</a></li>
      <li class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><a href="{{ route('admin.users.index') }}"><i class="fa fa-user"></i> Data User</a></li>
      <li><a href="{{ route('home') }}" target="_blank"><i class="fa fa-external-link"></i> Lihat Website</a></li>
    </ul>
  </aside>
  <main class="admin-main">
    <div class="admin-top">
      <h2>@yield('heading')</h2>
      <div class="who">
        {{ auth()->user()->name }} ·
        <a href="{{ route('profile.show') }}">Profile</a> ·
        <form action="{{ route('logout') }}" method="post" style="display:inline">@csrf
          <button type="submit" style="background:none;border:0;color:#f5a623;padding:0">Logout</button>
        </form>
      </div>
    </div>
    @if (session('success') || session('error'))
      <div class="alert alert-{{ session('success') ? 'success' : 'danger' }} alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session('success') ?? session('error') }}
      </div>
    @endif
    @yield('content')
  </main>
</div>
</body>
</html>
