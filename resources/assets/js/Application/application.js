require("./toggleFullScreen");
require("./preloader");
require("./sidebarMenu");
require('./scrollTop');
require('./detectIE');
require('./printing');
require('./extra');

let shistory = document.querySelector(".shipment-history")
if (shistory) shistory.scrollTo(0, 0);
