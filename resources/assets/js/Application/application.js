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
                            input.type = input.dataset.type;
                    });
                }
            })
        });
    })


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




