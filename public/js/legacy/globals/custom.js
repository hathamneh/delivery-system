//****************** YOUR CUSTOMIZED JAVASCRIPT **********************//
(function () {

    $(document).ready(function () {

        datatablesSetup()
        if ($('.table-selectable').length)
            selectableTable.init();
        fieldSetToggle();
        dateTimePicker();
        reportRangePicker();
        buttonLoader();
        bindElements();
        showPasswordBtn();
        customFileInput();
        changeShipmentClientType();
        customLinks()
        printing();

        $('[data-toggle="tooltip"]').tooltip();
    });










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


})();
