<?php
/**
 * Created by PhpStorm
 * User: 陈志洪
 * Date: 2020/1/21
 * Time: 22:10
 */

namespace app\api\service;

use think\Db;
use think\Exception;
use think\Log;

class PayService
{
    // 创建本地订单
    public function createOrder()
    {
        Db::startTrans();
        try {
            /*
             * 整理数据  创建本地订单
             * $data = ['user_id' => ...];
             * (new OrderModel())->insert($data);
             */
            Db::commit();
            return true;
        } catch (Exception $e) {
            Db::rollback();
            Log::info('[error] 创建本地订单失败 ' . date('Y-m-d H:i:s') . '，错误原因：' . $e->getMessage());
            return false;
        }
    }

    /**
     * 创建微信订单
     * @param $product_info array 商品信息，内要加多一个 order_no 订单号
     * @param $openid string 用户openid
     * @return array
     */
    public function createWeChatOrder($product_info, $openid)
    {
        // 前面三个参数请根据实际数据名称定义
        return [
            'body' => $product_info['name'], // 商品描述（产品标题）
            'out_trade_no' => $product_info['order_no'], // 订单号（创建订单生成的订单号）
            'total_fee' => $product_info['price'] * 100, // 价格  单位：分，所以要 * 100
            'trade_type' => 'JSAPI', // 请对应换成你的支付方式对应的值类型
            'openid' => $openid, // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
        ];
    }
}
