@extends('layouts.admin')

@section('title', 'Data Cast')
@section('crumb', 'Data Cast')

@section('content')
    <div class="adm-title">
        <div><h1>Data Cast</h1><p>Kelola data pemeran film.</p></div>
        <a href="{{ route('admin.cast.create') }}" class="btn-cine"><i class="bi bi-plus-lg"></i> Tambah Cast</a>
    </div>

    <div class="adm-card">
        <div class="adm-card-head">
            <h2>Daftar Cast <span class="badge-soft ms-1">{{ $casts->total() }}</span></h2>
            <form method="GET" class="adm-search">
                <input type="search" name="q" value="{{ $q }}" class="form-control form-control-sm" placeholder="Cari nama...">
                <button class="btn-cine btn-sm" type="submit"><i class="bi bi-search"></i></button>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table adm-table table-hover">
                <thead><tr><th>#</th><th>Nama</th><th>Umur</th><th>Biografi</th><th>Peran</th><th class="text-end">Aksi</th></tr></thead>
                <tbody>
                    @forelse ($casts as $cast)
                        <tr>
                            <td class="text-muted">{{ $casts->firstItem() + $loop->index }}</td>
                            <td class="fw-semibold">{{ $cast->nama }}</td>
                            <td>{{ $cast->umur }}</td>
                            <td><span class="truncate text-muted">{{ $cast->bio }}</span></td>
                            <td>{{ $cast->perans_count }}</td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('admin.cast.show', $cast) }}" class="btn-icon view" title="Detail"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('admin.cast.edit', $cast) }}" class="btn-icon edit" title="Edit"><i class="bi bi-pencil"></i></a>
                                    <button type="button" class="btn-icon danger" title="Hapus" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                            data-action="{{ route('admin.cast.destroy', $cast) }}" data-name="cast {{ $cast->nama }}"
                                            data-note="Semua peran milik cast ini ikut terhapus."><i class="bi bi-trash3"></i></button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-5">{{ $q !== '' ? 'Cast tidak ditemukan.' : 'Belum ada cast.' }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3 d-flex justify-content-center">{{ $casts->links() }}</div>
@endsection
