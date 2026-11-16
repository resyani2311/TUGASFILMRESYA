@extends('templates.index')
@section('title', 'Login')
@section('content')
<div class="container">
  <div class="page-card">
    <h3>Login</h3>
    <form action="{{ route('login.store') }}" method="post">
      @csrf
      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
      @error('email')<div class="text-danger">{{ $message }}</div>@enderror
      <label for="password">Password</label>
      <input type="password" id="password" name="password" class="form-control" required>
      <div class="checkbox"><label><input type="checkbox" name="remember" value="1"> Ingat saya</label></div>
      <button type="submit" class="btn-red">Login</button>
    </form>
    <p class="hint">Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
  </div>
</div>
@endsection
