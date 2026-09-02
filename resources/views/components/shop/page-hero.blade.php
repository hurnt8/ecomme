@props(['title', 'subtitle' => null, 'image' => 'img_bg_2.jpg'])

<header id="fh5co-header" class="fh5co-cover fh5co-cover-sm" role="banner" style="background-image:url({{ asset('template/images/'.$image) }});">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 text-center">
                <div class="display-t">
                    <div class="display-tc animate-box" data-animate-effect="fadeIn">
                        <h1>{{ $title }}</h1>
                        @if ($subtitle)
                            <h2>{{ $subtitle }}</h2>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
