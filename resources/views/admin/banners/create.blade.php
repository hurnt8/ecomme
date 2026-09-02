@extends('layouts.admin')

@section('title', 'Nouvelle bannière')

@section('content')
    <div class="bg-white rounded-lg border border-neutral-200 p-6">
        <form method="POST" action="{{ route('admin.bannieres.store') }}" enctype="multipart/form-data">
            @include('admin.banners._form')
        </form>
    </div>
@endsection
