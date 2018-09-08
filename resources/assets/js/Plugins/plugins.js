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
        $('[data-toggle="tooltip"]').tooltip();
    });

    $(document).ready(function () {
        $('#custom_price').on('change', function () {
            if($(this).is(':checked'))
                $('#total_price').prop('disabled', false);
            else
                $('#total_price').prop('disabled', true);
        });
    });
})(jQuery)