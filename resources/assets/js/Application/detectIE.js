var ua = window.navigator.userAgent;
var msie = ua.indexOf('MSIE ');
var trident = ua.indexOf('Trident/');
var edge = ua.indexOf('Edge/');
if (msie > 0 || trident > 0 || edge > 0) {
    $('html').addClass('ie-browser');
}
