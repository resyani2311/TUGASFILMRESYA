@extends('layouts.admin')
@section('title', 'Data Genre')
@section('heading', 'Data Genre')
@section('content')
<div class="toolbar">
  <span></span>
  <a href="{{ route('admin.genres.create') }}" class="btn btn-red"><i class="fa fa-plus"></i> Tambah Genre</a>
</div>
<div class="panel-dark table-wrap">
  <table class="table-dark-x">
    <thead><tr><th>#</th><th>Nama Genre</th><th>Jumlah Film</th><th style="width:150px">Aksi</th></tr></thead>
    <tbody>
      @forelse ($genres as $genre)
        <tr>
          <td>{{ $genre->id }}</td>
          <td>{{ $genre->name }}</td>
          <td>{{ $genre->films_count }}</td>
          <td>
            <a href="{{ route('admin.genres.edit', $genre) }}" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i> Edit</a>
            @include('admin.partials.delete', ['action' => route('admin.genres.destroy', $genre)])
          </td>
        </tr>
      @empty
        <tr><td colspan="4" class="empty-note">Belum ada genre.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
{{ $genres->links() }}
@endsection
