@extends('layouts.guest')

@section('title', 'Syarat & Ketentuan')

@section('content')
    <h1>Syarat &amp; Ketentuan</h1>
    <p class="sub">Aturan singkat penggunaan FilmKu.</p>

    <ul class="small text-muted ps-3 mb-4">
        <li class="mb-2">Gunakan komentar untuk menilai film secara sopan dan jujur.</li>
        <li class="mb-2">Jaga kerahasiaan password dan akun Anda.</li>
        <li class="mb-2">Data film dikelola oleh administrator.</li>
    </ul>

    <a href="{{ route('login') }}" class="btn-ghost w-100"><i class="bi bi-arrow-left"></i> Kembali</a>
@endsection
