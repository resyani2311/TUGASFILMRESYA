@extends('layouts.admin')

@section('title', 'Data User')
@section('crumb', 'Data User')

@section('content')
    <div class="adm-title">
        <div><h1>Data User</h1><p>Daftar pengguna yang terdaftar (hanya untuk dilihat).</p></div>
    </div>

    <div class="adm-card">
        <div class="adm-card-head">
            <h2>Daftar User <span class="badge-soft ms-1">{{ $users->total() }}</span></h2>
            <form method="GET" class="adm-search">
                <input type="search" name="q" value="{{ $q }}" class="form-control form-control-sm" placeholder="Cari nama, username, email...">
                <button class="btn-cine btn-sm" type="submit"><i class="bi bi-search"></i></button>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table adm-table table-hover">
                <thead><tr><th>#</th><th>Pengguna</th><th>Username</th><th>Email</th><th>Role</th><th>Komentar</th><th>Terdaftar</th><th>Login Terakhir</th></tr></thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td class="text-muted">{{ $users->firstItem() + $loop->index }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @if ($user->avatar_url)
                                        <img class="cn-avatar" src="{{ $user->avatar_url }}" alt="">
                                    @else
                                        <span class="cn-avatar">{{ $user->initial }}</span>
                                    @endif
                                    <span class="fw-semibold">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td>{{ $user->username ?? '-' }}</td>
                            <td>{{ $user->email }}</td>
                            <td><span class="role-pill {{ $user->isAdmin() ? '' : 'user' }}">{{ $user->isAdmin() ? 'Admin' : 'User' }}</span></td>
                            <td>{{ $user->kritiks_count }}</td>
                            <td class="text-muted small">{{ $user->created_at?->translatedFormat('d M Y') }}</td>
                            <td class="text-muted small">{{ $user->last_login_at?->diffForHumans() ?? 'Belum pernah' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted py-5">Pengguna tidak ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3 d-flex justify-content-center">{{ $users->links() }}</div>
@endsection
