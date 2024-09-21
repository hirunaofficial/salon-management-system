
(function($) {
    'use strict';
    
    /*-------------------------------------------
      01. jQuery MeanMenu
    --------------------------------------------- */
    
    $('.mobile-menu nav').meanmenu({
      meanMenuContainer: '.mobile-menu-area',
      meanScreenWidth: "767",
      meanRevealPosition: "right",
    });

    /*-------------------------------------------
      02. wow js active
    --------------------------------------------- */
    new WOW().init();
    /*-------------------------------------------
      03. Portfolio  Masonry (width)
    --------------------------------------------- */ 
  $('.our-portfolio-page').imagesLoaded( function() {
        // filter items on button click
        $('#our-filters').on('click', 'li', function () {
            var filterValue = $(this).attr('data-filter');
            $containerpage.isotope({ filter: filterValue });
        });
        // change is-checked class on buttons
        $('#our-filters li').on('click', function () {
            $('#our-filters li').removeClass('is-checked');
            $(this).addClass('is-checked');
            var selector = $(this).attr('data-filter');
            $containerpage.isotope({ filter: selector });
            return false;
        });
        var $containerpage = $('.our-portfolio-page');
        $containerpage.isotope({
            itemSelector: '.pro-item',
            filter: '*',
            transitionDuration: '0.5s',
            masonry: {
                columnWidth: '.pro-item'
            }
          });
      });



/*-------------------------------------------
  04. Sticky Header
--------------------------------------------- */ 
  $(window).on('scroll',function() {    
     var scroll = $(window).scrollTop();
     if (scroll < 245) {
      $("#sticky-header-with-topbar").removeClass("scroll-header");
     }else{
      $("#sticky-header-with-topbar").addClass("scroll-header");
     }
    });
/*--------------------------
  05. ScrollUp
---------------------------- */
$.scrollUp({
    scrollText: '<i class="zmdi zmdi-chevron-up"></i>',
    easingType: 'linear',
    scrollSpeed: 900,
    animation: 'fade'
});

/*--------------------------------
  06. Slider Area
-----------------------------------*/
  $('.slider-activation').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      draggable: true,
      fade: false,
      dots: true,
  });
    
    
/*---------------------
 price slider
--------------------- */  
	
    $( "#slider-range" ).slider({
        range: true,
        min: 40,
        max: 600,
        values: [ 60, 570 ],
        slide: function( event, ui ) {
        $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
        }
    });
    $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
    " - $" + $( "#slider-range" ).slider( "values", 1 ) );    
    
    
    /*--
    Simple Lens and Lightbox
    ------------------------*/
	$('.simpleLens-lens-image').simpleLens({
		loading_image: 'images/loading.gif'
	}); 
    
    
    /*--
    Pro Slider for Pro Details
    ------------------------*/
    $(".pro-img-tab-slider").owlCarousel({
        autoPlay: false,
        loop: true,
        slideSpeed: 2000,
        dots: false,
        nav: false,
        items: 3,
        responsive: {
            0: {
                items: 1
            },
            480: {
                items: 1
            },
            768: {
                items: 3
            },
            992: {
                items: 4
            },
            1200: {
                items: 4
            }
        }
    });
    
    
    
})(jQuery);




