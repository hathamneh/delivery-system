require('select2/dist/js/select2.full')

window.inputSelect = () => {

    if ($.fn.select2) {
        setTimeout(function () {
            $('select.select2').each(function () {
                $(this).select2({
                    theme: 'bootstrap4',
                    placeholder: $(this).data('placeholder') ? $(this).data('placeholder') : '',
                    allowClear: $(this).data('allowclear') ? $(this).data('allowclear') : false,
                    minimumInputLength: $(this).data('minimumInputLength') ? $(this).data('minimumInputLength') : -1,
                    minimumResultsForSearch: $(this).data('search') ? -1 : 1,
                    dropdownCssClass: $(this).data('style') ? $(this).data('style') : '',
                    //containerCssClass: $(this).data('container-class') ? $(this).data('container-class') : ''
                });
            });
            $('.select2-tags').select2({
                tags: true,
                placeholder: $(this).data('placeholder') ? $(this).data('placeholder') : '',
            })
        }, 200);
    }
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
                theme: 'bootstrap4',
                ajax: {
                    url: '/ajax/suggest/clients',
                    dataType: 'json',
                    data: function (params) {
                        return {
                            _token: window.token,
                            ...params
                        };
                    },
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
                            '<b>' + data.name + '</b> - '+ data.zone +'<br>' +
                            '<small>' + data.text + ' (' + data.trade_name + ')</small>' +
                            '</div>'
                    return markup;
                },
                templateSelection: function (data) {
                    if (!data.name) return data.text;
                    return data.text + "<small class='text-muted mx-2'>(" + data.name + " - " + data.zone + ")</small>";
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
                theme: 'bootstrap4',
                ajax: {
                    url: '/ajax/suggest/couriers',
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
                var markup = data.text;
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
            theme: 'bootstrap4',
            minimumInputLength: 9,
            tags: true,
            ajax: {
                url: '/ajax/suggest/shipments',
                headers: {
                    'X-CSRF-TOKEN': window.csrf_token,
                },
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

inputSelect()
ajaxSelect2()