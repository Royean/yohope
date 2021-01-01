<?php

/**
 * Created by PhpStorm
 * User: 陈志洪
 * Date: 2020/9/21
 * Time: 4:05 下午
 */

namespace app\api\model;

use think\Model;
use think\Request;

class ProductCategory extends Model
{
    public function getImageAttr($value)
    {
        return Request::instance()->domain() . $value;
    }
}
