<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use think\Request;

class Index extends Frontend
{

    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';
    protected $layout = '';

    public function index()
    {
        # return $this->view->fetch();

        $this->redirect(Request::instance()->domain(). '/01snt.php');
    }

}
