<?php

/**
 * Created by PhpStorm
 * User: 陈志洪
 * Date: 2020/9/18
 * Time: 5:46 下午
 */

namespace app\api\controller;

use app\api\service\IndexService;
use think\Request;

class Index extends Base
{
    /**
     * 首页接口
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @since: 2020/9/22
     * @author: Chen Zhihong
     */
    public function getIndex()
    {
        $data = IndexService::getIndex();

        $this->success('success', $data);
    }

    /**
     * 公司简介
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @since: 2020/9/21
     * @author: Chen Zhihong
     */
    public function getCompanyProfile()
    {
        $data = IndexService::getCompanyProfile();

        $this->success('success', $data);
    }

    /**
     * 销售网络
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @since: 2020/9/21
     * @author: Chen Zhihong
     */
    public function getSolution()
    {
        $data = IndexService::getSolution();

        $this->success('success', $data);
    }

    /**
     * 新闻列表
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @since: 2020/9/21
     * @author: Chen Zhihong
     */
    public function getNewsList()
    {
        $data = IndexService::getNewsList();

        $this->success('success', $data);
    }

    /**
     * 新闻详情
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @since: 2020/9/21
     * @author: Chen Zhihong
     */
    public function getNewsContent()
    {
        $data = IndexService::getNewsContent();

        $this->success('success', $data);

    }

    /**
     * 厂房设备
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @since: 2020/9/21
     * @author: Chen Zhihong
     */
    public function getPlantFacilities()
    {
        $data = IndexService::getPlantFacilities();

        $this->success('success', $data);
    }

    /**
     * 资质证书
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @since: 2020/9/21
     * @author: Chen Zhihong
     */
    public function getCertifications()
    {
        $data = IndexService::getCertifications();

        $this->success('success', $data);
    }

    /**
     * 产品分类列表
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @since: 2020/9/21
     * @author: Chen Zhihong
     */
    public function getProductCategoryList()
    {
        $data = IndexService::getProductCategoryList();

        $this->success('success', $data);
    }

    /**
     * 产品列表
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @since: 2020/9/21
     * @author: Chen Zhihong
     */
    public function getProduct()
    {
        $data = IndexService::getProduct();

        $this->success('success', $data);
    }

    /**
     * 产品详情
     * @param $id int 产品ID
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author: Chen Zhihong
     * @since: 2020/9/21
     */
    public function getProductDetails($id)
    {
        $data = IndexService::getProductDetails($id);

        $this->success('success', $data);
    }

    /**
     * 联系我们
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @since: 2020/9/21
     * @author: Chen Zhihong
     */
    public function getContactUs()
    {
        $data = IndexService::getContactUs();

        $this->success('success', $data);
    }

    /**
     * 新增咨询
     * @author: Chen Zhihong
     * @since: 2020/9/21
     */
    public function createAdvisory()
    {
        $data = Request::instance()->post();
        parent::validate($data,'AdvisoryValidate');

        IndexService::createAdvisory();

        $this->success('success');
    }
}
