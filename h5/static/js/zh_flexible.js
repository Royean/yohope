(function() {
    var designW1 = 1920;
    var font_rate = 100;
    var designW2 = 375;
    if (document.documentElement.clientWidth >= 768) {
        document.getElementsByTagName("html")[0].style.fontSize = (document.documentElement.clientWidth) / designW1 * font_rate + "px";
        window.addEventListener("onorientationchange" in window ? "orientationchange": "resize",
        function() {
            document.getElementsByTagName("html")[0].style.fontSize = (document.documentElement.clientWidth) / designW1 * font_rate + "px"
        },
        false)
    } else {
        document.getElementsByTagName("html")[0].style.fontSize = (document.documentElement.clientWidth) / designW2 * font_rate + "px";
        window.addEventListener("onorientationchange" in window ? "orientationchange": "resize",
        function() {
            document.getElementsByTagName("html")[0].style.fontSize = (document.documentElement.clientWidth) / designW2 * font_rate + "px"
        },
        false)
    }
})();