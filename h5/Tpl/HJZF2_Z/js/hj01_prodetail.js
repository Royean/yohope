require(['jquery', 'lightBox', 'swiper'], function ($, lightBox, Swiper) {    
    $('#gallery  img').click(function (i) {
        $("#model_wind").css({"opacity":"1","zIndex":"99","visibility":"visible"});
    });
    var index = null;
    $('#gallery .swiper-slide').click(function () {
        index = $(this).index();
        var model_swiper = new Swiper('.model_wind_swiper', {
            navigation: {
                nextEl: '.swiper-button-next-model',
                prevEl: '.swiper-button-prev-model',
            },
            pagination: {
                el: '.swiper-pagination_model',
                type: 'fraction'
            },
            autoHeight: true,
            on: {
                init: function () {
                    this.slideTo(index, 10, false);
                }
            }
        });
    })
    

    /*产品详情页360展示窗口，产品展示窗口*/
    $("#model_wind").click(function (event) {
        $(this).css({"opacity":"0","zIndex":"-1","visibility":"hidden"});
        event.stopPropagation();
    }); 
    $(".model_wind_box").click(function (event) {
        event.stopPropagation();
    });
    $(".vr_show").click(function(){
        $(".vr_window").css({"opacity":"1","zIndex":"99","visibility":"visible"});
    });
    $(".vidoe_close").click(function(){
        $(".vr_window").css({"opacity":"0","zIndex":"-1","visibility":"hidden"});
    });
    var galleryThumbs = new Swiper('.detail-gallery-thumbs', {
        spaceBetween: 10,
        slidesPerView: 4,
        navigation: {
            nextEl: '.swiper-button-next-detail',
            prevEl: '.swiper-button-prev-detail',
        },
        freeMode: true,
        watchSlidesVisibility: true,
        watchSlidesProgress: true,
    });
    var galleryTop = new Swiper('.detail-gallery-top', {
        spaceBetween: 10,
        thumbs: {
            swiper: galleryThumbs
        }
    });
    var evt = "onorientationchange" in window ? "orientationchange" : "resize";
    window.addEventListener(evt, resize, false);
    function resize(fals) {
        if ($(".detail-gallery-top").length > 0) {
            galleryTop.update();
        }
    };
    resize(true);
    /*第二套内页详情大小图切换*/
    var galleryThumbs2 = new Swiper('.detail-gallery-thumbs2', {
        direction : 'vertical',
        spaceBetween: 10,
        slidesPerView: 3,
        navigation: {
            nextEl: '.swiper-button-next-detail',
            prevEl: '.swiper-button-prev-detail',
        },
        freeMode: true,
        watchSlidesVisibility: true,
        watchSlidesProgress: true,
    });
    if($(window).width()<576 && $(".detail-gallery-thumbs2").length>0){
        galleryThumbs2.changeDirection();
    }
    var galleryTop2 = new Swiper('.detail-gallery-top2', {
        spaceBetween: 10,
        thumbs: {
            swiper: galleryThumbs2
        }
    });
    /*第三套内页详情大小图切换*/
    var galleryThumbs3 = new Swiper('.detail-gallery-thumbs3', {
        spaceBetween: 16,
        slidesPerView: 5,
        navigation: {
            nextEl: '.swiper-button-next-detail',
            prevEl: '.swiper-button-prev-detail',
        },
        freeMode: true,
        watchSlidesVisibility: true,
        watchSlidesProgress: true,
    });
    var galleryTop3 = new Swiper('.detail-gallery-top3', {
        thumbs: {
            swiper: galleryThumbs3
        }
    });
    /*第三套详情页其他产品滚动展示*/
    var otherswiper = new Swiper('.inner_3__prodetail__otherswiper', {
        slidesPerView: 4,
        spaceBetween: 30,
        navigation: {
            nextEl: '.inner_3__prodetail__next',
            prevEl: '.inner_3__prodetail__prev',
        },
        breakpoints: {
            640: {
                slidesPerView: 1,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
        },
    });
});
/*表格超出滚动条显示*/
$(".pro_detail table").wrap("<div style='overflow-x: auto;width: 100%'></div>");
function jumpto() {
    $('html,body').animate({scrollTop: $('#inquiry').offset().top}, 1000);
    return false
};
function show(i) {
    switch (i) {
        case 1:
        document.getElementById("gx1").style.display = "block";
        document.getElementById("gx2").style.display = "none";
        document.getElementById("pro1").className = "d_1";
        document.getElementById("pro2").className = "d_2";
        break;
        case 2:
        document.getElementById("gx1").style.display = "none";
        document.getElementById("gx2").style.display = "block";
        document.getElementById("pro1").className = "d_2";
        document.getElementById("pro2").className = "d_1";
        break
    }
};
$(function () {
    $('#gx1 > table').addClass('s')
});
if($(".tabsTitle").length>0){
    $(".tabsTitle").on('click', function () {
        $(".tabsTitle").removeClass("active");
        $(this).addClass("active");
        var index = $(this).attr("index");
        $(".pro_detail").hide();
        $(".pro_detail").eq(index - 1).show().addClass("fadeInUp").siblings(".pro_detail").hide().removeClass("fadeInUp")
    });
}



