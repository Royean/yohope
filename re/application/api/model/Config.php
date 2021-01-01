<?php
/**
 * Created by PhpStorm
 * User: 陈志洪
 * Date: 2020/1/21
 * Time: 19:32
 */

namespace app\api\model;

use think\Model;

class Config extends Model
{
    // 根据名称获取对应的值
    // 如果传入数组，则循环查询
    public static function getValueByName($name)
    {
        if (is_array($name)) {
            $data = [];
            foreach ($name as $value) {
                $config_info = self::get(['name' => $value]);
                $data[$value] = $config_info['value'];
            }
        } else {
            $config_info = self::get(['name' => $name]);
            $data = $config_info['value'];
        }

        return $data;
    }
}
