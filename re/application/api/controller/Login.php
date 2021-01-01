<?php
/**
 * Created by PhpStorm
 * User: 陈志洪
 * Date: 2020/1/21
 * Time: 20:12
 */

namespace app\api\controller;

use app\api\library\WeChat\OfficialAccount;
use app\api\service\UserService;
use think\Env;
use think\Exception;
use think\Log;
use think\Request;

class Login extends Base
{
    /**
     * 微信小程序登录
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \app\lib\exception\ParameterException
     */
    public function wxMiniProgramLogin()
    {
        # 校验参数
        $data = Request::instance()->post();
        parent::validate($data, 'LoginValidate');

        # 微信登录
        $token = (new UserService())->wxMiniProgramLogin();

        parent::success('success', ['token' => $token], 200);
    }

    /**
     * 公众号登录
     */
    public function wxOfficialAccountLogin()
    {
        try {
            (new OfficialAccount())->authorizedLogin();
        } catch (Exception $ex) {
            Log::info('[error] 登录失败 ' . date('Y-m-d H:i:s') . '，错误原因：' . $ex->getMessage());
        }
    }

    /**
     * 公众号登录回调
     */
    public function oauthCallback()
    {
        try {
            $user_info = (new OfficialAccount())->callback(); // 获取用户个人信息 具体内容查看callback方法的注释

            // 写登录成功后的业务代码  自行根据业务补全
            $token = (new UserService())->saveUserInfo($user_info['original']); // 保存用户信息生成token
            // 写登录成功后的业务代码  自行根据业务补全

            $url = Env::get('wechat.success_url'); // 成功后返回的地址
            header('Location: ' . $url . '?token=' . $token); // 重定向，登录成功返回到前端指定页面，并返回token给前端保存
            exit();
        } catch (Exception $ex) {
            Log::info('[error] 登录回调失败 ' . date('Y-m-d H:i:s') . '，错误原因：' . $ex->getMessage());
        }
    }
}
