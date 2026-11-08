@extends('layouts.admin')

@section('title', $peran->nama)
@section('crumb', 'Data Peran › Detail')

@section('content')
    <div class="adm-title">
        <div><h1>{{ $peran->nama }}</h1><p>Detail peran.</p></div>
        <a href="{{ route('admin.actor.edit', $peran) }}" class="btn-cine"><i class="bi bi-pencil"></i> Edit</a>
    </div>

    <div class="adm-card" style="max-width:640px"><div class="adm-card-body">
        <div class="info-row"><span>Nama peran</span><span>{{ $peran->nama }}</span></div>
        <div class="info-row"><span>Film</span><span><a href="{{ route('admin.film.show', $peran->film) }}">{{ $peran->film->judul }}</a> ({{ $peran->film->tahun }})</span></div>
        <div class="info-row"><span>Dimainkan oleh</span><span><a href="{{ route('admin.cast.show', $peran->cast) }}">{{ $peran->cast->nama }}</a></span></div>
    </div></div>
@endsection
