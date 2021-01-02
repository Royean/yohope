<?php
/**
 * Created by PhpStorm
 * User: 陈志洪
 * Date: 2020/1/21
 * Time: 21:45
 */

namespace app\api\library\WeChat;

use app\api\model\Config as ConfigModel;
use EasyWeChat\Factory;
use think\Request;
use function EasyWeChat\Kernel\Support\generate_sign;

/*
 * 支付相关
 */
class Payment
{
    public $app; // 支付实例

    private $key; // API 密钥

    public function __construct()
    {
        $this->key = '';
        $root_path = Request::instance()->domain();

        $config = [
            'app_id' => ConfigModel::getValueByName('appid'),
            'mch_id' => '', // 商户号
            'key' => $this->key, // API 密钥

            // 如需使用敏感接口（如退款、发送红包等）需要配置 API 证书路径(登录商户平台下载 API 证书)
            // 'cert_path'          => 'path/to/your/cert.pem', // XXX: 绝对路径！！！！
            // 'key_path'           => 'path/to/your/key',      // XXX: 绝对路径！！！！

            'notify_url' => $root_path . '/api/pay/response', // 支付回调地址
        ];

        $this->app = Factory::payment($config);// 支付实例
    }

    /**
     * 支付  统一下单
     * @param $order array 订单数据
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function order($order)
    {
        $result = $this->app->order->unify($order);
        // 如果成功生成统一下单的订单，那么进行二次签名
        if ($result['return_code'] === 'SUCCESS' && $result['result_code'] == 'SUCCESS') {
            // 二次签名的参数必须与下面相同
            $params = [
                'appId' => ConfigModel::getValueByName('appid'), // appid
                'timeStamp' => (string)time(),
                'nonceStr' => $result['nonce_str'],
                'package' => 'prepay_id=' . $result['prepay_id'],
                'signType' => 'MD5',
            ];

            // config('wechat.payment.default.key')为商户的key
            $params['paySign'] = generate_sign($params, $this->key);
            unset($params['appId']);
            unset($params['signType']);
            return $params;
        } else {
            return $result;
        }
    }

    /**
     * 根据商户订单号退款
     * @param $orderNumber string 商户订单号
     * @param $refundNumber string 退款订单号
     * @param $totalFree int 订单金额
     * @param $refundFree int 退款金额
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function refundByOutTradeNumber($orderNumber, $refundNumber, $totalFree, $refundFree)
    {
        return $this->app->refund->byOutTradeNumber($orderNumber, $refundNumber, $totalFree, $refundFree);
    }
}
