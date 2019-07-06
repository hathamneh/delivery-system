require('jquery.rateit')

function rating() {
    $('.rateit').each(function () {
        $(this).rateit({
            readonly: $(this).data('readonly') ? $(this).data('readonly') : false, // Not editable, for example to show rating that already exist
            resetable: $(this).data('resetable') ? $(this).data('resetable') : false,
            value: $(this).data('value') ? $(this).data('value') : 0, // Current value of rating
            min: $(this).data('min') ? $(this).data('min') : 1, // Maximum of star
            max: $(this).data('max') ? $(this).data('max') : 5, // Maximum of star
            step: $(this).data('step') ? $(this).data('step') : 0.1
        });
        // Tooltip Option
        if ($(this).data('tooltip')) {
            var tooltipvalues = ['bad', 'poor', 'ok', 'good', 'super']; // You can change text here
            $(this).bind('over', function (event, value) {
                $(this).attr('title', tooltipvalues[value - 1]);
            });
        }
        // Confirmation before voting option
        if ($(this).data('confirmation')) {
            $(this).on('beforerated', function (e, value) {
                value = value.toFixed(1);
                if (!confirm('Are you sure you want to rate this item: ' + value + ' stars?')) {
                    e.preventDefault();
                }
                else {
                    // We disable rating after voting. If you want to keep it enable, remove this part
                    $(this).rateit('readonly', true);
                }
            });
        }
        // Disable vote after rating
        if ($(this).data('disable-after')) {
            $(this).bind('rated', function (event, value) {
                $(this).rateit('readonly', true);
            });
        }
        // Display rating value as text below
        if ($(this).parent().find('.rating-value')) {
            $(this).bind('rated', function (event, value) {
                if (value) value = value.toFixed(1);
                $(this).parent().find('.rating-value').text('Your rating: ' + value);
            });
        }
        // Display hover value as text below
        if ($(this).parent().find('.hover-value')) {
            $(this).bind('over', function (event, value) {
                if (value) value = value.toFixed(1);
                $(this).parent().find('.hover-value').text('Hover rating value: ' + value);
            });
        }

    });
}

rating()