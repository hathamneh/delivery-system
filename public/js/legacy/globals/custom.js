//****************** YOUR CUSTOMIZED JAVASCRIPT **********************//
(function () {
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

        var dtOpts = {
            pageLength: 50,
            stateSave: true
        };
        if ($("body.rtl").length) {
            dtOpts.language = {

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

            };
        }
        var oTable = $('.dataTable').DataTable(dtOpts);

        $('.fieldset-toggle').each(function () {
            var $this = $(this);
            var $toggle = $this.find('legend input[type=checkbox], legend input[type=radio]');
            $toggle.on('change', function () {
                if ($(this).prop('checked')) {
                    $this.find('input[disabled]').not($(this)).prop('disabled', false);
                    $this.find('.btn.disabled').removeClass('disabled');
                } else {
                    $this.find('input').not($(this)).prop('disabled', true);
                    $this.find('.btn').addClass('disabled');
                }
            });
        })

        // $('.select2-tags').select2({
        //     tags: true
        // });


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
            $('.date-rangepicker').daterangepicker({
                showDropdowns: true,
                minDate: moment([2018]),
                locale: {
                    format: "DD-MM-YYYY hh:mm A"
                }
            }, function (start, end, label) {
                var years = moment().diff(start, 'years');
            });
            $('.datetime-rangepicker').daterangepicker({
                showDropdowns: true,
                timePicker: true,
                minDate: moment([2018]),
                locale: {
                    format: "DD-MM-YYYY hh:mm A"
                }
            }, function (start, end, label) {
                var years = moment().diff(start, 'years');
            });
            // endDate.daterangepicker({
            //     singleDatePicker: true,
            //     showDropdowns: true,
            //     minYear: 2018,
            //     maxYear: parseInt(moment().format('YYYY'), 10),
            //     locale: {
            //         format: "DD-MM-YYYY hh:mm A"
            //     }
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

        var $clinetAccNum = $("select.select2-accountNumber");
        $clinetAccNum.each(function() {
            var $this = $(this);
            $this.select2({
                ajax: {
                    url: '/api/suggest/clients',
                    dataType: 'json',
                    processResults: function (data, params) {
                        var out = {
                            results: data.data,
                        };
                        console.log(out);
                        return out;
                    },
                },
                placeholder: $this.data('placeholder'),
                minimumInputLength: 5,
                escapeMarkup: function (markup) {
                    return markup;
                },
                templateResult: function (data) {
                    var markup = data.text;
                    if (data.name && data.trade_name)
                        markup = '<div class="client-suggestion">' +
                            '<b>' + data.name + '</b><br>' +
                            '<small>' + data.text + ' (' + data.trade_name + ')</small>' +
                            '</div>'
                    return markup;
                }
            });
        });
        $clinetAccNum.on('select2:select', function (e) {
            var data = e.params.data;
            console.log(data)
            if(data.phone_number)
                $('#phone_number').val(data.phone_number);
            if(data.address_pickup_text)
                $('#pickup_address_text').val(data.address_pickup_text);
            if(data.address_pickup_maps)
                $('#pickup_address_maps').val(data.address_pickup_maps);
        });

        var $waybillSelect = $('.select2-waybills');
        $waybillSelect.select2({
            tags: true,
            ajax: {
                url: '/api/suggest/shipments',
                processResults: function (data, params) {
                    console.log(data);
                    return data;
                },
            },
            placeholder: $waybillSelect.data('placeholder'),
            escapeMarkup: function (markup) {
                return markup;
            },
            templateResult: function (data) {
                var markup = '<div class="shipment-suggestion">' +
                    '<b>' + data.text + '</b><br>';
                if (data.client || data.address || data.delivery_date) {
                    markup += "<small>";
                    markup += data.client ? "<span>Client: " + data.client + "</span> | " : "";
                    markup += data.client ? "<span>Address: " + data.address + "</span> | " : "";
                    markup += data.client ? "<span>Delivery Date: " + data.delivery_date + "</span>" : "";
                    markup += "</small>";
                }
                markup += '</div>';
                return markup;
            }
        });

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

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });

        $(document).on('click', '.show-password', function () {
            var $input = $(this).closest('.input-group').find('input');
            if ($input.attr('type') === "password") {
                $input.attr('type', 'text');
                $(this).find('i').addClass('fa-eye-slash2');
            } else {
                $input.attr('type', 'password');
                $(this).find('i').removeClass('fa-eye-slash2');
            }
        });

        $(document).on('click', '[data-delete]', function (e) {
            e.preventDefault();
            var id = $(this).data('delete');
            console.log(id);
            var $form = $('[data-id=' + id + ']').find('.delete-form');
            $form.submit();
        });


        $('.custom-file-input').on('change', function () {
            let fileInput = $(this)[0];
            let files = fileInput.files;
            let names = [];

            for (let i = 0; i < files.length; i++) {
                names.push(files[i].name);
            }
            $(this).next('.custom-file-label').addClass("selected").html(names.join(', '));
        });
    });

    $(window).scroll(function () {

        sticko();
    });
    var stickoLock = false;

    function sticko() {
        var $element = $('.custom-sticky-top');
        var topbarHeight = $('.topbar').outerHeight() || 0;
        var topPos = $('.page-heading').outerHeight() || 0;
        var originalWidth = $element.width();
        var start = window.innerWidth >= 786;
        if (start)
            if (!stickoLock && window.scrollY >= $element.offset().top - topbarHeight - 15) {

                $element.css({
                    top: topbarHeight + 15,
                    position: 'fixed',
                    width: originalWidth
                });
                stickoLock = true;

            } else if (stickoLock && window.scrollY < topPos + 15) {

                stickoLock = false
                $element.css({
                    top: 'auto',
                    position: 'static',
                    width: 'auto',
                });

            }
    }

    $(document).ready(function () {
        $("#shipmentClientInfo .custom-radio").on('change', "[name='shipment_client_type']", function () {
            var $this = $(this);
            var $allInputs = $('#shipmentClientInfo').find('.card-body input, .card-body select');
            var $myInputs = $this.closest('.card').find('.card-body input, .card-body select');
            $allInputs.prop('disabled', true);
            $myInputs.prop('disabled', false);
        })
    })


    function buttonLoader() {
        if ($('.ladda-button').length) {
            Ladda.bind('.ladda-button', {
                timeout: 2000
            });
        }
    }

    window.getUrlVars = function() {
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

    window.to_qs = function(obj) {
        var str = [];
        for (var p in obj)
            if (obj.hasOwnProperty(p)) {
                str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
            }
        return str.join("&");
    }
})();