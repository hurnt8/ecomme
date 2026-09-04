/*
 * Adapted from the shop-master template's main.js. Kept as a vendored jQuery
 * script (not ported to Alpine) because the mobile off-canvas menu, dropdown
 * hover and carousels are tightly coupled to animate.css/Owl/Flexslider
 * classes already shipped with the template's CSS — reimplementing them
 * would mean redefining that motion design, not simplifying it.
 *
 * Dropped from the original main.js: the page loader fade (no loader element
 * in this build), and the scroll-triggered counter/animate-box reveal (relied
 * on Modernizr's ".js" html class, which this build does not add).
 */
;(function ($) {
    'use strict';

    var closeOffcanvas = function () {
        $('body').removeClass('overflow offcanvas');
        $('.fh5co-nav-toggle').removeClass('active').attr('aria-expanded', 'false');
    };

    var mobileMenuOutsideClick = function () {
        $(document).click(function (e) {
            var container = $('#fh5co-offcanvas, .js-fh5co-nav-toggle');
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                if ($('body').hasClass('offcanvas')) {
                    closeOffcanvas();
                }
            }
        });

        // Escape closes it too — the panel traps the page behind body.overflow, so there needs
        // to be a keyboard way out.
        $(document).on('keyup', function (e) {
            if (e.key === 'Escape' && $('body').hasClass('offcanvas')) {
                closeOffcanvas();
            }
        });
    };

    var offcanvasMenu = function () {
        $('#page').prepend('<div id="fh5co-offcanvas" />');

        // The toggle is declared in the header markup so it sits on the logo's line (see
        // header.blade.php); only fall back to injecting one if that markup isn't present.
        if (!$('.js-fh5co-nav-toggle').length) {
            $('#page').prepend('<a href="#" class="js-fh5co-nav-toggle fh5co-nav-toggle fh5co-nav-white"><i></i></a>');
        }

        // The toggle sits behind the panel once it slides in, so the panel carries its own
        // close control rather than relying on the burger to double as one.
        $('#fh5co-offcanvas').append(
            '<a href="#" class="js-fh5co-nav-toggle offcanvas-close" aria-label="Fermer le menu">&times;</a>'
        );

        $('#fh5co-offcanvas').append($('.menu-1 > ul').clone());
        $('#fh5co-offcanvas').append($('.menu-2 > ul').clone());

        $('#fh5co-offcanvas .has-dropdown').addClass('offcanvas-has-dropdown');
        $('#fh5co-offcanvas').find('li').removeClass('has-dropdown');

        // mouseenter/mouseleave (as used for the desktop dropdown() below) never fires on a
        // touch device, and the off-canvas menu only ever shows below 768px — i.e. only on
        // touch. Tap the link itself to toggle the submenu instead of following it.
        $('#fh5co-offcanvas').on('click', '.offcanvas-has-dropdown > a', function (event) {
            event.preventDefault();
            $(this).parent().toggleClass('active').find('> .dropdown').slideToggle(300);
        });

        $(window).resize(function () {
            if ($('body').hasClass('offcanvas')) {
                closeOffcanvas();
            }
        });
    };

    var burgerMenu = function () {
        $('body').on('click', '.js-fh5co-nav-toggle', function (event) {
            event.preventDefault();

            var opening = !$('body').hasClass('offcanvas');

            $('body').toggleClass('overflow offcanvas', opening);
            // Only the burger carries the open/close animation; the panel's own close button
            // is not the element being toggled, so target the burger explicitly.
            $('.fh5co-nav-toggle').not('.offcanvas-close').toggleClass('active', opening)
                .attr('aria-expanded', opening ? 'true' : 'false');
        });
    };

    var dropdown = function () {
        $('.has-dropdown').mouseenter(function () {
            $(this).find('.dropdown').css('display', 'block').addClass('animated-fast fadeInUpMenu');
        }).mouseleave(function () {
            $(this).find('.dropdown').css('display', 'none').removeClass('animated-fast fadeInUpMenu');
        });
    };

    /*
     * Rewritten from the template's version, which absolutely positioned every panel and then
     * measured a height for the wrapper in JS (tab nav height — counted twice, since the nav sits
     * outside the wrapper — plus the active panel plus a flat 90px). That left a large dead gap
     * under short panels and risked long ones overflowing into the next section. It also only
     * cleared `.active` from the nav items, never from the panels, so every panel visited stayed
     * active. Panels now sit in normal flow (see .fh5co-tab-content-wrap in app.css) and each
     * .fh5co-tabs block manages only its own panels.
     */
    var tabs = function () {
        $('.fh5co-tab-nav a').on('click', function (event) {
            event.preventDefault();

            var $this = $(this),
                tab = $this.data('tab'),
                $tabs = $this.closest('.fh5co-tabs');

            $tabs.find('.fh5co-tab-nav li').removeClass('active');
            $this.closest('li').addClass('active');

            $tabs.find('.tab-content').removeClass('active animated-fast fadeIn');
            $tabs.find('.tab-content[data-tab-content="' + tab + '"]')
                .addClass('active animated-fast fadeIn');
        });
    };

    var goToTop = function () {
        $('.js-gotop').on('click', function (event) {
            event.preventDefault();
            $('html, body').animate({ scrollTop: $('html').offset().top }, 500, 'easeInOutExpo');
            return false;
        });

        $(window).scroll(function () {
            $('.js-top').toggleClass('active', $(window).scrollTop() > 200);
        });
    };

    var sliderMain = function () {
        var $slider = $('#fh5co-hero .flexslider');
        if (!$slider.length) return;

        $slider.flexslider({
            animation: 'fade',
            slideshowSpeed: 5000,
            directionNav: true,
            start: function () {
                setTimeout(function () {
                    $('.slider-text').removeClass('animated fadeInUp');
                    $('.flex-active-slide').find('.slider-text').addClass('animated fadeInUp');
                }, 500);
            },
            before: function () {
                setTimeout(function () {
                    $('.slider-text').removeClass('animated fadeInUp');
                    $('.flex-active-slide').find('.slider-text').addClass('animated fadeInUp');
                }, 500);
            },
        });

        // The template sized each slide to the full window height, ignoring the announcement bar
        // and nav sitting above it — so the hero always ran past the fold by exactly the height
        // of that chrome, pushing anything anchored to its bottom edge off screen. Subtract it
        // (floored, so the hero stays usable on very short windows).
        var sizeSlides = function () {
            var above = $('#fh5co-hero').offset().top;
            var height = Math.max($(window).height() - above, 420);

            $('#fh5co-hero .flexslider .slides > li').css('height', height);
        };

        sizeSlides();
        $(window).resize(sizeSlides);
    };

    var testimonialCarousel = function () {
        var $owl = $('.owl-carousel-fullwidth');
        if (!$owl.length) return;

        $owl.owlCarousel({
            items: 1,
            loop: true,
            margin: 0,
            nav: false,
            dots: true,
            smartSpeed: 800,
            autoHeight: true,
        });
    };

    var productGalleryCarousel = function () {
        var $owl = $('.product-carousel');
        if (!$owl.length) return;

        $owl.owlCarousel({
            items: 1,
            loop: false,
            margin: 0,
            nav: true,
            dots: true,
            smartSpeed: 500,
        });
    };

    $(function () {
        mobileMenuOutsideClick();
        offcanvasMenu();
        burgerMenu();
        dropdown();
        tabs();
        goToTop();
        sliderMain();
        testimonialCarousel();
        productGalleryCarousel();
    });
})(jQuery);
