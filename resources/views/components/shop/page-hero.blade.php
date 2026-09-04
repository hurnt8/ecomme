{{--
    Heroes come from public/images, not public/template/images. Every img_bg_* background is a
    photograph of one of the template's own demo products — the rocking chair, the woven daybed,
    the black chair — or of a man beside a boat. Those products were removed from the catalogue,
    so the shop was illustrating every page with furniture it does not sell. Each hero here is a
    triptych of the supplier's own catalogue photography.
--}}
@props(['title', 'subtitle' => null, 'image' => 'hero-maison.jpg'])

<header id="fh5co-header" class="fh5co-cover fh5co-cover-sm fh5co-cover-compact" role="banner" style="background-image:url({{ asset('images/'.$image) }});">
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
