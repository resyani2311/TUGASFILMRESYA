<div class="header">
  <div class="container">
    <div class="w3layouts_logo">
      <a href="{{ route('home') }}"><h1>One<span>Movies</span></h1></a>
    </div>
    <div class="w3_search">
      <form action="{{ route('movies') }}" method="get">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari film..." required="">
        <input type="submit" value="Go">
      </form>
    </div>
    <div class="w3l_sign_in_register">
      <ul>
        @auth
          <li class="user-menu dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{ auth()->user()->name }} <b class="caret"></b></a>
            <ul class="dropdown-menu user-dropdown">
              @if (auth()->user()->isAdmin())
                <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Panel Admin</a></li>
              @endif
              <li><a href="{{ route('profile.show') }}"><i class="fa fa-id-card-o"></i> Profile Saya</a></li>
              <li role="separator" class="divider"></li>
              <li>
                <form action="{{ route('logout') }}" method="post">@csrf
                  <button type="submit" class="logout-btn"><i class="fa fa-sign-out"></i> Logout</button>
                </form>
              </li>
            </ul>
          </li>
        @else
          <li><a href="{{ route('login') }}">Login</a></li>
          <li><a href="{{ route('register') }}">Register</a></li>
        @endauth
      </ul>
    </div>
    <div class="clearfix"> </div>
  </div>
</div>
