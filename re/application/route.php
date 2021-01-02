<?php

// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;

// 默认路径  http://localhost/api/...
// 如：http://localhost/api/login  微信小程序登录接口
// ⚠️注意：如果有多端，则需要在Api的基础上加入相应的分组(group)  如手机端 mobile，网页 h5等

Route::group('', function () {
    Route::group('api', function () {
        Route::post('login', 'api/Login/wxMiniProgramLogin'); // 微信小程序登录
        Route::get('login_gzh', 'api/Login/wxOfficialAccountLogin'); // 微信公众号登录
        Route::any('oauth_callback', 'api/Login/oauthCallback'); // 微信公众号登录回调

        // 支付相关接口
        Route::group('pay', function () {
            Route::post('', 'api/Pay/pay'); // 微信支付 统一下单
            Route::any('response', 'api/Pay/response'); // 微信支付回调
        });

        Route::get('index', 'api/Index/getIndex'); # 首页
        Route::get('company_profile', 'api/Index/getCompanyProfile'); # 公司简介
        Route::get('solution', 'api/Index/getSolution'); # 销售网络

        Route::group('news', function () {
            Route::get('list', 'api/Index/getNewsList'); # 新闻列表
            Route::get('content', 'api/Index/getNewsContent'); # 新闻详情
        });

        Route::get('plant_facilities', 'api/Index/getPlantFacilities'); # 厂房设备
        Route::get('certifications', 'api/Index/getCertifications'); # 资质证书

        Route::group('product', function () {
            Route::get('category', 'api/Index/getProductCategoryList'); # 产品分类列表
            Route::get('', 'api/Index/getProduct'); # 产品列表
            Route::get('details/:id', 'api/Index/getProductDetails'); # 产品详情
        });

        Route::get('contact_us', 'api/Index/getContactUs'); # 联系我们

        Route::post('advisory', 'api/Index/createAdvisory'); # 新增咨询
    });
});
