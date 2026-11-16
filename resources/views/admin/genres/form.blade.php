@extends('layouts.admin')
@php $edit = $genre->exists; @endphp
@section('title', $edit ? 'Edit Genre' : 'Tambah Genre')
@section('heading', $edit ? 'Edit Genre' : 'Tambah Genre')
@section('content')
<div class="panel-dark" style="max-width:520px">
  <form action="{{ $edit ? route('admin.genres.update', $genre) : route('admin.genres.store') }}" method="post">
    @csrf
    @if ($edit) @method('PUT') @endif
    <label>Nama Genre</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $genre->name) }}" required>
    @error('name')<div class="text-danger">{{ $message }}</div>@enderror
    <div style="margin-top:20px">
      <button type="submit" class="btn btn-red"><i class="fa fa-save"></i> Simpan</button>
      <a href="{{ route('admin.genres.index') }}" class="btn btn-default">Batal</a>
    </div>
  </form>
</div>
@endsection
