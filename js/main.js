(function($) {
  'use strict';

  // jQuery MeanMenu initialization
  $('.mobile-menu nav').meanmenu({
    meanMenuContainer: '.mobile-menu-area',
    meanScreenWidth: "767",
    meanRevealPosition: "right",
  });

  // WOW.js initialization
  new WOW().init();

  // Portfolio Masonry (width)
  $('.our-portfolio-page').imagesLoaded(function() {
      $('#our-filters').on('click', 'li', function () {
          var filterValue = $(this).attr('data-filter');
          $containerpage.isotope({ filter: filterValue });
      });
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

  // Sticky Header functionality
  $(window).on('scroll', function() {    
      var scroll = $(window).scrollTop();
      if (scroll < 245) {
          $("#sticky-header-with-topbar").removeClass("scroll-header");
      } else {
          $("#sticky-header-with-topbar").addClass("scroll-header");
      }
  });

  // ScrollUp functionality
  $.scrollUp({
      scrollText: '<i class="zmdi zmdi-chevron-up"></i>',
      easingType: 'linear',
      scrollSpeed: 900,
      animation: 'fade'
  });

  // Slider initialization
  $('.slider-activation').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      draggable: true,
      fade: false,
      dots: true,
  });

  // Price slider functionality
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
              $("#amount").val("LKR " + minPrice.toLocaleString() + " - LKR " + maxPrice.toLocaleString());
              $("form#price-filter-form").submit();
          }
      });

      $("#amount").val("LKR " + $("#slider-range").slider("values", 0).toLocaleString() +
          " - LKR " + $("#slider-range").slider("values", 1).toLocaleString());

      $("form#price-filter-form").submit(function(event) {
          event.preventDefault();  // Prevent the default form submission
          var priceRange = $("#amount").val().replace(/LKR\s|,/g, '').split('-');
          var minPrice = priceRange[0].trim();
          var maxPrice = priceRange[1].trim();
          var currentUrl = window.location.pathname;
          window.location.href = currentUrl + "?price=" + minPrice + "-" + maxPrice;
      });
  });

  // Pro Slider for product details
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

$(document).ready(function() {
  // Isotope filtering
  var $grid = $('.grid').isotope({
      itemSelector: '.pro-item'
  });

  $('#service-filters').on('click', 'li', function() {
      var filterValue = $(this).attr('data-filter');
      $grid.isotope({ filter: filterValue });
      $('#service-filters li').removeClass('is-checked');
      $(this).addClass('is-checked');
  });

  // Initialize jQuery UI Datepicker
  $("#datepicker").datepicker({
      dateFormat: "dd/mm/yy",
      minDate: 0,
      beforeShowDay: function(date) {
          var day = date.getDay();
          if (day === 0) {
              return [false, "closed", "Closed on Sundays"];
          }
          return [true, ""];
      },
      onSelect: function(dateText, inst) {
          var selectedDate = $(this).datepicker("getDate");
          var dayOfWeek = selectedDate.getUTCDay();
          var timeSelect = $("#time-select");
          timeSelect.empty();

          if (dayOfWeek === 6) { // Saturday
              timeSelect.append('<option value="09:00:00">9:00 AM</option>');
              timeSelect.append('<option value="10:00:00">10:00 AM</option>');
              timeSelect.append('<option value="11:00:00">11:00 AM</option>');
              timeSelect.append('<option value="12:00:00">12:00 PM</option>');
              timeSelect.append('<option value="13:00:00">1:00 PM</option>');
              timeSelect.append('<option value="14:00:00">2:00 PM</option>');
              timeSelect.append('<option value="15:00:00">3:00 PM</option>');
              timeSelect.append('<option value="16:00:00">4:00 PM</option>');
              timeSelect.append('<option value="17:00:00">5:00 PM</option>');
          } else { // Monday to Friday
              timeSelect.append('<option value="08:00:00">8:00 AM</option>');
              timeSelect.append('<option value="09:00:00">9:00 AM</option>');
              timeSelect.append('<option value="10:00:00">10:00 AM</option>');
              timeSelect.append('<option value="11:00:00">11:00 AM</option>');
              timeSelect.append('<option value="12:00:00">12:00 PM</option>');
              timeSelect.append('<option value="13:00:00">1:00 PM</option>');
              timeSelect.append('<option value="14:00:00">2:00 PM</option>');
              timeSelect.append('<option value="15:00:00">3:00 PM</option>');
              timeSelect.append('<option value="16:00:00">4:00 PM</option>');
              timeSelect.append('<option value="17:00:00">5:00 PM</option>');
              timeSelect.append('<option value="18:00:00">6:00 PM</option>');
              timeSelect.append('<option value="19:00:00">7:00 PM</option>');
              timeSelect.append('<option value="20:00:00">8:00 PM</option>');
          }
      }
  });
});