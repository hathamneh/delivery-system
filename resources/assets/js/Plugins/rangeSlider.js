require('ion-rangeslider')

/* Manage Range Slider */
function rangeSlider() {
    if ($('.range-slider').length && $.fn.ionRangeSlider) {
        $('.range-slider').each(function () {
            $(this).ionRangeSlider({
                min: $(this).data('min') ? $(this).data('min') : 0,
                max: $(this).data('max') ? $(this).data('max') : 5000,
                hideMinMax: $(this).data('hideMinMax') ? $(this).data('hideMinMax') : false,
                hideFromTo: $(this).data('hideFromTo') ? $(this).data('hideFromTo') : false,
                to: $(this).data('to') ? $(this).data('to') : '',
                step: $(this).data('step') ? $(this).data('step') : '',
                type: $(this).data('type') ? $(this).data('type') : 'double',
                prefix: $(this).data('prefix') ? $(this).data('prefix') : '',
                postfix: $(this).data('postfix') ? $(this).data('postfix') : '',
                maxPostfix: $(this).data('maxPostfix') ? $(this).data('maxPostfix') : '',
                hasGrid: $(this).data('hasGrid') ? $(this).data('hasGrid') : false,
            });
        });
    }
}

rangeSlider()