@extends('layouts.admin')

@section('title', 'Edit Film')
@section('crumb', 'Data Film › Edit')

@section('content')
    <div class="adm-title"><div><h1>Edit Film</h1><p>{{ $film->judul }} ({{ $film->tahun }})</p></div></div>
    <form action="{{ route('admin.film.update', $film) }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')
        @include('admin.films._form')
    </form>
@endsection
