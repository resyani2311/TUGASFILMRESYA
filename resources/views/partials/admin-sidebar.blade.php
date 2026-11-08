<aside class="adm-sidebar" id="admSidebar" aria-label="Menu admin">
    <a class="cn-brand" href="{{ route('admin.dashboard') }}"><i class="bi bi-film"></i> FILMKU</a>
    <span class="adm-badge">Panel Administrator</span>

    <ul class="adm-menu">
        <li class="label">Utama</li>
        <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>

        <li class="label">Kelola Data</li>
        <li><a href="{{ route('admin.film.index') }}" class="{{ request()->routeIs('admin.film.*') ? 'active' : '' }}"><i class="bi bi-film"></i> Data Film</a></li>
        <li><a href="{{ route('admin.cast.index') }}" class="{{ request()->routeIs('admin.cast.*') ? 'active' : '' }}"><i class="bi bi-people"></i> Data Cast</a></li>
        <li><a href="{{ route('admin.genre.index') }}" class="{{ request()->routeIs('admin.genre.*') ? 'active' : '' }}"><i class="bi bi-tags"></i> Data Genre</a></li>
        <li><a href="{{ route('admin.actor.index') }}" class="{{ request()->routeIs('admin.actor.*') ? 'active' : '' }}"><i class="bi bi-person-video3"></i> Data Peran</a></li>

        <li class="label">Pengguna</li>
        <li><a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><i class="bi bi-person-lines-fill"></i> Data User</a></li>

        <li class="label">Lainnya</li>
        <li><a href="{{ route('dashboard') }}"><i class="bi bi-box-arrow-up-right"></i> Lihat Website</a></li>
        <li><a href="{{ route('profile.show') }}"><i class="bi bi-person-circle"></i> Profile Saya</a></li>
    </ul>

    <div class="adm-foot">
        <div class="d-flex align-items-center gap-2 mb-3">
            @if (auth()->user()->avatar_url)
                <img class="cn-avatar" src="{{ auth()->user()->avatar_url }}" alt="Foto {{ auth()->user()->name }}">
            @else
                <span class="cn-avatar">{{ auth()->user()->initial }}</span>
            @endif
            <div class="small lh-sm">
                <strong class="d-block">{{ \Illuminate\Support\Str::limit(auth()->user()->name, 20) }}</strong>
                <span class="role-pill">Admin</span>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-ghost w-100"><i class="bi bi-box-arrow-right"></i> Logout</button>
        </form>
    </div>
</aside>
