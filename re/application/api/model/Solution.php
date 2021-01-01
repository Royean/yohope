<?php

/**
 * Created by PhpStorm
 * User: 陈志洪
 * Date: 2020/9/21
 * Time: 9:44 上午
 */

namespace app\api\model;

use think\Model;

class Solution extends Model
{
    /**
     * 获取标题列表
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author: Chen Zhihong
     * @since: 2020/9/21
     */
    public static function getTitleList()
    {
        return self::order('weigh desc')->field('solution_id, title')->select();
    }

    public function getContentAttr($value)
    {
        return base64_decode(urldecode($value));
    }
}
