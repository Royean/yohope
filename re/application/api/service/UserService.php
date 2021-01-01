<?php
/**
 * Created by PhpStorm
 * User: 陈志洪
 * Date: 2020/1/21
 * Time: 19:45
 */

namespace app\api\service;

use app\api\controller\Base;
use app\api\library\WeChat\MiniProgram;
use app\api\model\User as UserModel;
use app\lib\exception\ParameterException;
use think\Cache;
use think\Db;
use think\Exception;
use think\Log;
use think\Request;

class UserService extends Base
{
    /**
     * 微信登录
     * @return string|null
     * @throws ParameterException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function wxMiniProgramLogin()
    {
        $data = Request::instance()->post(); // code iv encryptedData 如需手机号登录，则需要传递 iv 和 encryptedData

        $wx_result = (new MiniProgram())->getUserInfoByCode($data['code']); // code 换取 openid 和 session_key
        if (array_key_exists('errcode', $wx_result)) {
            throw new ParameterException(10002, 'code已失效'); # 登陆失败或未登录 微信code失效
        }

        $wx_result = array_merge($wx_result, $data);

        return $this->saveUserInfo($wx_result);
    }

    // 保存用户信息 并生成token
    public function saveUserInfo($wx_result)
    {
        $user_info = UserModel::get(['openid' => $wx_result['openid']]);

        Db::startTrans();
        try {
            // 如果用户不存在则创建用户
            if (!$user_info) {
                $miniProgram = new MiniProgram();
                // 如需手机号登录，则开启下面两行代码，否则注释或删除下面两行代码
                $user_info = $miniProgram->decryptData( // 解密获取手机号
                    $wx_result['session_key'],
                    $wx_result['iv'],
                    $wx_result['encryptedData']
                );
                $phone = $user_info['purePhoneNumber'];

                $data = [
                    'openid' => $wx_result['openid'],
                    'phone' => $phone,
                    'nickname' => $wx_result['nickName'],
                    'gender' => $wx_result['gender'],
                    'avatar_image' => $wx_result['avatarUrl'],
                ];

                $user_info = UserModel::create($data, true); // 新增用户
            } else {
                $data = [
                    'nickname' => $wx_result['nickName'],
                    'gender' => $wx_result['gender'],
                    'avatar_image' => $wx_result['avatarUrl'],
                ];

                # 更新用户信息
                (new UserModel())->save($data, array('openid' => $wx_result['openid']));
                $user_info = UserModel::get(['openid' => $wx_result['openid']]);
            }

            $user_info['session_key'] = $wx_result['session_key']; // 把 session_key 一起存入缓存

            $token = self::getRandChar(32); // 生成32位的 token
            $date = 60 * 60 * 24 * 30; // 单位：秒 30天
            Cache::set($token, $user_info, $date); // 写入缓存

            Db::commit();
            return $token;
        } catch (Exception $e) {
            Db::rollback();
            throw new ParameterException(10002, $e->getMessage()); # 登陆失败或未登录
        }
    }

    // 随机生成字符串
    public static function getRandChar($length)
    {
        $str = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol) - 1;

        for ($i = 0; $i < $length; $i++) {
            $str .= $strPol[rand(0, $max)];
        }

        return $str;
    }
}
