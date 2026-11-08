@php($editing = isset($film))
<div class="row g-4">
    <div class="col-lg-8">
        <div class="adm-card">
            <div class="adm-card-head"><h2>Informasi Film</h2></div>
            <div class="adm-card-body">
                <div class="row g-3">
                    <div class="col-md-8">
                        <label for="judul" class="form-label">Judul <span class="text-danger">*</span></label>
                        <input type="text" id="judul" name="judul" maxlength="45" value="{{ old('judul', $film->judul ?? '') }}" class="form-control @error('judul') is-invalid @enderror" required>
                        @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label for="tahun" class="form-label">Tahun <span class="text-danger">*</span></label>
                        <input type="number" id="tahun" name="tahun" min="1888" max="{{ date('Y') + 5 }}" value="{{ old('tahun', $film->tahun ?? '') }}" class="form-control @error('tahun') is-invalid @enderror" required>
                        @error('tahun')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label for="genre_id" class="form-label">Genre <span class="text-danger">*</span></label>
                        <select id="genre_id" name="genre_id" class="form-select @error('genre_id') is-invalid @enderror">
                            <option value="">&mdash; Pilih genre &mdash;</option>
                            @foreach ($genres as $genre)
                                <option value="{{ $genre->id }}" @selected((string) old('genre_id', $film->genre_id ?? '') === (string) $genre->id)>{{ $genre->nama }}</option>
                            @endforeach
                        </select>
                        @error('genre_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="genre_baru" class="form-label">Atau genre baru</label>
                        <input type="text" id="genre_baru" name="genre_baru" maxlength="45" value="{{ old('genre_baru') }}" placeholder="Ketik untuk membuat genre baru" class="form-control @error('genre_baru') is-invalid @enderror">
                        @error('genre_baru')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text">Jika diisi, genre ini dipakai menggantikan pilihan di kiri.</div>
                    </div>

                    <div class="col-12">
                        <label for="ringkasan" class="form-label">Sinopsis <span class="text-danger">*</span></label>
                        <textarea id="ringkasan" name="ringkasan" rows="6" class="form-control @error('ringkasan') is-invalid @enderror" required>{{ old('ringkasan', $film->ringkasan ?? '') }}</textarea>
                        @error('ringkasan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="adm-card mb-3">
            <div class="adm-card-head"><h2>Poster @unless($editing)<span class="text-danger">*</span>@endunless</h2></div>
            <div class="adm-card-body">
                <img id="posterPreview" class="preview-img" src="{{ $editing ? $film->poster_url : '' }}" alt="Pratinjau poster" style="{{ $editing ? '' : 'display:none' }}">
                <input type="file" id="poster" name="poster" accept="image/png,image/jpeg,image/webp" data-preview="#posterPreview" class="form-control @error('poster') is-invalid @enderror" @unless($editing) required @endunless>
                @error('poster')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <div class="form-text">JPG/PNG/WEBP, maks. 2 MB. Rasio 2:3 disarankan.{{ $editing ? ' Kosongkan jika tidak diganti.' : '' }}</div>
            </div>
        </div>

        <div class="adm-card mb-3">
            <div class="adm-card-head"><h2>Banner (opsional)</h2></div>
            <div class="adm-card-body">
                <img id="backdropPreview" class="preview-img" src="{{ $editing ? $film->backdrop_url : '' }}" alt="Pratinjau banner" style="{{ $editing && $film->backdrop ? '' : 'display:none' }}">
                <input type="file" id="backdrop" name="backdrop" accept="image/png,image/jpeg,image/webp" data-preview="#backdropPreview" class="form-control @error('backdrop') is-invalid @enderror">
                @error('backdrop')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <div class="form-text">Gambar lebar 16:9 untuk hero &amp; halaman detail. Maks. 4 MB.</div>
                @if ($editing && $film->backdrop)
                    <div class="form-check mt-2"><input class="form-check-input" type="checkbox" name="remove_backdrop" value="1" id="remove_backdrop"><label class="form-check-label small" for="remove_backdrop">Hapus banner saat ini</label></div>
                @endif
            </div>
        </div>

        <div class="adm-card">
            <div class="adm-card-head"><h2>Trailer (opsional)</h2></div>
            <div class="adm-card-body">
                @if ($editing && $film->trailer)<p class="small text-muted mb-2"><i class="bi bi-camera-video"></i> Trailer sudah diunggah.</p>@endif
                <input type="file" id="trailer" name="trailer" accept="video/mp4,video/quicktime,video/webm,video/x-msvideo" class="form-control @error('trailer') is-invalid @enderror">
                @error('trailer')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <div class="form-text">MP4/MOV/AVI/WEBM, maks. 20 MB.</div>
                @if ($editing && $film->trailer)
                    <div class="form-check mt-2"><input class="form-check-input" type="checkbox" name="remove_trailer" value="1" id="remove_trailer"><label class="form-check-label small" for="remove_trailer">Hapus trailer saat ini</label></div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="d-flex gap-2 mt-4">
    <button type="submit" class="btn-cine" data-loading="Menyimpan..."><i class="bi bi-check-lg"></i> {{ $editing ? 'Simpan Perubahan' : 'Simpan Film' }}</button>
    <a href="{{ route('admin.film.index') }}" class="btn-ghost">Batal</a>
</div>
