@extends('layouts.admin')

@section('title', 'Modifier ' . $user->name)

@section('content')
    <form method="POST" action="{{ route('admin.utilisateurs.update', $user) }}">
        @csrf
        @method('PATCH')
        @include('admin.users._form')
    </form>
@endsection
