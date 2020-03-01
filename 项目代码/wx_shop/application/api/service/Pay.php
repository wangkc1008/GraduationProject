<?php
namespace app\api\service;
use think\Exception;
use app\api\model\Order as OrderModel;
use app\lib\exception\OrderException;
use app\lib\exception\TokenException;
use app\api\service\Token as TokenService;
use app\lib\enum\OrderStatusEnum;
use app\api\service\Order as OrderService;
use think\Loader;
use think\Log;
//extend/WxPay/WxPay.Api.php
// Loader::import('WxPay.WxPay', EXTEND_PATH, '.Data.php');
Loader::import('WxPay.WxPay',EXTEND_PATH,'.Api.php');
class Pay {
	private $orderID;
	private $orderNo;

	function __construct($orderID){
		if(!$orderID){
			throw new Exception('订单号不能为null');
		}
		$this->orderID = $orderID;
	}
	//可调用order中的方法进行库存量检测
	public function pay(){
		$this->checkOrderValid();
		//库存量检查
		$status = (new OrderService())->checkOrderStatus($this->orderID);
		if(!$status['pass']){
			return $status;
		}
		//微信预订单接口
		return $this->makeWxPreOrder($status);

	}
	//微信预订单接口
	private function makeWxPreOrder($status){
		$openid = TokenService::getCurrentTokenVar('openid');
		if(!$openid){
			throw new TokenException();
		}
		$wxOrderData = new \WxPayUnifiedOrder();
		$wxOrderData->SetOut_trade_no($this->orderNo);
		$wxOrderData->SetTrade_type('JSAPI');
		$wxOrderData->SetTotal_fee($status['orderPrice']);
		$wxOrderData->SetOpenid($openid);
		$wxOrderData->SetBody('手机商城');
		$wxOrderData->SetNotify_url('回调接口');
		return $this->getPaySignature($wxOrderData);
	}
	//向微信请求订单号并生成签名
	private function getPaySignature($wxOrderData){
		$wxOrder = \WxPayApi::unifiedOrder($wxOrderData);
        // 失败时不会返回result_code
        if($wxOrder['return_code'] != 'SUCCESS' || $wxOrder['result_code'] !='SUCCESS'){
            Log::record($wxOrder,'error');
            Log::record('获取预支付订单失败','error');
        }
        $this->recordPreOrder($wxOrder);
        $signature = $this->sign($wxOrder);
        return $signature;
	}
	private function sign($wxOrder){
		$jsApiPayData = new \WxPayJsApiPay();
        $jsApiPayData->SetAppid(config('wx.app_id'));
        $jsApiPayData->SetTimeStamp((string)time());
        $rand = md5(time() . mt_rand(0, 1000));
        $jsApiPayData->SetNonceStr($rand);
        $jsApiPayData->SetPackage('prepay_id=' . $wxOrder['prepay_id']);
        $jsApiPayData->SetSignType('md5');
        $sign = $jsApiPayData->MakeSign();
        $rawValues = $jsApiPayData->GetValues();
        $rawValues['paySign'] = $sign;
        unset($rawValues['appId']);
        return $rawValues;
	}

	private function recordPreOrder($wxOrder){
		//每次用户取消支付再对同一订单支付生成的prepay_id不同
		OrderModel::where('id','=',$this->orderID)->update(['prepay_id'=>$wxOrder['prepay_id']]);
	}

	protected function checkOrderValid(){
		//判断当前订单是否存在
		$order = OrderModel::where('id','=',$this->orderID)->find();
		if(!$order){
			throw new OrderException();
		}
		//判断订单号是否与当前用户匹配
		if(!TokenService::isValidOperate($order->user_id)){
			throw new TokenException([
				'msg' => '订单与用户不匹配',
				'errorCode' => 10003
			]);
		}
		//判断订单是否支付
		if($order->status != OrderStatusEnum::UNPAID){
			throw new OrderException([
				'msg' => '当前订单已支付',
				'errorCode' => 80003,
                'code' => 400
			]);
		}
		$this->orderNo = $order->order_no;
		return true;
	} 
}