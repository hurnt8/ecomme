@extends('layouts.admin')

@section('title', 'Modifier — '.$product->name)

@section('content')
    <div class="bg-white rounded-lg border border-neutral-200 p-6 max-w-5xl">
        <form method="POST" action="{{ route('admin.produits.update', $product) }}" enctype="multipart/form-data">
            @method('PUT')
            @include('admin.products._form')
        </form>
    </div>
@endsection
