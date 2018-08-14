/****  Variables Initiation  ****/
var doc = document;
var docEl = document.documentElement;
var $body = $('body');
var $sidebar = $('.sidebar');
var $sidebarFooter = $('.sidebar .sidebar-footer');
var $mainContent = $('.main-content');
var $pageContent = $('.page-content');
var $topbar = $('.topbar');
var $logopanel = $('.logopanel');
var $sidebarWidth = $(".sidebar").width();
var content = document.querySelector('.page-content');
var $loader = $('#preloader');
var docHeight = $(document).height();
var windowHeight = $(window).height();
var topbarWidth = $('.topbar').width();
var headerLeftWidth = $('.header-left').width();
var headerRightWidth = $('.header-right').width();
var start = delta = end = 0;






/* ========================================================= */






/****  Resize Event Functions  ****/

$(window).resize(function() {
    setTimeout(function() {
        customScroll();
        if (!$('body').hasClass('fixed-sidebar') && !$('body').hasClass('builder-admin')) sidebarBehaviour();
    }, 100);
});
