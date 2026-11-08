@extends('layouts.guest')

@section('title', 'Daftar')

@section('content')
    <h1>Buat akun baru</h1>
    <p class="sub">Daftar untuk memberi komentar pada film favorit Anda.</p>

    <form action="{{ route('register') }}" method="POST" novalidate>
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" autocomplete="name"
                   class="form-control @error('name') is-invalid @enderror" required autofocus>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" id="username" value="{{ old('username') }}" autocomplete="username"
                   class="form-control @error('username') is-invalid @enderror" required>
            @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" autocomplete="email"
                   class="form-control @error('email') is-invalid @enderror" required>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="row g-3 mb-3">
            <div class="col-sm-6">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" autocomplete="new-password"
                       class="form-control @error('password') is-invalid @enderror" required>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-sm-6">
                <label for="password_confirmation" class="form-label">Ulangi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password"
                       class="form-control" required>
            </div>
        </div>
        <div class="form-text mb-4">Minimal 8 karakter.</div>

        <button type="submit" class="btn-cine w-100" data-loading="Mendaftarkan..."><i class="bi bi-person-plus"></i> Daftar</button>
    </form>

    <p class="text-center text-muted small mt-4 mb-0">
        Sudah punya akun? <a href="{{ route('login') }}" class="fw-semibold">Login</a>
    </p>
@endsection
