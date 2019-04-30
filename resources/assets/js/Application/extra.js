import moment from 'moment';

(function() {
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
    let stickoLock = false;
    function sticko() {
        var $element = $('.custom-sticky-top');
        if(!$element.length) return;
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
            var $allCards = $('#shipmentClientInfo').find('.card');
            var $allInputs = $allCards.find('.card-body input, .card-body select');
            let selectPickers = $allInputs.filter('.selectpicker');
            let $myCard = $this.closest('.card');
            var $myInputs = $myCard.find('.card-body input, .card-body select');
            $allInputs.prop('disabled', true);
            $myInputs.prop('disabled', false);
            selectPickers.selectpicker('refresh');
            $allCards.addClass('collapsed');
            $myCard.removeClass('collapsed');
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

    function shipmentServiceAutoSelect($services) {
        const featuredServices = {};
        $services.find('option').each(function () {
            if($(this).text().includes('COD')) featuredServices['cod'] = $(this).val();
            if($(this).text().includes('PCC')) featuredServices['pcc'] = $(this).val();
        })
        $("input#shipment_value").on('change', function () {
            let val = $(this).val();
            if(val !== '' && val > 0) {
                $services.selectpicker('val', featuredServices['cod']);
            } else if(val !== '' && val < 0) {
                $services.selectpicker('val', featuredServices['pcc']);
            } else {
                $services.selectpicker('deselectAll');
            }
        })
    }

    function shipmentServiceTypeAutoSelect($serviceType) {
        $("input#delivery_date").on('change', function () {
            let val = $(this).val();
            if(moment(val, "DD/MM/YYYY").diff(moment().startOf('day')) === 0)
                $serviceType.val('sameday');
            else
                $serviceType.val('nextday');

        })
    }

    $(document).ready(function () {
        fieldSetToggle()
        bindElements()
        showPasswordBtn()
        customFileInput()
        changeShipmentClientType()
        customLinks()
        let $services = $('select#services');
        if($services.length) {
            shipmentServiceAutoSelect($services)
        }
        let $serviceType = $('input#service_type');
        if($serviceType.length) {
            shipmentServiceTypeAutoSelect($serviceType)
        }
    })
    $(window).scroll(function () {
        sticko()
    });
})()