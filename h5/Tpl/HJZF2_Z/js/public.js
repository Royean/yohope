/*search form*/
function CheckForm(theForm) {
    if (theForm.keywords.value == "Product Search") {
        alert('Please enter the keywords');
        theForm.keywords.focus();
        return false;
    } else if (theForm.keywords.value == "产品搜索") {
        alert('请输入关键字');
        theForm.keywords.focus();
        return false
    } else if (theForm.keywords.value == "keyword") {
        alert('Please enter the keywords');
        theForm.keywords.focus();
        return false;
    } else if (theForm.keywords.value == '') {
        alert('Please enter the keywords');
        theForm.keywords.focus();
        return false;
    } else if (theForm.keywords.value == 'ключевые слова') {
        alert('Введите ключевое слово');
        theForm.keywords.focus();
        return false;
    }


}

function OnFocusFun(element, elementvalue) {
    if (element.value == elementvalue) {
        element.value = "";
        element.style.color = "#292929"
    }
};

function OnBlurFun(element, elementvalue) {
    if (element.value == "" || element.value.replace(/\s/g, "") == "") {
        element.value = elementvalue;
        element.style.color = "#292929"
    }
};

function OnFocusFun_m(element, elementvalue) {
    if (element.value == elementvalue) {
        element.value = "";
        element.style.color = "#fff"
    }
};

function OnBlurFun_m(element, elementvalue) {
    if (element.value == "" || element.value.replace(/\s/g, "") == "") {
        element.value = elementvalue;
        element.style.color = "#fff"
    }
};

$('#keyword').keydown(function () {
    var keyword = $("#keyword").val();
    var errora = $(this).attr('date-empty-error');
    if (event.keyCode == 13) {
        if (keyword.length <= 0) {
            alert(errora);
            return false;
        } else {
            window.location.href = "{:U('/search','','')}?keywords=" + keyword;
        }
    }
});
$('#keyword_m').keydown(function () {
    var keyword = $("#keyword_m").val();
    if (event.keyCode == 13) {
        if (keyword.length <= 0) {
            alert("Please enter the keywords!");
            return false
        } else {
            window.location.href = "{:U('/search','','')}?keywords=" + keyword;
        }
    }
});
$('#keyword_mcn').keydown(function () {
    var keyword = $("#keyword_mcn").val();
    if (event.keyCode == 13) {
        if (keyword.length <= 0) {
            alert("请输入关键字!");
            return false
        } else {
            window.location.href = "{:U('/search','','')}?keywords=" + keyword;
        }
    }
});
$('#keyword1').keydown(function () {
    var keyword = $("#keyword1").val();
    if (event.keyCode == 13) {
        if (keyword.length <= 0) {
            alert("Please enter the keywords!");
            return false
        } else {
            window.location.href = "{:U('/search','','')}?keywords=" + keyword;
        }
    }
});
$('#keyword2').keydown(function () {
    var keyword = $("#keyword2").val();
    if (event.keyCode == 13) {
        if (keyword.length <= 0) {
            alert("请输入关键字!");
            return false
        } else {
            window.location.href = "{:U('/search','','')}?keywords=" + keyword;
        }
    }
});

$(function () {
    var nav = $(".side");
    var win = $(window);
    var sc = $(document);
    win.scroll(function () {
        if (win.width() >= 992) {
            if (sc.scrollTop() >= 450) {
                nav.fadeIn();
            } else {
                nav.fadeOut();
            }
        } else {
            if (sc.scrollTop() >= 150) {

                $(".mobile_sidebar").css({
                    "transform": "scale(1)",
                    "transitionDuration": '1s'
                });
                if (document.referrer == '') {
                    $(".mfb-component__button--back").css({
                        "transform": "scale(0)"
                    });
                }
            } else {
                $(".mobile_sidebar").css({
                    "transform": "scale(0)",
                    "transitionDuration": '1s'
                });
            }
        }
    })
});

function goTop() {
    var dom = $('.hjzf_nav_page li a').eq(0);
    if (dom.length != 0) {
        dom.trigger('click');
    }
    jQuery('html,body').animate({
        'scrollTop': 0
    }, 600);
};

// slidebar 3 灵通侧边栏

jQuery(function () {
    jQuery('.mysidebar_btn').click(function () {
        jQuery('.mysidebar_wrapper').fadeIn();
    })
    $('.mysidebar_wrapper_colse').click(function () {
        $('.mysidebar_wrapper').fadeOut();
        setTemCookie('mysidebar_wrapper', 111);
    })

    getCookie('mysidebar_wrapper');

    // 临时设置cookie，关闭窗口即消失;
    // key 键 val 值
    function setTemCookie(key, val) {
        document.cookie = key + '=' + val;
    }

    function getCookie(name) {
        var cookie = document.cookie;
        if (cookie) {
            var sp = cookie.split(';');
            sp.forEach(function (ele, i) {
                if (ele.match(name)) {
                    $('.' + name).hide();
                }
            })
        }
        return;
    }
})



// slidebar 3 end

$(function () {
    $(".mfb-component__button--main").click(function () {
        if ($(this).parent().hasClass('open')) {
            $(this).parent().removeClass("open");
        } else {
            $(this).parent().addClass("open");
        }
    });
});


(function () {
    var muban1_arr_height = [];
    for (var i = 0; i < $(".main_caseitem").length; i++) {
        var item_height_arr = $('.main_caseitem').eq(i).find('.case_item-title').height();
        muban1_arr_height.push(item_height_arr)
    }
    var max_main_proitem_name = Math.max.apply(null, muban1_arr_height);
    if (max_main_proitem_name > 48) {
        $('.case_item-title').css({
            "height": '48px',
            'overflow': 'hidden'
        });
    } else {
        $('.case_item-title').css("height", max_main_proitem_name);
    }
})();
$('#mianze').on('click', function () {
    layer.open({
        type: 2,
        title: ['免责声明', 'font-size:18px;'],
        area: ['1000px', '770px'],
        shadeClose: true, //点击遮罩关闭

        content: 'https://www.one-all.com/mianze.html'
    });
});
require(['proDetail', 'jquery'], function (proDetail, $) {
    proDetail.todo();

    if ($(window).width() < 768) {
        $("#payment img, #payment1 img").parent("a").click(function () {
            event.preventDefault();
        });
    }
});

require(['jquery'], function ($) {
    $(document).ready(function () {
        if ($(".main_page")) {
            if ($(".main_page").children().length == 0) {
                $(".main_page").hide();
            }
        };
    });
});
require(['jquery', 'swiper'], function ($, Swiper) {
    if ($('.InsidePages_navswiper').length > 0) {
        var leftSwiper = new Swiper('.InsidePages_navswiper', {
            slidesPerView: 'auto',
            spaceBetween: 40,
            navigation: {
                nextEl: '.InsidePages_list-next',
                prevEl: '.InsidePages_list-prev',
            },
            on: {
                init: function (leftSwiper) {
                    if (this.slides.length > 6) {
                        $(".InsidePages_list-next").show();
                        $(".InsidePages_list-prev").show();
                    }
                }
            }
        });
    };
    if ($('.hjzf_innertop_navlist').length > 0) {
        var leftSwiper = new Swiper('.hjzf_innertop_navlist', {
            slidesPerView: 4,
            spaceBetween: 10,
            pagination: {
                el: '.hjzf_innertop_nav_pageation',
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 10,
                },
                992: {
                    slidesPerView: 4,
                    spaceBetween: 10,
                },
            },
            on: {
                init: function (leftSwiper) {
                    /* if(this.slides.length>6){
                         $(".InsidePages_list-next").show();
                         $(".InsidePages_list-prev").show();
                     }*/
                }
            },
            resize: function () {
                leftSwiper.update(true)
            },
        });
    };
});
/*require(['jqueryzoom', 'jquery'], function (jqueryzoom, $) {
 $("#gallery .jqzoom").jqueryzoom({xzoom: 326, yzoom: 241, offset: 10, position: "right"});
});*/
jQuery(function () {
    jQuery('.skype-show').hide();
    jQuery(".skype-container").bind('mouseenter', function () {
        jQuery('.skype-show').show();
    })
    jQuery(".skype-container").bind('mouseleave', function () {
        jQuery('.skype-show').hide();
    });
});
jQuery(function () {
    jQuery('.whatsapp-show').hide();
    jQuery(".whatsapp-container").bind('mouseenter', function () {
        jQuery('.whatsapp-show').show();
    })
    jQuery(".whatsapp-container").bind('mouseleave', function () {
        jQuery('.whatsapp-show').hide();
    });
});
jQuery(function () {
    jQuery('.email-show').hide();
    jQuery(".email-container").bind('mouseenter', function () {
        jQuery('.email-show').show();
    })
    jQuery(".email-container").bind('mouseleave', function () {
        jQuery('.email-show').hide();
    });
});
require(['jquery'], function ($) {
    /*第三套分类内页*/
    $(document).ready(function () {
        $(".inner-3__anchorUl li").click(function () {
            $(this).addClass("active").siblings("li").removeClass("active");
        })
    })
});

// 手机站替换电话链接
require(['jquery'], function ($) {
    // 修改手机站底部 0086-xxxxx号码为xxxxx；
    $(function () {
        $('[href^="tel:"]').each(function () {
            var self = $(this);
            var url = self.attr('href');
            var newUrl = url.replace("-", "");
            self.attr('href', newUrl);
        })
    })

    // btn 到顶部消失
    function hideBtn(top) {
        var side_first_btn = $('.side_first_btn');
        if (top < 500) {
            side_first_btn.fadeOut();
        } else {
            side_first_btn.fadeIn();
        };
    }
    $(window).scroll(function () {
        var top = $(window).scrollTop();
        hideBtn(top);
    });
    var top = $(window).scrollTop();
    hideBtn(top);

});

$(function () {
    function random(max, min) {
        return Math.floor(Math.random() * (max - min) + min);
    };

    function Trims(str) {
        return str.replace(/^\s\s*/, '').replace(/\s\s*$/, '')
    }

    function is_email(str) {
        return (/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/.test(str));
    }
    $('.content_submit div').each(function () {
        var input = $(this).find('input');
        var textrae = $(this).find('textarea');
        input.focus(function () {
            $(this).siblings('span').html('');
        });
        var img = $(this).find('img');
        img.click(function () {
            $(this).attr('src', '/code_char.php?webid=1&time=12345;');
        });

    });

    $('.bottom_submit_content').click(function () {
        var flag = contentsubmit();
        if (!flag) {
            return false;
        }
        return true;
    })

    function contentsubmit() {
        var stra = '';
        $('.content_xp li .info').each(function () {
            var che = $(this).find('input').get(0).checked;
            var info = $(this).find('.info_content');
            if (che) {
                stra += '&' + info.find('strong').text() + '&' + info.find('p').eq(0).text() + '&' + info.find('p').eq(1).text() + '&';
            }
        })
        var count = 0;
        var message = Trims($("#message_con").val());
        var linkname = Trims($("#linkname_con").val());
        var comname = Trims($("#companyname").val());
        var phone = Trims($("#phone_con").val());
        var email = Trims($("#email_con").val());
        var companyname = Trims($("#companyname").val());
        var mesVal = $("#message_con").val();


        if (linkname.length <= 0) {
            $("#linkname_error").html("姓名不能为空！");
            count++;
        } else {
            $("#linkname_error").html("");
        };
        if (companyname.length <= 0) {
            $("#companyname_error").html("公司名称不能为空！");
            count++;
        } else {
            $("#companyname_error").html("");
        };
        var str = /[\u4E00-\u9FA5a-zA-Z]/;
        console.log(str.test(phone));
        if (phone.length <= 0) {
            $("#phone_error").html("*电话不能为空！");
            count++;
        } else if (str.test(phone)) {
            $("#phone_error").html("*电话号码有误！");
            count++;
        } else {
            $("#phone_error").html("");
        }
        if (email.length == 0) {
            count++;
            $("#email_error").html("*邮箱格式错误");
        } else if (email.length > 0 && !is_email(email)) {
            $("#email_error").html("*邮箱格式错误");
            count++;
        } else {
            $("#email_error").html("");
        }
        if (mesVal.length <= 0) {
            $("#message_error").html("咨询内容不能为空！");
            count++;
        } else {
            $('message_error').html("");
        }

        if (count > 0) {
            return false;
        }
        $('#message_con').val(mesVal + stra);
        return true;

    }



    /* 底部二维码点击效果 */
    $('.mobile_down li.qrcode').on('click', function () {
        $(this).find('img').toggle();
    })




});