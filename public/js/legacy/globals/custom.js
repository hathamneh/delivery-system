//****************** YOUR CUSTOMIZED JAVASCRIPT **********************//
(function () {
    var ajax_url = "/ajax_requests.php";

    $(document).ready(function () {

        datatablesSetup()
        if ($('.table-selectable').length)
            selectableTable.init();
        fieldSetToggle();
        dateTimePicker();
        reportRangePicker();
        ajaxSelect2();
        buttonLoader();
        bindElements();
        showPasswordBtn();
        customFileInput();
        changeShipmentClientType();
        customLinks()
        printing();

        $('[data-toggle="tooltip"]').tooltip();
    });

    $(window).scroll(function () {
        sticko();
    });


    function buttonLoader() {
        if ($('.ladda-button').length) {
            Ladda.bind('.ladda-button', {
                timeout: 2000
            });
        }
    }

    let selectableTable = {
        $selectableTable: null,
        selected: [],
        $selAll: null,
        init: function () {
            this.$selectableTable = $('.table-selectable');
            this.$selAll = this.$selectableTable.find("#selectAll");
            this.controller();
        },
        controller: function () {
            this.$selectableTable.on('click', 'tbody tr', selectableTable.on.rowSelect)
            this.$selectableTable.on('change', 'tbody .custom-checkbox .custom-control-input', function () {
                selectableTable.on.checkboxChanged(this);
                selectableTable.checkSelected()
            });
            this.$selAll.on('change', selectableTable.on.selectAll);
            this.extra();
        },
        extra: function () {
            $('.dataTables_wrapper .page-link').on("click", function () {
                selectableTable.checkSelected();
            });
        },
        on: {
            rowSelect: function (e) {
                if ($(e.target).is('.custom-checkbox, .custom-checkbox *')) return;
                var checkbox = $(this).find('.custom-checkbox .custom-control-input');
                var oldVal = checkbox.prop('checked')
                checkbox.prop('checked', !oldVal).trigger('change');
            },
            checkboxChanged: function (_this) {
                var $this = _this ? $(_this) : $(this)
                var $row = $this.closest('tr');
                if ($this.is(":checked")) {
                    $row.addClass('selected');
                    selectableTable.selected.push($row.data('id'));
                } else {
                    $row.removeClass('selected');
                    var position = selectableTable.selected.indexOf($row.data('id'));
                    if (position !== -1)
                        selectableTable.selected.splice(position, 1);
                }
            },
            selectAll: function () {
                var $this = $(this)
                console.log($this.is(":checked"));
                var $checkBoxes = selectableTable.$selectableTable.find('tbody .custom-checkbox .custom-control-input');
                if ($this.is(":checked")) {
                    $checkBoxes.prop('checked', true);
                } else {
                    $checkBoxes.prop('checked', false);
                }
                $checkBoxes.each(function () {
                    selectableTable.on.checkboxChanged(this);
                });
                selectableTable.checkSelected();
            }
        },
        checkSelected: function () {
            var $selected = $('.table-selectable tbody tr.selected');
            var $notSelected = $('.table-selectable tbody tr:not(.selected)');
            var $actions = $(".reports-actions");
            if ($selected.length) {
                $('.selection-indicator').text($selected.length + " Selected");
                $actions.find('input[name=shipments]').val(selectableTable.selected.join(','));
                $(".page-heading").addClass('sticky');
                if ($notSelected.length) {
                    selectableTable.$selAll.prop('indeterminate', true);
                } else {
                    selectableTable.$selAll.prop('checked', true);
                    selectableTable.$selAll.prop('indeterminate', false);
                }
                $actions.slideDown();
            } else {
                $(".page-heading").removeClass('sticky');
                selectableTable.$selAll.prop('selected', false);
                $actions.slideUp();
            }
        },
        clearSelected: function () {
            $('.table-selectable tr.selected').removeClass('selected');
            selectableTable.selected = [];
            var $actions = $(".reports-actions");
            $actions.find('input[name=shipments]').val("");
            $actions.slideUp();
        }
    }

    function datatablesSetup() {
        var dtOpts = {
            pageLength: 25,
            "lengthMenu": [[10, 25, 50, 75], [10, 25, 50, 75]],
            stateSave: true,
            "columnDefs": [{
                "targets": [-1],
                "orderable": false
            }],
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
        $('.dataTable').each(function () {
            var $this = $(this);
            if ($this.data('ajax')) {
                var url = $this.data('ajax');
                dtOpts = {
                    ...dtOpts, ...{
                        "processing": true,
                        "serverSide": true,
                        "deferRender": true,
                        "ajax": {
                            url: url
                        },
                        createdRow: function (row, data, dataIndex) {
                            $(row).data('id', data.id);
                            $(row).attr('data-id', data.id);
                        },
                        "columnDefs": [{
                            "targets": [0, -1, -2],
                            "orderable": false
                        }],
                        columns: [
                            {
                                data: null,
                                render: function (data, type, row) {
                                    return '<div class="custom-control custom-checkbox" title="Select">\n' +
                                        '                        <input type="checkbox" class="custom-control-input" id="select-' + data.id + '">\n' +
                                        '                        <label class="custom-control-label" for="select-' + data.id + '"></label>\n' +
                                        '                    </div>';
                                }
                            },
                            {data: "client_account_number"},
                            {
                                data: "status",
                                render: {
                                    _: "display",
                                    sort: "value",
                                }
                            },
                            {data: "waybill"},
                            {data: "courier"},
                            {
                                data: "delivery_date",
                                render: {
                                    _: "display",
                                    sort: "value"
                                }
                            },
                            {data: "address"},
                            {data: "phone_number"},
                            {data: "delivery_cost"},
                            {data: "shipment_value"},
                            {data: "actual_paid_by_consignee"},
                            {
                                data: "courier_cashed",
                                render: function (data, type, row) {
                                    return data ? '<i class="fa-check"></i>' : '<i class="fa-times"></i>'
                                }
                            },
                            {
                                data: "client_paid",
                                render: function (data, type, row) {
                                    return data ? '<i class="fa-check"></i>' : '<i class="fa-times"></i>'
                                }
                            }
                        ]
                    }
                }

            }

            if ($this.hasClass('reports-table')) {
                dtOpts.dom = "<'row align-items-center dt-top'<'col-auto'l><'col'B><'col-auto'f>>rtip";
                dtOpts.buttons = [
                    'print', 'excel', 'colvis'
                ];
            }

            $this.on('preXhr.dt', function (e, settings, data) {
                data.client = $('select[name=client]').val()
                data.courier = $('select[name=courier]').val()
            }).on('xhr.dt', function () {
                selectableTable.clearSelected();
            }).DataTable(dtOpts);
        })
    }

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

    function showPasswordBtn() {
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
    }

    function changeShipmentClientType() {
        var $clientType = $("#shipmentClientInfo .custom-radio");
        $clientType.on('change', "[name='shipment_client[type]']", function () {
            var $this = $(this);
            var $allInputs = $('#shipmentClientInfo').find('.card-body input, .card-body select');
            var $myInputs = $this.closest('.card').find('.card-body input, .card-body select');
            $allInputs.prop('disabled', true);
            $myInputs.prop('disabled', false);
        });
    }

    function customFileInput() {
        $('.custom-file-input').on('change', function () {
            let fileInput = $(this)[0];
            let files = fileInput.files;
            let names = [];

            for (let i = 0; i < files.length; i++) {
                names.push(files[i].name);
            }
            $(this).next('.custom-file-label').addClass("selected").html(names.join(', '));
        });
    }

    function bindElements() {
        // Declare a global object to store view data.
        var viewData;

        viewData = {};

        (function () {
            // Update the viewData object with the current field keys and values.
            function updateViewData(key, value) {
                viewData[key] = value;
            }

            // Register all bindable elements
            function detectBindableElements() {
                var bindableEls;
                bindableEls = $('[data-bind]');

                function refresh($this) {
                    var value;
                    if ($this.is('[type="checkbox"], [type="radio"]'))
                        value = $('[for="' + $this.attr('id') + '"]').text();
                    else if ($this.is('select'))
                        value = $this.find("option:selected").text();
                    else
                        value = $this.val();
                    updateViewData($this.data('bind'), value);
                    $(document).trigger('updateDisplay');
                }

                bindableEls.each(function () {
                    refresh($(this));
                });

                // Add event handlers to update viewData and trigger callback event.
                bindableEls.on('change', function () {
                    refresh($(this));
                });

            }

            // Trigger this event to manually update the list of bindable elements, useful when dynamically loading form fields.
            $(document).on('updateBindableElements', detectBindableElements);

            detectBindableElements();
        })();

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
    }

    function customLinks() {
        $('[data-href]').on('click', function () {
            var href = $(this).data('href');
            if (typeof href === "string")
                window.location.href = href;
        })
    }

    function ajaxSelect2() {
        clientSelect();
        couriersSelect();
        waybillSelect()

        function clientSelect() {
            var $clinetAccNum = $("select.select2-accountNumber");
            $clinetAccNum.each(function () {
                var $this = $(this);
                $this.select2({
                    ajax: {
                        url: '/api/suggest/clients',
                        dataType: 'json',
                        processResults: function (data, params) {
                            var out = {
                                results: data.data,
                            };
                            return out;
                        },
                    },
                    allowClear: true,
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
                    },
                    templateSelection: function (data) {
                        if (!data.name) return data.text;
                        return data.text + "<small class='text-muted mx-2'>(" + data.name + ")</small>";
                    }
                });
            });
            $clinetAccNum.on('select2:select', function (e) {
                var data = e.params.data;
                let reportsDT = $('.reports-table.dataTable');
                if (reportsDT.length) {
                    reportsDT.DataTable().ajax.reload();
                    let urlVars = getUrlVars();
                    urlVars.client = data.text;
                    window.history.pushState({}, window.title, "?" + to_qs(urlVars))
                }
            });
            $clinetAccNum.on('select2:unselect', function (e) {
                var data = e.params.data;
                let reportsDT = $('.reports-table.dataTable');
                if (reportsDT.length) {
                    reportsDT.DataTable().ajax.reload();
                    let urlVars = getUrlVars();
                    if (urlVars.client)
                        delete urlVars.client;
                    window.history.pushState({}, window.title, "?" + to_qs(urlVars))
                }
            });
        }

        function couriersSelect() {


            var $courierSelect = $("select.select2-courier");
            $courierSelect.each(function () {
                var $this = $(this);
                $this.select2({
                    ajax: {
                        url: '/api/suggest/couriers',
                        dataType: 'json',
                        processResults: function (data, params) {
                            var out = {
                                results: data.data,
                            };
                            return out;
                        },
                    },
                    allowClear: true,
                    placeholder: $this.data('placeholder'),
                    escapeMarkup: function (markup) {
                        return markup;
                    },
                    templateResult: couriersTemplate,
                    templateSelection: couriersTemplate
                });

                function couriersTemplate(data) {
                    var markup = '<b>' + data.text + '</b>';
                    if (data.zone)
                        markup += '<small class="text-muted mx-1">(' + data.zone + ')</small>';
                    return markup;
                }
            });
            $courierSelect.on('select2:select', function (e) {
                var data = e.params.data;
                let reportsDT = $('.reports-table.dataTable');
                if (reportsDT.length) {
                    reportsDT.DataTable().ajax.reload();
                    let urlVars = getUrlVars();
                    urlVars.courier = data.id;
                    window.history.pushState({}, window.title, "?" + to_qs(urlVars))
                }
            });
            $courierSelect.on('select2:unselect', function (e) {
                var data = e.params.data;
                let reportsDT = $('.reports-table.dataTable');
                if (reportsDT.length) {
                    reportsDT.DataTable().ajax.reload();
                    let urlVars = getUrlVars();
                    if (urlVars.courier)
                        delete urlVars.courier;
                    window.history.pushState({}, window.title, "?" + to_qs(urlVars))
                }
            });
        }

        function waybillSelect() {

            var $waybillSelect = $('.select2-waybills');
            $waybillSelect.select2({
                tags: true,
                ajax: {
                    url: '/api/suggest/shipments',
                    processResults: function (data, params) {
                        var out = {
                            results: data.data,
                        };
                        return out;
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
        }
    }

    function dateTimePicker() {
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
        $('.datetimepicker').each(function () {
            drops = $(this).data('drp-drops') || "down"
            $(this).daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                locale: {
                    format: "DD-MM-YYYY"
                },
                minDate: moment(),
                drops: drops
            });
        })
    }

    function reportRangePicker() {
        var $range = $('#reportrange');

        var pickerRanges = {};
        var key = window.trans('common.today');
        console.log(key);
        pickerRanges = {[key]: [moment(), moment()]};
        // ranges[trans('common.yesterday')] = [moment().subtract(1, 'days'), moment().subtract(1, 'days')];
        // ranges[trans('common.last30days')] = [moment().subtract(29, 'days'), moment()];
        // ranges[trans('common.thisMonth')] = [moment().startOf('month'), moment().endOf('month')];
        // ranges[trans('common.lastMonth')] = [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')];
        console.log(pickerRanges);

        var drpOptions = {
            ranges: pickerRanges,
            lifetimeRangeLabel: trans('common.lifetime'),
            locale: {
                "format": "MM/DD/YYYY",
                "separator": " - ",
                "applyLabel": trans('common.apply'),
                "cancelLabel": trans('common.cancel'),
                "fromLabel": trans('common.from'),
                "toLabel": trans('common.to'),
                "customRangeLabel": trans('common.customRange'),
                "weekLabel": "W",
                "daysOfWeek": [
                    "Su",
                    "Mo",
                    "Tu",
                    "We",
                    "Th",
                    "Fr",
                    "Sa"
                ],
                "monthNames": [
                    "January",
                    "February",
                    "March",
                    "April",
                    "May",
                    "June",
                    "July",
                    "August",
                    "September",
                    "October",
                    "November",
                    "December"
                ],
                "firstDay": 1
            }
        };

        window.lifetimeRangeLabel = trans('common.lifetime');
        var qs = window.getUrlVars();
        var startDate = qs.start || false;
        var endDate = qs.end || false;
        drpOptions.isLifetime = !(startDate && endDate);

        if (!drpOptions.isLifetime) {
            drpOptions.startDate = moment(startDate);
            drpOptions.endDate = moment(endDate);
        }


        if ($range.length) {
            drpOptions.lifetimeRange = true;
            drpOptions.opens = "left";

            function cb(start, end) {
                var label = $range.find('span');
                if (drpOptions.isLifetime)
                    label.html(window.lifetimeRangeLabel);
                else
                    label.html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }

            // init date time range picker
            $range.daterangepicker(drpOptions, cb);

            $range.on('apply.daterangepicker', function (ev, picker) {
                var qs = window.getUrlVars();
                qs.start = picker.startDate.unix();
                qs.end = picker.endDate.unix();
                window.location.href = window.location.protocol + "//" + window.location.host + window.location.pathname + "?" + window.to_qs(qs);
            });
            $range.on('lifetime.daterangepicker', function (ev, picker) {
                var qs = window.getUrlVars();
                if (qs.start) delete qs.start;
                if (qs.end) delete qs.end;
                window.location.href = window.location.protocol + "//" + window.location.host + window.location.pathname + (qs.length ? "?" + window.to_qs(qs) : "");
            });

            cb(drpOptions.startDate, drpOptions.endDate);

        }
    }

    function fieldSetToggle() {
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
    }

    function printing() {
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
    }
})();

window.getUrlVars = function () {
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

window.to_qs = function (obj) {
    var str = [];
    for (var p in obj)
        if (obj.hasOwnProperty(p) && p !== "" && obj[p]) {
            str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
        }
    return str.join("&");
}