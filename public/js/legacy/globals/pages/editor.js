$(function(){
    $(".page-content .header h2 span").typed({
        strings: ["Form <strong>Editors</strong>"],
        typeSpeed: 200,
        backDelay: 500,
        loop: false,
        contentType: 'html',
        loopCount: false,
        callback: function() {
            $('.page-content .header h2 .typed-cursor').css('-webkit-animation', 'none').animate({opacity: 0}, 400);
            $(".page-content .header p span").typed({
                strings: ["Beautiful editors, clean and rich with many useful components."],
                typeSpeed: 10,
                backDelay: 500,
                loop: false,
                contentType: 'html', 
                loopCount: false,
            });  
        }
    });  
});