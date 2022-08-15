(function ($) {
    "use strict";




    $(document).on('click', '.nav-link', function (event) {
        event.preventDefault();

        $('html, body').animate({
            scrollTop: $($.attr(this, 'href')).offset().top
        }, 800);
    });

    jQuery(document).ready(function ($) {




        // Sticky header
        var $header = $('#masthead');
        $(window).on('scroll', function () {
            if ($header.offset().top > 0) {
                $header.addClass('sticky');
            } else {
                $header.removeClass('sticky');
            }
        }).trigger('scroll');

        // Scroll Down
        $('a.scroll-down, a.scroll-to').on('click', function (event) {
            event.preventDefault();

            var target = $(this).attr('href');

            $([document.documentElement, document.body]).animate({
                scrollTop: $(target).offset().top
            }, 1200, 'swing');
        });

        // Demos carousel
        $('.demos-carousel')
            .on('init', function (event, slick) {
                if (slick.$slides.length < 2) {
                    return;
                }

                slick.$slides.eq(1).append('<span class="drag-guide">Drag</span>');
            })
            .on('swipe', function (event, slick) {
                if (slick.$slides.length < 2) {
                    return;
                }

                if (slick.currentSlide >= 1) {
                    slick.$slides.eq(1).find('.drag-guide').fadeOut('fast');
                } else {
                    slick.$slides.eq(1).find('.drag-guide').fadeIn('fast');
                }
            })
            .slick({
                dots: false,
                arrows: false,
                infinite: false,
                variableWidth: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                swipeToSlide: true
            });

        // Tabs
        $('.tabs').on('click', '.tabs-nav li', function () {
            var $tab = $(this),
                $panels = $tab.closest('.tabs').children('.tabs-panels').children();

            if ($tab.hasClass('active')) {
                return;
            }

            $tab.addClass('active').siblings('.active').removeClass('active');

            $panels.eq($tab.index()).addClass('showing').fadeIn(function () {
                $(this).addClass('active').removeClass('showing');
            }).siblings('.active').fadeOut(function () {
                $(this).removeClass('active');
            });
        });
        // Quick view
        $('.quick_view_button').on('click', function (event) {
            event.preventDefault();
        });

  

        // Add scrollspy to <body>
        $('body').scrollspy({
            target: ".navbar",
            offset: 50
        });

        // Add smooth scrolling on all links inside the navbar
        $("#myNavbar a").on('click', function (event) {
            // Make sure this.hash has a value before overriding default behavior
            if (this.hash !== "") {
                // Prevent default anchor click behavior
                event.preventDefault();

                // Store hash
                var hash = this.hash;

                // Using jQuery's animate() method to add smooth page scroll
                // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
                $('html, body').animate({
                    scrollTop: $(hash).offset().top
                }, 800, function () {

                    // Add hash (#) to URL when done scrolling (default click behavior)
                    window.location.hash = hash;
                });
            } // End if
        });

        // Demos carousel
        $('.demos-carousel')
            .on('init', function (event, slick) {
                if (slick.$slides.length < 2) {
                    return;
                }

                slick.$slides.eq(1).append('<span class="drag-guide">Drag</span>');
            })
            .on('swipe', function (event, slick) {
                if (slick.$slides.length < 2) {
                    return;
                }

                if (slick.currentSlide >= 1) {
                    slick.$slides.eq(1).find('.drag-guide').fadeOut('fast');
                } else {
                    slick.$slides.eq(1).find('.drag-guide').fadeIn('fast');
                }
            })
            .slick({
                dots: false,
                arrows: false,
                infinite: false,
                variableWidth: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                swipeToSlide: true
            });

        // Tabs
        $('.tabs').on('click', '.tabs-nav li', function () {
            var $tab = $(this),
                $panels = $tab.closest('.tabs').children('.tabs-panels').children();

            if ($tab.hasClass('active')) {
                return;
            }

            $tab.addClass('active').siblings('.active').removeClass('active');

            $panels.eq($tab.index()).addClass('showing').fadeIn(function () {
                $(this).addClass('active').removeClass('showing');
            }).siblings('.active').fadeOut(function () {
                $(this).removeClass('active');
            });
        });

    });





}(jQuery));
