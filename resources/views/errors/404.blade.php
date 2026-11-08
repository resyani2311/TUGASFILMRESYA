<!doctype html>
<html lang="id" data-bs-theme="dark">
<head><title>404 Tidak Ditemukan | FilmKu</title>@include('partials.head')</head>
<body>
    <div class="error-wrap">
        <div>
            <div class="error-code">404</div>
            <h1 class="h3 mb-2">Halaman tidak ditemukan</h1>
            <p class="text-muted mb-4">Halaman atau data yang Anda cari tidak ada atau sudah dihapus.</p>
            <a href="{{ url('/') }}" class="btn-cine"><i class="bi bi-house-door"></i> Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>
