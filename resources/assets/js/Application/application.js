require("./toggleFullScreen");
require("./preloader");
require("./sidebarMenu");
require('./scrollTop');
require('./detectIE');
require('./printing');
require('./extra');
require('./pickups');
require('./suggestions');

(function () {
    let shistory = document.querySelector(".shipment-history")
    if (shistory) shistory.scrollTo(0, 0);

    let deliveryReasons = document.querySelectorAll('.delivery-reasons input[type=radio]');
    if (deliveryReasons.length) {
        deliveryReasons.forEach(item => {
            item.addEventListener('change', () => {
                let step2 = document.querySelector('.delivery-failed-form .step-2');
                if (item.checked) {
                    step2.querySelector('.message').textContent = item.dataset.message;
                    step2.style.display = "block";
                }
                let crInput = step2.querySelector('.deliveryDate-input');
                let apInput = step2.querySelector('.actualPaid-input');
                let suggInput = step2.querySelector('.suggestions');
                crInput.querySelector('input').removeAttribute('required');
                crInput.style.display = "none";
                apInput.style.display = "none";
                suggInput.style.display = "none";
                if (item.value === "consignee_rescheduled") {
                    crInput.querySelector('input').required = true;
                    crInput.style.display = "block";
                } else if (item.value === "rejected") {
                    apInput.style.display = "block";
                } else if(item.value === 'not_available') {
                    suggInput.style.display = "block";
                }
            });
        });
    }


    let pickupStates = document.querySelectorAll('.pickup-statuses input[type=radio]');
    if (pickupStates.length) {
        pickupStates.forEach(item => {
            item.addEventListener('change', () => {
                let step2 = document.querySelector('.pickup-actions-form .step-2');
                let suggestions = step2.querySelector('.reasons-input .suggestions');
                let newtimeInput = step2.querySelector('.newTime-input');
                let actualPackagesInput = step2.querySelector('.actualPackages-input');
                suggestions.style.display = "none";
                newtimeInput.style.display = "none";
                actualPackagesInput.style.display = "none";
                if (item.value === "client_rescheduled") {
                    //newtimeInput.querySelector('input').required = true;
                    newtimeInput.style.display = "block";
                } else if (item.value === "declined_not_available") {
                    suggestions.style.display = "block";
                } else if (item.value === "completed") {
                    actualPackagesInput.style.display = "block";
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
                let input = document.querySelector('input[name="scope"]')
                if(!input) return;
                input.value = $(filter_status).val().join(',');
            });
        });

    }


    $("select#status, select#original_status").on('change', function () {
        let val = $(this).val();
        let $container = $(this).closest('form');
        let $newDeliveryDate = $container.find(".newDeliveryDate-input");
        if (val == 4)
            $newDeliveryDate.show();
        else
            $newDeliveryDate.hide();

    });
})();




