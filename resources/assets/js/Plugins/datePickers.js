let moment = require('moment')
require('daterangepicker')

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
    });
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
    pickerRanges[Lang.get('common.today')] = [moment().startOf("day"), moment().endOf('day')];
    pickerRanges[Lang.get('common.yesterday')] = [moment().subtract(1, 'days').startOf('day'), moment().subtract(1, 'days').endOf('day')];
    pickerRanges[Lang.get('common.last30days')] = [moment().subtract(29, 'days'), moment()];
    pickerRanges[Lang.get('common.thisMonth')] = [moment().startOf('month'), moment().endOf('month')];
    pickerRanges[Lang.get('common.lastMonth')] = [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')];

    var drpOptions = {
        ranges: pickerRanges,
        lifetimeRangeLabel: Lang.get('common.lifetime'),
        locale: {
            "format": "MM/DD/YYYY",
            "separator": " - ",
            "applyLabel": Lang.get('common.apply'),
            "cancelLabel": Lang.get('common.cancel'),
            "fromLabel": Lang.get('common.from'),
            "toLabel": Lang.get('common.to'),
            "customRangeLabel": Lang.get('common.customRange'),
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

    window.lifetimeRangeLabel = Lang.get('common.lifetime');
    var qs = window.getUrlVars();
    var startDate = qs.start || false;
    var endDate = qs.end || false;
    drpOptions.isLifetime = !(startDate && endDate);

    if (!drpOptions.isLifetime) {
        drpOptions.startDate = moment.unix(startDate);
        drpOptions.endDate = moment.unix(endDate);
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

dateTimePicker()
reportRangePicker()