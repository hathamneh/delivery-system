import mixitup from 'mixitup';

var containerEl = document.querySelector('.pickups-list');
if (containerEl)
    mixitup(containerEl,
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
        e.stopPropagation();
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


});