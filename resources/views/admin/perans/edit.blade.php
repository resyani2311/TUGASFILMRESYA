@extends('layouts.admin')

@section('title', 'Edit Peran')
@section('crumb', 'Data Peran › Edit')

@section('content')
    <div class="adm-title"><div><h1>Edit Peran</h1><p>{{ $peran->nama }} &mdash; {{ $peran->film->judul }}</p></div></div>
    <form action="{{ route('admin.actor.update', $peran) }}" method="POST" novalidate>
        @csrf
        @method('PUT')
        @include('admin.perans._form')
    </form>
@endsection
