@extends('layouts.admin')
@section('title', 'Data Cast')
@section('heading', 'Data Cast')
@section('content')
<div class="toolbar">
  @include('admin.partials.search', ['action' => route('admin.casts.index'), 'placeholder' => 'Cari nama cast...'])
  <a href="{{ route('admin.casts.create') }}" class="btn btn-red"><i class="fa fa-plus"></i> Tambah Cast</a>
</div>
<div class="panel-dark table-wrap">
  <table class="table-dark-x">
    <thead><tr><th>#</th><th>Nama</th><th>Umur</th><th>Bio</th><th>Jml Peran</th><th style="width:150px">Aksi</th></tr></thead>
    <tbody>
      @forelse ($casts as $cast)
        <tr>
          <td>{{ $cast->id }}</td>
          <td>{{ $cast->name }}</td>
          <td>{{ $cast->age }}</td>
          <td>{{ \Illuminate\Support\Str::limit($cast->bio, 70) }}</td>
          <td>{{ $cast->perans_count }}</td>
          <td>
            <a href="{{ route('admin.casts.edit', $cast) }}" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i> Edit</a>
            @include('admin.partials.delete', ['action' => route('admin.casts.destroy', $cast), 'confirm' => 'Hapus cast ini beserta data perannya?'])
          </td>
        </tr>
      @empty
        <tr><td colspan="6" class="empty-note">Belum ada data cast.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
{{ $casts->links() }}
@endsection
