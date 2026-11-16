@extends('layouts.admin')
@section('title', 'Data User')
@section('heading', 'Data User')
@section('content')
<div class="toolbar">
  @include('admin.partials.search', ['action' => route('admin.users.index'), 'placeholder' => 'Cari nama / email...'])
  <span style="color:#888;align-self:center">Hanya untuk dilihat (read-only)</span>
</div>
<div class="panel-dark table-wrap">
  <table class="table-dark-x">
    <thead><tr><th>#</th><th>Nama</th><th>Email</th><th>Role</th><th>Umur</th><th>Alamat</th><th>Komentar</th><th>Bergabung</th></tr></thead>
    <tbody>
      @forelse ($users as $u)
        <tr>
          <td>{{ $u->id }}</td>
          <td>{{ $u->name }}</td>
          <td>{{ $u->email }}</td>
          <td><span class="badge-role {{ $u->role?->name }}">{{ ucfirst($u->role?->name ?? '-') }}</span></td>
          <td>{{ $u->profile?->umur ?? '-' }}</td>
          <td>{{ \Illuminate\Support\Str::limit($u->profile?->alamat, 40) }}</td>
          <td>{{ $u->kritiks_count }}</td>
          <td style="white-space:nowrap">{{ $u->created_at?->format('d M Y') }}</td>
        </tr>
      @empty
        <tr><td colspan="8" class="empty-note">Tidak ada user.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
{{ $users->links() }}
@endsection
