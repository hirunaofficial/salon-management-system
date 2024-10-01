
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
	
  $(document).ready(function() {
    $("#slider-range").slider({
        range: true,
        min: 1000,
        max: 50000,
        values: [1000, 50000],
        slide: function(event, ui) {
            $("#amount").val("LKR " + ui.values[0].toLocaleString() + " - LKR " + ui.values[1].toLocaleString());
        },
        stop: function(event, ui) {
            var minPrice = ui.values[0];
            var maxPrice = ui.values[1];
            // Update hidden inputs with the selected range
            $("#amount").val("LKR " + minPrice.toLocaleString() + " - LKR " + maxPrice.toLocaleString());
            
            // Trigger form submission to update products on page
            $("form#price-filter-form").submit();
        }
    });

    $("#amount").val("LKR " + $("#slider-range").slider("values", 0).toLocaleString() +
        " - LKR " + $("#slider-range").slider("values", 1).toLocaleString());

    // On form submit, process price and update URL
    $("form#price-filter-form").submit(function(event) {
        event.preventDefault();  // Prevent the default form submission
        
        var priceRange = $("#amount").val().replace(/LKR\s|,/g, '').split('-');
        var minPrice = priceRange[0].trim();
        var maxPrice = priceRange[1].trim();
        
        // Redirect to the page with the updated price range in the query string
        var currentUrl = window.location.pathname;
        window.location.href = currentUrl + "?price=" + minPrice + "-" + maxPrice;
    });
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

$(document).ready(function(){
  var $grid = $('.grid').isotope({
      itemSelector: '.pro-item'
  });
  
  $('#service-filters').on('click', 'li', function(){
      var filterValue = $(this).attr('data-filter');
      $grid.isotope({ filter: filterValue });
      
      $('#service-filters li').removeClass('is-checked');
      $(this).addClass('is-checked');
  });
});