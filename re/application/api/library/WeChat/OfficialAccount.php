<?php
/**
 * Created by PhpStorm
 * User: 陈志洪
 * Date: 2020/2/11
 * Time: 22:57
 */

namespace app\api\library\WeChat;

use app\api\model\Config as ConfigModel;
use app\api\service\UserService;
use EasyWeChat\Factory;
use think\Env;
use think\Session;

/*
 * 公众号相关
 */
class OfficialAccount
{
    private $app; // 公众号实例

    private $oauth;

    public function __construct()
    {
        $config = [
            'app_id' => ConfigModel::getValueByName('appid'),
            'secret' => ConfigModel::getValueByName('secret'),

            // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
            'response_type' => 'array',

            'oauth' => [
                'scopes' => ['snsapi_userinfo'], // 授权类型
                'callback' => '/api/oauth_callback', // 指定微信回调地址，该定义可在route.php修改地址名称
            ],
        ];

        $this->app = Factory::officialAccount($config);

        $this->oauth = $this->app->oauth;
    }

    // 授权登录
    public function authorizedLogin()
    {
        // 未登录
        if (!Session::get('wechat_user')) {
            return $this->oauth->scopes(['snsapi_userinfo'])->redirect()->send();
        }

        // 已经登录过
        $user_info = Session::get('wechat_user');

        // 写登录成功后的业务代码  自行根据业务补全
        $token = (new UserService())->saveUserInfo($user_info['original']); // 保存用户信息生成token
        // 写登录成功后的业务代码  自行根据业务补全

        $url = Env::get('wechat.success_url'); // 成功后返回的地址
        header('Location: ' . $url . '?token=' . $token); // 重定向，登录成功返回到前端指定页面，并返回token给前端保存
        exit();
    }

    // 微信授权登录回调
    /*
     * user_info获取的用户数据
     * 'id' => 'oHINx5u3cD_TF3wBPsnUJriR123', // openid
     * 'name' => '🧊1',
     * 'nickname' => '🧊1',
     * 'avatar' => 'http://thirdwx.qlogo.cn/mmopen/vi_32/r0PSstibm4Q4UiaKce0b7tiacibYxVk1BF7UePQKVjnYVp0LpXYB9DUFMpm2ibJjgJNNchmiaPw2fibYRKtEwU8eZ1u9A/132',
     * 'email' => NULL,
     * 'original' =>
     * array (
     *      'openid' => 'oHINx5u3cD_TF3wBPsnUJriR123',
     *      'nickname' => '🧊1',
     *      'sex' => 1, // 值为1时是男性，值为2时是女性，值为0时是未知
     *      'language' => 'zh_CN',
     *      'city' => '梅州', // 普通用户个人资料填写的城市
     *      'province' => '广东', // 用户个人资料填写的省份
     *      'country' => '中国', // 国家
     *      // 用户头像
     *      'headimgurl' => 'http://thirdwx.qlogo.cn/mmopen/vi_32/r0PSstibm4Q4UiaKce0b7tiacibYxVk1BF7UePQKVjnYVp0LpXYB9DUFMpm2ibJjgJNNchmiaPw2fibYRKtEwU8eZ1u9A/132',
     *      'privilege' => // 用户特权信息，json 数组，如微信沃卡用户为（chinaunicom）
     *      array (
     *      ),
     * ),
     * 'token' => '30_NmJCwz-0cTtCr3Z78xoo8OMg_kNjDtxDZLWBzLDhFOc0nO3qTGy_fmZrVUBxpLbsRdk8XMF1n0OCosIKR8u1bQ',
     * 'provider' => 'WeChat',
     */
    public function callback()
    {
        $user_info = $this->oauth->user()->toArray(); // 获取用户信息
        Session::set('wechat_user', $user_info); // 将用户信息存入缓存
        return $user_info;
    }
}
