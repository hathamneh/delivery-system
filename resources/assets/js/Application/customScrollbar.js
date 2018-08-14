require('imports-loader?define=>false!jquery-mousewheel/jquery.mousewheel')($)
require('imports-loader?define=>false!malihu-custom-scrollbar-plugin')($)
/****  Custom Scrollbar  ****/

/* Create Custom Scroll for elements like Portlets or Dropdown menu */
function customScroll() {
    if ($.fn.mCustomScrollbar) {
        $('.withScroll').each(function () {
            $(this).mCustomScrollbar("destroy");
            var scroll_height = $(this).data('height') ? $(this).data('height') : 'auto';
            var data_padding = $(this).data('padding') ? $(this).data('padding') : 0;
            if ($(this).data('height') == 'window') {
                thisHeight = $(this).height();
                windowHeight = $(window).height() - data_padding - 50;
                if (thisHeight < windowHeight) scroll_height = thisHeight;
                else scroll_height = windowHeight;
            }
            $(this).mCustomScrollbar({
                scrollButtons: {
                    enable: false
                },
                autoHideScrollbar: $(this).hasClass('show-scroll') ? false : true,
                scrollInertia: 150,
                theme: "light-thick",
                set_height: scroll_height,
                advanced: {
                    updateOnContentResize: true
                }
            });
        });
    }
}

/* Create custom scroll for sidebar used for fixed sidebar */
function createSideScroll() {
    if ($.fn.mCustomScrollbar) {
        destroySideScroll();
        if (!$('body').hasClass('sidebar-collapsed') && !$('body').hasClass('sidebar-collapsed') && !$('body').hasClass('submenu-hover') && $('body').hasClass('fixed-sidebar')) {
            $('.sidebar-inner:not(.no-scrollbar)').mCustomScrollbar({
                scrollButtons: {
                    enable: false
                },
                autoHideScrollbar: true,
                scrollInertia: 150,
                theme: "light",
                advanced: {
                    updateOnContentResize: true
                }
            });
        }
        if ($('body').hasClass('sidebar-top')) {
            destroySideScroll();
        }
    }
}


/* Destroy sidebar custom scroll */
function destroySideScroll() {
    var $innerSidebar = $('.sidebar-inner');
    $innerSidebar.mCustomScrollbar("destroy");
    $innerSidebar.removeClass();
    $innerSidebar.addClass('sidebar-inner');
    $innerSidebar.prepend($innerSidebar.find('.nav-sidebar'));
    $innerSidebar.find('.mCustomScrollBox').remove();
    $innerSidebar.find('.nav-sidebar .active .children').removeAttr('style');

}

module.exports = {
    destroy: destroySideScroll,
    init: customScroll,
    sidebar: createSideScroll
}