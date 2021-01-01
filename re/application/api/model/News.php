<?php

/**
 * Created by PhpStorm
 * User: 陈志洪
 * Date: 2020/9/21
 * Time: 10:30 上午
 */

namespace app\api\model;

use think\Model;
use think\Request;

class News extends Model
{
    public function getContentAttr($value)
    {
        return base64_decode(urldecode($value));
    }

    public function getImageAttr($value)
    {
        return Request::instance()->domain() . $value;
    }
}
