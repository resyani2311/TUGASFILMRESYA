@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
    <div class="container-xl">
        <div class="page-head">
            <h1>Edit Profile</h1>
            <p class="text-muted mb-0">Perubahan hanya berlaku untuk akun Anda sendiri.</p>
        </div>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf
            @method('PUT')

            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="panel profile-card">
                        @if ($user->avatar_url)
                            <img class="profile-ava mb-3" id="avatarPreview" src="{{ $user->avatar_url }}" alt="Foto profile">
                        @else
                            <span class="profile-ava mb-3" id="avatarFallback">{{ $user->initial }}</span>
                            <img class="profile-ava mb-3" id="avatarPreview" src="" alt="Pratinjau foto" style="display:none">
                        @endif

                        <label for="avatar" class="form-label d-block">Foto profile</label>
                        <input type="file" name="avatar" id="avatar" accept="image/png,image/jpeg,image/webp" data-preview="#avatarPreview"
                               class="form-control @error('avatar') is-invalid @enderror">
                        @error('avatar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text">JPG, PNG, atau WEBP. Maksimal 2 MB.</div>

                        @if ($user->avatar)
                            <div class="form-check mt-3 text-start">
                                <input class="form-check-input" type="checkbox" name="remove_avatar" value="1" id="remove_avatar">
                                <label class="form-check-label small" for="remove_avatar">Hapus foto saat ini</label>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="panel mb-4">
                        <h2 class="panel-title">Data Akun</h2>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nama lengkap</label>
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}" class="form-control @error('username') is-invalid @enderror" required>
                                @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="panel mb-4">
                        <h2 class="panel-title">Ubah Password <small class="text-muted fs-6">(opsional)</small></h2>
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="current_password" class="form-label">Password saat ini</label>
                                <input type="password" id="current_password" name="current_password" autocomplete="current-password" class="form-control @error('current_password') is-invalid @enderror">
                                @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="password" class="form-label">Password baru</label>
                                <input type="password" id="password" name="password" autocomplete="new-password" class="form-control @error('password') is-invalid @enderror">
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Ulangi password baru</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password" class="form-control">
                            </div>
                        </div>
                        <div class="form-text mt-2">Kosongkan jika tidak ingin mengganti password.</div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn-cine" data-loading="Menyimpan..."><i class="bi bi-check-lg"></i> Simpan Perubahan</button>
                        <a href="{{ route('profile.show') }}" class="btn-ghost">Batal</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
