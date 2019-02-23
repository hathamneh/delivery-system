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

    let statusChangers = document.querySelectorAll('.status-changer');
    statusChangers.forEach(statusChanger => {
        statusChanger.addEventListener('change', e => {
            let targetSelector = e.target.dataset.target;
            if (!targetSelector) return;
            let target = document.querySelector(targetSelector);
            let selectedStatus = e.target.value;
            target.style.display = "block";

            target.querySelectorAll('.form-group:not(.all)').forEach(item => {
                item.style.display = "none";
                item.querySelectorAll('input, select').forEach(input => {
                    if (input.name[0] !== "_") input.name = "_" + input.name;
                    if (input.tagName.toLowerCase() === "input")
                        input.type = "hidden"
                });
                if (item.classList.contains(selectedStatus)) {
                    item.style.display = 'block';
                    item.querySelectorAll('input, select').forEach(input => {
                        if (input.name[0] === "_") input.name = input.name.substr(1);
                        if (input.tagName.toLowerCase() === "input")
                            input.type = "text"
                    });
                }
            })
        });
    })


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

    const statisticsNav = document.querySelectorAll('.statistics-nav .nav-link');
    const statisticsBox = document.querySelector('.widget-infobox');
    if(statisticsNav.length && statisticsBox) {
        statisticsNav.forEach(item => item.addEventListener('click', (e) => {
            e.preventDefault();
            statisticsNav.forEach(i => i.classList.remove('active'));
            item.classList.add('active');
            let value = item.dataset.value;
            statisticsBox.setAttribute('data-show', value);
        }))
    }
})();




