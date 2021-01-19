
(function($) {
    
    "use strict";
// ========== Preloader ========= //        
    function preloader_load() {
        if($('.chargement').length){
            $('.chargement').delay(1500).fadeOut(700);
        }
    }
// ========== Preloader ========= //

// ==================== Scroll To top
    function scrollToTop() {
        $(window).scroll(function(){
            if ($(this).scrollTop() > 600) {
                $('.scrolltotop').fadeIn();
            } else {
                $('.scrolltotop').fadeOut();
            }
        });
        
        //Click event to scroll to top
        $('.scrolltotop').click(function(){
            $('html, body').animate({scrollTop : 0},800);
            return false;
        });
    }
    
    var $window = $(window);

    if ($window.width() > 767) {
        new WOW().init();
    }
    
    //Tooltip activation
    $(function () {
       $('[data-toggle="tooltip"]').tooltip()
    })
    
    // :: 8.0 Sticky Active Code
    $window.on('scroll', function () {
        if ($window.scrollTop() > 48) {
            $('.header_area').addClass('sticky slideInDown');
        } else {
            $('.header_area').removeClass('sticky slideInDown');
        }
    });
/* ==========================================================================
   When document is loading, do
   ========================================================================== */

    $(window).on('load', function() {
        // Ajout de fonctions
        preloader_load();
        //new WOW().init();
        scrollToTop();
    }); 

    // Counters
    
    if ($('.facts-i-num').length > 0) {
        var waypoints = $('.facts-i-num').eq(1).waypoint({
            handler: function(direction) {
                $('.facts-i-num').each(function () {
                    $(this).prop('Counter',0).animate({
                        Counter: $(this).data('num')
                    }, {
                        duration: 3000,
                        step: function (now) {
                            $(this).text(Math.ceil(now));
                        }
                    });
                });
                this.disable();
            },
            offset: 'bottom-in-view'
        });
    }
    
// Search Button
    $('.search-field').on('click', '#search-field-btn', function () {
        if ($('body').hasClass('search-show')) {
            $('body').removeClass('search-show');
        } else {
            $('body').addClass('search-show');
        }
            return false;
    });

// Search Close
    $('body.search-show').on('click', '#search-field-btn', function () {
        if ($('body').hasClass('search-show')) {
            $('body').removeClass('search-show');
        }
        return false;
    });

    $('html').on('click', 'body.search-show', function () {
        $('body').removeClass('search-show');
    });
    $('body').on('click', '.search-field', function(event){
        event.stopPropagation();
    });
    
//jQuery for page scrolling feature - requires jQuery Easing plugin
    $(function() {
        $(document).on('click', 'a.page-scroll', function(event) {
            var $anchor = $(this);
            $('html, body').stop().animate({
                scrollTop: $($anchor.attr('href')).offset().top
            }, 1500, 'easeInOutExpo');
            event.preventDefault();
        });
        
    });
    //*************************************************
    //Gallery  ****************************************
    //*************************************************
   /**
    $('.gallery-block').magnificPopup({
        delegate: 'a',
        type: 'image',
        gallery: {
            enabled: true
        }
    });
*/
    $('.gallery-filter').click(function(){
        var ele = $(this), value = ele.attr('data-filter');
        $('.gallery-filter').removeClass('active');
        ele.addClass('active');
        if(value == "all") {
            $('.filter').show('1000');
        } else {
            $(".filter").not('.'+value).hide('3000');
            $('.filter').filter('.'+value).show('3000');
        }
    });
    
})(window.jQuery);