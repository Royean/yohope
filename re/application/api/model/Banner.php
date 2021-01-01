<?php

/**
 * Created by PhpStorm
 * User: 陈志洪
 * Date: 2020/9/18
 * Time: 5:46 下午
 */

namespace app\api\model;

use think\Model;
use think\Request;

class Banner extends Model
{
    public function getImageAttr($value)
    {
        return Request::instance()->domain() . $value;
    }
}
