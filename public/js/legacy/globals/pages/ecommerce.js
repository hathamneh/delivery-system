 var sfw;

 function cartWizard(){
    sfw = $(".wizard-validation").stepFormWizard({
        height: "auto",
        theme: 'sky',
        rtl: $('body').hasClass('rtl') ? true : false,
        finishBtn: $('<input class="finish-btn sf-right sf-btn" type="submit" value="Confirm Payment"/>'),
        onNext: function(i, wizard) {
            return $('.wizard-validation', wizard).parsley().validate('block' + i);

        },
        onFinish: function(i, wizard) {
            return $('.wizard-validation', wizard).parsley().validate();

        }
    });
 }

$(document).ready(function() {
    setTimeout(function(){
        cartWizard();
    },100);

    $('.wizard-validation').on('click', '.sf-btn', function(){
        setTimeout(function () {
            $(window).resize();
            $(window).trigger('resize');
        }, 0);

    });

    /* Remove Elements */
    $(".shopping-cart-table .icons-office-52").on('click', function(){
        $(this).closest('tr').fadeOut(200, function(){
            $(this).closest('tr').remove();
            var total = 0;
            $('.item-total').each(function(){
                total += +($(this).text());
            });
            $('.total p').text(total+'.00');
        });
    });

    /* Update total on quantity change */
    $(".shopping-cart-table .quantity").on('change', function(){
        var quantity = $(this).val();
        var itemPrice = $(this).closest('tr').find('.item-price').text();
        var itemTotal = quantity * itemPrice;
        $(this).closest('tr').find('.item-total').text(itemTotal+'.00');
        var total = 0;
        $('.item-total').each(function(){
            total += +($(this).text());
        });
        $('.total p').text(total+'.00');
    });
});