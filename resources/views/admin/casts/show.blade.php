@extends('layouts.admin')

@section('title', $cast->nama)
@section('crumb', 'Data Cast › Detail')

@section('content')
    <div class="adm-title">
        <div><h1>{{ $cast->nama }}</h1><p>Detail pemeran.</p></div>
        <a href="{{ route('admin.cast.edit', $cast) }}" class="btn-cine"><i class="bi bi-pencil"></i> Edit</a>
    </div>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="adm-card"><div class="adm-card-body">
                <div class="info-row"><span>Nama</span><span>{{ $cast->nama }}</span></div>
                <div class="info-row"><span>Umur</span><span>{{ $cast->umur }} tahun</span></div>
                <div class="info-row"><span>Biografi</span><span style="max-width:70%">{{ $cast->bio }}</span></div>
            </div></div>
        </div>
        <div class="col-lg-7">
            <div class="adm-card">
                <div class="adm-card-head"><h2>Filmografi &amp; Peran</h2></div>
                <div class="table-responsive">
                    <table class="table adm-table">
                        <thead><tr><th>Film</th><th>Peran</th></tr></thead>
                        <tbody>
                            @forelse ($cast->perans as $peran)
                                <tr><td><a href="{{ route('admin.film.show', $peran->film) }}">{{ $peran->film->judul }}</a> <span class="text-muted">({{ $peran->film->tahun }})</span></td><td>{{ $peran->nama }}</td></tr>
                            @empty
                                <tr><td colspan="2" class="text-center text-muted py-4">Belum memiliki peran.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
