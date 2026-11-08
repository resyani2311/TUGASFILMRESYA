<div class="adm-card" style="max-width: 560px">
    <div class="adm-card-head"><h2>Data Genre</h2></div>
    <div class="adm-card-body">
        <label for="nama" class="form-label">Nama genre <span class="text-danger">*</span></label>
        <input type="text" id="nama" name="nama" maxlength="45" value="{{ old('nama', $genre->nama ?? '') }}" class="form-control @error('nama') is-invalid @enderror" required>
        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
        <div class="form-text">Minimal 3 karakter, tidak boleh sama dengan genre lain.</div>

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn-cine" data-loading="Menyimpan..."><i class="bi bi-check-lg"></i> {{ isset($genre) ? 'Simpan Perubahan' : 'Simpan' }}</button>
            <a href="{{ route('admin.genre.index') }}" class="btn-ghost">Batal</a>
        </div>
    </div>
</div>
