@extends('templates.index')
@section('title', 'Profile Saya')
@section('content')
<div class="container">
  <div class="page-card wide">
    <h3>Profile Saya</h3>
    <table class="table profile-table">
      <tr><th>Nama</th><td>{{ $user->name }}</td></tr>
      <tr><th>Email</th><td>{{ $user->email }}</td></tr>
      <tr><th>Role</th><td><span class="badge-role {{ $user->role?->name }}" style="background:#eee;padding:2px 10px;border-radius:10px">{{ ucfirst($user->role?->name ?? '-') }}</span></td></tr>
      <tr><th>Umur</th><td>{{ $user->profile?->umur ?? '-' }} tahun</td></tr>
      <tr><th>Alamat</th><td>{{ $user->profile?->alamat ?? '-' }}</td></tr>
      <tr><th>Bio</th><td>{{ $user->profile?->bio ?: '-' }}</td></tr>
      <tr><th>Bergabung</th><td>{{ $user->created_at?->translatedFormat('d F Y') }}</td></tr>
      @unless ($user->isAdmin())
        <tr><th>Total Komentar</th><td>{{ $user->kritiks_count }}</td></tr>
      @endunless
    </table>
    <a href="{{ route('profile.edit') }}" class="btn-red" style="display:inline-block;padding:9px 26px;border-radius:3px;color:#fff;background:#e61e2a"><i class="fa fa-pencil"></i> Ubah Profile</a>
  </div>
</div>
@endsection
