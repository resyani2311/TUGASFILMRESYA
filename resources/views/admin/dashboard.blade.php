@extends('layouts.admin')
@section('title', 'Dashboard')
@section('heading', 'Dashboard')
@section('content')
<div class="stat-grid">
  @foreach ($stats as $label => $s)
    @if ($s['route'])
      <a href="{{ route($s['route']) }}" class="stat-card"><i class="fa {{ $s['icon'] }}"></i><div class="num">{{ number_format($s['count']) }}</div><div class="lbl">{{ $label }}</div></a>
    @else
      <div class="stat-card"><i class="fa {{ $s['icon'] }}"></i><div class="num">{{ number_format($s['count']) }}</div><div class="lbl">{{ $label }}</div></div>
    @endif
  @endforeach
</div>
<div class="panel-dark">
  <h4>Komentar Terbaru</h4>
  <div class="table-wrap">
    <table class="table-dark-x">
      <thead><tr><th>User</th><th>Film</th><th>Rating</th><th>Komentar</th><th>Waktu</th></tr></thead>
      <tbody>
        @forelse ($latestKritiks as $k)
          <tr>
            <td>{{ $k->user?->name }}</td>
            <td><a href="{{ route('movies.show', $k->film_id) }}" target="_blank">{{ $k->film?->title }}</a></td>
            <td style="color:#f5a623;white-space:nowrap">{{ str_repeat('★', $k->rating) }}</td>
            <td>{{ \Illuminate\Support\Str::limit($k->comment, 80) }}</td>
            <td style="white-space:nowrap">{{ $k->created_at?->diffForHumans() }}</td>
          </tr>
        @empty
          <tr><td colspan="5" class="empty-note">Belum ada komentar.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <p style="color:#888;margin:12px 0 0;font-size:13px">Catatan: administrator tidak dapat memberi komentar pada film; komentar hanya berasal dari user biasa.</p>
</div>
@endsection
