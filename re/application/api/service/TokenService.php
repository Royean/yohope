<?php
/**
 * Created by PhpStorm
 * User: 陈志洪
 * Date: 2020/1/21
 * Time: 21:59
 */

namespace app\api\service;

use app\lib\exception\ParameterException;
use app\lib\exception\UnAuthorizationException;
use think\Cache;
use think\Request;

class TokenService
{
    // 获取 token
    public static function checkToken()
    {
        $token = Request::instance()->header('token');
        if (!$token) {
            throw new ParameterException(10002); # 登陆失败或未登录
        }

        return self::isOverdue($token);
    }

    // 是否过期或无效
    private static function isOverdue($token)
    {
        $token_info = Cache::get($token);
        if (!$token_info) {
            throw new UnAuthorizationException(10003); # 令牌不合法或者过期
        }

        return $token_info;
    }
}
