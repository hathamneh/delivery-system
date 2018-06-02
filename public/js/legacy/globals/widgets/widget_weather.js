/**** WEATHER WIDGET ****/

$(document).ready(function () {
    var ww = $('.widget-weather');
    if (ww.length) {

        widgetWeather(
            function () {
                ww.addClass("loading");
            },
            function () {
                ww.removeClass("loading");
            });
    }
});

function widgetWeather(loading, loaded) {

    var weatherWidget = '<!--<div class="panel-header background-primary"><h3><i class="icon-30"></i> <strong>Weather</strong> Widget</h3></div>--><div class="weather panel-content" class="widget-container widget-weather boxed"><div class="weather-highlighted">';
    weatherWidget += '<div class="day-0 weather-item clearfix active"><canvas id="day-0-icon" class="m-t-15" width="64" height="64"></canvas><div class="inner"><strong class="today-temp-low"></strong><span class="weather-currently"></span><span class="today-temp"></span></div></div>';
    weatherWidget += '<div class="day-1 weather-item clearfix"><canvas id="day-1-icon" class="m-t-15" width="64" height="64"></canvas><div class="inner"><strong class="1-days-temp-low"></strong><span class="one-days-text"></span><span class="1-days-temp"></span></div></div>';
    weatherWidget += '<div class="day-2 weather-item clearfix"><canvas id="day-2-icon" class="m-t-15" width="64" height="64"></canvas><div class="inner"><strong class="2-days-temp-low"></strong><span class="two-days-text"></span><span class="2-days-temp"></span></div></div>';
    weatherWidget += '<div class="day-3 weather-item clearfix"><canvas id="day-3-icon" class="m-t-15" width="64" height="64"></canvas><div class="inner"><strong class="3-days-temp-low"></strong><span class="three-days-text"></span><span class="3-days-temp"></span></div></div>';
    weatherWidget += '<div class="day-4 weather-item clearfix"><canvas id="day-4-icon" class="m-t-15" width="64" height="64"></canvas><div class="inner"><strong class="4-days-temp-low"></strong><span class="four-days-text"></span><span class="4-days-temp"></span></div></div>';
    weatherWidget += '</div><div class="weather-location clearfix"><strong></strong>';
    weatherWidget += '<div class="weather-search-form"><input type="text" name="search2" value="" id="city-form" class="weather-search-field" placeholder="Search"><input type="submit" value="" class="btn weather-search-submit" name="search-send2"></div></div><ul class="weather-forecast clearfix">';
    weatherWidget += '<li class="first"><a id="day-0" class="today-day active" href="javascript:;"><strong>dd</strong><span class="today-img"></span><span class="today-temp-low"></span></a></li>';
    weatherWidget += '<li><a id="day-1" class="1-days-day" href="javascript:;"><strong></strong><span class="1-days-image"></span><span class="1-days-temp-low"></span></a></li>';
    weatherWidget += '<li><a id="day-2" class="2-days-day" href="javascript:;"><strong></strong><span class="2-days-image"></span><span class="2-days-temp-low"></span></a></li>';
    weatherWidget += '<li><a id="day-3" href="javascript:;" class="3-days-day"><strong></strong><span class="3-days-image"></span><span class="3-days-temp-low"></span></a></li>';
    weatherWidget += '<li class="last"><a id="day-4" href="javascript:;" class="4-days-day"><strong></strong><span class="4-days-image"></span><span class="4-days-temp-low"></span></a></li></ul></div>';

    $('.widget-weather').html('');
    $('.widget-weather').append(weatherWidget);
    $('.widget-weather').height($('.widget-weather .panel-header').height() + $('.weather').height() + 80);

    loading();

    // Weather
    $('.weather-forecast li a').on('click', function () {
        var day = $(this).attr('id');
        $('.weather-forecast li a, .weather-item').removeClass('active');
        $(this).addClass('active');
        $('.weather-item.' + day).addClass('active');
    });
    //************************* WEATHER WIDGET *************************//
    /* We initiate widget with a city (can be changed) */
    var city = 'Amman, Jordan';
    var today_day = '';
    var icon_type_today = icon_type_1 = icon_type_2 = icon_type_3 = icon_type_4 = "partly-cloudy-day";

    $.simpleWeather({
        location: city,
        woeid: '',
        unit: 'c',
        success: function (weather) {
            city = weather.city;
            region = weather.country;
            tomorrow_date = weather.forecast[0].date;
            weather_icon = '<i class="icon-' + weather.code + '"></i>';
            $(".weather-location strong").html(city);
            if (weather.forecast[1].day == 'Sun') today_day = 'Sat';
            if (weather.forecast[1].day == 'Mon') today_day = 'Sun';
            if (weather.forecast[1].day == 'Tue') today_day = 'Mon';
            if (weather.forecast[1].day == 'Wed') today_day = 'Tue';
            if (weather.forecast[1].day == 'Thu') today_day = 'Wed';
            if (weather.forecast[1].day == 'Fri') today_day = 'Thu';
            if (weather.forecast[1].day == 'Sat') today_day = 'Fri';
            $(".today-day strong").html(today_day);
            $(".weather-currently").html(weather.currently);
            $(".today-img").html('<i class="big-img-weather icon-' + weather.code + '"></i>');
            $(".today-temp-low").html(weather.high + '°');
            $(".today-temp").html(weather.low + '° / ' + weather.high + '°');
            $(".weather-region").html(region);
            $(".weather-day").html(weather.forecast[1].day);
            $(".weather-icon").html(weather_icon);
            $(".1-days-day strong").html(weather.forecast[1].day);
            $(".one-days-text").html(weather.forecast[1].forecast);
            $(".1-days-image").html('<i class="icon-' + weather.forecast[1].code + '"></i>');
            $(".1-days-temp-low").html(weather.forecast[1].low + '°');
            $(".1-days-temp").html(weather.forecast[1].low + '° / ' + weather.forecast[1].high + '°');
            $(".2-days-day strong").html(weather.forecast[2].day);
            $(".two-days-text").html(weather.forecast[2].forecast);
            $(".2-days-image").html('<i class="icon-' + weather.forecast[2].code + '"></i>');
            $(".2-days-temp-low").html(weather.forecast[2].low + '°');
            $(".2-days-temp").html(weather.forecast[2].low + '° / ' + weather.forecast[2].high + '°');
            $(".3-days-day strong").html(weather.forecast[3].day);
            $(".three-days-text").html(weather.forecast[3].forecast);
            $(".3-days-image").html('<i class="icon-' + weather.forecast[3].code + '"></i>');
            $(".3-days-temp-low").html(weather.forecast[3].low + '°');
            $(".3-days-temp").html(weather.forecast[3].low + '° / ' + weather.forecast[3].high + '°');
            $(".4-days-day strong").html(weather.forecast[4].day);
            $(".four-days-text").html(weather.forecast[4].forecast);
            $(".4-days-image").html('<i class="icon-' + weather.forecast[4].code + '"></i>');
            $(".4-days-temp-low").html(weather.forecast[4].low + '°');
            $(".4-days-temp").html(weather.forecast[4].low + '° / ' + weather.forecast[4].high + '°');

            if (weather.code == 31 || weather.code == 32 || weather.code == 33 || weather.code == 34 || weather.code == 36) icon_type_today = "clear-day";
            if (weather.code == 13 || weather.code == 14 || weather.code == 15 || weather.code == 16) icon_type_today = "snow";
            if (weather.code == 25 || weather.code == 26 || weather.code == 27 || weather.code == 28 || weather.code == 29 || weather.code == 30) icon_type_today = "cloudy";
            if (weather.code == 5 || weather.code == 6 || weather.code == 10 || weather.code == 11 || weather.code == 12 || weather.code == 35) icon_type_today = "rain";
            if (weather.code == 20) icon_type_today = "fog";
            if (weather.code == 32) icon_type_today = "partly-cloudy-day";
            if (weather.code == 29) icon_type_today = "partly-cloudy-night";
            if (weather.code == 24) icon_type_today = "wind";
            if (weather.code == 18) icon_type_today = "sleet";

            if (weather.forecast[1].code == 31 || weather.forecast[1].code == 32 || weather.forecast[1].code == 33 || weather.forecast[1].code == 34 || weather.forecast[1].code == 36) icon_type_1 = "clear-day";
            if (weather.forecast[1].code == 13 || weather.forecast[1].code == 14 || weather.forecast[1].code == 15 || weather.forecast[1].code == 16) icon_type_1 = "snow";
            if (weather.forecast[1].code == 25 || weather.forecast[1].code == 26 || weather.forecast[1].code == 27 || weather.forecast[1].code == 28) icon_type_1 = "cloudy";
            if (weather.forecast[1].code == 5 || weather.forecast[1].code == 6 || weather.forecast[1].code == 10 || weather.forecast[1].code == 11 || weather.forecast[1].code == 12 || weather.forecast[1].code == 35) icon_type_1 = "rain";
            if (weather.forecast[1].code == 20) icon_type_1 = "fog";
            if (weather.forecast[1].code == 30) icon_type_1 = "partly-cloudy-day";
            if (weather.forecast[1].code == 29) icon_type_1 = "partly-cloudy-night";
            if (weather.forecast[1].code == 24) icon_type_1 = "wind";
            if (weather.forecast[1].code == 18) icon_type_1 = "sleet";

            if (weather.forecast[2].code == 31 || weather.forecast[2].code == 32 || weather.forecast[2].code == 33 || weather.forecast[2].code == 34 || weather.forecast[2].code == 36) icon_type_2 = "clear-day";
            if (weather.forecast[2].code == 13 || weather.forecast[2].code == 14 || weather.forecast[2].code == 15 || weather.forecast[2].code == 16) icon_type_2 = "snow";
            if (weather.forecast[2].code == 25 || weather.forecast[2].code == 26 || weather.forecast[2].code == 27 || weather.forecast[2].code == 28) icon_type_2 = "cloudy";
            if (weather.forecast[2].code == 5 || weather.forecast[2].code == 6 || weather.forecast[2].code == 10 || weather.forecast[2].code == 11 || weather.forecast[2].code == 12 || weather.forecast[2].code == 35) icon_type_2 = "rain";
            if (weather.forecast[2].code == 20) icon_type_2 = "fog";
            if (weather.forecast[2].code == 30) icon_type_2 = "partly-cloudy-day";
            if (weather.forecast[2].code == 29) icon_type_2 = "partly-cloudy-night";
            if (weather.forecast[2].code == 24) icon_type_2 = "wind";
            if (weather.forecast[2].code == 18) icon_type_2 = "sleet";

            if (weather.forecast[3].code == 31 || weather.forecast[3].code == 32 || weather.forecast[3].code == 33 || weather.forecast[3].code == 34 || weather.forecast[3].code == 36) icon_type_3 = "clear-day";
            if (weather.forecast[3].code == 13 || weather.forecast[3].code == 14 || weather.forecast[3].code == 15 || weather.forecast[3].code == 16) icon_type_3 = "snow";
            if (weather.forecast[3].code == 25 || weather.forecast[3].code == 26 || weather.forecast[3].code == 27 || weather.forecast[3].code == 28) icon_type_3 = "cloudy";
            if (weather.forecast[3].code == 5 || weather.forecast[3].code == 6 || weather.forecast[3].code == 10 || weather.forecast[3].code == 11 || weather.forecast[3].code == 12 || weather.forecast[3].code == 356) icon_type_3 = "rain";
            if (weather.forecast[3].code == 20) icon_type_3 = "fog";
            if (weather.forecast[3].code == 30) icon_type_3 = "partly-cloudy-day";
            if (weather.forecast[3].code == 29) icon_type_3 = "partly-cloudy-night";
            if (weather.forecast[3].code == 24) icon_type_3 = "wind";
            if (weather.forecast[3].code == 18) icon_type_3 = "sleet";

            if (weather.forecast[4].code == 31 || weather.forecast[4].code == 32 || weather.forecast[4].code == 33 || weather.forecast[4].code == 33) icon_type_4 = "clear-day";
            if (weather.forecast[4].code == 13 || weather.forecast[4].code == 14 || weather.forecast[4].code == 15 || weather.forecast[4].code == 16) icon_type_4 = "snow";
            if (weather.forecast[4].code == 25 || weather.forecast[4].code == 26 || weather.forecast[4].code == 27 || weather.forecast[4].code == 28) icon_type_4 = "cloudy";
            if (weather.forecast[4].code == 5 || weather.forecast[4].code == 6 || weather.forecast[4].code == 10 || weather.forecast[4].code == 11 || weather.forecast[4].code == 12 || weather.forecast[4].code == 35) icon_type_4 = "rain";
            if (weather.forecast[4].code == 20) icon_type_4 = "fog";
            if (weather.forecast[4].code == 30) icon_type_4 = "partly-cloudy-day";
            if (weather.forecast[4].code == 29) icon_type_4 = "partly-cloudy-night";
            if (weather.forecast[4].code == 24) icon_type_4 = "wind";
            if (weather.forecast[4].code == 18) icon_type_4 = "sleet";

            var icons = new Skycons(),
                list = ["clear-day", "clear-night", "partly-cloudy-day", "partly-cloudy-night", "cloudy", "rain", "sleet", "snow", "wind", "fog"],
                i;
            for (i = list.length; i--;) {
                icons.set(list[i], list[i]);
            }
            icons.set("day-0-icon", icon_type_today);
            icons.set("day-1-icon", icon_type_1);
            icons.set("day-2-icon", icon_type_2);
            icons.set("day-3-icon", icon_type_3);
            icons.set("day-4-icon", icon_type_4);
            icons.play();
            loaded();
        },
        error: function (err) {
            console.error(err);
        }
    });

    /* We get city from input on change */
    $("#city-form").change(function (e) {
        e.preventDefault;
        city = document.getElementById("city-form").value;
        loading();
        $.simpleWeather({
            location: city,
            woeid: '',
            unit: 'c',
            success: function (weather) {
                city = weather.city;
                region = weather.country;
                tomorrow_date = weather.forecast[0].date;
                weather_icon = '<i class="icon-' + weather.code + '"></i>';
                $(".weather-location strong").html(city);
                if (weather.forecast[1].day == 'Sun') today_day = 'Sat';
                if (weather.forecast[1].day == 'Mon') today_day = 'Sun';
                if (weather.forecast[1].day == 'Tue') today_day = 'Mon';
                if (weather.forecast[1].day == 'Wed') today_day = 'Tue';
                if (weather.forecast[1].day == 'Thu') today_day = 'Wed';
                if (weather.forecast[1].day == 'Fri') today_day = 'Thu';
                if (weather.forecast[1].day == 'Sat') today_day = 'Fri';
                $(".today-day strong").html(today_day);
                $(".weather-currently").html(weather.currently);
                $(".today-img").html('<i class="big-img-weather icon-' + weather.code + '"></i>');
                $(".today-temp-low").html(weather.high + '°');
                $(".today-temp").html(weather.low + '° / ' + weather.high + '°');
                $(".weather-region").html(region);
                $(".weather-day").html(weather.forecast[1].day);
                $(".weather-icon").html(weather_icon);
                $(".1-days-day strong").html(weather.forecast[1].day);
                $(".one-days-text").html(weather.forecast[1].forecast);
                $(".1-days-image").html('<i class="icon-' + weather.forecast[1].code + '"></i>');
                $(".1-days-temp-low").html(weather.forecast[1].low + '°');
                $(".1-days-temp").html(weather.forecast[1].low + '° / ' + weather.forecast[1].high + '°');
                $(".2-days-day strong").html(weather.forecast[2].day);
                $(".two-days-text").html(weather.forecast[2].forecast);
                $(".2-days-image").html('<i class="icon-' + weather.forecast[2].code + '"></i>');
                $(".2-days-temp-low").html(weather.forecast[2].low + '°');
                $(".2-days-temp").html(weather.forecast[2].low + '° / ' + weather.forecast[2].high + '°');
                $(".3-days-day strong").html(weather.forecast[3].day);
                $(".three-days-text").html(weather.forecast[3].forecast);
                $(".3-days-image").html('<i class="icon-' + weather.forecast[3].code + '"></i>');
                $(".3-days-temp-low").html(weather.forecast[3].low + '°');
                $(".3-days-temp").html(weather.forecast[3].low + '° / ' + weather.forecast[3].high + '°');
                $(".4-days-day strong").html(weather.forecast[4].day);
                $(".four-days-text").html(weather.forecast[4].forecast);
                $(".4-days-image").html('<i class="icon-' + weather.forecast[4].code + '"></i>');
                $(".4-days-temp-low").html(weather.forecast[4].low + '°');
                $(".4-days-temp").html(weather.forecast[4].low + '° / ' + weather.forecast[4].high + '°');

                if (weather.code == 31 || weather.code == 32 || weather.code == 33 || weather.code == 34 || weather.code == 36) icon_type_today = "clear-day";
                if (weather.code == 13 || weather.code == 14 || weather.code == 15 || weather.code == 16) icon_type_today = "snow";
                if (weather.code == 25 || weather.code == 26 || weather.code == 27 || weather.code == 28 || weather.code == 29 || weather.code == 30) icon_type_today = "cloudy";
                if (weather.code == 5 || weather.code == 6 || weather.code == 10 || weather.code == 35) icon_type_today = "rain";
                if (weather.code == 20) icon_type_today = "fog";
                if (weather.code == 32) icon_type_today = "partly-cloudy-day";
                if (weather.code == 29) icon_type_today = "partly-cloudy-night";
                if (weather.code == 24) icon_type_today = "wind";
                if (weather.code == 18) icon_type_today = "sleet";

                if (weather.forecast[1].code == 31 || weather.forecast[1].code == 32 || weather.forecast[1].code == 33 || weather.forecast[1].code == 34 || weather.forecast[1].code == 36) icon_type_1 = "clear-day";
                if (weather.forecast[1].code == 13 || weather.forecast[1].code == 14 || weather.forecast[1].code == 15 || weather.forecast[1].code == 16) icon_type_1 = "snow";
                if (weather.forecast[1].code == 25 || weather.forecast[1].code == 26 || weather.forecast[1].code == 27 || weather.forecast[1].code == 28) icon_type_1 = "cloudy";
                if (weather.forecast[1].code == 5 || weather.forecast[1].code == 6 || weather.forecast[1].code == 10 || weather.forecast[1].code == 35) icon_type_1 = "rain";
                if (weather.forecast[1].code == 20) icon_type_1 = "fog";
                if (weather.forecast[1].code == 30) icon_type_1 = "partly-cloudy-day";
                if (weather.forecast[1].code == 29) icon_type_1 = "partly-cloudy-night";
                if (weather.forecast[1].code == 24) icon_type_1 = "wind";
                if (weather.forecast[1].code == 18) icon_type_1 = "sleet";

                if (weather.forecast[2].code == 31 || weather.forecast[2].code == 32 || weather.forecast[2].code == 33 || weather.forecast[2].code == 34 || weather.forecast[2].code == 36) icon_type_2 = "clear-day";
                if (weather.forecast[2].code == 13 || weather.forecast[2].code == 14 || weather.forecast[2].code == 15 || weather.forecast[2].code == 16) icon_type_2 = "snow";
                if (weather.forecast[2].code == 25 || weather.forecast[2].code == 26 || weather.forecast[2].code == 27 || weather.forecast[2].code == 28) icon_type_2 = "cloudy";
                if (weather.forecast[2].code == 5 || weather.forecast[2].code == 6 || weather.forecast[2].code == 10 || weather.forecast[2].code == 35) icon_type_2 = "rain";
                if (weather.forecast[2].code == 20) icon_type_2 = "fog";
                if (weather.forecast[2].code == 30) icon_type_2 = "partly-cloudy-day";
                if (weather.forecast[2].code == 29) icon_type_2 = "partly-cloudy-night";
                if (weather.forecast[2].code == 24) icon_type_2 = "wind";
                if (weather.forecast[2].code == 18) icon_type_2 = "sleet";

                if (weather.forecast[3].code == 31 || weather.forecast[3].code == 32 || weather.forecast[3].code == 33 || weather.forecast[3].code == 34 || weather.forecast[3].code == 36) icon_type_3 = "clear-day";
                if (weather.forecast[3].code == 13 || weather.forecast[3].code == 14 || weather.forecast[3].code == 15 || weather.forecast[3].code == 16) icon_type_3 = "snow";
                if (weather.forecast[3].code == 25 || weather.forecast[3].code == 26 || weather.forecast[3].code == 27 || weather.forecast[3].code == 28) icon_type_3 = "cloudy";
                if (weather.forecast[3].code == 5 || weather.forecast[3].code == 6 || weather.forecast[3].code == 10 || weather.forecast[3].code == 356) icon_type_3 = "rain";
                if (weather.forecast[3].code == 20) icon_type_3 = "fog";
                if (weather.forecast[3].code == 30) icon_type_3 = "partly-cloudy-day";
                if (weather.forecast[3].code == 29) icon_type_3 = "partly-cloudy-night";
                if (weather.forecast[3].code == 24) icon_type_3 = "wind";
                if (weather.forecast[3].code == 18) icon_type_3 = "sleet";

                if (weather.forecast[4].code == 31 || weather.forecast[4].code == 32 || weather.forecast[4].code == 33 || weather.forecast[4].code == 33) icon_type_4 = "clear-day";
                if (weather.forecast[4].code == 13 || weather.forecast[4].code == 14 || weather.forecast[4].code == 15 || weather.forecast[4].code == 16) icon_type_4 = "snow";
                if (weather.forecast[4].code == 25 || weather.forecast[4].code == 26 || weather.forecast[4].code == 27 || weather.forecast[4].code == 28) icon_type_4 = "cloudy";
                if (weather.forecast[4].code == 5 || weather.forecast[4].code == 6 || weather.forecast[4].code == 10 || weather.forecast[4].code == 35) icon_type_4 = "rain";
                if (weather.forecast[4].code == 20) icon_type_4 = "fog";
                if (weather.forecast[4].code == 30) icon_type_4 = "partly-cloudy-day";
                if (weather.forecast[4].code == 29) icon_type_4 = "partly-cloudy-night";
                if (weather.forecast[4].code == 24) icon_type_4 = "wind";
                if (weather.forecast[4].code == 18) icon_type_4 = "sleet";

                var icons = new Skycons(),
                    list = ["clear-day", "clear-night", "partly-cloudy-day", "partly-cloudy-night", "cloudy", "rain", "sleet", "snow", "wind", "fog"],
                    i;
                for (i = list.length; i--;) {
                    icons.set(list[i], list[i]);
                }
                icons.set("day-0-icon", icon_type_today);
                icons.set("day-1-icon", icon_type_1);
                icons.set("day-2-icon", icon_type_2);
                icons.set("day-3-icon", icon_type_3);
                icons.set("day-4-icon", icon_type_4);
                icons.play();
                loaded();
            },
            error: function (err) {
                console.error(err);
            }
        });
    });


    var myTimeout;
    $('.widget-weather').mouseenter(function () {

        myTimeout = setTimeout(function () {
            $('.weather, .widget-weather .panel-header').animate({
                backgroundColor: '#33A3A6'
            }, 400);
        }, 200);
    }).mouseleave(function () {
        clearTimeout(myTimeout);
        $('.weather, .widget-weather .panel-header').animate({
            backgroundColor: '#319DB5'
        }, 400);
    });

    $(window).resize(function () {
        setTimeout(function () {
            $('.widget-weather').height($('.widget-weather .panel-header').height() + $('.weather').height() + 12);
        }, 100);
    });

}


