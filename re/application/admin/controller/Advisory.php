<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use think\Request;

/**
 * 咨询管理
 *
 * @icon fa fa-circle-o
 */
class Advisory extends Backend
{
    /**
     * Advisory模型对象
     * @var \app\admin\model\Advisory
     */
    protected $model = null;

    # 搜索
    protected $searchFields = 'advisory_id,name';

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Advisory;
        $this->view->assign("statusList", $this->model->getStatusList());
    }
    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */


    /**
     * 设置切换状态
     * @param $ids string id集
     * @since: 2020/9/14
     * @author: Chen Zhihong
     */
    public function checkStatus($ids)
    {
        $ids = explode(',', $ids);
        $status = Request::instance()->get('status');

        $this->model->save(array('status' => $status), array('advisory_id' => array('in', $ids)));

        $this->success('设置成功');
    }
}
