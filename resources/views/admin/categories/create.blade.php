@extends('layouts.admin')

@section('title', 'Nouvelle catégorie')

@section('content')
    <div class="bg-white rounded-lg border border-neutral-200 p-6">
        <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
            @include('admin.categories._form')
        </form>
    </div>
@endsection
