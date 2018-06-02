var main_color = 'background-primary';

$('body').addClass('sidebar-collapsed');

$('.builder-toggle').on('click', function(){
    if($('#builder').hasClass('open')) $('.page-pricing-table').removeClass('open');
    else  $('.page-pricing-table').addClass('open');
});


function pricingSeparated(element){
    if(element.is(":checked")) $('.pricing-table').addClass('plan-separated');
    else  $('.pricing-table').removeClass('plan-separated');
}

function pricingTopBtn(element){
    if(element.is(":checked")) $('.pricing-table .plan-header').append('<div class="text-center plan-top-btn"><span class="offer">Get a free month</span></div>');
    else $('.pricing-table .plan-header .plan-top-btn').remove();
}

function pricingBottomBtn(element){
    if(element.is(":checked")) $('.pricing-table .description').append('<div class="text-center plan-bottom-btn p-b-10"><a class="btn btn-primary" href="#">Change to this Plan</a></div>');
    else $('.pricing-table .description .plan-bottom-btn').remove();
}

function handlePricingLayout(){
    $('.layout-option input').on('click', function(){
        var layout = $(this).attr('data-pricing-layout');
        var is_checked = $(this).prop('checked');
        if(layout == 'separated-plan') pricingSeparated($(this));
        if(layout == 'top-btn') pricingTopBtn($(this));
        if(layout == 'bottom-btn') pricingBottomBtn($(this));
        if(layout == 'full-color') pricingFullColor($(this));
        if(layout == 'icon') pricingIcons($(this));
        if(layout == 'rounded') pricingRounded($(this));
        if(layout == 'shadow') pricingShadow($(this));
    });
}

function pricingRounded(element){
    if(element.is(":checked")) $('.pricing-table').addClass('plan-rounded');
    else  $('.pricing-table').removeClass('plan-rounded');
}

function pricingShadow(element){
    if(element.is(":checked")) $('.pricing-table').addClass('plan-shadow');
    else  $('.pricing-table').removeClass('plan-shadow');
}

function pricingIcons(element){
    if(element.is(":checked")){
        $('.pricing-table .plan').each(function(){
            var i = 0;
            var icon = 'icon-rocket';
            $(this).find('.plan-item').each(function(){
                if(i == 1) icon = 'icon-present';
                if(i == 2) icon = 'icon-camera';
                if(i == 3) icon = 'icon-cloud-download';
                if(i == 4) icon = 'icon-support';
                if(i == 4) icon = 'icon-picture';
                $(this).prepend('<i class="plan-icon ' + icon + ' "></i>');
                i++;
            });
        });
    } 
    else{
        $('.pricing-table .plan-item i').each(function(){
           $(this).remove();
        });
    }
}

function pricingFullColor(element){
    if(element.is(":checked")){
        $('.pricing-table').addClass('full-color');
        if(main_color == 'background-primary') $('.pricing-table .description').addClass('background-primary');
        else $('.pricing-table .description').addClass('bg-'+main_color);
    } 
    else{
        $('.pricing-table .description').removeClass('background-primary');
        $('.pricing-table .description').removeClass (function (index, css) {
            return (css.match (/(^|\s)bg-\S+/g) || []).join(' ');
        });
    }
}

function pricingColor(){
    $('.pricing-color').on('click', function(e){
        e.preventDefault();
        var main_color = $(this).data('color');
        $('.pricing-table .plan-header').removeClass (function (index, css) {
            return (css.match (/(^|\s)bg-\S+/g) || []).join(' ');
        });
        $('.pricing-table .description').removeClass (function (index, css) {
            return (css.match (/(^|\s)bg-\S+/g) || []).join(' ');
        });
        $('.pricing-table .description').removeClass('background-primary');
        $('.pricing-table .btn').removeClass (function (index, css) {
            return (css.match (/(^|\s)btn-\S+/g) || []).join(' ');
        });
        $('.pricing-table .plan-header').removeClass('background-primary');
        $('.pricing-color').removeClass('active');
        $(this).addClass('active');
        if ($(this).data('color') == 'dark'){
            $('.pricing-table .plan-header').addClass('bg-dark');
            $('.pricing-table .btn').addClass('btn-dark');
            if($('.pricing-table').hasClass('full-color')) $('.pricing-table .description').addClass('bg-dark');
        }
        if ($(this).data('color') == 'primary'){
            $('.pricing-table .plan-header').addClass('background-primary');
            $('.pricing-table .btn').addClass('btn-primary');
            if($('.pricing-table').hasClass('full-color')) $('.pricing-table .description').addClass('background-primary');
        }
        if ($(this).data('color') == 'red'){
            $('.pricing-table .plan-header').addClass('bg-red');
            $('.pricing-table .btn').addClass('btn-danger');
            if($('.pricing-table').hasClass('full-color')) $('.pricing-table .description').addClass('bg-red');
        }
        if ($(this).data('color') == 'green'){
            $('.pricing-table .plan-header').addClass('bg-green');
            $('.pricing-table .btn').addClass('btn-success');
            if($('.pricing-table').hasClass('full-color')) $('.pricing-table .description').addClass('bg-green');
        }
        if ($(this).data('color') == 'orange'){
            $('.pricing-table .plan-header').addClass('bg-orange');
            $('.pricing-table .btn').addClass('btn-warning');
            if($('.pricing-table').hasClass('full-color')) $('.pricing-table .description').addClass('bg-orange');
        }
        if ($(this).data('color') == 'purple'){
            $('.pricing-table .plan-header').addClass('bg-purple');
            $('.pricing-table .btn').addClass('btn-info');
            if($('.pricing-table').hasClass('full-color')) $('.pricing-table .description').addClass('bg-purple');
        }
        if ($(this).data('color') == 'blue'){
            $('.pricing-table .plan-header').addClass('bg-blue');
            $('.pricing-table .btn').addClass('btn-blue');
            if($('.pricing-table').hasClass('full-color')) $('.pricing-table .description').addClass('bg-blue');
        }
    });
}


$('.pricing-font-size').on('slide', function(ev){
    var pricingFontSize = $('.pricing-font-size').sliderIOS('getValue');
    pricingFontSize = pricingFontSize / 4;
    $('.pricing-table .price').removeClass (function (index, css) {
        return (css.match (/(^|\s)f-\S+/g) || []).join(' ');
    });
    $('.pricing-table .price').addClass('f-'+pricingFontSize);
});

$('.text-font-size').on('slide', function(ev){
    var textFontSize = $('.text-font-size').sliderIOS('getValue');
    $('.pricing-table .title span, .pricing-table .offer, .pricing-table p, .pricing-table .btn').removeClass (function (index, css) {
        return (css.match (/(^|\s)f-\S+/g) || []).join(' ');
    });
    $('.pricing-table .offer, .pricing-table p, .pricing-table .btn').addClass('f-'+textFontSize);
    $('.pricing-table .title span').addClass('f-'+textFontSize * 2);
});

/* Remove a Plan */
$('.pricing-table').on('click', '.remove-plan', function(){
    plan = $(this).parent();

    bootbox.confirm("Are you sure to remove this plan?", function(result) {
        if(result === true){
          plan.addClass("animated bounceOut");
            window.setTimeout(function () {
              plan.remove();
              var planLength = $('.pricing-table .plan').length; 
              $('.pricing-table').removeClass (function (index, css) {
                  return (css.match (/(^|\s)num-plan-\S+/g) || []).join(' ');
              });
              $('.pricing-table').addClass('num-plan-'+planLength);


            }, 300);
        }
    }); 
});

/* Remove Plan Item */
$('.pricing-table').on('click', '.remove-item', function(){
    planItem = $(this).parent();
    bootbox.confirm("Are you sure to remove this item?", function(result) {
        if(result === true){
          planItem.addClass("animated bounceOut");
            window.setTimeout(function () {
              planItem.remove();
            }, 300);
        }
    }); 
});

/* Pricing Plan Sortable*/
function handlePricingSortable() {
     $( ".pricing-table" ).sortable({
          items : ".plan",
          handle: ".reorder-plan",
          opacity: 0.5,
          revert:false,
          forceHelperSize: true,
          forcePlaceholderSize: true,
          axis: "x",
          dropOnEmpty: true
      });
}

/* Pricing Plan Sortable*/
function handleItemSortable() {
     $( ".plan .description" ).sortable({
          items : ".p-item",
          handle: ".sort-item",
          opacity: 0.5,
          revert:false,
          forceHelperSize: true,
          forcePlaceholderSize: true,
          axis: "y",
          dropOnEmpty: true
      });
}

function createEditorAirMode(element){

    element.addClass('editing');
    element.summernote({
        height: 300,
        airMode : true,
        airPopover: [
            ["style", ["style"]],
            ['font', ['bold', 'underline', 'clear']]
          ]
    });
}

function removeEditor(element){
      
    $('.pricing-table span, .pricing-table p, .pricing-table h1, .pricing-table h2, .pricing-table h2, .pricing-table h3, .pricing-table label, .pricing-table button').removeClass('editing');
    $(this).addClass('editing');
    $('.pricing-table span, .pricing-table p, .pricing-table h1, .pricing-table h2, .pricing-table h2, .pricing-table h3, .pricing-table label, .pricing-table button').each(function(){
        if(!$(this).hasClass('editing')){
            $(this).destroy();
        }
    });  
}

function addPlan(){
    $('#add-plan').on('click', function(e){
        e.preventDefault();
        var planHtml = '<div class="plan">' + $('.pricing-table .plan').html() + '</div>';
        var planLength = $('.pricing-table .plan').length + 1; 
        if(planLength > 5) {
            $('#max-plans').modal('show');
            return;
        }
        $('.pricing-table').removeClass (function (index, css) {
            return (css.match (/(^|\s)num-plan-\S+/g) || []).join(' ');
        });
        $('.pricing-table').addClass('num-plan-'+planLength);
        $('.pricing-table .plans').append(planHtml);
    })
}

function addItem(element){
    var duplicateItem = element.parent().find('.description .p-item:first-child').clone();
    duplicateItem.find('.plan-item').text('New Item');
    console.log(duplicateItem);
    element.parent().find('.description').prepend(duplicateItem);
}

$('.plans').on('click', '> .plan > .add-item', function(){
    addItem($(this));
});

$('.pricing-table').on('click', 'h1, h2, h3, h4, p, button, span, li, a',  function(){
    $('.pricing-table span, .pricing-table p, .pricing-table h1, .pricing-table h2, .pricing-table h2, .pricing-table h3, .pricing-table label, .pricing-table button').removeClass('editing');
    $(this).addClass('editing');
    $('.pricing-table span, .pricing-table p, .pricing-table h1, .pricing-table h2, .pricing-table h2, .pricing-table h3, .pricing-table label, .pricing-table button').each(function(){
        if(!$(this).hasClass('editing')){
            $(this).destroy();
        }
    });  
    createEditorAirMode($(this));
});

$(document).ready(function() {
   "use strict";
    handlePricingLayout();
    handlePricingSortable();
    handleItemSortable();
    pricingColor();
    addPlan();

    /* Edit Link */
    $('.pricing-table').on('mousedown', '.plan-item i', function(){
        $(this).contextmenu({
            target: '#context-menu',
            onItem: function (context, e) {
                var action = $(e.target).data("action");
                $('#modal-'+action).modal('show');
                context.addClass('current-context');   
            }
        });
    });

    /* Edit Icon */
    $('#modal-icons .modal-body').on('click', 'i', function(){
        $('#modal-icons .modal-body i').removeClass('active');
        var selectedIconClass = $(this).attr('class');
        if(selectedIconClass != ''){
            $(this).addClass('active');
        }
    });

    $('#modal-icons').on('click', '.save', function(){
        var selectedIconClass = $('#modal-icons .modal-body i.active').attr('class');
        if(selectedIconClass != ''){
            $('.current-context').removeClass().addClass('plan-icon').addClass(selectedIconClass).removeClass('active');
            $('#modal-icons').modal('hide');
            $('.current-context').removeClass('current-context');
            $('#modal-icons .modal-body i').removeClass('active');
        }
    });

    $('.pricing-html').on('click', function(){
        /* We destroy all editor instances */
        $('.pricing-table span, .pricing-table p, .pricing-table h1, .pricing-table h2, .pricing-table h2, .pricing-table h3, .pricing-table label, .pricing-table button').removeClass('editing');
        $('.pricing-table span, .pricing-table p, .pricing-table h1, .pricing-table h2, .pricing-table h2, .pricing-table h3, .pricing-table label, .pricing-table button').each(function(){
            if(!$(this).hasClass('editing')){
                $(this).destroy();
            }
        }); 


        /* We clone html content to remove builder parts */
        var exportPricing = $('.pricing-table').parent().clone();
        exportPricing.find('.pricing-table').removeClass('ui-sortable').removeClass('m-b-80');
        exportPricing.find('.reorder-plan').remove();
        exportPricing.find('.remove-item').remove();
        exportPricing.find('.sort-item').remove();
        exportPricing.find('.add-item').remove();
        exportPricing.find('.description').removeClass('ui-sortable');
        exportPricing.find('.remove-plan').remove();
       
        /* We get html content from clone */
        var exportHtml = exportPricing.html();

        /* We copy html content inside textarea */
        $('#export-html #export-textarea').text(exportHtml);
        customScroll();
        $('#export-html').modal('show');
    });

});