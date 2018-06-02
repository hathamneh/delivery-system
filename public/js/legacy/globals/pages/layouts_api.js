$(function(){

    if(!$('.page-content').hasClass('page-sidebar-hover')) removeSidebarHover();
    if(!$('.page-content').hasClass('page-boxed')) removeBoxedLayout();
    
    if($('.page-content').hasClass('page-submenu-hover')){
        createSubmenuHover();
    } 

    setTimeout(function(){
        manageSubmenu();
        manageLayout();
    },100);

    $('.submenu-layout').on('click', function(){
        manageSubmenu();
    });

    $('.layout-options a:not(.submenu-layout)').on('click', function(){
        setTimeout(function(){
            manageLayout();
        },10);
    });

});

function manageSubmenu(){
    if($('body').hasClass('submenu-hover')){
        $('.img-submenu-hover').removeClass('hidden');
        $('.img-submenu-click').addClass('hidden');
        $('.submenu-txt').html('current layout: <strong>sidebar submenu on hover</strong>');
    } 
    else{
        $('.img-submenu-hover').addClass('hidden');
        $('.img-submenu-click').removeClass('hidden');
        $('.submenu-txt').html('current layout: <strong>sidebar submenu on click</strong>');
    }
}

function manageLayout(){

    if($('body').hasClass('fixed-sidebar')){
        $('.img-sidebar-fluid').addClass('hidden');
        $('.img-sidebar-fixed').removeClass('hidden');
        $('.sidebar-txt').html('current layout: <strong>sidebar fixed</strong>');
    } 
    else{
        $('.img-sidebar-fluid').removeClass('hidden');
        $('.img-sidebar-fixed').addClass('hidden');
        $('.sidebar-txt').html('current layout: <strong>sidebar fluid</strong>');
    }

    if($('body').hasClass('fixed-topbar')){
        $('.img-topbar-fluid').addClass('hidden');
        $('.img-topbar-fixed').removeClass('hidden');
        $('.topbar-txt').html('current layout: <strong>topbar fixed</strong>');
    } 
    else{
        $('.img-topbar-fluid').removeClass('hidden');
        $('.img-topbar-fixed').addClass('hidden');
        $('.topbar-txt').html('current layout: <strong>topbar fluid</strong>');
    }
    if($('body').hasClass('sidebar-hover')){
        $('.img-sidebar-click').addClass('hidden');
        $('.img-sidebar-hover').removeClass('hidden');
        $('.sidebar-hover-txt').html('current layout: <strong>sidebar on hover</strong>');
    } 
    else{
        $('.img-sidebar-click').removeClass('hidden');
        $('.img-sidebar-hover').addClass('hidden');
        $('.sidebar-hover-txt').html('current layout: <strong>sidebar on click</strong>');
    }

    if($('body').hasClass('boxed')){
        $('.layout-boxed .img-boxed').removeClass('hidden');
        $('.layout-boxed .img-sidebar-large').addClass('hidden');
        $('.boxed-txt').html('current layout: <strong>boxed page</strong>');
    } 
    else{
        $('.layout-boxed .img-boxed').addClass('hidden');
        $('.layout-boxed .img-sidebar-large').removeClass('hidden');
        $('.boxed-txt').html('current layout: <strong>fullwidth page</strong>');          
    }

    if($('body').hasClass('sidebar-collapsed')){
        $('.layout-sidebar-collapsed .img-sidebar-collapsed').removeClass('hidden');
        $('.layout-sidebar-collapsed .img-sidebar-large').addClass('hidden');
        $('.sidebar-collapsed-txt').html('current layout: <strong>sidebar collapsed</strong>');
    } 
    else{
        $('.layout-sidebar-collapsed .img-sidebar-collapsed').addClass('hidden');
        $('.layout-sidebar-collapsed .img-sidebar-large').removeClass('hidden');
        $('.sidebar-collapsed-txt').html('current layout: <strong>sidebar normal</strong>');          
    }
}