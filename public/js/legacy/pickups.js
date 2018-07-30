var containerEl = document.querySelector('.pickups-list');
var mixer = mixitup(containerEl,
    {
        selectors: {
            control: '[data-mixitup-control]'
        }
    });

$(document).ready(function () {
    $(".pickup-item").each(function () {
        $(this).css({
            "max-height": $(this).innerHeight()
        });
    });
    $(".pickup-toggle-details").on('click', function () {
        var $this = $(this);
        var $parent = $this.closest('.pickup-item');
        var expanded = $this.attr("aria-expanded") !== "true";
        if (expanded) {
            $('body').addClass('lock-screen');
            $parent.addClass('item-expanded');
        } else {
            setTimeout(function () {
                $parent.removeClass('item-expanded');
                $('body').removeClass('lock-screen');
            }, 350)
        }
    });
    $(document).on('click', 'body.lock-screen', function (e) {
        if ($(e.target).closest('.item-expanded').length === 0) {
            var $expanded = $('.item-expanded');
            $expanded.find(".pickup-meta.collapse").collapse('hide')
            setTimeout(function () {
                $expanded.removeClass('item-expanded');
                $('body').removeClass('lock-screen');
            }, 350)
        }
    });
});


$(function () {

    var $range = $('#reportrange');

    if ($range.length) {
        window.drpOptions.lifetimeRange = true;
        window.drpOptions.opens = "left";

        function cb(start, end) {
            var label = $range.find('span');
            if (window.drpOptions.isLifetime)
                label.html(window.lifetimeRangeLabel);
            else
                label.html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        $range.daterangepicker(window.drpOptions, cb);
        $range.on('apply.daterangepicker', function (ev, picker) {
            var qs = window.getUrlVars();
            qs.start = picker.startDate.unix();
            qs.end = picker.endDate.unix();
            window.location.href = window.location.protocol + "//" + window.location.host + window.location.pathname + "?" + window.to_qs(qs);
        });
        $range.on('lifetime.daterangepicker', function (ev, picker) {
            var qs = window.getUrlVars();
            if (qs.start) delete qs.start;
            if (qs.end) delete qs.end;
            window.location.href = window.location.protocol + "//" + window.location.host + window.location.pathname + (qs.length ? "?" + window.to_qs(qs) : "");
        });

        cb(window.drpOptions.startDate, window.drpOptions.endDate);

    }
});