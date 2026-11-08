@extends('layouts.guest')

@section('title', 'Login')

@section('content')
    <h1>Selamat datang kembali</h1>
    <p class="sub">Masuk untuk menjelajahi katalog film.</p>

    <form action="{{ route('login') }}" method="POST" novalidate>
        @csrf

        <div class="mb-3">
            <label for="login" class="form-label">Email atau Username</label>
            <div class="input-group has-validation">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" name="login" id="login" value="{{ old('login') }}" autocomplete="username"
                       class="form-control @error('login') is-invalid @enderror" placeholder="nama@email.com" required autofocus>
                @error('login')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group has-validation">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" name="password" id="password" autocomplete="current-password"
                       class="form-control @error('password') is-invalid @enderror" placeholder="Password Anda" required>
                <span class="input-group-text pw-toggle" data-pw-toggle="#password" role="button" aria-label="Tampilkan password"><i class="bi bi-eye"></i></span>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label small" for="remember">Ingat saya</label>
            </div>
            <a href="{{ route('forgot-password') }}" class="small">Lupa password?</a>
        </div>

        <button type="submit" class="btn-cine w-100" data-loading="Memeriksa..."><i class="bi bi-box-arrow-in-right"></i> Login</button>
    </form>

    <p class="text-center text-muted small mt-4 mb-0">
        Belum punya akun? <a href="{{ route('register') }}" class="fw-semibold">Daftar sekarang</a>
    </p>
@endsection
