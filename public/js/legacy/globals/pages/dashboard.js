(function(){
    /****  Animated Panels  ****/
    function liveTile() {

        if ($('.live-tile').length && $.fn.liveTile) {
            $('.live-tile').each(function () {
                $(this).liveTile("destroy", true); /* To get new size if resize event */
                tile_height = $(this).data("height") ? $(this).data("height") : $(this).find('.panel-body').height() + 52;
                $(this).height(tile_height);
                $(this).liveTile({
                    speed: $(this).data("speed") ? $(this).data("speed") : 500, // Start after load or not
                    mode: $(this).data("animation-easing") ? $(this).data("animation-easing") : 'carousel', // Animation type: carousel, slide, fade, flip, none
                    playOnHover: $(this).data("play-hover") ? $(this).data("play-hover") : false, // Play live tile on hover
                    repeatCount: $(this).data("repeat-count") ? $(this).data("repeat-count") : -1, // Repeat or not (-1 is infinite
                    delay: $(this).data("delay") ? $(this).data("delay") : 0, // Time between two animations
                    startNow: $(this).data("start-now") ? $(this).data("start-now") : true, //Start after load or not
                });
            });
        }
    }

    $(document).ready(function () {
        liveTile();
    });
})();