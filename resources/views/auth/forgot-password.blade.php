@extends('layouts.guest')

@section('title', 'Lupa Password')

@section('content')
    <h1>Lupa password?</h1>
    <p class="sub">Fitur reset password lewat email belum diaktifkan pada aplikasi ini.</p>

    <div class="panel mb-4 small text-muted">
        <i class="bi bi-info-circle text-white"></i>
        Silakan hubungi administrator untuk mengatur ulang password akun Anda.
    </div>

    <a href="{{ route('login') }}" class="btn-ghost w-100"><i class="bi bi-arrow-left"></i> Kembali ke Login</a>
@endsection
