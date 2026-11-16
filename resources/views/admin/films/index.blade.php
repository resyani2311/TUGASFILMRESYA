@extends('layouts.admin')
@section('title', 'Data Film')
@section('heading', 'Data Film')
@section('content')
<div class="toolbar">
  @include('admin.partials.search', ['action' => route('admin.films.index'), 'placeholder' => 'Cari judul film...'])
  <a href="{{ route('admin.films.create') }}" class="btn btn-red"><i class="fa fa-plus"></i> Tambah Film</a>
</div>
<div class="panel-dark table-wrap">
  <table class="table-dark-x">
    <thead><tr><th>#</th><th>Poster</th><th>Judul</th><th>Tahun</th><th>Genre</th><th style="width:150px">Aksi</th></tr></thead>
    <tbody>
      @forelse ($films as $film)
        <tr>
          <td>{{ $film->id }}</td>
          <td><img class="thumb" src="{{ asset($film->poster) }}" alt=""></td>
          <td><a href="{{ route('movies.show', $film) }}" target="_blank">{{ $film->title }}</a></td>
          <td>{{ $film->year }}</td>
          <td>{{ $film->genre?->name }}</td>
          <td>
            <a href="{{ route('admin.films.edit', $film) }}" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i> Edit</a>
            @include('admin.partials.delete', ['action' => route('admin.films.destroy', $film), 'confirm' => 'Hapus film ini beserta komentar & perannya?'])
          </td>
        </tr>
      @empty
        <tr><td colspan="6" class="empty-note">Belum ada data film.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
{{ $films->links() }}
@endsection
