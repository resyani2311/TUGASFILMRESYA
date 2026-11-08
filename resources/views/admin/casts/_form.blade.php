<div class="adm-card" style="max-width: 760px">
    <div class="adm-card-head"><h2>Data Cast</h2></div>
    <div class="adm-card-body">
        <div class="row g-3">
            <div class="col-md-8">
                <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                <input type="text" id="nama" name="nama" maxlength="45" value="{{ old('nama', $cast->nama ?? '') }}" class="form-control @error('nama') is-invalid @enderror" required>
                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label for="umur" class="form-label">Umur <span class="text-danger">*</span></label>
                <input type="number" id="umur" name="umur" min="1" max="120" value="{{ old('umur', $cast->umur ?? '') }}" class="form-control @error('umur') is-invalid @enderror" required>
                @error('umur')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12">
                <label for="bio" class="form-label">Biografi <span class="text-danger">*</span></label>
                <textarea id="bio" name="bio" rows="5" class="form-control @error('bio') is-invalid @enderror" required>{{ old('bio', $cast->bio ?? '') }}</textarea>
                @error('bio')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn-cine" data-loading="Menyimpan..."><i class="bi bi-check-lg"></i> {{ isset($cast) ? 'Simpan Perubahan' : 'Simpan' }}</button>
            <a href="{{ route('admin.cast.index') }}" class="btn-ghost">Batal</a>
        </div>
    </div>
</div>
