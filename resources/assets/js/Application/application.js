require("./toggleFullScreen");
require("./preloader");
require("./sidebarMenu");
require('./scrollTop');
require('./detectIE');
require('./printing');
require('./extra');

let shistory = document.querySelector(".shipment-history")
if (shistory) shistory.scrollTo(0, 0);

let deliveryReasons = document.querySelectorAll('.delivery-reasons input[type=radio]');
if(deliveryReasons.length) {
    deliveryReasons.forEach(item => {
        item.addEventListener('change', () => {
            if(item.checked) {
                let step2 = document.querySelector('.delivery-failed-form .step-2');
                step2.querySelector('.message').textContent = item.dataset.message;
                step2.style.display = "block";
            }
        });
    });
}
