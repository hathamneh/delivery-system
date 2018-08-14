/****  Variables Initiation  ****/
var doc = document;
var docEl = document.documentElement;
var $sidebar = $('.sidebar');
var $mainContent = $('.main-content');
var $sidebarWidth = $(".sidebar").width();
var is_RTL = false;
if ($('body').hasClass('rtl')) is_RTL = true;

/* ==========================================================*/
/* PLUGINS                                                   */

/* ========================================================= */













/****  Initiation of Main Functions  ****/
$(document).ready(function () {


    sortablePortlets();
    sortableTable();
    nestable();
    showTooltip();
    popover();
    colorPicker();
    numericStepper();
    iosSwitch();
    sliderIOS();
    rangeSlider();
    buttonLoader();
    inputSelect();
    inputTags();
    tableResponsive();
    tableDynamic();
    handleiCheck();
    timepicker();
    datepicker();
    bDatepicker();
    multiDatesPicker();
    datetimepicker();
    rating();
    magnificPopup();
    editorSummernote();
    editorCKE();
    slider();
    liveTile();
    formWizard();
    formValidation();
    barCharts();
    // animateNumber();
    textareaAutosize();
    appearEffect();
    handleProgress();
    $('.autogrow').autogrow();
});
