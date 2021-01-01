define(['jquery', 'lightBox'], function ($, lightBox) {

    var todo = function () {
        $('.product_detail_01').on('click', 'a', function (e) {
            e.preventDefault();
            $(this).lightBox();
            return false;
        })

        $("#payment img").click(function () {
            var mp4 = $(this).parent().attr('href');
            if (mp4) {
                if (mp4.indexOf(".mp4") > 0) {
                    openvideo(mp4);
                    return false;
                } else if (mp4.indexOf("jpg") > 0 || mp4.indexOf("png") > 0 || mp4.indexOf("gif") > 0) {
                    $('#payment a').has('img').not(".pdf").lightBox();
                } else {
                    return;
                }
            }
        });
        $("#payment1 img").click(function () {
            var mp4 = $(this).parent().attr('href');
            if (mp4) {
                if (mp4.indexOf(".mp4") > 0) {
                    openvideo(mp4);
                    return false;
                } else if (mp4.indexOf("jpg") > 0 || mp4.indexOf("png") > 0 || mp4.indexOf("gif") > 0) {
                    $('#payment a').has('img').not(".pdf").lightBox();
                } else {
                    return;
                }
            }
        });
        $("#payment span").click(function () {
            var mp4 = $(this).parent().attr('href');
            if (mp4) {
                if (mp4.indexOf(".mp4") > 0) {
                    openvideo(mp4);
                    return false;
                } else if (mp4.indexOf("jpg") > 0 || mp4.indexOf("png") > 0 || mp4.indexOf("gif") > 0) {
                    $('#payment a').lightBox();
                } else {
                    return;
                }
            }
        });

        $(".pro_detail img").click(function () {
            var mp4 = $(this).parent().attr('href');
            if (mp4) {
                if (mp4.indexOf(".mp4") > 0) {
                    openvideo(mp4);
                    return false;
                } else {
                    $('#payment a').has('img').not(".pdf").lightBox();
                }
            }
        });

        function openvideo(url) {
            //iframe窗
            layer.open({
                type: 2,
                title: '&nbsp;',
                shadeClose: true,
                shade: 0.8,
                area: ['800px', '600px'],
                maxmin: true,
                content: url //iframe的url
            });
        };



    };
    return {
        todo: todo
    };




});