const customScrollbar = require('./customScrollbar');
let $body = $('body');
/* Toggle submenu open */
function toggleSidebarMenu() {
    // Check if sidebar is collapsed
    if ($('body').hasClass('sidebar-collapsed') || $('body').hasClass('sidebar-top') || $('body').hasClass('submenu-hover'))
        $('.nav-sidebar .children').css({
            display: ''
        });
    else $('.nav-active.active .children').css('display', 'block');
    $('.sidebar').on('click', '.nav-sidebar li.nav-parent > a', function (e) {
        e.preventDefault();
        if ($('body').hasClass('sidebar-collapsed') && !$('body').hasClass('sidebar-hover')) return;
        if ($('body').hasClass('submenu-hover')) return;
        var parent = $(this).parent().parent();
        parent.children('li.active').children('.children').slideUp(200);
        $('.nav-sidebar .arrow').removeClass('active');
        parent.children('li.active').removeClass('active');
        var sub = $(this).next();
        if (sub.is(":visible")) {
            sub.children().addClass('hidden-item')
            $(this).parent().removeClass("active");
            sub.slideUp(200, function () {
                sub.children().removeClass('hidden-item')
            });
        } else {
            $(this).find('.arrow').addClass('active');
            sub.children().addClass('is-hidden');
            setTimeout(function () {
                sub.children().addClass('is-shown');
            }, 0);
            sub.slideDown(200, function () {
                $(this).parent().addClass("active");
                setTimeout(function () {
                    sub.children().removeClass('is-hidden').removeClass('is-shown');
                }, 500);
            });
        }
    });
}

function hoverEffects() {
    // Add class everytime a mouse pointer hover over it
    let hoverTimeout;
    $('.nav-sidebar > li').hover(function () {
        clearTimeout(hoverTimeout);
        $(this).siblings().removeClass('nav-hover');
        $(this).addClass('nav-hover');
    }, function () {
        let $self = $(this);
        hoverTimeout = setTimeout(function () {
            $self.removeClass('nav-hover');
        }, 200);
    });
    $('.nav-sidebar > li .children').hover(function () {
        clearTimeout(hoverTimeout);
        $(this).closest('.nav-parent').siblings().removeClass('nav-hover');
        $(this).closest('.nav-parent').addClass('nav-hover');
    }, function () {
        hoverTimeout = setTimeout(function () {
            $(this).closest('.nav-parent').removeClass('nav-hover');
        }, 200);
    });
}

function sidebarBehaviour() {
    let windowWidth = $(window).width();
    let windowHeight = $(window).height() - $('.topbar').height();
    let sidebarMenuHeight = $('.nav-sidebar').height();
    if (windowWidth < 1024) {
        $body.removeClass('sidebar-collapsed');
    }
    if ($body.hasClass('sidebar-collapsed') && sidebarMenuHeight > windowHeight) {
        $body.removeClass('fixed-sidebar');
        customScrollbar.destroy();
    }
}


toggleSidebarMenu()
hoverEffects()
customScrollbar.sidebar()
sidebarBehaviour()
// Check if sidebar is collapsed
if ($body.hasClass('sidebar-collapsed')) $('.nav-sidebar .children').css({
    display: ''
});

$(window).resize(function() {
    setTimeout(function() {
        customScrollbar.init();
        if (!$body.hasClass('fixed-sidebar') && !$('body').hasClass('builder-admin')) sidebarBehaviour();
    }, 100);
});
