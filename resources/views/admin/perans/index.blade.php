@extends('layouts.admin')

@section('title', 'Data Peran')
@section('crumb', 'Data Peran')

@section('content')
    <div class="adm-title">
        <div><h1>Data Peran</h1><p>Peran yang dimainkan cast pada setiap film.</p></div>
        <a href="{{ route('admin.actor.create') }}" class="btn-cine"><i class="bi bi-plus-lg"></i> Tambah Peran</a>
    </div>

    <div class="adm-card">
        <div class="adm-card-head">
            <h2>Daftar Peran <span class="badge-soft ms-1">{{ $perans->total() }}</span></h2>
            <form method="GET" class="adm-search">
                <input type="search" name="q" value="{{ $q }}" class="form-control form-control-sm" placeholder="Cari peran, film, atau cast...">
                <button class="btn-cine btn-sm" type="submit"><i class="bi bi-search"></i></button>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table adm-table table-hover">
                <thead><tr><th>#</th><th>Film</th><th>Cast</th><th>Nama Peran</th><th class="text-end">Aksi</th></tr></thead>
                <tbody>
                    @forelse ($perans as $peran)
                        <tr>
                            <td class="text-muted">{{ $perans->firstItem() + $loop->index }}</td>
                            <td>{{ $peran->film->judul }} <span class="text-muted">({{ $peran->film->tahun }})</span></td>
                            <td>{{ $peran->cast->nama }}</td>
                            <td class="fw-semibold">{{ $peran->nama }}</td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('admin.actor.show', $peran) }}" class="btn-icon view" title="Detail"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('admin.actor.edit', $peran) }}" class="btn-icon edit" title="Edit"><i class="bi bi-pencil"></i></a>
                                    <button type="button" class="btn-icon danger" title="Hapus" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                            data-action="{{ route('admin.actor.destroy', $peran) }}" data-name="peran {{ $peran->nama }} ({{ $peran->film->judul }})"><i class="bi bi-trash3"></i></button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-5">{{ $q !== '' ? 'Peran tidak ditemukan.' : 'Belum ada peran.' }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3 d-flex justify-content-center">{{ $perans->links() }}</div>
@endsection
