if (window.NodeList && !NodeList.prototype.forEach) {
    window.NodeList.prototype.forEach = Array.prototype.forEach;
}