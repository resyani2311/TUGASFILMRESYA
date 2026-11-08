<!doctype html>
<html lang="id" data-bs-theme="dark">
<head><title>403 Akses Ditolak | FilmKu</title>@include('partials.head')</head>
<body>
    <div class="error-wrap">
        <div>
            <div class="error-code">403</div>
            <h1 class="h3 mb-2">Akses ditolak</h1>
            <p class="text-muted mb-4">{{ $exception->getMessage() ?: 'Anda tidak memiliki hak akses untuk halaman ini.' }}</p>
            <a href="{{ url('/') }}" class="btn-cine"><i class="bi bi-house-door"></i> Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>
