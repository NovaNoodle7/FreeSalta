jQuery(document).ready(function($) {
    jQuery('.nav li.dropdown').find('.mobi-clk').each(function() {
        jQuery(this).on('click', function(event) {
            event.preventDefault();
            if (jQuery(window).width() < 768) {
                var nav = $(this).parent().parent();
                if (nav.hasClass('open')) {
                    nav.removeClass('open');
                } else {
                    nav.addClass('open');
                }
            }
            return false;
        });
    });


    $(window).scroll(function() {
        if ($(window).width() > 768) {
            if ($(this).scrollTop() > 100) {
                $('.site-header').addClass('sticky-head');
            } else {
                $('.site-header').removeClass('sticky-head');
            }
        } else {
            if ($(this).scrollTop() > 100) {
                $('.site-header').addClass('sticky-head');
            } else {
                $('.site-header').removeClass('sticky-head');
            }
        }
    });

    $(document).on('click', '.product-categories .cat-parent', function(event) {
        event.preventDefault();
        if ($(this).hasClass('show-cat-child')) {
            $(this).removeClass('show-cat-child');
        } else {
            $(this).addClass('show-cat-child');
        }
    });

    $('.home-swiper').owlCarousel({
        nav: true,
        loop: true,
        margin: 10,
        responsiveClass: true,
        items: 1,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        dots: false,
    });

    $('.shop-swiper').owlCarousel({
        nav: true,
        loop: true,
        margin: 10,
        responsiveClass: true,
        items: 1,
        lazyLoad:true,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
    });
    
    $('.blog-swiper').owlCarousel({
        nav: true,
        loop: true,
        margin: 10,
        responsiveClass: true,
        items: 1,
        lazyLoad:true,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
    });
    
    var homeSliderHeight  = $('.home-swiper').height();
    $('.home-swiper').find('.carousel-caption').each(function(index, el) {
        var captionHeight = $(this).outerHeight();
        var top = 0;
        if(homeSliderHeight > captionHeight){
            top = ((homeSliderHeight - captionHeight)/2);
        }else{
            top = 1;
        }
        top = parseInt(top);
        $(this).css('top', top+'px');
    });
    
    var shopSliderHeight  = $('.shop-swiper').height();
    $('.shop-swiper').find('.carousel-caption').each(function(index, el) {
        var captionHeight = $(this).outerHeight();
        var top = 0;
        if(shopSliderHeight > captionHeight){
            top = ((shopSliderHeight - captionHeight)/2);
        }else{
            top = 1;
        }
        top = parseInt(top);
        $(this).css('top', top+'px');
    });

    var blogSliderHeight  = $('.blog-swiper').height();
    $('.blog-swiper').find('.carousel-caption').each(function(index, el) {
        var captionHeight = $(this).outerHeight();
        var top = 0;
        if(blogSliderHeight > captionHeight){
            top = ((blogSliderHeight - captionHeight)/2);
        }else{
            top = 1;
        }
        top = parseInt(top);
        $(this).css('top', top+'px');
    });

    
    var product_carasol = $('.bgs-product-carasol').owlCarousel({
        nav: true,
        loop: true,
        margin: 10,
        responsiveClass: true,
        items: 4,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        dots: false,
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
                nav:false
            },
            500:{
                items:2,
                nav:false
            },
            768:{
                items:3,
            },
            992:{
                items:4,
            },
        }
    });

    $(document).on('click', '.btn-filter', function(e) {
        var cat = $(this).data('filter');

        /* return if current */
        if ($(this).hasClass('btn-active')) return;

        /* active current */
        $(this).addClass('btn-active').siblings().removeClass('btn-active');

        $elemCopy = $('<div>').css('display', 'none');
        if (typeof($(product_carasol).data('owl-clone')) == 'undefined') {
            //console.log($(owl).data('owl-clone'));
            $(product_carasol).find('.owl-item:not(.cloned)').clone().appendTo($elemCopy);
            $(product_carasol).data('owl-clone', $elemCopy);
        } else {
            $elemCopy = $(product_carasol).data('owl-clone');
        }
        var elemLength = $elemCopy.children().length;
        for (var i = 0; i < elemLength; i++) {
            product_carasol.trigger('remove.owl.carousel', i);
        }
        /* Filter */
        switch (cat) {
            case '*':
                $elemCopy.find('.item').each(function() {
                    product_carasol.trigger('add.owl.carousel', [$(this).clone()]);

                });
                break;
            default:
                $elemCopy.find('.' + cat).each(function() {
                    product_carasol.trigger('add.owl.carousel', [$(this).clone()]);
                });
                break;
        }
        product_carasol.trigger('refresh.owl.carousel').trigger('to.owl.carousel', [0]);
    });

    $('.testimonial-swiper').owlCarousel({
        items:1,
        loop:true,
        center:true,
        margin:10,
        autoplayHoverPause:true,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        nav:true
    });
    $('.nav-pills a').click(function(e){
        e.preventDefault();
        $(this).tab('show');
    });
    $('.blog-gallery').masonry({
        itemSelector: '.bgs-post',
    });
    /* Lignt Box*/
    var gallery = $('.w_blogs .ec-right').simpleLightbox();


});
new WOW().init();
