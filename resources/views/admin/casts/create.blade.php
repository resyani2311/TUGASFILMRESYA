@extends('layouts.admin')

@section('title', 'Tambah Cast')
@section('crumb', 'Data Cast › Tambah')

@section('content')
    <div class="adm-title"><div><h1>Tambah Cast</h1><p>Tambahkan pemeran baru.</p></div></div>
    <form action="{{ route('admin.cast.store') }}" method="POST" novalidate>
        @csrf
        @include('admin.casts._form')
    </form>
@endsection
