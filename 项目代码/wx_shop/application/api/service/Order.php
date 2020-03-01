<?php
namespace app\api\service;
use think\Db;
use think\Exception;
use app\api\model\Product;
use app\lib\exception\OrderException;
use app\api\model\UserAddress;
use app\lib\exception\UserException;
use app\api\model\Order as OrderModel;
use app\api\model\OrderProduct as OrderProductModel;
use app\api\service\DeliveryMessage;
use app\lib\enum\OrderStatusEnum;

class Order{
	//客户端传来的订单信息
	protected $oProducts;
	//数据库查到的订单信息
	protected $products;
	protected $uid;

	function __construct(){

	}

	public function place($uid,$oProducts){
		$this->uid = $uid;
		$this->oProducts = $oProducts;
		$this->products = $this->getProductsByOrder($oProducts);
		$status = $this->getOrderStatus();
		//不通过的订单将order_id置为-1
		if(!$status['pass']){
			$status['order_id'] = -1;
			return $status;
		}
		//开始创建订单快照
		$snap = $this->snapOrder($status);
		//生成订单
		$order = $this->createOrder($snap);
		$order['pass'] = true;
		return $order;
	}

	//生成订单
	private function createOrder($snap){
		Db::startTrans();
		try{
			//将订单信息写入order表中
			$orderNo = $this->makeOrderNo();
			$order = new OrderModel();
			$order->order_no = $orderNo;
			$order->user_id = $this->uid;
			$order->total_price = $snap['orderPrice'];
            $order->total_count = $snap['totalCount'];
            $order->snap_img = $snap['snapImg'];
            $order->snap_name = $snap['snapName'];
            $order->snap_address = $snap['snapAddress'];
            $order->snap_items = json_encode($snap['pStatus']);
            $order->save();
            $orderID = $order->id;
            $createTime = $order->create_time;     
            //将部分信息写入order_product表
            foreach($this->oProducts as &$p){
            	$p['order_id'] = $orderID;
            }
            $orderProduct = new OrderProductModel();
            $orderProduct->saveAll($this->oProducts);
            Db::commit();
            return [
            	'order_no' => $orderNo,
            	'order_id' => $orderID,
            	'create_time' => $createTime
            ];
		}catch(Excepeion $ex){
			Db::rollback();
			throw $ex;
		}
	}
	//处理生成订单快照信息
	private function snapOrder($status){
		$snap = [
			'orderPrice' => 0,
			'totalCount' => 0,
			'pStatus' => [],
			'snapAddress' => null,
			'snapName' => '',
			'snapImg' => ''
		];
		$snap['orderPrice'] = $status['orderPrice'];
		$snap['totalCount'] = $status['totalCount'];
		$snap['pStatus'] = $status['pStatusArray'];
		$snap['snapAddress'] = json_encode($this->getUserAddress());
		$snap['snapName'] = $this->products[0]['name'];
		$count = count(explode('/',$this->products[0]['main_img_url']));
		$snap['snapImg'] = '/'.explode('/',$this->products[0]['main_img_url'])[$count - 1];
		//如果商品种类大于1  
		if(count($this->products) > 1){
			$snap['snapName'] .= '等';
		}
		return $snap;
	}

	public function getUserAddress(){
		$address = UserAddress::where('user_id','=',$this->uid)->find();
		if(!$address){
			throw new UserException([
				'msg' => '用户收货地址不存在，下单失败',
				'errorCode' => 60001
			]);
		}
		return $address->toArray();
	}
	//对外提供的检测库存量方法
	public function checkOrderStatus($orderID){
		$oProducts = OrderProductModel::where('order_id','=',$orderID)->select();
		$this->oProducts = $oProducts;
		$products = $this->getProductsByOrder($oProducts);
		$this->products = $products;
		$status = $this->getOrderStatus();
		return $status;

	}
	//处理小程序传来的订单的状态
	private function getOrderStatus(){
		$status = [
			'pass' => true,
			'orderPrice' => 0,
			'totalCount' => 0,
			'pStatusArray' =>[]
		];
		//对全部订单进行遍历
		foreach($this->oProducts as $oProduct){
			$result = $this->getProductStatus($oProduct['product_id'],$oProduct['count'],$this->products);
			if(!$result['haveStock']){
				$status['pass'] = false;
			}
			$status['orderPrice'] += $result['totalPrice'];
			$status['totalCount'] += $result['counts'];
			array_push($status['pStatusArray'],$result);
		}
		return $status;
	}
	//处理订单中每个商品的状态
	private function getProductStatus($oID,$oCount,$products){
		$index = -1;
		$pStatus = [
			'id' => null,
			'haveStock' => false,
			'counts' => 0,
			'price' => 0,
			'name' => '',
			'totalPrice' => 0,
			'main_img_url' => null
		];
		for($i=0;$i<count($products);$i++){
			if($oID == $products[$i]['id']){
				$index = $i;
			}
		}
		if($index == -1){
			throw new OrderException([
				'msg' => 'id为' . $oID . '的商品不存在，订单创建失败'
			]);
		}else{
			$pStatus['id'] = $products[$index]['id'];
			$pStatus['name'] = $products[$index]['name'];
			$pStatus['counts'] = $oCount;
			$pStatus['price'] = $products[$index]['price'];
            $count = count(explode('/',$products[$index]['main_img_url']));
            $pStatus['main_img_url'] = '/'.explode('/',$products[$index]['main_img_url'])[$count - 1];
			$pStatus['totalPrice'] = $products[$index]['price']*$oCount;
			if($products[$index]['stock'] - $oCount >= 0){
				$pStatus['haveStock'] = true;
			}
			return $pStatus;
		}
	}
	//根据订单中的商品id取出来数据库中对应的商品信息 用于库存量检测
	private function getProductsByOrder($oProducts){
		$oIDs = [];
		//避免循环查询数据库
		foreach($oProducts as $items){
			array_push($oIDs,$items['product_id']);
		}
		$result = Product::all($oIDs)->visible(['id','price','name','stock','main_img_url'])->toArray();
		return $result;
	}
	//生成订单编号
	public function makeOrderNo(){
		$yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
		$orderSn = $yCode[intval(date('Y'))-2018].strtoupper(dechex(date('m'))).date('d').substr(time(), -5).substr(microtime(),2,5).sprintf('%02d',rand(0,99));
		return $orderSn;
	}

	public function delivery($orderID,$jumpPage=''){
		$order = OrderModel::where('id','=',$orderID)->find();
		if(!$order){
			throw new OrderException();
		}
		if($order->status!=OrderStatusEnum::PAID){
			throw new OrderException([
				'msg' => '未付款',
				'errorCode' => 80002,
				'code' => 403
			]);
		}
		$order->status = OrderStatusEnum::DELIVERED;
		$order->save();
		$message = new DeliveryMessage();
		return $message->sendDeliveryMessage($order,$jumpPage);
	}
}