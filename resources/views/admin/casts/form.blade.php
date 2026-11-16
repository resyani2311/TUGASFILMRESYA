@extends('layouts.admin')
@php $edit = $cast->exists; @endphp
@section('title', $edit ? 'Edit Cast' : 'Tambah Cast')
@section('heading', $edit ? 'Edit Cast' : 'Tambah Cast')
@section('content')
<div class="panel-dark" style="max-width:640px">
  <form action="{{ $edit ? route('admin.casts.update', $cast) : route('admin.casts.store') }}" method="post">
    @csrf
    @if ($edit) @method('PUT') @endif
    <label>Nama</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $cast->name) }}" required>
    @error('name')<div class="text-danger">{{ $message }}</div>@enderror
    <label>Umur</label>
    <input type="number" name="age" class="form-control" value="{{ old('age', $cast->age) }}" required>
    @error('age')<div class="text-danger">{{ $message }}</div>@enderror
    <label>Bio</label>
    <textarea name="bio" rows="4" class="form-control" required>{{ old('bio', $cast->bio) }}</textarea>
    @error('bio')<div class="text-danger">{{ $message }}</div>@enderror
    <div style="margin-top:20px">
      <button type="submit" class="btn btn-red"><i class="fa fa-save"></i> Simpan</button>
      <a href="{{ route('admin.casts.index') }}" class="btn btn-default">Batal</a>
    </div>
  </form>
</div>
@endsection
