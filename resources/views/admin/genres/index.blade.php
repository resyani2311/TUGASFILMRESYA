@extends('layouts.admin')

@section('title', 'Data Genre')
@section('crumb', 'Data Genre')

@section('content')
    <div class="adm-title">
        <div><h1>Data Genre</h1><p>Kelola kategori genre film.</p></div>
        <a href="{{ route('admin.genre.create') }}" class="btn-cine"><i class="bi bi-plus-lg"></i> Tambah Genre</a>
    </div>

    <div class="adm-card">
        <div class="adm-card-head">
            <h2>Daftar Genre <span class="badge-soft ms-1">{{ $genres->total() }}</span></h2>
            <form method="GET" class="adm-search">
                <input type="search" name="q" value="{{ $q }}" class="form-control form-control-sm" placeholder="Cari genre...">
                <button class="btn-cine btn-sm" type="submit"><i class="bi bi-search"></i></button>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table adm-table table-hover">
                <thead><tr><th>#</th><th>Nama Genre</th><th>Jumlah Film</th><th class="text-end">Aksi</th></tr></thead>
                <tbody>
                    @forelse ($genres as $genre)
                        <tr>
                            <td class="text-muted">{{ $genres->firstItem() + $loop->index }}</td>
                            <td class="fw-semibold">{{ $genre->nama }}</td>
                            <td><span class="badge-soft">{{ $genre->films_count }} film</span></td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('admin.genre.show', $genre) }}" class="btn-icon view" title="Detail"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('admin.genre.edit', $genre) }}" class="btn-icon edit" title="Edit"><i class="bi bi-pencil"></i></a>
                                    <button type="button" class="btn-icon danger" title="Hapus" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                            data-action="{{ route('admin.genre.destroy', $genre) }}" data-name="genre {{ $genre->nama }}"
                                            @if ($genre->films_count > 0) data-note="Genre ini masih dipakai {{ $genre->films_count }} film dan tidak akan bisa dihapus." @endif><i class="bi bi-trash3"></i></button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-5">{{ $q !== '' ? 'Genre tidak ditemukan.' : 'Belum ada genre.' }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3 d-flex justify-content-center">{{ $genres->links() }}</div>
@endsection
