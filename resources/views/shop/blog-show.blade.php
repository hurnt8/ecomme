@extends('layouts.shop')

@section('title', $post->title)
@section('meta_description', $post->excerpt)

@section('content')
    <x-shop.page-hero :title="$post->title" :subtitle="$post->published_at->translatedFormat('d F Y')" image="hero-objets.jpg" />

    <div id="fh5co-about">
        <div class="container">
            <div class="row animate-box">
                <div class="col-md-8 col-md-offset-2">
                    @if ($post->cover_image_url)
                        <img class="img-responsive" src="{{ $post->cover_image_url }}" alt="{{ $post->title }}" style="margin-bottom:30px;">
                    @endif

                    <div class="desc">
                        @foreach (explode("\n\n", $post->body) as $paragraph)
                            <p>{{ $paragraph }}</p>
                        @endforeach
                    </div>

                    <p style="margin-top:30px;">
                        <a href="{{ route('blog.index') }}" class="btn btn-primary btn-outline">&larr; Retour au blog</a>
                    </p>
                </div>
            </div>

            @if ($related->isNotEmpty())
                <div class="row animate-box" style="margin-top:40px;">
                    <div class="col-md-8 col-md-offset-2 text-center fh5co-heading">
                        <h2>À lire aussi</h2>
                    </div>
                </div>
                <div class="row">
                    @foreach ($related as $item)
                        <div class="col-md-4 text-center animate-box">
                            <div class="product">
                                <div class="product-grid" style="background-image:url('{{ $item->cover_image_url }}');">
                                    <div class="inner">
                                        <p>
                                            <a href="{{ route('blog.show', $item->slug) }}" class="icon"><i class="icon-eye"></i></a>
                                        </p>
                                    </div>
                                </div>
                                <div class="desc">
                                    <h3><a href="{{ route('blog.show', $item->slug) }}">{{ $item->title }}</a></h3>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
