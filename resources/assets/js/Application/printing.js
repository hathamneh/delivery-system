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

printing()