/* ============================================================
 * Layout Script
 =========================================================== */
 var  $logopanel     = $('.logopanel');
 var  $topbar        = $('.topbar');
 var  $sidebar       = $('.sidebar');
 var  $sidebarFooter = $('.sidebar-footer');
 
/****  Initiation of Main Functions  ****/
$(document).ready(function() {

    handleboxedLayout();
    setTimeout(function() {
        handleboxedLayout();
    }, 100);
    if ($('body').hasClass('sidebar-hover')) sidebarHover();

    $('[data-toggle-sidebar]').on('click', function(event) {
        event.preventDefault();
        var toggleLayout = $(this).data('toggle-sidebar');
        if (toggleLayout == 'sidebar-behaviour') toggleSidebar();
        if (toggleLayout == 'submenu') toggleSubmenuHover();
        if (toggleLayout == 'sidebar-collapsed') collapsedSidebar();
        if (toggleLayout == 'sidebar-top') toggleSidebarTop();
        if (toggleLayout == 'sidebar-hover') toggleSidebarHover();
        if (toggleLayout == 'boxed') toggleboxedLayout();
        if (toggleLayout == 'topbar') toggleTopbar();
    });

});

/****  Resize Event Functions  ****/
$(window).resize(function() {
    setTimeout(function() {
        handleboxedLayout();
    }, 100);
});

/* ==========================================================*/
/* LAYOUTS API                                                */
/* ========================================================= */

/* Create Sidebar Fixed */
function handleSidebarFixed() {
    // removeSidebarHover();
    $('#switch-sidebar').prop('checked', true);
    $('#switch-submenu').prop('checked', false);
    $.removeCookie('submenu-hover');
    if ($('body').hasClass('sidebar-top')) {
        $('body').removeClass('fixed-topbar').addClass('fixed-topbar');
        $.removeCookie('fluid-topbar');
        $('#switch-topbar').prop('checked', true);
    }
    $('body').removeClass('fixed-sidebar').addClass('fixed-sidebar');
    $('.sidebar').height('');
    handleboxedLayout();
    if (!$('body').hasClass('sidebar-collapsed')) removeSubmenuHover();
    createSideScroll();
    $.removeCookie('fluid-sidebar');
    $.cookie('fixed-sidebar', 1);
}

/* Create Sidebar Fluid / Remove Sidebar Fixed */
function handleSidebarFluid() {
    $('#switch-sidebar').prop('checked', false);
    if ($('body').hasClass('sidebar-hover')) {
        removeSidebarHover();
        $('#switch-sidebar-hover').prop('checked', false);
    }
    $('body').removeClass('fixed-sidebar');
    handleboxedLayout();
    destroySideScroll();
    $.removeCookie('fixed-sidebar');
    $.cookie('fluid-sidebar', 1);
    $.cookie('fluid-sidebar', 1);
}

/* Toggle Sidebar Fixed / Fluid */
function toggleSidebar() {
    if ($('body').hasClass('fixed-sidebar')) handleSidebarFluid();
    else handleSidebarFixed();
}

/* Create Sidebar on Top */
function createSidebarTop() {
    $('#switch-sidebar-top').prop('checked', true);
    removeSidebarHover();
    $('body').removeClass('sidebar-collapsed');
    $.removeCookie('sidebar-collapsed');
    $('body').removeClass('sidebar-top').addClass('sidebar-top');
    $('.main-content').css('margin-left', '').css('margin-right', '');
    $('.topbar').css('left', '').css('right', '');
    if ($('body').hasClass('fixed-sidebar') && !$('body').hasClass('fixed-topbar')) {
        $('body').removeClass('fixed-topbar').addClass('fixed-topbar');
        $.removeCookie('fluid-topbar');
        $('#switch-topbar').prop('checked', true);
    }
    $('.sidebar').height('');
    destroySideScroll();
    $('#switch-sidebar-hover').prop('checked', false);
    handleboxedLayout();
    $.cookie('sidebar-top', 1);
    $.removeCookie('sidebar-hover');
}

/* Remove Sidebar on Top */
function removeSidebarTop() {
    $('#switch-sidebar-top').prop('checked', false);
    $('body').removeClass('sidebar-top');
    createSideScroll();
    $('#switch-sidebar-top').prop('checked', false);
    $.removeCookie('sidebar-top');
    handleboxedLayout();
}

/* Toggle Sidebar on Top */
function toggleSidebarTop() {
    if ($('body').hasClass('sidebar-top')) removeSidebarTop();
    else createSidebarTop();
}

/* Create Sidebar only visible on Hover */
function createSidebarHover() {
    $('body').addClass('sidebar-hover');
    $('body').removeClass('fixed-sidebar').addClass('fixed-sidebar');
    $('.main-content').css('margin-left', '').css('margin-right', '');
    $('.topbar').css('left', '').css('right', '');
    $('body').removeClass('sidebar-top');
    removeSubmenuHover();
    removeBoxedLayout();
    removeCollapsedSidebar();
    sidebarHover();
    handleSidebarFixed();
    $('#switch-sidebar-hover').prop('checked', true);
    $('#switch-sidebar').prop('checked', true);
    $('#switch-sidebar-top').prop('checked', false);
    $('#switch-boxed').prop('checked', false);
    $.removeCookie('fluid-topbar');
    $.removeCookie('sidebar-top');
    $.cookie('sidebar-hover', 1);
}

/* Remove Sidebar on Hover */
function removeSidebarHover() {
    $('#switch-sidebar-hover').prop('checked', false);
    $('body').removeClass('sidebar-hover');
    if (!$('body').hasClass('boxed')) $('.sidebar, .sidebar-footer').attr('style', '');
    $('.logopanel2').remove();
    $.removeCookie('sidebar-hover');
}

/* Toggle Sidebar on Top */
function toggleSidebarHover() {
    if ($('body').hasClass('sidebar-hover')) removeSidebarHover();
    else createSidebarHover();
}

/* Create Sidebar Submenu visible on Hover */
function createSubmenuHover() {
    removeSidebarHover();
    removeSidebarTop();
    handleSidebarFluid();
    $('#switch-submenu-hover').prop('checked', true);
    $('body').addClass('submenu-hover');
    $('.nav-sidebar .children').css('display', '');
    $.cookie('submenu-hover', 1);
    $('#switch-sidebar').prop('checked', false);
}

/* Remove Submenu on Hover */
function removeSubmenuHover() {
    $('#switch-submenu-hover').prop('checked', false);
    $('body').removeClass('submenu-hover');
    $('.nav-sidebar .nav-parent.active .children').css('display', 'block');
    $.removeCookie('submenu-hover');
}

/* Toggle Submenu on Hover */
function toggleSubmenuHover() {
    if ($('body').hasClass('submenu-hover')) removeSubmenuHover();
    else createSubmenuHover();
}

/* Create Topbar Fixed */
function handleTopbarFixed() {
    $('#switch-topbar').prop('checked', true);
    $('body').removeClass('fixed-topbar').addClass('fixed-topbar');
    $.removeCookie('fluid-topbar');
}

/* Create Topbar Fluid / Remove Topbar Fixed */
function handleTopbarFluid() {
    $('#switch-topbar').prop('checked', false);
    $('body').removeClass('fixed-topbar');
    if ($('body').hasClass('sidebar-top') && $('body').hasClass('fixed-sidebar')) {
        $('body').removeClass('fixed-sidebar');
        $('#switch-sidebar').prop('checked', false);
    }
    $.cookie('fluid-topbar', 1);
}

/* Toggle Topbar Fixed / Fluid */
function toggleTopbar() {
    if ($('body').hasClass('fixed-topbar')) handleTopbarFluid();
    else handleTopbarFixed();
}

/* Adjust margin of content for boxed layout */
function handleboxedLayout() {
    if ($('body').hasClass('builder-admin')) return;
    $logopanel.css('left', '').css('right', '');
    $topbar.css('width', '');
    $sidebar.css('margin-left', '').css('margin-right', '');
    $sidebarFooter.css('left', '').css('right', '');
    if ($('body').hasClass('boxed')) {
        windowWidth = $(window).width();
        windowHeight = $(window).height();
        $('.page-content').height('');
        pageContentHeight = $('.page-content').height();
        var container = 1200;
        var margin = (windowWidth - 1200) / 2;
        if (!$('body').hasClass('sidebar-top') && windowWidth > 1220)  {
            if(!$('body').hasClass('fixed-sidebar')){
                if(pageContentHeight < $(document).height()){
                    setTimeout(function(){
                        $('.page-content').height($(document).height());
                    },100);
                } 
            }
            else{
                if(pageContentHeight < windowHeight) {
                    $('.page-content').height(windowHeight);
                }
            }
            $logopanel.css('right', margin);
            if ($('body').hasClass('sidebar-collapsed')) {
                $topbar.css('width', 1200);
            }
            else {
                topbarWidth = (1200 - $sidebarWidth);
                $sidebarFooter.css('right', margin);
                if ($('body').hasClass('fixed-sidebar')) {
                    $sidebar.css('margin-left', margin);
                    $('.topbar').css('width', topbarWidth);
                }
                $sidebarFooter.css('left', margin);
                if($('body').hasClass('sidebar-light')){
                    $topbar.css('width', 960);
                }
                else{
                    $topbar.css('width', topbarWidth);
                }
                
            }
       
            $.backstretch(["../assets/global/images/gallery/bg1.jpg", "../assets/global/images/gallery/bg2.jpg", "../assets/global/images/gallery/bg3.jpg", "../assets/global/images/gallery/bg4.jpg"], 
            {duration: 4000, fade: 600});
        }
        else{
            $('.backstretch').remove();
        }
        
    }
}

/* Create Boxed Layout */
function createBoxedLayout() {
    removeSidebarHover();
    $('body').addClass('boxed');
    handleboxedLayout();
    $('#switch-boxed').prop('checked', true);
    $.cookie('boxed-layout', 1);
}

/* Remove boxed layout */
function removeBoxedLayout() {
    if ($('body').hasClass('boxed')) {
        $('body').removeClass('boxed');
        $logopanel.css('left', '').css('right', '');
        $topbar.css('width', '');
        $sidebar.css('margin-left', '').css('margin-right', '');
        $sidebarFooter.css('left', '').css('right', '');
        $.removeCookie('boxed-layout');
        $('#switch-boxed').prop('checked', false);
        $.backstretch("destroy");
    }
}

function toggleboxedLayout() {
    if ($('body').hasClass('boxed')) removeBoxedLayout();
    else createBoxedLayout();
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
    handleboxedLayout();
}

function createCollapsedSidebar() {
    $body.addClass('sidebar-collapsed');
    $('.sidebar').css('width', '').resizable().resizable('destroy');
    $('.nav-sidebar ul').attr('style', '');
    $(this).addClass('menu-collapsed');
    destroySideScroll();
    $('#switch-sidebar').prop('checked');
    $.cookie('sidebar-collapsed', 1);
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
    createSideScroll();
    $.removeCookie('sidebar-collapsed');
}

/* Reset to Default Style, remove all cookie and custom layouts */
function resetStyle() {
    $('#reset-style').on('click', function(event) {
        event.preventDefault();
        removeBoxedLayout();
        removeSidebarTop();
        removeSidebarHover();
        removeSubmenuHover();
        removeCollapsedSidebar();
        $.removeCookie('main-color');
        $.removeCookie('main-name');
        $.removeCookie('theme');
        $.removeCookie('bg-name');
        $.removeCookie('bg-color');
        $.removeCookie('submenu-hover');
        $.removeCookie('sidebar-collapsed');
        $.removeCookie('boxed-layout');
        $.removeCookie('sidebar-hover');
        $.removeCookie('sidebar-hover', { path: '/'});
        $.removeCookie('main-color', { path: '/'});
        $.removeCookie('main-name', { path: '/'});
        $.removeCookie('theme', { path: '/'});
        $.removeCookie('bg-name', { path: '/'});
        $.removeCookie('bg-color', { path: '/'});
        $.removeCookie('boxed-layout', { path: '/'});
        $('body').removeClass(function(index, css) {
            return (css.match(/(^|\s)bg-\S+/g) || []).join(' ');
        });
        $('body').removeClass(function(index, css) {
            return (css.match(/(^|\s)color-\S+/g) || []).join(' ');
        });
        $('body').removeClass(function(index, css) {
            return (css.match(/(^|\s)theme-\S+/g) || []).join(' ');
        });
        $('body').addClass('theme-sdtl').addClass('color-default');
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