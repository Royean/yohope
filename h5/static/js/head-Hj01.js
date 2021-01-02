require(['jquery', 'swiper'], function ($, Swiper) {

    /*绉诲姩绔鑸爮*/
    $(".dt-mobile-menu-icon").click(function () {
        $(".mobile-sticky-header-overlay").toggleClass("active");
    });
    /* 鎵嬫満渚ц竟瀵艰埅灞傜偣鍑婚樆姝㈠啋娉?*/
    $("#mobile-menu-Sidebar").click(function (event) {
        event.stopPropagation();
    });
    $(".mobile-menu-Sidebar-close").click(function () {
        $(".mobile-sticky-header-overlay").toggleClass("active");

    });
    $(".next-level-button").click(function () {
        $(this).toggleClass("active");
        $(this).next(".hj_navbar_nav_dropdown-menu").slideToggle();
    });
    /* 闃村奖灞傜偣鍑?*/
    $(".mobile-sticky-header-overlay").click(function (event) {
        $(".mobile-sticky-header-overlay").removeClass("active");
        event.stopPropagation();
    });
    /*绉诲姩绔悳绱㈡*/
    $(".mobile_searchbutton").click(function () {
        $(".mobile_search_content ").toggleClass("active");
        $(".mobile-sticky-header-overlay").removeClass("active");
    });
    $(".mobile_search_close").click(function () {
        $(".mobile_search_content ").toggleClass("active");
    });
    /*绉诲姩绔瑷€鐗堟湰鍒囨崲*/
    $(".mobile_languagebutton").click(function () {
        $(this).toggleClass("active");
        $(".mobile_languagelist").toggleClass("active");
    });




    var offsetTop_head = $(".HJZF2__header-HJ01").height();
    $(window).scroll(function () {
        if ($(window).width() > 992) {
            if ($(document).scrollTop() > offsetTop_head) {
                $(".HJZF2__header_scroll").css({
                    'position': 'fixed'
                }).addClass("active");
            } else {
                $(".HJZF2__header_scroll").css({
                    'position': 'absolute'
                }).removeClass("active");
            }

        }

    });
    $('.seach_click').click(function () {
        $('.pc_search').toggleClass('active');
    });

    if (typeof lan_str != "undefined" && lan_str != '') {
        var ul = document.getElementById("lang_ul");
        var lang_ul_mobile = document.getElementById("lang_ul_mobile");
        var _url = window.location.href;
        _url = _url.toLowerCase();
        var arry = [];
        var arry_two = [];
        arry = lan_str.split('<br>');

        for (i = 0; i < arry.length; i++) {
            var country_src = arry[i].substring(arry[i].indexOf("锛?) + 1, arry[i].length);
            var country_name = arry[i].substring(0, arry[i].indexOf("锛?));
            var li = document.createElement("li");
            li.className += country_name;

            li.setAttribute('data-count', country_name);
            li.innerHTML = "<a href=" + country_src + " target='_blank'>" + country_name + "</a>";
            if ($(".language_ul").length > 0) {
                $(".language_ul").append(li);
            }
        }
    } else {
        $(".language_ul").hide();
        return false;
    };


});