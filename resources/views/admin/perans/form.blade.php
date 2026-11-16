@extends('layouts.admin')
@php $edit = $peran->exists; @endphp
@section('title', $edit ? 'Edit Peran' : 'Tambah Peran')
@section('heading', $edit ? 'Edit Peran' : 'Tambah Peran')
@section('content')
<div class="panel-dark" style="max-width:640px">
  <form action="{{ $edit ? route('admin.perans.update', $peran) : route('admin.perans.store') }}" method="post">
    @csrf
    @if ($edit) @method('PUT') @endif
    <label>Film</label>
    <select name="film_id" class="form-control" required>
      <option value="">-- pilih film --</option>
      @foreach ($films as $f)
        <option value="{{ $f->id }}" @selected(old('film_id', $peran->film_id) == $f->id)>{{ $f->title }} ({{ $f->year }}) #{{ $f->id }}</option>
      @endforeach
    </select>
    @error('film_id')<div class="text-danger">{{ $message }}</div>@enderror
    <label>Cast</label>
    <select name="cast_id" class="form-control" required>
      <option value="">-- pilih cast --</option>
      @foreach ($casts as $c)
        <option value="{{ $c->id }}" @selected(old('cast_id', $peran->cast_id) == $c->id)>{{ $c->name }}</option>
      @endforeach
    </select>
    @error('cast_id')<div class="text-danger">{{ $message }}</div>@enderror
    <label>Nama Peran</label>
    <input type="text" name="actor" class="form-control" value="{{ old('actor', $peran->actor) }}" placeholder="contoh: Raka (Tokoh Utama)" required>
    @error('actor')<div class="text-danger">{{ $message }}</div>@enderror
    <div style="margin-top:20px">
      <button type="submit" class="btn btn-red"><i class="fa fa-save"></i> Simpan</button>
      <a href="{{ route('admin.perans.index') }}" class="btn btn-default">Batal</a>
    </div>
  </form>
</div>
@endsection
