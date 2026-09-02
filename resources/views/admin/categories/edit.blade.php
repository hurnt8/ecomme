@extends('layouts.admin')

@section('title', 'Modifier — '.$category->name)

@section('content')
    <div class="bg-white rounded-lg border border-neutral-200 p-6">
        <form method="POST" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data">
            @method('PUT')
            @include('admin.categories._form')
        </form>
    </div>
@endsection
