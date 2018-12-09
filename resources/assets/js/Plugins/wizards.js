require('./src/step-form-wizard')

function formWizard() {

    if ($('.wizard').length && $.fn.stepFormWizard) {
        var finishText = "Finish";
        if (wizardFinishText)
            finishText = wizardFinishText;
        $('.wizard').each(function () {
            $this = $(this);
            $(this).stepFormWizard({
                theme: $(this).data('style') ? $(this).data('style') : "circle",
                showNav: $(this).data('nav') ? $(this).data('nav') : "top",
                height: "auto",
                rtl: $('body').hasClass('rtl') ? true : false,
                onNext: function (i, wizard) {
                    if ($this.hasClass('wizard-validation')) {
                        return $('form', wizard).parsley().validate('block' + i);
                    }
                },
                onFinish: function (i) {
                    if ($this.hasClass('wizard-validation')) {
                        return $('form', wizard).parsley().validate();
                    }
                },
                finishBtn: $('<button class="sf-right sf-btn finish-btn" type="button" data-toggle="modal" data-target="#reviewShipmentModal">' + finishText + '</button>')
            });
        });

        /* Fix issue only with tabs with Validation on error show */
        $('#validation .wizard .sf-btn').on('click', function () {
            setTimeout(function () {
                $(window).resize();
                $(window).trigger('resize');
            }, 50);
        });
    }
}

formWizard()