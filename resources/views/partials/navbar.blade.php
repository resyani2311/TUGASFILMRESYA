<nav class="cn-nav {{ $navSolid ?? false ? 'solid' : '' }}" aria-label="Navigasi utama">
    <div class="container-xl">
        <a class="cn-brand" href="{{ auth()->check() ? route('dashboard') : route('login') }}"><i class="bi bi-film"></i> FILMKU</a>
        <button class="cn-toggle" id="cnToggle" type="button" aria-label="Buka menu" aria-expanded="false"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M4 6h16M4 12h16M4 18h16"/></svg></button>

        <div class="cn-collapse" id="cnCollapse">
            <ul class="cn-links">
                @auth
                    <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"><i class="bi bi-house-door"></i> Dashboard</a></li>
                    <li><a href="{{ route('film.index') }}" class="{{ request()->routeIs('film.*') ? 'active' : '' }}"><i class="bi bi-collection-play"></i> Film</a></li>
                    <li><a href="{{ route('profile.show') }}" class="{{ request()->routeIs('profile.*') ? 'active' : '' }}"><i class="bi bi-person-circle"></i> Profile</a></li>
                    @if (auth()->user()->isAdmin())
                        <li><a href="{{ route('admin.dashboard') }}" class="admin-link"><i class="bi bi-speedometer2"></i> Menu Admin</a></li>
                    @endif
                @endauth
            </ul>

            <div class="cn-right">
                @auth
                    <a href="{{ route('profile.show') }}" class="cn-user">
                        @if (auth()->user()->avatar_url)
                            <img class="cn-avatar" src="{{ auth()->user()->avatar_url }}" alt="Foto {{ auth()->user()->name }}">
                        @else
                            <span class="cn-avatar">{{ auth()->user()->initial }}</span>
                        @endif
                        <span>
                            {{ \Illuminate\Support\Str::limit(auth()->user()->name, 18) }}
                            <small>{{ auth()->user()->isAdmin() ? 'Administrator' : 'Member' }}</small>
                        </span>
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-ghost btn-sm"><i class="bi bi-box-arrow-right"></i> Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-cine btn-sm"><i class="bi bi-box-arrow-in-right"></i> Login</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
