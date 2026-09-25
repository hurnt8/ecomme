@extends('layouts.shop')

@section('title', 'Blog')
@section('meta_description', 'Conseils d\'achat, entretien du matériel et bois de chauffage : le blog de ' . $settings->site_name . '.')

@section('content')
    <x-shop.page-hero title="Blog" subtitle="Kaufberatung, Pflege und Brennholz" image="hero-objets.jpg" />

    <div id="fh5co-product">
        <div class="container">
            @if ($posts->isEmpty())
                <p class="text-center">Aucun article publié pour le moment.</p>
            @endif

            @foreach ($posts->chunk(3) as $row)
                <div class="row">
                    @foreach ($row as $post)
                        <div class="col-md-4 text-center animate-box">
                            <div class="product">
                                <div class="product-grid" style="background-image:url('{{ $post->cover_image_url }}');">
                                    <div class="inner">
                                        <p>
                                            <a href="{{ route('blog.show', $post->slug) }}" class="icon"><i class="icon-eye"></i></a>
                                        </p>
                                    </div>
                                </div>
                                <div class="desc">
                                    <h3><a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a></h3>
                                    <p style="font-size:13px; color:#8f8f8f;">{{ $post->published_at->translatedFormat('d F Y') }}</p>
                                    <p>{{ $post->excerpt }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach

            <div class="row">
                <div class="col-md-12 text-center">
                    {{ $posts->links('partials.shop.pagination') }}
                </div>
            </div>
        </div>
    </div>
@endsection
