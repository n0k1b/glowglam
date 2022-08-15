(function($) {
    "use strict";

    $(window).on('resize', function() {
        var win = $(this); //this = window
        if (win.width() > 990) { history.go(0); } else if (win.width() < 990) { history.go(0); }
    });

    //Detect device mobile
    var isMobile = false;
    if (/Android|webOS|iPhone|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) || ($(window).width() < 1100)) {
        $('body').addClass('mobile');
        isMobile = true;
    } else {
        isMobile = false;
    }


    if (!isMobile) {
        $(window).scroll(function() {
            var sc = $(window).scrollTop();
            var menu = $('#main-menu').clone();
            if (sc > 300) {
                $("#header-middle").addClass("fixed");
                $("#header-middle .middle-column .header-search").hide();
                $("#header-middle .middle-column .fixed-menu").html(menu);
            } else {
                $("#header-middle").removeClass("fixed");
                $("#header-middle .middle-column .fixed-menu").html('');
                $("#header-middle .middle-column .header-search").show();
            }
        });
    }

    if (isMobile) {

        var lang_opt = $('.language-switcher').clone();
        var currency_opt = $('.currency-switcher').clone();
        var top_menu = $('.header-top-menu').clone();
        var social = $('.header-top-social').clone();
        $("#mobile-nav").append(top_menu);
        $("#mobile-nav").append(lang_opt);
        $("#mobile-nav").append(currency_opt);
        $("#mobile-nav").append(social);

        $(".mega-title").addClass("has-dropdown");
        $(".mega-title ul").addClass("dropdown");

        $(".has-dropdown").on("click", function() {
            $(this).find("> .dropdown").toggleClass("show");
        });

        $(".dropdown .has-dropdown").on("click", function() {
            $(this).parent().toggleClass("show");
        });

        $(".mobile-menu-icon").on("click", function() {
            $('.body__overlay').addClass('is-visible');
            $("#mobile-nav").toggleClass("show");
        });
    }


    /*------------------------------------------      
            Open filter menu mobile
      --------------------------------------------*/
    $('.filter-collection-left > a').on('click', function() {
        $('.wrappage').addClass('show-filter');
    });

    $('.close-sidebar-collection').on('click', function() {
        $('.wrappage').removeClass('show-filter');
    });


    /*------------------------------------------
                     Tooltip
    --------------------------------------------*/
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })

    /*------------------------------------------
                      Scroll to top
    --------------------------------------------*/
    $(window).scroll(function() {
        if ($(this).scrollTop() >= 200) { // If page is scrolled more than 50px
            $('#scrolltotop').fadeIn(500); // Fade in the arrow
        } else {
            $('#scrolltotop').fadeOut(500); // Else fade out the arrow
        }
    });
    $('#scrolltotop').click(function() { // When arrow is clicked
        $('body,html').animate({
            scrollTop: 0 // Scroll to top of body
        }, 700);
    });


    /* -------------------------------------
        JS FOR MAP START
    -------------------------------------- */
    function map() {
        if ($('#mapid').length > 0) {
            var lat = $('#mapid').data('lat');
            var lang = $('#mapid').data('lang');
            var mymap = L.map('mapid').setView([lat, lang], 20);
            L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
                maxZoom: 18,
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                    '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                    'Imagery Â© <a href="https://www.mapbox.com/">Mapbox</a>',
                id: 'mapbox.streets'
            }).addTo(mymap);

            var marker = "<img src='images/others/map-marker.png'>";
            var popup = L.popup()
                .setLatLng([lat, lang])
                .setContent(marker)
                .openOn(mymap);
        }
    }
    map();


    $('select').selectpicker();


    $(document).ready(function() {

        /*------------------------------------------
                      Filetr Show More/Less
        --------------------------------------------*/
        if ($('.filter-opt.color li').length > 3) {
            $('.filter-opt.color li:gt(2)').hide();
            $('.show-more').show();
        }

        $('.show-more').on('click', function() {
            //toggle elements with class .ty-compact-list that their index is bigger than 2
            $('.filter-opt.color li:gt(2)').toggle();
            //change text of show more element just for demonstration purposes to this demo
            $(this).html() === '<i class="ti-minus"></i> Show Less' ? $(this).html('<i class="ti-plus"></i> Show More') : $(this).html('<i class="ti-minus"></i> Show Less');
        });

        /*------------------------------------    
             Shopping Cart 
        --------------------------------------*/

        $('.cart__menu').on('click', function() {
            $('.shopping__cart').addClass('shopping__cart__on');
            $('.body__overlay').addClass('is-visible');

        });
        $('.panel_setting').on('click', function() {
            $('.setting-panel').addClass('setting-panel-on');
            $('.body__overlay').addClass('is-visible');

        });
        $('.offsetmenu__close__btn').on('click', function() {
            $('.shopping__cart').removeClass('shopping__cart__on');
            $('.body__overlay').removeClass('is-visible');
        });
        $('.offsetmenu__close__btn').on('click', function() {
            $('.setting-panel').removeClass('setting-panel-on');
            $('.body__overlay').removeClass('is-visible');
        });


        //Close body Overlay 
        $('.body__overlay').on('click', function() {
            $(this).removeClass('is-visible');
            $('.offsetmenu').removeClass('offsetmenu__on');
            $('.shopping__cart').removeClass('shopping__cart__on');
            $('.filter__wrap').removeClass('filter__menu__on');
            $('.user__meta').removeClass('user__meta__on');
            $("#mobile-nav").removeClass("show");
        });


        /*------------------------------------------
                        Carousel 
        --------------------------------------------*/

        //Single Product carousel
        var swiper = new Swiper('.single-product-slider', {
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });

        //Product carousel 1
        var swiper = new Swiper('.product-slider-wrapper.v1', {

            slidesPerView: 4,
            spaceBetween: 30,
            navigation: {
                nextEl: '.product-button-next.v1',
                prevEl: '.product-button-prev.v1',
            },
            // Responsive breakpoints
            breakpoints: {
                // when window width is <= 675
                675: {
                    slidesPerView: 1,
                    spaceBetween: 30
                },

                // when window width is <= 991
                991: {
                    slidesPerView: 2,
                    spaceBetween: 30
                },
                // when window width is <= 1024px
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 15
                }

            }
        });

        //Product carousel 2
        var swiper = new Swiper('.product-slider-wrapper.v2', {

            slidesPerView: 3,
            spaceBetween: 15,
            navigation: {
                nextEl: '.product-button-next.v2',
                prevEl: '.product-button-prev.v2',
            },
            // Responsive breakpoints
            breakpoints: {
                // when window width is <= 568px
                568: {
                    slidesPerView: 1,
                    spaceBetween: 30
                },

                // when window width is <= 991
                991: {
                    slidesPerView: 2,
                    spaceBetween: 15
                },
                // when window width is <= 1200px
                1200: {
                    slidesPerView: 3,
                    spaceBetween: 15
                }

            }
        });

        //Product carousel 3
        var swiper = new Swiper('.product-slider-wrapper.v3', {

            slidesPerView: 3,
            spaceBetween: 15,
            navigation: {
                nextEl: '.product-button-next.v3',
                prevEl: '.product-button-prev.v3',
            },
            // Responsive breakpoints
            breakpoints: {
                // when window width is <= 568px
                568: {
                    slidesPerView: 1,
                    spaceBetween: 30
                },
                // when window width is <= 767
                767: {
                    slidesPerView: 2,
                    spaceBetween: 30
                },

                // when window width is <= 991
                991: {
                    slidesPerView: 2,
                    spaceBetween: 30
                },
                // when window width is <= 1200px
                1200: {
                    slidesPerView: 3,
                    spaceBetween: 15
                }

            }
        });
        //Product carousel 4
        var swiper = new Swiper('.product-slider-wrapper.v4', {

            slidesPerView: 3,
            spaceBetween: 30,
            navigation: {
                nextEl: '.product-button-next.v4',
                prevEl: '.product-button-prev.v4',
            },
            // Responsive breakpoints
            breakpoints: {
                // when window width is <= 675px
                675: {
                    slidesPerView: 1,
                    spaceBetween: 30
                },

                // when window width is <= 991px
                991: {
                    slidesPerView: 2,
                    spaceBetween: 30
                },
                // when window width is <= 1200px
                1200: {
                    slidesPerView: 3,
                    spaceBetween: 15
                }

            }
        });
        //Single Product carousel
        var swiper = new Swiper('.single-product-slider', {
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
        var swiper = new Swiper('.single-product-slider', {
            slidesPerView: 1,
            loop: true,
            spaceBetween: 20,
            navigation: {
                nextEl: '.single-product-button.swiper-button-next',
                prevEl: '.single-product-button.swiper-button-prev',
            },
        });

        //Brands carousel
        var swiper = new Swiper('.brand-slider-wrapper', {

            slidesPerView: 6,
            spaceBetween: 30,
            loop: true,
            navigation: {
                nextEl: '.brand-button-next.v1',
                prevEl: '.brand-button-prev.v1',
            },
            // Responsive breakpoints
            breakpoints: {
                // when window width is <= 675
                675: {
                    slidesPerView: 2,
                    spaceBetween: 30
                },

                // when window width is <= 991
                991: {
                    slidesPerView: 4,
                    spaceBetween: 30
                },
                // when window width is <= 1024px
                1024: {
                    slidesPerView: 5,
                    spaceBetween: 15
                }

            }
        });

        /*------------------------------------------
                         Product quantity
        --------------------------------------------*/

        var quantitiy = 0;
        $('.quantity-right-plus').on("click", function(e) {
            e.preventDefault();
            var quantity = parseInt($(this).parent().siblings("input.input-number").val());
            $(this).parent().siblings("input.input-number").val(quantity + 1);
        });
        $('.quantity-left-minus').on("click", function(e) {
            e.preventDefault();
            var quantity = parseInt($(this).parent().siblings("input.input-number").val());
            if (quantity > 1) {
                $(this).parent().siblings("input.input-number").val(quantity - 1);
            }
        });


        /*------------------------
             price range slider
        --------------------------*/
        $("#slider-range").slider({
            range: true,
            min: 0,
            max: 500,
            values: [75, 300],
            slide: function(event, ui) {
                $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
            }
        });
        $("#amount").val("$" + $("#slider-range").slider("values", 0) +
            " - $" + $("#slider-range").slider("values", 1));



        /*------------------------
           Category menu Activation
        --------------------------*/
        $('.category-sub-menu li.has-sub').on('click', function() {
            var element = $(this);
            if (element.hasClass('open')) {
                element.removeClass('open');
                element.find('li').removeClass('open');
                element.find('ul').slideUp('fast');
            } else {
                element.addClass('open');
                element.children('ul').slideDown('fast');
                element.siblings('li').children('ul').slideUp('fast');
                element.siblings('li').removeClass('open');
                element.siblings('li').find('li').removeClass('open');
                element.siblings('li').find('ul').slideUp('fast');
            }
        });


        /*--------------------------
             Count Down Timer
         ----------------------------*/
        $('[data-countdown]').each(function() {
            var $this = $(this),
                finalDate = $(this).data('countdown');
            $this.countdown(finalDate, function(event) {
                $this.html(event.strftime('<span class="cdown day"><span class="time-count">%-D</span> <p>Days</p></span> <span class="cdown hour"><span class="time-count">%-H</span> <p>Hours</p></span> <span class="cdown minutes"><span class="time-count">%M</span> <p>mins</p></span> <span class="cdown second"><span class="time-count">%S</span> <p>secs</p></span>'));
            });
        });


    });

    /*---------------------------------------
        Slick slider with zoom
    -----------------------------------------*/
    // SLICK
    $('.slider-for').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        fade: true,
        asNavFor: '.slider-nav',
        nextArrow: '<div class="slick-next"><i class="ion-ios-arrow-right"></i></div>',
        prevArrow: '<div class="slick-prev"><i class="ion-ios-arrow-left"></i></div>',
    });
    $('.slider-nav').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        asNavFor: '.slider-for',
        dots: false,
        focusOnSelect: true,
        arrows: false,        
        vertical: true,
    });

    // ZOOM
    $('.ex1').zoom();

    // STYLE GRAB
    $('.ex2').zoom({
        on: 'grab'
    });

    // STYLE CLICK
    $('.ex3').zoom({
        on: 'click'
    });

    // STYLE TOGGLE
    $('.ex4').zoom({
        on: 'toggle'
    });

}(jQuery));