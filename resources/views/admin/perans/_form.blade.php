<div class="adm-card" style="max-width: 760px">
    <div class="adm-card-head"><h2>Data Peran</h2></div>
    <div class="adm-card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="film_id" class="form-label">Film <span class="text-danger">*</span></label>
                <select id="film_id" name="film_id" class="form-select @error('film_id') is-invalid @enderror" required>
                    <option value="">&mdash; Pilih film &mdash;</option>
                    @foreach ($films as $film)
                        <option value="{{ $film->id }}" @selected((string) old('film_id', $peran->film_id ?? '') === (string) $film->id)>{{ $film->judul }} ({{ $film->tahun }})</option>
                    @endforeach
                </select>
                @error('film_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="cast_id" class="form-label">Cast / Pemeran <span class="text-danger">*</span></label>
                <select id="cast_id" name="cast_id" class="form-select @error('cast_id') is-invalid @enderror" required>
                    <option value="">&mdash; Pilih cast &mdash;</option>
                    @foreach ($casts as $cast)
                        <option value="{{ $cast->id }}" @selected((string) old('cast_id', $peran->cast_id ?? '') === (string) $cast->id)>{{ $cast->nama }}</option>
                    @endforeach
                </select>
                @error('cast_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12">
                <label for="nama" class="form-label">Nama peran <span class="text-danger">*</span></label>
                <input type="text" id="nama" name="nama" maxlength="45" value="{{ old('nama', $peran->nama ?? '') }}" placeholder="Contoh: Dom Cobb" class="form-control @error('nama') is-invalid @enderror" required>
                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        @if ($films->isEmpty() || $casts->isEmpty())
            <div class="alert alert-warning mt-3 mb-0 small">Tambahkan data film dan cast terlebih dahulu sebelum membuat peran.</div>
        @endif

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn-cine" data-loading="Menyimpan..."><i class="bi bi-check-lg"></i> {{ isset($peran) ? 'Simpan Perubahan' : 'Simpan' }}</button>
            <a href="{{ route('admin.actor.index') }}" class="btn-ghost">Batal</a>
        </div>
    </div>
</div>
