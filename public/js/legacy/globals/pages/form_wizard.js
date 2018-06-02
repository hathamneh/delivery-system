$(document).ready(function() {

    setTimeout(function () {
        $(window).resize();
        $(window).trigger('resize');
    }, 500);


    $('#style .form-wizard-style').on('click', 'a', function(e){
        $('.form-wizard-style a').removeClass('current');
        $(this).addClass('current');
        var style = $(this).attr('id');
        e.preventDefault();
        $('#style .wizard-div').removeClass('current');
        $('#style .wizard-' + style).addClass('current');
    });

    $('#navigation .form-wizard-nav').on('click', 'a', function(e){    
        $('#navigation .form-wizard-nav a').removeClass('current');
        $(this).addClass('current');
        var style = $(this).attr('id');
        e.preventDefault();
        $('#navigation .wizard-div').removeClass('current');
        $('#navigation .wizard-' + style).addClass('current');
    });

    $('.nav-tabs > li > a').on('click', function(){
        /* Fix issue only with tabs, demo purpose */
        setTimeout(function () {
            $(window).resize();
            $(window).trigger('resize');
        }, 0);
    });

});