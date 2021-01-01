<?php

namespace app\admin\controller;

use app\common\controller\Backend;

/**
 * 产品管理
 *
 * @icon fa fa-circle-o
 */
class Product extends Backend
{
    
    /**
     * Product模型对象
     * @var \app\admin\model\Product
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Product;
        $this->view->assign("isHotList", $this->model->getIsHotList());
    }
    
    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */

    public function checkIsHot($ids, $isHot)
    {
        # 更新条件，字符转整型
        $where['product_id'] = $ids;
        $isHot = intval($isHot);

        # 如果设置为热门，则检测是否有超过4个
        if ($isHot == 0) {
            $number = $this->model->where(array('is_hot' => 1))->count();
            if ($number >= 4) {
                $this->error('热门产品不能超过4个！');
            }
        }

        # 更新上架状态
        $this->model->save([
            'is_hot' => $isHot ? 0 : 1,
        ], $where);

        $this->success('设置成功！');
    }
}
