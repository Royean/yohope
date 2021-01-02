<?php

/**
 * Created by PhpStorm
 * User: 陈志洪
 * Date: 2020/9/21
 * Time: 3:25 下午
 */

namespace app\api\model;

use think\Model;
use think\Request;

class Certifications extends Model
{
    public function getImageAttr($value)
    {
        return Request::instance()->domain() . $value;
    }
}
