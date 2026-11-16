@extends('templates.index')
@section('title', 'Register')
@section('content')
<div class="container">
  <div class="page-card">
    <h3>Buat Akun</h3>
    <form action="{{ route('register.store') }}" method="post">
      @csrf
      <label>Nama</label>
      <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
      @error('name')<div class="text-danger">{{ $message }}</div>@enderror
      <label>Email</label>
      <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
      @error('email')<div class="text-danger">{{ $message }}</div>@enderror
      <label>Umur</label>
      <input type="number" name="umur" value="{{ old('umur') }}" class="form-control" min="1" max="120" required>
      @error('umur')<div class="text-danger">{{ $message }}</div>@enderror
      <label>Alamat</label>
      <textarea name="alamat" class="form-control" rows="2" required>{{ old('alamat') }}</textarea>
      @error('alamat')<div class="text-danger">{{ $message }}</div>@enderror
      <label>Password</label>
      <input type="password" name="password" class="form-control" required>
      @error('password')<div class="text-danger">{{ $message }}</div>@enderror
      <label>Konfirmasi Password</label>
      <input type="password" name="password_confirmation" class="form-control" required>
      <button type="submit" class="btn-red">Daftar</button>
    </form>
    <p class="hint">Sudah punya akun? <a href="{{ route('login') }}">Login</a></p>
  </div>
</div>
@endsection
