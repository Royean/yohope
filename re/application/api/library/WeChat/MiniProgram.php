<?php
/**
 * Created by PhpStorm
 * User: 陈志洪
 * Date: 2020/1/21
 * Time: 19:32
 */

namespace app\api\library\WeChat;

use app\api\controller\Base;
use app\api\model\Config as ConfigModel;
use EasyWeChat\Factory;
use EasyWeChat\Kernel\Http\StreamResponse;
use think\Session;

/*
 * 小程序相关
 */
class MiniProgram
{
    private $app; // 小程序实例

    private $appId; # AppId

    private $secret; # secret

    // 获取小程序实例
    public function __construct()
    {
        $this->appId = ConfigModel::getValueByName('appid');
        $this->secret = ConfigModel::getValueByName('secret');

        $config = [
            'app_id' => $this->appId,
            'secret' => $this->secret,

            // 下面为可选项
            // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
            'response_type' => 'array',
        ];

        $this->app = Factory::miniProgram($config); // 实例话小程序
    }

    /**
     * 根据code 获取用户信息 openid 和 session_key
     * @param $code string code
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function getUserInfoByCode($code)
    {
        return $this->app->auth->session($code);
    }

    /**
     * @param $session string session_key code换取的
     * @param $iv string 前端传递 用于配合解密
     * @param $encryptedData string 前端传递 用于配合解密
     * @return array
     * @throws \EasyWeChat\Kernel\Exceptions\DecryptException
     */
    public function decryptData($session, $iv, $encryptedData)
    {
        return $this->app->encryptor->decryptData($session, $iv, $encryptedData);
    }

    /**
     * 生成带参数的小程序码
     * @param $url string 跳转路径
     * @param $id int 需要存入的参数
     * @return bool|int
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
     */
    public function getMPCode($url, $id)
    {
        $response = $this->app->app_code->getUnlimit('id=' . $id, [
            'page' => $url,
            'width' => 500,
        ]);

        $name = session_create_id();
        if ($response instanceof StreamResponse) {
            return $filename = $response->save(ROOT_PATH . 'public/wechat/', $name . '.png');
        }
    }

    /**
     * 发送小程序订阅消息
     * @param $templateId string 订阅模板id
     * @param $openId string 接收者（用户）的 openid
     * @param $page string 点击模板卡片后的跳转页面
     * @param $data array 模板内容
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendSubscribeMessage($templateId, $openId, $page, $data)
    {
        $array = [
            'template_id' => $templateId, # 所需下发的订阅模板id
            'touser' => $openId, # 接收者（用户）的 openid
            'page' => $page, # 点击模板卡片后的跳转页面，仅限本小程序内的页面。支持带参数,（示例index?foo=bar）。该字段不填则模板无跳转。
            'data' => $data, # 模板内容，格式形如 { "key1": { "value": any }, "key2": { "value": any } }
        ];

        return $this->app->subscribe_message->send($array);
    }


    /**
     * 获取AccessToken
     * @return mixed
     * @since: 2020/8/26
     * @author: Chen Zhihong
     */
    public function getAccessToken()
    {
        $accessToken = Session::get('accessToken');

        if (!$accessToken) {
            # 拼接微信获取AccessToken路径
            $sendUrl = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&" . "appid=%s&secret=%s";
            $url = sprintf($sendUrl, $this->appId, $this->secret);

            # 请求接口，获取token
            $res = Base::getCurl($url);
            $data = json_decode($res, true);

            # 存入session
            $accessToken = $data['access_token'];
            Session::set('accessToken', $accessToken);
        }

        return $accessToken;
    }

    /**
     * 发送统一的信息 小程序发送公众号消息
     * @author: Chen Zhihong
     * @since: 2020/8/26
     * @param $accessToken string accessToken
     * @param $openId string 小程序openid获取关联公众号的openid
     * @param $templateId string 模版ID
     * @param $data array 消息数据
     * @return bool|string
     */
    public function sendUniformMessage($accessToken, $openId, $templateId, $data)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/uniform_send?access_token=" . $accessToken;
        $mpAppId = ''; # ⚠️必填 公众号appid，要求与小程序有绑定且同主体
        $mpUrl = ''; # 公众号模板消息所要跳转的url

        $sendData = array(
            'access_token' => $accessToken,
            'touser' => $openId, # 用户openid，可以是小程序的openid，也可以是mp_template_msg.appid对应的公众号的openid
            # 公众号模板消息相关的信息
            'mp_template_msg' => array(
                'appid' => $mpAppId, # 公众号appid，要求与小程序有绑定且同主体
                'template_id' => $templateId, # 公众号模板id
                'url' => $mpUrl, # 公众号模板消息所要跳转的url
                # # 公众号模板消息所要跳转的小程序，小程序的必须与公众号具有绑定关系
                'miniprogram' => array(
                    'appid' => $this->appId,
                    'pagepath' => 'page/tabBar/navbar/navbar', # 小程序首页地址
                ),
                # 公众号模板消息的数据
                'data' => $data,
            ),
        );

        return Base::postCurl($url, json_encode($sendData));
    }
}
