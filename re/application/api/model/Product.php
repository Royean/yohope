<?php

/**
 * Created by PhpStorm
 * User: 陈志洪
 * Date: 2020/9/21
 * Time: 4:14 下午
 */

namespace app\api\model;

use think\Model;
use think\Request;

class Product extends Model
{
    protected $append = [
        'image'
    ];

    public function getImagesAttr($value)
    {
        $data = explode(',', $value);
        $url = Request::instance()->domain();

        foreach ($data as &$item) {
            $item = $url . $item;
        }

        return $data;
    }

    public function getImageAttr($value, $data)
    {
        $data = explode(',', $data['images']);

        return Request::instance()->domain() . $data[0];
    }
}
