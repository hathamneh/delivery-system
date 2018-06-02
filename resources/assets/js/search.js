(function () {


    if ($('#search-results').length) {
        var $morphSearch = $('#morphsearch'),
            $searchResult = $('#search-results'),
            input = $searchResult.find('input'),
            ctrlClose = $morphSearch.find('span.morphsearch-close'),
            isOpen = isAnimating = false,
            // show/hide search area
            toggleSearch = function (evt) {
                console.log("hi")
                // return if open and the input gets focused
                if (evt.type.toLowerCase() === 'focus' && isOpen) return false;

                //let offsets = $morphsearch.offset();
                if (isOpen) {
                    $morphSearch.removeClass('open');
                    $searchResult.removeClass('open');
                    if (input.val() !== '') {
                        setTimeout(function () {
                            $morphSearch.addClass('hideInput');
                            $searchResult.addClass('hideInput');
                            setTimeout(function () {
                                $morphSearch.removeClass('hideInput');
                                $searchResult.removeClass('hideInput');
                                input.val('');
                            }, 300);
                        }, 500);
                    }

                    input.blur();
                    $('body').removeClass('ov-hidden');
                    $('.page-content').css('display', '');
                }
                else {
                    $morphSearch.addClass('open');
                    $searchResult.addClass('open');
                    var morphSearchHeight = $('.morphsearch-content').height();

                    setTimeout(function () {
                        $('.page-content').css('display', 'none');
                    }, 450);

                    setTimeout(function () {
                        $('.morphsearch-input').focus();
                        if ($('#noty_topRight_layout_container').length) $('#noty_topRight_layout_container').remove();
                    }, 200);
                }
                isOpen = !isOpen;
            };

        // events
        console.log(input.length)
        $searchResult.on('focus click', toggleSearch);
        ctrlClose.on('click', toggleSearch);
        // esc key closes search overlay
        // keyboard navigation events

        $(document).on('keydown', function (ev) {
            var keyCode = ev.keyCode || ev.which;
            if (keyCode === 27 && isOpen) {
                toggleSearch(ev);
            }
        });
    }

})();