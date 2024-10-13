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

  // Service Page Filter Option
  $(document).ready(function() {
        $('#service-filters li').on('click', function() {
            var filterValue = $(this).attr('data-filter');

            $('#service-filters li').removeClass('is-checked');
            $(this).addClass('is-checked');

            if (filterValue === '*') {
                $('.pro-item').show();
            } else {
                $('.pro-item').hide();
                $(filterValue).show();
            }
        });
    });

  // Gallery Page Filter Option
  $(document).ready(function() {
        $('#gallery-filters li').on('click', function() {
            var filterValue = $(this).attr('data-filter');

            $('#gallery-filters li').removeClass('is-checked');
            $(this).addClass('is-checked');

            if (filterValue === '*') {
                $('.pro-item').show();
            } else {
                $('.pro-item').hide();
                $(filterValue).show();
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
  
    $(document).ready(function() {
        // Initialize jQuery UI Datepicker
        $("#datepicker").datepicker({
            dateFormat: "dd/mm/yy", // Date format you need
            minDate: 0, // Disable past dates
            beforeShowDay: function(date) {
                var day = date.getDay();
                if (day === 0) {
                    return [false, "closed", "Closed on Sundays"]; // Disable Sundays
                }
                return [true, ""];
            },
            onSelect: function(dateText, inst) {
                var selectedDate = $(this).datepicker("getDate");
                var dayOfWeek = selectedDate.getUTCDay();
                var timeSelect = $("#time-select");
                timeSelect.empty();

                // Load time slots based on the selected day
                if (dayOfWeek === 6) {
                    timeSelect.append('<option value="09:00:00">9:00 AM</option>');
                    timeSelect.append('<option value="10:00:00">10:00 AM</option>');
                    timeSelect.append('<option value="11:00:00">11:00 AM</option>');
                    timeSelect.append('<option value="12:00:00">12:00 PM</option>');
                    timeSelect.append('<option value="13:00:00">1:00 PM</option>');
                    timeSelect.append('<option value="14:00:00">2:00 PM</option>');
                    timeSelect.append('<option value="15:00:00">3:00 PM</option>');
                    timeSelect.append('<option value="16:00:00">4:00 PM</option>');
                    timeSelect.append('<option value="17:00:00">5:00 PM</option>');
                } else {
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

})(jQuery);