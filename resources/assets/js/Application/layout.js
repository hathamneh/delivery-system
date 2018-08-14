let customScrollbar = require('./customScrollbar')

/* ============================================================
 * Layout Script
 =========================================================== */

 let $body = $('body');
$('[data-toggle-sidebar]').on('click', function(event) {
    event.preventDefault();
    let toggleLayout = $(this).data('toggle-sidebar');
    if (toggleLayout === 'sidebar-behaviour') toggleSidebar();
    if (toggleLayout === 'submenu') toggleSubmenuHover();
    if (toggleLayout === 'sidebar-collapsed') collapsedSidebar();
    if (toggleLayout === 'sidebar-top') toggleSidebarTop();
    if (toggleLayout === 'sidebar-hover') toggleSidebarHover();
    if (toggleLayout === 'boxed') toggleboxedLayout();
    if (toggleLayout === 'topbar') toggleTopbar();
});


/* ==========================================================*/
/* LAYOUTS API                                                */
/* ========================================================= */

/* Create Sidebar Fixed */
function handleSidebarFixed() {
    // removeSidebarHover();
    $('#switch-sidebar').prop('checked', true);
    $('#switch-submenu').prop('checked', false);
    if ($body.hasClass('sidebar-top')) {
        $body.removeClass('fixed-topbar').addClass('fixed-topbar');
        $('#switch-topbar').prop('checked', true);
    }
    $body.removeClass('fixed-sidebar').addClass('fixed-sidebar');
    $('.sidebar').height('');
    if (!$body.hasClass('sidebar-collapsed')) removeSubmenuHover();
    customScrollbar.sidebar();
}

/* Create Sidebar Fluid / Remove Sidebar Fixed */
function handleSidebarFluid() {
    $('#switch-sidebar').prop('checked', false);
    if ($body.hasClass('sidebar-hover')) {
        removeSidebarHover();
        $('#switch-sidebar-hover').prop('checked', false);
    }
    $body.removeClass('fixed-sidebar');
    customScrollbar.destroy();
}

/* Toggle Sidebar Fixed / Fluid */
function toggleSidebar() {
    if ($body.hasClass('fixed-sidebar')) handleSidebarFluid();
    else handleSidebarFixed();
}

/* Create Sidebar on Top */
function createSidebarTop() {
    $('#switch-sidebar-top').prop('checked', true);
    removeSidebarHover();
    $body.removeClass('sidebar-collapsed');
    $body.removeClass('sidebar-top').addClass('sidebar-top');
    $('.main-content').css('margin-left', '').css('margin-right', '');
    $('.topbar').css('left', '').css('right', '');
    if ($body.hasClass('fixed-sidebar') && !$body.hasClass('fixed-topbar')) {
        $body.removeClass('fixed-topbar').addClass('fixed-topbar');
        $('#switch-topbar').prop('checked', true);
    }
    $('.sidebar').height('');
    customScrollbar.destroy();
    $('#switch-sidebar-hover').prop('checked', false);
}

/* Remove Sidebar on Top */
function removeSidebarTop() {
    $('#switch-sidebar-top').prop('checked', false);
    $body.removeClass('sidebar-top');
    customScrollbar.sidebar();
    $('#switch-sidebar-top').prop('checked', false);
}

/* Toggle Sidebar on Top */
function toggleSidebarTop() {
    if ($body.hasClass('sidebar-top')) removeSidebarTop();
    else createSidebarTop();
}

/* Create Sidebar only visible on Hover */
function createSidebarHover() {
    $body.addClass('sidebar-hover');
    $body.removeClass('fixed-sidebar').addClass('fixed-sidebar');
    $('.main-content').css('margin-left', '').css('margin-right', '');
    $('.topbar').css('left', '').css('right', '');
    $body.removeClass('sidebar-top');
    removeSubmenuHover();
    removeCollapsedSidebar();
    sidebarHover();
    handleSidebarFixed();
    $('#switch-sidebar-hover').prop('checked', true);
    $('#switch-sidebar').prop('checked', true);
    $('#switch-sidebar-top').prop('checked', false);
    $('#switch-boxed').prop('checked', false);
}

/* Remove Sidebar on Hover */
function removeSidebarHover() {
    $('#switch-sidebar-hover').prop('checked', false);
    $body.removeClass('sidebar-hover');
    if (!$body.hasClass('boxed')) $('.sidebar, .sidebar-footer').attr('style', '');
    $('.logopanel2').remove();
}

/* Toggle Sidebar on Top */
function toggleSidebarHover() {
    if ($body.hasClass('sidebar-hover')) removeSidebarHover();
    else createSidebarHover();
}

/* Create Sidebar Submenu visible on Hover */
function createSubmenuHover() {
    removeSidebarHover();
    removeSidebarTop();
    handleSidebarFluid();
    $('#switch-submenu-hover').prop('checked', true);
    $body.addClass('submenu-hover');
    $('.nav-sidebar .children').css('display', '');
    $('#switch-sidebar').prop('checked', false);
}

/* Remove Submenu on Hover */
function removeSubmenuHover() {
    $('#switch-submenu-hover').prop('checked', false);
    $body.removeClass('submenu-hover');
    $('.nav-sidebar .nav-parent.active .children').css('display', 'block');
}

/* Toggle Submenu on Hover */
function toggleSubmenuHover() {
    if ($body.hasClass('submenu-hover')) removeSubmenuHover();
    else createSubmenuHover();
}

/* Create Topbar Fixed */
function handleTopbarFixed() {
    $('#switch-topbar').prop('checked', true);
    $body.removeClass('fixed-topbar').addClass('fixed-topbar');
}

/* Create Topbar Fluid / Remove Topbar Fixed */
function handleTopbarFluid() {
    $('#switch-topbar').prop('checked', false);
    $body.removeClass('fixed-topbar');
    if ($body.hasClass('sidebar-top') && $body.hasClass('fixed-sidebar')) {
        $body.removeClass('fixed-sidebar');
        $('#switch-sidebar').prop('checked', false);
    }
}

/* Toggle Topbar Fixed / Fluid */
function toggleTopbar() {
    if ($body.hasClass('fixed-topbar')) handleTopbarFluid();
    else handleTopbarFixed();
}

/* Toggle Sidebar Collapsed */
function collapsedSidebar() {
    if ($body.css('position') != 'relative') {
        if (!$body.hasClass('sidebar-collapsed')) createCollapsedSidebar();
        else removeCollapsedSidebar();
    } else {
        if ($body.hasClass('sidebar-show')) $body.removeClass('sidebar-show');
        else $body.addClass('sidebar-show');
    }
}

function createCollapsedSidebar() {
    $body.addClass('sidebar-collapsed');
    $('.sidebar').css('width', '');
    $('.nav-sidebar ul').attr('style', '');
    $(this).addClass('menu-collapsed');
    customScrollbar.destroy();
    $('#switch-sidebar').prop('checked');
}

function removeCollapsedSidebar() {
    $body.removeClass('sidebar-collapsed');
    if (!$body.hasClass('submenu-hover')) $('.nav-sidebar li.active ul').css({
        display: 'block'
    });
    $(this).removeClass('menu-collapsed');
    if ($body.hasClass('sidebar-light') && !$body.hasClass('sidebar-fixed')) {
        $('.sidebar').height('');
    }
    customScrollbar.sidebar();
}

/* Reset to Default Style, remove all cookie and custom layouts */
function resetStyle() {
    $('#reset-style').on('click', function(event) {
        event.preventDefault();
        removeSidebarTop();
        removeSidebarHover();
        removeSubmenuHover();
        removeCollapsedSidebar();
        $body.removeClass(function(index, css) {
            return (css.match(/(^|\s)bg-\S+/g) || []).join(' ');
        });
        $body.removeClass(function(index, css) {
            return (css.match(/(^|\s)color-\S+/g) || []).join(' ');
        });
        $body.removeClass(function(index, css) {
            return (css.match(/(^|\s)theme-\S+/g) || []).join(' ');
        });
        $body.addClass('theme-sdtl').addClass('color-default');
        $('.builder .theme-color').removeClass('active');
        $('.theme-color').each(function() {
            if ($(this).data('color') == '#319DB5') $(this).addClass('active');
        });
        $('.builder .theme').removeClass('active');
        $('.builder .theme-default').addClass('active');
        $('.builder .sp-replacer').removeClass('active');
    });
}

/******************** END LAYOUT API  ************************/
/* ========================================================= */