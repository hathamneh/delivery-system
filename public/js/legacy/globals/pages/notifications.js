/* Demo Purpose file */
/* Can be remove from your live project */

$(document).ready(function() {


    NotifContent = $('#preview').find('.alert').html(),
    autoClose = true;
    type = 'success';
    notifContent = '<div class="alert alert-success media fade in"><p><strong>Well done!</strong> You successfully read this important alert message.</p></div>';
    method = 3000;
    position = 'top';
    container ='';
    style = 'topbar';

    /* Notification Content */
    $('#content input').on('ifChecked', function(event){
        content = $(this).data('content');
        $('.preview').hide(0, function(){
            setTimeout(function(){
                $('#preview .preview').removeClass('active');
                $('#'+content+'-preview').fadeIn(300).addClass('active');
                
            },0);
        });
    });

    /* Notification Context */
    $('#context input').on('ifChecked', function(event){
        type = $(this).data('context');
        $('.preview').hide(0, function(){
            setTimeout(function(){
                $('.preview .alert').removeClass('alert-success').removeClass('alert-info').removeClass('alert-danger').removeClass('alert-warning').addClass('alert-'+type); 
                $('.preview.active').fadeIn(300);
            },0);
        });
    });

    /* Notification Style */
    $('#style button').on('click', function(){
        style = $(this).data('style');
        $('#style button').removeClass('btn-default').addClass('btn-white');
        $(this).removeClass('btn-white').addClass('btn-default');
        if(style == 'topbar') {
          $('.notif_pos_top').fadeOut(300);
          $('.notif_pos_all').fadeOut(300, function(){
              setTimeout(function(){
                  $('.notif_pos_top_bottom').fadeIn(300);
              },300);   
          });
          container = '.page-content';
          position = 'top';
        }
        if(style == 'panel') {
          $('.notif_pos_top_bottom').fadeOut(300);
          $('.notif_pos_all').fadeOut(300, function(){
              setTimeout(function(){
                  $('.notif_pos_top').fadeIn(300);
                  $('.notif_container .notification').removeClass('active');
                  $('.notif_container .top.left.notification').addClass('active');
              },300);
          });
          
          container = '.panel-notif';
          position = 'top';
        }
        if(style == 'box') {
          $('.notif_pos_top').fadeOut(300);
          $('.notif_pos_top_bottom').fadeOut(300, function(){
              setTimeout(function(){
                  $('.notif_pos_all').fadeIn(300);
                  $('.notif_container .notification').removeClass('active');
                  $('.notif_container .top.right.notification').addClass('active');
              },300);
          });
          container = '';
          position = 'topRight';
        }
       
    });

    $('#show').on('click', function(){  
      if(style == 'topbar' && position == 'bottom') container = '';
        if(style == 'topbar' && position == 'top') {
          container = '.page-content';
        }
        if(style == 'panel') container = '.panel-notif .panel-content';
        notifContent = $('#preview .active').html();
        if(method == 'validation') generate(position, container, notifContent, true);
        else generate(position, container, notifContent);  
    });


    /* Notification Method */
    $('#method input').on('ifChecked', function(event){
        method = $(this).data('method');
    });

    /* Notification Position */
    $('.notification_position').on('click','.notification', function(){ 
        $('.notification_position .notification').removeClass('active');
        $(this).addClass('active');
        position = $(this).data('position');
    });

});


function generate(position, container, content, confirm) {
    
    if(position == 'bottom') {
        openAnimation = 'animated fadeInUp';
        closeAnimation = 'animated fadeOutDown';
    }
    else if(position == 'top'){
        openAnimation = 'animated fadeIn';
        closeAnimation = 'animated fadeOut';
    }
    else{
        openAnimation = 'animated bounceIn';
        closeAnimation = 'animated bounceOut';
    }
      
    if(container == '') {

        var n = noty({
            text        : content,
            type        : type,
            dismissQueue: true,
            layout      : position,
            closeWith   : ['click'],
            theme       : 'made',
            maxVisible  : 10,
            animation   : {
                open  : openAnimation,
                close : closeAnimation,
                easing: 'swing',
                speed : 100
            },
            timeout: method,
            buttons     : confirm ? [
                {addClass: 'btn btn-primary', text: 'Ok', onClick: function ($noty) {
                    $noty.close();
                    noty({dismissQueue: true, layout: 'topRight', theme : 'defaultTheme', text: 'You clicked "Ok" button', animation   : {
                    open  : 'animated bounceIn', close : 'animated bounceOut'},type: 'success', timeout:3000});
                    confirm = false;
                }
                },
                {addClass: 'btn btn-danger', text: 'Cancel', onClick: function ($noty) {
                    $noty.close();
                    noty({dismissQueue: true, layout: 'topRight', theme : 'defaultTheme',text: 'You clicked "Cancel" button', animation   : {
                    open  : 'animated bounceIn', close : 'animated bounceOut'}, type: 'error', timeout:3000});
                    confirm = false;
                }
                }
            ] : '',
            callback: {
                onShow: function() {
                    leftNotfication = $('.sidebar').width();
                    if($('body').hasClass('rtl')){
                        if(position == 'top' || position == 'bottom') {
                            $('#noty_top_layout_container').css('margin-right', leftNotfication).css('left', 0);
                            $('#noty_bottom_layout_containe').css('margin-right', leftNotfication).css('left', 0);
                        }
                        if(position == 'topRight' || position == 'centerRight' || position == 'bottomRight') {
                            $('#noty_centerRight_layout_container').css('right', leftNotfication + 20);
                            $('#noty_topRight_layout_container').css('right', leftNotfication + 20);
                            $('#noty_bottomRight_layout_container').css('right', leftNotfication + 20);
                        } 
                    }
                    else{
                        if(position == 'top' || position == 'bottom') {
                            $('#noty_top_layout_container').css('margin-left', leftNotfication).css('right', 0);
                            $('#noty_bottom_layout_container').css('margin-left', leftNotfication).css('right', 0);
                        }
                        if(position == 'topLeft' || position == 'centerLeft' || position == 'bottomLeft') {
                            $('#noty_centerLeft_layout_container').css('left', leftNotfication + 20);
                            $('#noty_topLeft_layout_container').css('left', leftNotfication + 20);
                            $('#noty_bottomLeft_layout_container').css('left', leftNotfication + 20);
                        } 
                    }
                    
                }
            }
        });

    }
    else  {
        var n = $(container).noty({
            text        : content,
            dismissQueue: true,
            layout      : position,
            closeWith   : ['click'],
            theme       : 'made',
            maxVisible  : 10,
            buttons     : confirm ? [
                {addClass: 'btn btn-primary', text: 'Ok', onClick: function ($noty) {
                    $noty.close();
                    noty({dismissQueue: true, layout: 'topRight', theme : 'defaultTheme', text: 'You clicked "Ok" button', animation   : {
                    open  : 'animated bounceIn', close : 'animated bounceOut'},type: 'success', timeout:3000});
                }
                },
                {addClass: 'btn btn-danger', text: 'Cancel', onClick: function ($noty) {
                    $noty.close();
                    noty({dismissQueue: true, layout: 'topRight', theme : 'defaultTheme',text: 'You clicked "Cancel" button', animation   : {
                    open  : 'animated bounceIn', close : 'animated bounceOut'}, type: 'error', timeout:3000});
                }
                }
            ] : '',
            animation   : {
                open  : openAnimation,
                close : closeAnimation
            },
            timeout: method,
            callback: {
                onShow: function() {
                    var sidebarWidth = $('.sidebar').width();
                    var topbarHeight = $('.topbar').height();
                    if(position == 'top' && style == 'topbar') {
                        $('.noty_inline_layout_container').css('top', 0);
                        if($('body').hasClass('rtl')) {
                            $('.noty_inline_layout_container').css('right', 0);
                        }
                        else{
                            $('.noty_inline_layout_container').css('left', 0);
                        }
                        
                    }
                    
                }
            }
        });

    }
  
}

