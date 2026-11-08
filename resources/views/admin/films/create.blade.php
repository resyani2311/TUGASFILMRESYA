@extends('layouts.admin')

@section('title', 'Tambah Film')
@section('crumb', 'Data Film › Tambah')

@section('content')
    <div class="adm-title"><div><h1>Tambah Film</h1><p>Lengkapi data film baru.</p></div></div>
    <form action="{{ route('admin.film.store') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        @include('admin.films._form')
    </form>
@endsection
