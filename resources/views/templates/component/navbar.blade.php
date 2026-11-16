<div class="movies_nav">
  <div class="container">
    <nav class="navbar navbar-default">
      <div class="navbar-header navbar-right">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div>
      <div class="collapse navbar-collapse navbar-right" id="bs-example-navbar-collapse-1">
        <nav>
          <ul class="nav navbar-nav">
            <li class="w3_home_act {{ request()->routeIs('home') ? 'active' : '' }}"><a href="{{ route('home') }}">Home</a></li>
            <li class="dropdown {{ request()->routeIs('genre') ? 'active' : '' }}">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Genres <b class="caret"></b></a>
              <ul class="dropdown-menu multi-column columns-3">
                <li>
                  @foreach ($genres->chunk(7) as $chunk)
                    <div class="col-sm-4">
                      <ul class="multi-column-dropdown">
                        @foreach ($chunk as $g)
                          <li><a href="{{ route('genre', $g->id) }}">{{ $g->name }}</a></li>
                        @endforeach
                      </ul>
                    </div>
                  @endforeach
                  <div class="clearfix"></div>
                </li>
              </ul>
            </li>
            <li class="w3_home_act {{ request()->routeIs('movies') ? 'active' : '' }}"><a href="{{ route('movies') }}">Movies</a></li>
            @auth
              <li class="w3_home_act {{ request()->routeIs('profile.*') ? 'active' : '' }}"><a href="{{ route('profile.show') }}">Profile</a></li>
              @if (auth()->user()->isAdmin())
                <li class="w3_home_act"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
              @endif
            @endauth
          </ul>
        </nav>
      </div>
    </nav>
  </div>
</div>
