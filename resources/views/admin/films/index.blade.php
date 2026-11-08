@extends('layouts.admin')

@section('title', 'Data Film')
@section('crumb', 'Data Film')

@section('content')
    <div class="adm-title">
        <div><h1>Data Film</h1><p>Kelola daftar film yang tampil di website.</p></div>
        <a href="{{ route('admin.film.create') }}" class="btn-cine"><i class="bi bi-plus-lg"></i> Tambah Film</a>
    </div>

    <div class="adm-card">
        <div class="adm-card-head">
            <h2>Daftar Film <span class="badge-soft ms-1">{{ $films->total() }}</span></h2>
            <form method="GET" class="adm-search">
                <input type="search" name="q" value="{{ $q }}" class="form-control form-control-sm" placeholder="Cari judul...">
                <button class="btn-cine btn-sm" type="submit"><i class="bi bi-search"></i></button>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table adm-table table-hover">
                <thead>
                    <tr><th>#</th><th>Poster</th><th>Judul</th><th>Genre</th><th>Tahun</th><th>Peran</th><th>Komentar</th><th class="text-end">Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse ($films as $film)
                        <tr>
                            <td class="text-muted">{{ $films->firstItem() + $loop->index }}</td>
                            <td><img src="{{ $film->poster_url }}" class="thumb" alt="Poster {{ $film->judul }}" loading="lazy"></td>
                            <td class="fw-semibold">{{ $film->judul }}</td>
                            <td><span class="badge-soft red">{{ $film->genre->nama }}</span></td>
                            <td>{{ $film->tahun }}</td>
                            <td>{{ $film->perans_count }}</td>
                            <td>{{ $film->kritiks_count }}</td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('admin.film.show', $film) }}" class="btn-icon view" title="Detail"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('admin.film.edit', $film) }}" class="btn-icon edit" title="Edit"><i class="bi bi-pencil"></i></a>
                                    <button type="button" class="btn-icon danger" title="Hapus" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                            data-action="{{ route('admin.film.destroy', $film) }}" data-name="film {{ $film->judul }}"
                                            data-note="Peran dan komentar pada film ini ikut terhapus."><i class="bi bi-trash3"></i></button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted py-5">{{ $q !== '' ? 'Film tidak ditemukan.' : 'Belum ada film. Klik "Tambah Film".' }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3 d-flex justify-content-center">{{ $films->links() }}</div>
@endsection
