/**** IOS Switch  ****/
function iosSwitch() {
    if ($('.js-switch').length) {
        setTimeout(function () {
            $('.js-switch').each(function () {
                var colorOn = '#18A689';
                var colorOff = '#DFDFDF';
                if ($(this).data('color-on')) colorOn = $(this).data('color-on');
                if ($(this).data('color-on')) colorOff = $(this).data('color-off');
                if (colorOn == 'blue') colorOn = '#56A2D5';
                if (colorOn == 'red') colorOn = '#C75757';
                if (colorOn == 'yellow') colorOn = '#F3B228';
                if (colorOn == 'green') colorOn = '#18A689';
                if (colorOn == 'purple') colorOn = '#8227f1';
                if (colorOn == 'dark') colorOn = '#292C35';
                if (colorOff == 'blue') colorOff = '#56A2D5';
                if (colorOff == 'red') colorOff = '#C75757';
                if (colorOff == 'yellow') colorOff = '#F3B228';
                if (colorOff == 'green') colorOff = '#18A689';
                if (colorOff == 'purple') colorOff = '#8227f1';
                if (colorOff == 'dark') colorOff = '#292C35';
                var switchery = new Switchery(this, {
                    color: colorOn,
                    secondaryColor: colorOff
                });
            });
        }, 500);
    }
}

/* Manage Slider */
function sliderIOS() {
    if ($('.slide-ios').length && $.fn.slider) {
        $('.slide-ios').each(function () {
            $(this).sliderIOS();
        });
    }
}

iosSwitch()
sliderIOS()