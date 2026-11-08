@extends('layouts.admin')

@section('title', 'Edit Genre')
@section('crumb', 'Data Genre › Edit')

@section('content')
    <div class="adm-title"><div><h1>Edit Genre</h1><p>{{ $genre->nama }}</p></div></div>
    <form action="{{ route('admin.genre.update', $genre) }}" method="POST" novalidate>
        @csrf
        @method('PUT')
        @include('admin.genres._form')
    </form>
@endsection
