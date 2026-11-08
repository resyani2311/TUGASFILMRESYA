@extends('layouts.admin')

@section('title', 'Edit Cast')
@section('crumb', 'Data Cast › Edit')

@section('content')
    <div class="adm-title"><div><h1>Edit Cast</h1><p>{{ $cast->nama }}</p></div></div>
    <form action="{{ route('admin.cast.update', $cast) }}" method="POST" novalidate>
        @csrf
        @method('PUT')
        @include('admin.casts._form')
    </form>
@endsection
