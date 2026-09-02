@extends('layouts.admin')

@section('title', 'Nouveau produit')

@section('content')
    <div class="bg-white rounded-lg border border-neutral-200 p-6 max-w-5xl">
        <form method="POST" action="{{ route('admin.produits.store') }}" enctype="multipart/form-data">
            @include('admin.products._form')
        </form>
    </div>
@endsection
