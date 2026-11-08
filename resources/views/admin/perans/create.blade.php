@extends('layouts.admin')

@section('title', 'Tambah Peran')
@section('crumb', 'Data Peran › Tambah')

@section('content')
    <div class="adm-title"><div><h1>Tambah Peran</h1><p>Hubungkan cast dengan film beserta nama perannya.</p></div></div>
    <form action="{{ route('admin.actor.store') }}" method="POST" novalidate>
        @csrf
        @include('admin.perans._form')
    </form>
@endsection
