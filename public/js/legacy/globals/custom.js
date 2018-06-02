//****************** YOUR CUSTOMIZED JAVASCRIPT **********************//
var ajax_url = "/ajax_requests.php";

$(document).ready(function () {

    var print_btn = $("#print-data");
    if (print_btn.length) {
        print_btn.on('click', function (e) {
            e.preventDefault();
            var active = $(".tab-pane.active");
            if (active.length)
                printData(active.find('.printArea')[0]);
            else
                printData($('.printArea')[0]);
        });
    }

    function printData(divToPrint) {
        divToPrint.classList.add("table-print");

        var dir = "ltr";
        if ($("body.rtl").length)
            dir = "rtl";

        newWin = window.open();
        newWin.document.write('<html><head>' +
            '<link href="/assets/global/css/style.css" rel="stylesheet">' +
            '</head><body class="' + dir + '"><div class="container">');
        newWin.document.write(divToPrint.outerHTML);
        newWin.document.write('</div></body>');

        $(newWin).ready(function (ev) {
            setTimeout(function () {
                newWin.print();
                newWin.close();
            }, 500);
        });

        // }, 500);
    }

    if ($(".notification-element").length) {
        $(".notification-element").each(function () {
            showNoty("top", ".page-content", $(this).html(), "topbar");
        });
    }
    $('.console_error').each(function () {
        console.error($(this).text());
    });

    var dtOpts = {};
    if ($("body.rtl").length) {
        dtOpts = {
            "language": {
                "sProcessing": "جارٍ التحميل...",
                "sLengthMenu": "أظهر _MENU_ مدخلات",
                "sZeroRecords": "لم يعثر على أية سجلات",
                "sInfo": "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
                "sInfoEmpty": "يعرض 0 إلى 0 من أصل 0 سجل",
                "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
                "sInfoPostFix": "",
                "sSearch": "بحث:",
                "sUrl": "",
                "oPaginate": {
                    "sFirst": "الأول",
                    "sPrevious": "السابق",
                    "sNext": "التالي",
                    "sLast": "الأخير"
                }
            },
            "pageLength": 50,
        };
    } else {
        dtOpts = {
            "pageLength": 50
        }
    }
    ;
    var oTable = $('.dataTable').dataTable(dtOpts);
    $('input[type="radio"], input[type="checkbox"]').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue',
        increaseArea: '20%' // optional

    });


    $(function () {
        var startDate = $('#available_time_start');
        var endDate = $('#available_time_end');
        var icons = {
            next: 'glyphicon glyphicon-chevron-right',
            previous: 'glyphicon glyphicon-chevron-left'
        };
        if ($("body.rtl").length)
            icons = {
                next: 'glyphicon glyphicon-chevron-left',
                previous: 'glyphicon glyphicon-chevron-right'
            };
        startDate.daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 2018,
            maxYear: parseInt(moment().format('YYYY'), 10),
            locale: {
                format: "DD-MM-YYYY hh:mm A"
            }
        }, function (start, end, label) {
            var years = moment().diff(start, 'years');
        });
        // endDate.datetimepicker({
        //     format: "DD-MM-YYYY hh:mm A",
        //     sideBySide: true,
        //     useCurrent: false, //Important! See issue #1075
        //     icons: icons
        //     //keepInvalid:true
        // });
        startDate.on("dp.change", function (e) {
            endDate.data("DateTimePicker").minDate(e.date);
        });
        endDate.on("dp.change", function (e) {
            startDate.data("DateTimePicker").maxDate(e.date);
        });
        $('.datetimepicker').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
                format: "DD-MM-YYYY"
            },
            startDate: moment(),
            minDate: moment(),

        });
    });

    var modal_action = $(".modal input[name='action']").val();
    if (modal_action === "update") {
        var $modal = $(".modal");
        $modal.modal('show');
        $modal.find('form').submit(function (e) {
            e.preventDefault();
            var $current_modal = $(this).closest(".modal");
            var $toedit = $current_modal.attr("id");
            var formData = $(this).serialize();
            formData += "&toedit=" + $toedit;
            console.log(formData);
            $.post(ajax_url, formData, function (res) {
                console.log(res);
                var data = JSON.parse(res);
                $modal.modal('hide');

                var html = '<div class="alert alert-success fade in media"><p><i class="fa fa-check"></i> ' + data.msg + '</p></div>';

                showNoty("top", ".page-content", html, "topbar");
            });
        });
    }

    buttonLoader();


    $('.dropdown.overflow-fix').on('show.bs.dropdown', function () {
        var $this = $(this);
        var id = $this.closest('tr').data('id');
        $('body').append($this.css({
            position: 'absolute',
            left: $($this).offset().left,
            top: $($this).offset().top,
            "z-index": 999
        }).data('id', id).detach());
    });
    //add BT DD hide event
    $('.dropdown.overflow-fix').on('hidden.bs.dropdown', function () {
        var $this = $(this);
        var id = $this.data('id');
        $('tr[data-id="' + id + '"] .dropdown-original').append($this.removeAttr('style').detach());
    });

    // Declare a global object to store view data.
    var viewData;

    viewData = {};

    $(function () {
        // Update the viewData object with the current field keys and values.
        function updateViewData(key, value) {
            viewData[key] = value;
        }

        // Register all bindable elements
        function detectBindableElements() {
            var bindableEls;

            bindableEls = $('[data-bind]');

            // Add event handlers to update viewData and trigger callback event.
            bindableEls.on('change', function () {
                var $this;

                $this = $(this);

                updateViewData($this.data('bind'), $this.val());

                $(document).trigger('updateDisplay');
            });

            // Add a reference to each bindable element in viewData.
            bindableEls.each(function () {
                updateViewData($(this), $(this).val());
                console.log($(this).val())
            });

        }

        // Trigger this event to manually update the list of bindable elements, useful when dynamically loading form fields.
        $(document).on('updateBindableElements', detectBindableElements);

        detectBindableElements();
    });

    $(function () {
        // An example of how the viewData can be used by other functions.
        function updateDisplay() {
            var updateEls;

            updateEls = $('[data-update]');

            updateEls.each(function () {
                $(this).text(viewData[$(this).data('update')]);
            });
        }

        // Run updateDisplay on the callback.
        $(document).on('updateDisplay', updateDisplay);
    });

});

function buttonLoader() {
    if ($('.ladda-button').length) {
        Ladda.bind('.ladda-button', {
            timeout: 2000
        });
    }
}

function getUrlVars() {
    var vars = [], hash;
    if (window.location.href.indexOf('?') > 0) {
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for (var i = 0; i < hashes.length; i++) {
            hash = hashes[i].split('=');
            vars[hash[0]] = hash[1];
        }
    }
    return vars;
}

function to_qs(obj) {
    var str = [];
    for (var p in obj)
        if (obj.hasOwnProperty(p)) {
            str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
        }
    return str.join("&");
}

function showNoty(position, container, content, style, confirm) {

    if (position == 'bottom') {
        openAnimation = 'animated fadeInUp';
        closeAnimation = 'animated fadeOutDown';
    }
    else if (position == 'top') {
        openAnimation = 'animated fadeIn';
        closeAnimation = 'animated fadeOut';
    }
    else {
        openAnimation = 'animated bounceIn';
        closeAnimation = 'animated bounceOut';
    }

    if (container == '') {

        var n = noty({
            text: content,
            type: type,
            dismissQueue: true,
            layout: position,
            closeWith: ['click'],
            theme: 'made',
            maxVisible: 10,
            animation: {
                open: openAnimation,
                close: closeAnimation,
                easing: 'swing',
                speed: 100
            },
            //timeout: 3000,
            buttons: confirm ? [
                {
                    addClass: 'btn btn-primary', text: 'Ok', onClick: function ($noty) {
                        $noty.close();
                        noty({
                            dismissQueue: true,
                            layout: 'topRight',
                            theme: 'defaultTheme',
                            text: 'You clicked "Ok" button',
                            animation: {
                                open: 'animated bounceIn', close: 'animated bounceOut'
                            },
                            type: 'success',
                            timeout: 3000
                        });
                        confirm = false;
                    }
                },
                {
                    addClass: 'btn btn-danger', text: 'Cancel', onClick: function ($noty) {
                        $noty.close();
                        noty({
                            dismissQueue: true,
                            layout: 'topRight',
                            theme: 'defaultTheme',
                            text: 'You clicked "Cancel" button',
                            animation: {
                                open: 'animated bounceIn', close: 'animated bounceOut'
                            },
                            type: 'error',
                            timeout: 3000
                        });
                        confirm = false;
                    }
                }
            ] : '',
            callback: {
                onShow: function () {
                    leftNotfication = $('.sidebar').width();
                    if ($('body').hasClass('rtl')) {
                        if (position == 'top' || position == 'bottom') {
                            $('#noty_top_layout_container').css('margin-right', leftNotfication).css('left', 0);
                            $('#noty_bottom_layout_containe').css('margin-right', leftNotfication).css('left', 0);
                        }
                        if (position == 'topRight' || position == 'centerRight' || position == 'bottomRight') {
                            $('#noty_centerRight_layout_container').css('right', leftNotfication + 20);
                            $('#noty_topRight_layout_container').css('right', leftNotfication + 20);
                            $('#noty_bottomRight_layout_container').css('right', leftNotfication + 20);
                        }
                    }
                    else {
                        if (position == 'top' || position == 'bottom') {
                            $('#noty_top_layout_container').css('margin-left', leftNotfication).css('right', 0);
                            $('#noty_bottom_layout_container').css('margin-left', leftNotfication).css('right', 0);
                        }
                        if (position == 'topLeft' || position == 'centerLeft' || position == 'bottomLeft') {
                            $('#noty_centerLeft_layout_container').css('left', leftNotfication + 20);
                            $('#noty_topLeft_layout_container').css('left', leftNotfication + 20);
                            $('#noty_bottomLeft_layout_container').css('left', leftNotfication + 20);
                        }
                    }

                }
            }
        });

    }
    else {
        var n = $(container).noty({
            text: content,
            dismissQueue: true,
            layout: position,
            closeWith: ['click'],
            theme: 'made',
            maxVisible: 10,
            buttons: confirm ? [
                {
                    addClass: 'btn btn-primary', text: 'Ok', onClick: function ($noty) {
                        $noty.close();
                        noty({
                            dismissQueue: true,
                            layout: 'topRight',
                            theme: 'defaultTheme',
                            text: 'You clicked "Ok" button',
                            animation: {
                                open: 'animated bounceIn', close: 'animated bounceOut'
                            },
                            type: 'success',
                            timeout: 3000
                        });
                    }
                },
                {
                    addClass: 'btn btn-danger', text: 'Cancel', onClick: function ($noty) {
                        $noty.close();
                        noty({
                            dismissQueue: true,
                            layout: 'topRight',
                            theme: 'defaultTheme',
                            text: 'You clicked "Cancel" button',
                            animation: {
                                open: 'animated bounceIn', close: 'animated bounceOut'
                            },
                            type: 'error',
                            timeout: 3000
                        });
                    }
                }
            ] : '',
            animation: {
                open: openAnimation,
                close: closeAnimation
            },
            timeout: 3000,
            callback: {
                onShow: function () {
                    var sidebarWidth = $('.sidebar').width();
                    var topbarHeight = $('.topbar').height();
                    if (position == 'top' && style == 'topbar') {
                        $('.noty_inline_layout_container').css('top', 0);
                        if ($('body').hasClass('rtl')) {
                            $('.noty_inline_layout_container').css('right', 0);
                        }
                        else {
                            $('.noty_inline_layout_container').css('left', 0);
                        }

                    }

                }
            }
        });

    }

}