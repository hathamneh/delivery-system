require("./toggleFullScreen");
require("./preloader");
require("./sidebarMenu");
require('./scrollTop');
require('./detectIE');
require('./printing');
require('./extra');
require('./pickups');
require('./suggestions');
require('./shipments');
import NotificationService from './notifications';

new NotificationService({
    url: "/ajax/notifications"
});

(function () {
    let shistory = document.querySelector(".shipment-history")
    if (shistory) shistory.scrollTo(0, 0);

    let deliveryReasons = document.querySelector('.delivery-reasons select#notDeliveredStatus');
    if (deliveryReasons) {
        deliveryReasons.addEventListener('change', () => {
            let step2 = document.querySelector('.delivery-failed-form .step-2');
            let selectedStatus = deliveryReasons.value;
            step2.style.display = "block";

            step2.querySelectorAll('.form-group:not(.all)').forEach(item => {
                item.style.display = "none";
                if (item.classList.contains(selectedStatus))
                    item.style.display = 'block';
            })
        });
    }


    let pickupStates = document.querySelectorAll('.pickup-statuses input[type=radio]');
    if (pickupStates.length) {
        pickupStates.forEach(item => {
            item.addEventListener('change', () => {
                let step2 = item.closest('.pickup-actions-form').querySelector('.step-2');
                let reasonsInput = step2.querySelector('.reasons-input');
                let notesTextArea = reasonsInput.querySelector('textarea');
                let suggestions = reasonsInput.querySelector('.suggestions');
                let newtimeInput = step2.querySelector('.newTime-input');
                let actualPackagesInput = step2.querySelector('.actualPackages-input');
                let prepaid_cash = step2.querySelector('.prepaid_cash-input');
                suggestions.style.display = "none";
                newtimeInput.style.display = "none";
                newtimeInput.querySelector('input').disabled = true;
                actualPackagesInput.style.display = "none";
                actualPackagesInput.querySelector('input').disabled = true;
                prepaid_cash.style.display = "none";
                prepaid_cash.querySelector('input').disabled = true;

                if (item.value === "client_rescheduled") {
                    let originalTime = item.dataset.originalTime;
                    newtimeInput.style.display = "block";
                    newtimeInput.querySelector('input').disabled = false;
                    notesTextArea.value = `Rescheduled (Original: ${originalTime})`;

                } else if (item.value === "declined_not_available") {
                    suggestions.style.display = "block";
                    notesTextArea.value = "";

                } else if (item.value === "declined_client") {
                    notesTextArea.value = "Cancelled by client";

                } else if (item.value === "declined_dispatcher") {
                    notesTextArea.value = "Cancelled by dispatcher";

                } else if (item.value === "completed") {
                    actualPackagesInput.style.display = "block";
                    actualPackagesInput.querySelector('input').disabled = false;
                    prepaid_cash.style.display = "block";
                    prepaid_cash.querySelector('input').disabled = false;
                    notesTextArea.value = "";
                }
            });
        });
    }

    let filtersBtn = document.querySelector('.shipments-filter-btn');
    if (filtersBtn) {

        $(filtersBtn).on('inserted.bs.popover', e => {
            inputSelect()
            let filter_status = document.querySelector("#filter_status");
            if (!filter_status) return;
            $(filter_status).on('change', () => {
                let input = document.querySelector('input[name="filters[scope]"]')
                if (!input) return;
                input.value = $(filter_status).val().join(',');
            });
        });

    }


    $("select#status, select#original_status").on('change', function () {
        let val = $(this).val();
        let $container = $(this).closest('form');
        let $newDeliveryDate = $container.find(".newDeliveryDate-input");
        if (val === 'consignee_rescheduled')
            $newDeliveryDate.show();
        else
            $newDeliveryDate.hide();

    });
})();




