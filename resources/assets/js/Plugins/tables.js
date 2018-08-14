require( 'jszip' );
require( 'datatables.net-bs4' )
require( 'datatables.net-buttons-bs4' )
require( 'datatables.net-buttons/js/buttons.colVis.js' )
require( 'datatables.net-buttons/js/buttons.html5.js' )
require( 'datatables.net-buttons/js/buttons.print.js' )
require( 'datatables.net-responsive-bs4' )
const selectableTable = require('./selectableTable')

/****  Tables Responsive  ****/
function tableResponsive() {
    setTimeout(function () {
        $('.table').each(function () {
            window_width = $(window).width();
            table_width = $(this).width();
            content_width = $(this).parent().width();
            if (table_width > content_width) {
                $(this).parent().addClass('force-table-responsive');
            }
            else {
                $(this).parent().removeClass('force-table-responsive');
            }
        });
    }, 200);
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

tableResponsive()
if ($('.table-selectable').length)
    selectableTable.init();
datatablesSetup()

$(window).on('resize', function (e) {
    let resizeEvt;
    $(window).resize(function () {
        clearTimeout(resizeEvt);
        resizeEvt = setTimeout(function () {
            tableResponsive();
        }, 250);
    });
});