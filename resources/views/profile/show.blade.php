@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <div class="container-xl">
        <div class="page-head d-flex flex-wrap justify-content-between align-items-center gap-2">
            <h1>Profile Saya</h1>
            <a href="{{ route('profile.edit') }}" class="btn-cine"><i class="bi bi-pencil-square"></i> Edit Profile</a>
        </div>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="panel profile-card">
                    @if ($user->avatar_url)
                        <img class="profile-ava mb-3" src="{{ $user->avatar_url }}" alt="Foto {{ $user->name }}">
                    @else
                        <span class="profile-ava mb-3">{{ $user->initial }}</span>
                    @endif
                    <h2 class="h4 mb-1">{{ $user->name }}</h2>
                    <p class="text-muted mb-2">&#64;{{ $user->username }}</p>
                    <span class="role-pill {{ $user->isAdmin() ? '' : 'user' }}">{{ $user->isAdmin() ? 'Administrator' : 'User Biasa' }}</span>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="panel mb-4">
                    <h2 class="panel-title">Informasi Akun</h2>
                    <div class="info-row"><span>Nama</span><span>{{ $user->name }}</span></div>
                    <div class="info-row"><span>Username</span><span>{{ $user->username ?? '-' }}</span></div>
                    <div class="info-row"><span>Email</span><span>{{ $user->email }}</span></div>
                    <div class="info-row"><span>Role</span><span>{{ $user->isAdmin() ? 'Administrator' : 'User Biasa' }}</span></div>
                    <div class="info-row"><span>Bergabung</span><span>{{ $user->created_at?->translatedFormat('d F Y') }}</span></div>
                    <div class="info-row"><span>Login terakhir</span><span>{{ $user->last_login_at?->diffForHumans() ?? '-' }}</span></div>
                    @if ($user->isRegularUser())
                        <div class="info-row"><span>Total komentar</span><span>{{ $user->kritiks_count }}</span></div>
                    @endif
                </div>

                @if ($user->isRegularUser())
                    <div class="panel">
                        <h2 class="panel-title">Komentar Terbaru Saya</h2>
                        @forelse ($kritiks as $kritik)
                            <div class="review">
                                <img src="{{ $kritik->film->poster_url }}" alt="" style="width:48px;height:72px;object-fit:cover;border-radius:6px">
                                <div>
                                    <a href="{{ route('film.show', $kritik->film) }}" class="fw-semibold">{{ $kritik->film->judul }}</a>
                                    <div>@include('partials.stars', ['value' => $kritik->point])</div>
                                    <p>{{ $kritik->content }}</p>
                                    <small class="text-muted">{{ $kritik->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state"><i class="bi bi-chat-square-dots"></i> Anda belum memberi komentar.</div>
                        @endforelse
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
