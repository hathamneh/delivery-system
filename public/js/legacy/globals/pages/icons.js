$(function () {


    $('#finder').on('keyup', function() {
        if ($(this).val()) {
            $('input#finder').quicksearch('#results > .col-md-12 > .panel > .panel-content > .row > .col-sm-4');
            $('#results').removeClass('hidden');
            $('.icons').hide();
      } else {
          $('input#finder').quicksearch();
          $('.icons').show();
          $('#results').addClass('hidden');
      }
    });

    var icons = new Skycons({
        "color": "#5B5B5B"
      }),
      list = ["clear-day", "clear-night", "partly-cloudy-day", "partly-cloudy-night", "cloudy", "rain", "sleet", "snow", "wind", "fog"],
      i;
    for (i = list.length; i--;) icons.set(list[i], list[i]);
    icons.play();


});






