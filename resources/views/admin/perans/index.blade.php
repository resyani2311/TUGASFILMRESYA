@extends('layouts.admin')
@section('title', 'Data Peran')
@section('heading', 'Data Peran')
@section('content')
<div class="toolbar">
  @include('admin.partials.search', ['action' => route('admin.perans.index'), 'placeholder' => 'Cari film / cast / peran...'])
  <a href="{{ route('admin.perans.create') }}" class="btn btn-red"><i class="fa fa-plus"></i> Tambah Peran</a>
</div>
<div class="panel-dark table-wrap">
  <table class="table-dark-x">
    <thead><tr><th>#</th><th>Film</th><th>Cast</th><th>Peran</th><th style="width:150px">Aksi</th></tr></thead>
    <tbody>
      @forelse ($perans as $peran)
        <tr>
          <td>{{ $peran->id }}</td>
          <td>{{ $peran->film?->title }} <small style="color:#888">({{ $peran->film?->year }})</small></td>
          <td>{{ $peran->cast?->name }}</td>
          <td>{{ $peran->actor }}</td>
          <td>
            <a href="{{ route('admin.perans.edit', $peran) }}" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i> Edit</a>
            @include('admin.partials.delete', ['action' => route('admin.perans.destroy', $peran)])
          </td>
        </tr>
      @empty
        <tr><td colspan="5" class="empty-note">Belum ada data peran.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
{{ $perans->links() }}
@endsection
