@extends('layouts.admin')
@php $edit = $film->exists; @endphp
@section('title', $edit ? 'Edit Film' : 'Tambah Film')
@section('heading', $edit ? 'Edit Film' : 'Tambah Film')
@section('content')
<div class="panel-dark" style="max-width:760px">
  <form action="{{ $edit ? route('admin.films.update', $film) : route('admin.films.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    @if ($edit) @method('PUT') @endif
    <label>Judul</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', $film->title) }}" required>
    @error('title')<div class="text-danger">{{ $message }}</div>@enderror
    <div class="row">
      <div class="col-sm-4">
        <label>Tahun</label>
        <input type="number" name="year" class="form-control" value="{{ old('year', $film->year ?? now()->year) }}" required>
        @error('year')<div class="text-danger">{{ $message }}</div>@enderror
      </div>
      <div class="col-sm-8">
        <label>Genre</label>
        <select name="genre_id" class="form-control" required>
          <option value="">-- pilih genre --</option>
          @foreach ($genres as $g)
            <option value="{{ $g->id }}" @selected(old('genre_id', $film->genre_id) == $g->id)>{{ $g->name }}</option>
          @endforeach
        </select>
        @error('genre_id')<div class="text-danger">{{ $message }}</div>@enderror
      </div>
    </div>
    <label>Sinopsis</label>
    <textarea name="sinopsis" rows="5" class="form-control" required>{{ old('sinopsis', $film->sinopsis) }}</textarea>
    @error('sinopsis')<div class="text-danger">{{ $message }}</div>@enderror
    <label>Poster {{ $edit ? '(kosongkan jika tidak diganti)' : '' }}</label>
    <input type="file" name="poster" class="form-control" accept="image/*" {{ $edit ? '' : 'required' }}>
    @error('poster')<div class="text-danger">{{ $message }}</div>@enderror
    @if ($edit && $film->poster)
      <img src="{{ asset($film->poster) }}" class="form-poster" alt="">
    @endif
    <div style="margin-top:20px">
      <button type="submit" class="btn btn-red"><i class="fa fa-save"></i> Simpan</button>
      <a href="{{ route('admin.films.index') }}" class="btn btn-default">Batal</a>
    </div>
  </form>
</div>
@endsection
