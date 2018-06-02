$(function() {
    var newItemHeight = $('.new-item').height();
    $('.new-item').height(0);
    setTimeout(function() {
        TweenMax.to($('.new-item'), .5, {
            css: {
                height: newItemHeight,
                autoAlpha: 1,
                marginBottom: 30
            },
            ease: Circ.easeInOut
        });
        setTimeout(function() {
            $('.new-item').css('height', '');
        }, 600);
    }, 4000);

    /* Google Map */
    var simple_map;
    if ($("#profil-map").length) {
        simple_map = new GMaps({
            el: '#profil-map',
            lat: 37.775,
            lng: -122.41833,
            zoomControl: false,
            zoomControlOpt: {
                style: 'SMALL',
                position: 'TOP_LEFT'
            },
            panControl: false,
            streetViewControl: false,
            mapTypeControl: false,
            overviewMapControl: false
        });
        simple_map.addMarker({
            lat: 37.776,
            lng: -122.41833,
            title: 'Marker with InfoWindow',
            icon: '../assets/global/images/profil_page/marker.png'
        });
    }

    /* Handle Comments Show / Hide */
    $('.profil-content').on('click', '.more-comments', function() {
        $(this).closest('.more').find('.share').slideUp(200, function() {
            $(this).closest('.more').find('.comments').slideToggle(200);
            $(this).closest('.more').find('.more-comments').toggleClass('active');
            $(this).closest('.more').find('.more-share').removeClass('active');
        });
    });

    /* Handle Like Comment */
    $('.profil-content').on('click', '.like', function() {
        $(this).toggleClass('liked');
    });

    /* Handle Share Show / Hide */
    $('.profil-content').on('click', '.more-share', function() {
        $(this).closest('.more').find('.comments').slideUp(200, function() {
            $(this).closest('.more').find('.share').slideToggle(200);
            $(this).closest('.more').find('.more-share').toggleClass('active');
            $(this).closest('.more').find('.more-comments').removeClass('active');
        });
    });

    /* Radar Chart */
    var radarChartData = {
        labels: ["Eating", "Drinking", "Sleeping", "Designing", "Coding", "Cycling", "Running"],
        datasets: [
            {
                label: "My Second dataset",
                backgroundColor: "rgba(151,187,205,0.2)",
                borderColor: "rgba(151,187,205,1)",
                pointBackgroundColor: "rgba(151,187,205,1)",
                pointBorderColor: "#fff",
                pointHoverBackgroundColor: "#fff",
                pointHoverBorderColor: "rgba(151,187,205,1)",
                data: [38, 48, 40, 89, 96, 27, 90]
            }
        ]
    };
    setTimeout(function() {
        
        var ctx = document.getElementById("profil-chart").getContext("2d");
        var myRadarChart = new Chart(ctx, {
            type: 'radar',
            data: radarChartData,
            options: {
                scale: {
                    ticks: {
                        display: false
                    },
                    gridLines: {
                        color: 'rgba(0,0,0,0.05)'
                    }
                },
                legend:{
                    display: false
                  },
                tooltips : {
                    cornerRadius: 0
                }
            }
        });


    }, 1500);
    
    /* Item Map */
    var miami = new google.maps.LatLng(25.7738889, -80.1938889);
    var neighborhoods = [
      new google.maps.LatLng(25.7768889, -80.1788889)
    ];
    var markers = [];
    var iterator = 0;
    var map;

    function initialize() {
        var mapOptions = {
            zoom: 12,
            center: miami,
            panControl: false,
            zoomControl: false,
            streetViewControl: false,
            mapTypeControl: false,
            overviewMapControl: false,
            styles: [
                {
                    "featureType": "water",
                    "stylers": [
                        {
                            "saturation": 43
                    },
                        {
                            "lightness": -11
                    },
                        {
                            "hue": "#0088ff"
                    }
                ]
            },
                {
                    "featureType": "road",
                    "elementType": "geometry.fill",
                    "stylers": [
                        {
                            "hue": "#ff0000"
                    },
                        {
                            "saturation": -100
                    },
                        {
                            "lightness": 99
                    }
                ]
            },
                {
                    "featureType": "road",
                    "elementType": "geometry.stroke",
                    "stylers": [
                        {
                            "color": "#808080"
                    },
                        {
                            "lightness": 54
                    }
                ]
            },
                {
                    "featureType": "landscape.man_made",
                    "elementType": "geometry.fill",
                    "stylers": [
                        {
                            "color": "#ece2d9"
                    }
                ]
            },
                {
                    "featureType": "poi.park",
                    "elementType": "geometry.fill",
                    "stylers": [
                        {
                            "color": "#ccdca1"
                    }
                ]
            },
                {
                    "featureType": "road",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#767676"
                    }
                ]
            },
                {
                    "featureType": "road",
                    "elementType": "labels.text.stroke",
                    "stylers": [
                        {
                            "color": "#ffffff"
                    }
                ]
            },
                {
                    "featureType": "poi",
                    "stylers": [
                        {
                            "visibility": "off"
                    }
                ]
            },
                {
                    "featureType": "landscape.natural",
                    "elementType": "geometry.fill",
                    "stylers": [
                        {
                            "visibility": "on"
                    },
                        {
                            "color": "#b8cb93"
                    }
                ]
            },
                {
                    "featureType": "poi.park",
                    "stylers": [
                        {
                            "visibility": "on"
                    }
                ]
            },
                {
                    "featureType": "poi.sports_complex",
                    "stylers": [
                        {
                            "visibility": "on"
                    }
                ]
            },
                {
                    "featureType": "poi.medical",
                    "stylers": [
                        {
                            "visibility": "on"
                    }
                ]
            },
                {
                    "featureType": "poi.business",
                    "stylers": [
                        {
                            "visibility": "simplified"
                    }
                ]
            }
        ]
        };
        map = new google.maps.Map(document.getElementById('item-map'), mapOptions);
    }

    function drop() {
        setTimeout(function() {
            for (var i = 0; i < neighborhoods.length; i++) {
                setTimeout(function() {
                    addMarker();
                }, i * 350);
            }
        }, 1500);
    }

    function addMarker() {
        markers.push(new google.maps.Marker({
            position: neighborhoods[iterator],
            map: map,
            draggable: false,
            animation: google.maps.Animation.DROP
        }));
        iterator++;
    }
    google.maps.event.addDomListener(window, 'load', initialize);
    drop();
});