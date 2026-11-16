@extends('templates.index')
@section('title', 'Ubah Profile')
@section('content')
<div class="container">
  <div class="page-card wide">
    <h3>Ubah Profile</h3>
    <form action="{{ route('profile.update') }}" method="post">
      @csrf @method('PUT')
      <div class="row">
        <div class="col-sm-6">
          <label>Nama</label>
          <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
          @error('name')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="col-sm-6">
          <label>Email</label>
          <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
          @error('email')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="col-sm-4">
          <label>Umur</label>
          <input type="number" name="umur" value="{{ old('umur', $user->profile?->umur) }}" class="form-control" min="1" max="120" required>
          @error('umur')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="col-sm-8">
          <label>Alamat</label>
          <input type="text" name="alamat" value="{{ old('alamat', $user->profile?->alamat) }}" class="form-control" required>
          @error('alamat')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="col-sm-12">
          <label>Bio</label>
          <textarea name="bio" rows="3" class="form-control">{{ old('bio', $user->profile?->bio) }}</textarea>
          @error('bio')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="col-sm-6">
          <label>Password baru <small>(kosongkan jika tidak diubah)</small></label>
          <input type="password" name="password" class="form-control" autocomplete="new-password">
          @error('password')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="col-sm-6">
          <label>Konfirmasi password baru</label>
          <input type="password" name="password_confirmation" class="form-control" autocomplete="new-password">
        </div>
      </div>
      <button type="submit" class="btn-red">Simpan</button>
      <a href="{{ route('profile.show') }}" class="btn btn-default" style="margin-top:16px">Batal</a>
    </form>
  </div>
</div>
@endsection
