require('./autogrow');
require('./iosComponents');
require('./rangeSlider');
require('./select2');
require('./tables');
require('./datePickers');
require('./rateit');
require('./editor');
require('./wizards');
require('./liveTitles');
require('./charts');
require('bootstrap-select');
require('bootstrap-slider');

(function ($) {
    $(document).ready(function () {
        if(isTouchDevice()===false) {
            $('[data-toggle="tooltip"],[data-toggle-tooltip]').tooltip();
        }
        $('[data-toggle="popover"]').popover();

        $('#custom_price').on('change', function () {
            if($(this).is(':checked'))
                $('#total_price').prop('disabled', false);
            else
                $('#total_price').prop('disabled', true);
        });
    });
})(jQuery)