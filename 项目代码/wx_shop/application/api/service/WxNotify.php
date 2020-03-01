<?php
namespace app\api\service;

use app\api\model\Order as OrderModel;
use app\api\model\Product as ProductModel;
use app\api\service\Order as OrderService;
use app\lib\enum\OrderStatusEnum;
use app\lib\order\OrderStatus;
use think\Db;
use think\Exception;
use think\Loader;
use think\Log;
Loader::import('WxPay.WxPay',EXTEND_PATH,'Api.php');
class WxNotify extends \WxPayNotify{
//    protected $data = <<<EOD
//<xml><appid><![CDATA[wxaaf1c852597e365b]]></appid>
//<bank_type><![CDATA[CFT]]></bank_type>
//<cash_fee><![CDATA[1]]></cash_fee>
//<fee_type><![CDATA[CNY]]></fee_type>
//<is_subscribe><![CDATA[N]]></is_subscribe>
//<mch_id><![CDATA[1392378802]]></mch_id>
//<nonce_str><![CDATA[k66j676kzd3tqq2sr3023ogeqrg4np9z]]></nonce_str>
//<openid><![CDATA[ojID50G-cjUsFMJ0PjgDXt9iqoOo]]></openid>
//<out_trade_no><![CDATA[A301089188132321]]></out_trade_no>
//<result_code><![CDATA[SUCCESS]]></result_code>
//<return_code><![CDATA[SUCCESS]]></return_code>
//<sign><![CDATA[944E2F9AF80204201177B91CEADD5AEC]]></sign>
//<time_end><![CDATA[20170301030852]]></time_end>
//<total_fee>1</total_fee>
//<trade_type><![CDATA[JSAPI]]></trade_type>
//<transaction_id><![CDATA[4004312001201703011727741547]]></transaction_id>
//</xml>
//EOD;
	public function NotifyProcess($data,&$msg){
		if($data['result_code'] == 'SUCCESS'){
			$orderNo = $data['out_trade_no'];
			Db::startTrans();
			try{
				$order = OrderModel::where('order_no','=',$orderNo)->lock(true)->find();
				$service = new OrderService();
				//检查该订单的库存状态
				$status = $service->checkOrderStatus($order->id);
				if($status['pass']){
					//更新订单状态 支付成功有库存
					$this->updateOrderStatus($order->id,true);
					//减库存
					$this->reduceStock($status);
				}else{
					//支付成功但库存不足
					$this->updateOrderStatus($order->id,false);
				}
				Db::commit();
			}catch(Exception $ex){
				Db::rollback();
                Log::error($ex);
                // 如果出现异常，向微信返回false，请求重新发送通知
                return false;
			}
		}
		//告诉微信虽然有错误但是不用再继续发送
		return true;
	}

	public function reduceStock($status){
		foreach($status['pStatusArray'] as $singlePStatus){
			ProductModel::where('id', '=', $singlePStatus['id'])
                ->setDec('stock', $singlePStatus['count']);
		}
	}

	public function updateOrderStatus($orderID,$success){
		$orderStatus = $success ? OrderStatusEnum::PAID : OrderStatusEnum::PAID_BUT_OUT_OF;
		OrderModel::where('id','=',$orderID)->update(['status'=>$orderStatus]);
	}

}