<?php
/**
 * Created by PhpStorm
 * User: 陈志洪
 * Date: 2020/1/21
 * Time: 21:53
 */

namespace app\api\controller;

use app\api\library\WeChat\Payment;
use app\api\service\PayService;
use app\api\service\TokenService;
use think\Db;
use think\Exception;
use think\Log;
use function fast\array_get;

class Pay extends Base
{
    private $token_info;

    /**
     * 微信支付 下单
     * 1、业务逻辑处理
     * 2、创建本地订单
     * 3、微信统一下单
     * 4、返回签名给前端拉起微信支付
     */
    public function pay()
    {
        $this->token_info = (new TokenService())->checkToken(); // 登录验证

        // 支付记录
        Log::info('开始支付：' . date('Y-m-d H:i:s'));

        // 1、业务逻辑 START
        // ...
        // 1、业务逻辑 END

        $order_no = parent::makeOrderNo(); // 生成订单号
        $product_info = []; // 获取商品信息
        // 2、创建本地订单 START
        // ...
        // 2、创建本地订单 END

        // 3、微信统一下单 START
        $product_info['order_no'] = $order_no; // 订单号放入商品信息内
        $order = (new PayService())->createWeChatOrder($product_info, $this->token_info['openid']); // 整理订单格式
        $result = (new Payment())->order($order); // 统一下单
        // 3、微信统一下单 END


        Log::info('结束支付：' . date('Y-m-d H:i:s'));

        parent::success('success', $result, 200);
    }

    // 微信支付回调
    public function response()
    {
        Log::info('开始支付回调处理：' . date('Y-m-d H:i:s'));

        (new Payment())->app->handlePaidNotify(function ($message, $fail) {
            if ($message['return_code'] == 'SUCCESS') {
                // 用户是否支付成功
                if (array_get($message, 'result_code') === 'SUCCESS') {
                    Db::startTrans();
                    try {
                        // 回调后支付成功的业务处理
                        // 温馨提示：$message['out_trade_no'] 为生成的订单号，可根据这个查找订单

                        Db::commit();
                    } catch (Exception $e) {
                        Db::rollback();
                        Log::info('[error] 支付回调失败 ' . date('Y-m-d H:i:s') . '，错误原因：' . $e->getMessage());
                    }

                    // 用户支付失败
                } elseif (array_get($message, 'result_code') == 'FAIL') {
                    // 支付失败业务代码
                    // ...
                    // 支付失败业务代码
                }
            } else {
                Log::info('通知失败');
                return $fail('通信失败，请稍后再通知我');
            }

            Log::info('结束支付回调处理：'. date('Y-m-d H:i:s'));
            return true;
        });
    }
}
