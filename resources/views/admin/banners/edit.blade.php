@extends('layouts.admin')

@section('title', 'Modifier — '.$banner->title)

@section('content')
    <div class="bg-white rounded-lg border border-neutral-200 p-6">
        <form method="POST" action="{{ route('admin.bannieres.update', $banner) }}" enctype="multipart/form-data">
            @method('PUT')
            @include('admin.banners._form')
        </form>
    </div>
@endsection
