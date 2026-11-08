@extends('layouts.admin')

@section('title', 'Tambah Genre')
@section('crumb', 'Data Genre › Tambah')

@section('content')
    <div class="adm-title"><div><h1>Tambah Genre</h1><p>Tambahkan genre film baru.</p></div></div>
    <form action="{{ route('admin.genre.store') }}" method="POST" novalidate>
        @csrf
        @include('admin.genres._form')
    </form>
@endsection
