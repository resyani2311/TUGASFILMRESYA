<div class="toast-stack" aria-live="polite" aria-atomic="true">
    @if (session('success'))
        <div class="cn-toast success" role="status">
            <i class="bi bi-check-circle-fill"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="close" aria-label="Tutup">&times;</button>
        </div>
    @endif
    @if (session('error'))
        <div class="cn-toast error" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <div>{{ session('error') }}</div>
            <button type="button" class="close" aria-label="Tutup">&times;</button>
        </div>
    @endif
    @if ($errors->any() && ! request()->routeIs('login'))
        <div class="cn-toast error" role="alert">
            <i class="bi bi-x-octagon-fill"></i>
            <div>Data belum valid. Periksa kembali isian yang ditandai merah.</div>
            <button type="button" class="close" aria-label="Tutup">&times;</button>
        </div>
    @endif
</div>
