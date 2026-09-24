@extends('layouts.admin')

@section('title', 'Nouvel utilisateur')

@section('content')
    <form method="POST" action="{{ route('admin.utilisateurs.store') }}">
        @csrf
        @include('admin.users._form')
    </form>
@endsection
