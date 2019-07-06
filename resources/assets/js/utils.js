window.getUrlVars = function () {
    var vars = [], hash;
    if (window.location.href.indexOf('?') > 0) {
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for (var i = 0; i < hashes.length; i++) {
            hash = hashes[i].split('=');
            vars[decodeURI(hash[0])] = decodeURI(hash[1]);
        }
    }
    return vars;
}

window.to_qs = function (obj) {
    var str = [];
    for (var p in obj)
        if (obj.hasOwnProperty(p) && p !== "") {
            str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
        }
    return str.join("&");
}

window.isTouchDevice = () => {
    return true == ("ontouchstart" in window || window.DocumentTouch && document instanceof DocumentTouch);
}