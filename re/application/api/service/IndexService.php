<?php

/**
 * Created by PhpStorm
 * User: 陈志洪
 * Date: 2020/9/18
 * Time: 5:46 下午
 */

namespace app\api\service;

use app\api\model\Banner;
use app\api\model\News as NewsModel;
use app\api\model\Config as ConfigModel;
use app\api\model\Product as ProductModel;
use app\api\model\Solution as SolutionModel;
use app\api\model\Advisory as AdvisoryModel;
use app\api\model\PlantFacilities as PlantFacilitiesModel;
use app\api\model\Certifications as CertificationsModel;
use app\api\model\ProductCategory as ProductCategoryModel;
use think\Db;
use think\Request;

class IndexService
{
    /**
     * 首页接口
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author: Chen Zhihong
     * @since: 2020/9/22
     */
    public static function getIndex()
    {
        # 轮播图
        $banner = (new Banner())->field('banner_id,image,genre,news_id')->order('weigh desc')->select();
        # footer
        $footer  = self::getFooter();
        # 右边数据
        $right = self::getRight();
        # header
        $header = self::getHeader();
        # 新闻
        $news = self::getNews();
        # 介绍
        $introduce = self::getIntroduce();
        # 产品
        $product = self::getHotProduct();

        return compact('banner', 'footer', 'right', 'header', 'news', 'introduce', 'product');
    }

    /**
     * 产品分类列表
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author: Chen Zhihong
     * @since: 2020/9/21
     */
    public static function getProductCategoryList()
    {
        $data['list'] = (new ProductCategoryModel())
            ->order('weigh desc')
            ->field('product_category_id,title,image')
            ->select();

        $data['header'] = self::getHeader();
        $data['footer'] = self::getFooter();
        $data['right'] = self::getRight();

        return $data;
    }

    /**
     * 产品分类
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author: Chen Zhihong
     * @since: 2020/9/21
     */
    public static function getHotProduct()
    {
        $data = (new ProductModel())
            ->where(array('is_hot' => 1))
            ->field('product_id,title,images')
            ->limit(4)
            ->select();

        if ($data) {
            foreach ($data as $key => &$value) {
                $value['image'] = $value['images'][0];
            }
        }

        return $data;
    }


    /**
     * 介绍
     * @return array
     * @since: 2020/9/21
     * @author: Chen Zhihong
     */
    public static function getIntroduce()
    {
        return array(
            'title' => ConfigModel::getValueByName('introduce_title'),
            'content' => ConfigModel::getValueByName('introduce_content'),
            'text1' => ConfigModel::getValueByName('introduce_text1'),
            'text2' => ConfigModel::getValueByName('introduce_text2'),
            'text3' => ConfigModel::getValueByName('introduce_text3'),
            'num1' => ConfigModel::getValueByName('introduce_num1'),
            'num2' => ConfigModel::getValueByName('introduce_num2'),
            'num3' => ConfigModel::getValueByName('introduce_num3'),
        );
    }

    /**
     * 首页新闻 只获取10个
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author: Chen Zhihong
     * @since: 2020/9/21
     */
    public static function getNews()
    {
        $data = (new NewsModel())
            ->field('news_id,image,title,number,create_time,status')
            ->order('create_time desc')
            ->limit(10)
            ->select();

        foreach ($data as &$value) {
            $value['create_time'] = date('Y-m-d', $value['create_time']);
            $value['status_text'] = $value['status'] == 0
                ? '新闻中心'
                : '行业动态';
        }

        return $data;
    }

    /**
     * 公司简介
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author: Chen Zhihong
     * @since: 2020/9/21
     */
    public static function getCompanyProfile()
    {
        return array(
            'text' => '公司简介',
            'content' => ConfigModel::getValueByName('company_profile'),
            'footer' => self::getFooter(),
            'header' => self::getHeader(),
            'right' => self::getRight(),
        );
    }

    /**
     * 销售网络
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author: Chen Zhihong
     * @since: 2020/9/21
     */
    public static function getSolution()
    {
        $list = SolutionModel::getTitleList();

        # 获取销售网络ID
        $solutionId = Request::instance()->get('solution_id', '');

        if ($list) {
            if (!$solutionId) {
                $solutionId = $list[0]['solution_id'];
            }

            foreach ($list as &$value) {
                $value['solution_id'] != $solutionId
                    ? $value['is_check'] = 0
                    : $value['is_check'] = 1;
            }
        }

        $data = (new SolutionModel())
            ->where(array('solution_id' => $solutionId))
            ->field('solution_id,title,content')
            ->find();

        $data['list'] = $list;
        $data['header'] = self::getHeader();
        $data['footer'] = self::getFooter();
        $data['right'] = self::getRight();

        return $data;
    }

    /**
     * 新闻列表
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author: Chen Zhihong
     * @since: 2020/9/21
     */
    public static function getNewsList()
    {
        $status = Request::instance()->get('status', '');
        $status
            ? $where['status'] = $status
            : $where = [];

        $list = (new NewsModel())
            ->where($where)
            ->field('news_id,image,title,number,create_time,status')
            ->order('create_time desc')
            ->select();

        if ($list) {
            foreach ($list as &$value) {
                $value['create_time'] = date('m月d', $value['create_time']);
            }
        }

        $data['list'] = $list;
        $data['header'] = self::getHeader();
        $data['footer'] = self::getFooter();
        $data['right'] = self::getRight();

        return $data;
    }

    /**
     * 新闻详情
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author: Chen Zhihong
     * @since: 2020/9/21
     */
    public static function getNewsContent()
    {
        $newsId = Request::instance()->get('news_id');
        $where['news_id'] = $newsId;

        # 新增浏览量
        (new NewsModel())->save(array('number' => Db::raw('number+1')), $where);

        $data = (new NewsModel())
            ->where($where)
            ->field('news_id,image,title,number,create_time,status,content')
            ->find();

        $data['create_time'] = date('Y年m月d日', $data['create_time']);
        $data['header'] = self::getHeader();
        $data['footer'] = self::getFooter();
        $data['right'] = self::getRight();

        return $data;
    }

    /**
     * 厂房设备
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author: Chen Zhihong
     * @since: 2020/9/21
     */
    public static function getPlantFacilities()
    {
        $data['list'] = (new PlantFacilitiesModel())
            ->order('weigh desc')
            ->field('plant_facilities_id,title,image')
            ->select();

        $data['header'] = self::getHeader();
        $data['footer'] = self::getFooter();
        $data['right'] = self::getRight();

        return $data;
    }

    /**
     * 资质证书
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author: Chen Zhihong
     * @since: 2020/9/21
     */
    public static function getCertifications()
    {
        $data['list'] = (new CertificationsModel())
            ->order('weigh desc')
            ->field('certifications_id,image')
            ->select();

        $data['header'] = self::getHeader();
        $data['footer'] = self::getFooter();
        $data['right'] = self::getRight();

        return $data;
    }

    /**
     * 获取导航栏信息
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author: Chen Zhihong
     * @since: 2020/9/21
     */
    public static function getHeader()
    {
        return array(
            'solution' => SolutionModel::getTitleList(), # 解决方案
            'product' => self::getProductCategoryTextList(), # 获取产品分类
        );
    }

    /**
     * 获取产品分类
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author: Chen Zhihong
     * @since: 2020/9/21
     */
    public static function getProductCategoryTextList()
    {
        return (new ProductCategoryModel())
            ->order('weigh desc')
            ->field('product_category_id,title')
            ->select();
    }

    /**
     * 获取底部数据
     * @return array
     * @since: 2020/9/20
     * @author: Chen Zhihong
     */
    public static function getFooter()
    {
        return array(
            'contact_person' => ConfigModel::getValueByName('contact_person'), # 联系人
            'phone1' => ConfigModel::getValueByName('phone1'), # 电话1
            'phone2' => ConfigModel::getValueByName('phone2'), # 电话2
            'email' => ConfigModel::getValueByName('email'), # 邮箱
            'address' => ConfigModel::getValueByName('address'), # 地址
            'case_number' => ConfigModel::getValueByName('case_number'), # 备案号
            'company_name' => ConfigModel::getValueByName('company_name'), # 公司名称
        );
    }

    /**
     * 获取右边数据
     * @return array
     * @since: 2020/9/20
     * @author: Chen Zhihong
     */
    public static function getRight()
    {
        return array(
            'phone1' => ConfigModel::getValueByName('phone1'), # 电话1
            'phone2' => ConfigModel::getValueByName('phone2'), # 电话2
            'email' => ConfigModel::getValueByName('email'), # 邮箱
            'qr_code' => Request::instance()->domain() . ConfigModel::getValueByName('qr_code'), # 微信二维码
            'qq_number' => ConfigModel::getValueByName('qq_number'), # QQ号码
        );
    }

    /**
     * 产品列表
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author: Chen Zhihong
     * @since: 2020/9/21
     */
    public static function getProduct()
    {
        # 产品分类ID
        $productCategoryId = Request::instance()->get('product_category_id', '');
        $title = Request::instance()->get('title', '');

        $text = '全部产品';
        $where = [];
        if ($productCategoryId) {
            $where['product_category_id'] = $productCategoryId;
            $text = (new ProductCategoryModel())->where($where)->value('title');
            $text = $text ? $text : '全部产品';
        }
        if ($title) {
            $where = ['title' => ['like', $title . '%']];
        }

        $data['list'] = (new ProductModel())
            ->where($where)
            ->field('product_id,title,images')
            ->select();

        $data['header'] = self::getHeader();
        $data['footer'] = self::getFooter();
        $data['right'] = self::getRight();

        $data['text'] = $text;

        return $data;
    }

    /**
     * 产品详情
     * @param $id int 产品ID
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @since: 2020/9/21
     * @author: Chen Zhihong
     */
    public static function getProductDetails($id)
    {
        $data = (new ProductModel())
            ->where(array('product_id' => $id))
            ->find();

        $data['header'] = self::getHeader();
        $data['footer'] = self::getFooter();
        $data['right'] = self::getRight();

        return $data;
    }

    /**
     * 联系我们
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author: Chen Zhihong
     * @since: 2020/9/21
     */
    public static function getContactUs()
    {
        $data = array(
            'image' => Request::instance()->domain() . ConfigModel::getValueByName('image'),
            'contact_title' => ConfigModel::getValueByName('contact_title'),
            'contact_address' => ConfigModel::getValueByName('contact_address'),
            'contact_web_url' => ConfigModel::getValueByName('contact_web_url'),
            'contact_phone' => ConfigModel::getValueByName('contact_phone'),
            'contact_email' => ConfigModel::getValueByName('contact_email'),
        );

        $data['header'] = self::getHeader();
        $data['footer'] = self::getFooter();
        $data['right'] = self::getRight();

        return $data;
    }

    /**
     * 新增咨询
     * @return AdvisoryModel
     * @since: 2020/9/21
     * @author: Chen Zhihong
     */
    public static function createAdvisory()
    {
        $data = Request::instance()->post();

        return AdvisoryModel::create($data, true);
    }
}
