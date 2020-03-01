<?php
namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\validate\OrderPlace;
use think\Request;
use app\api\service\Order as OrderService;
use app\api\service\Token as TokenService;
use app\api\validate\PageParameter;
use app\api\validate\IDMustBePositiveInt;
use app\api\model\Order as OrderModel;
use app\api\exception\OrderException;
use think\Controller;
use app\lib\exception\SuccessMessage;

class Order extends BaseController{

	protected $beforeActionList = [
		'checkExclusiveScope' => ['only' => 'placeData'],
		'checkPrimaryScope' => ['only' => 'getSummaryByUser,getDetailsByID']
	];

	public function placeData(){
		(new OrderPlace())->goCheck();
		//接收到数组参数
		$products = input('post.products/a');
		$uid = TokenService::getCurrentUid();

		$order = new OrderService();
		$status = $order->place($uid,$products);

		return $status;
	}

	public function getSummaryByUser($size=15,$page=1){
		(new PageParameter)->goCheck();
		$uid = TokenService::getCurrentUid();
		$pagniOrders = OrderModel::getSummaryByUser($uid,$page,$size);
		if($pagniOrders->isEmpty()){
			return[
				'data' => ['data' => []],
				'current_page' => $pagniOrders->getCurrentPage()
			];
		}
		return [
			'data' => $pagniOrders->hidden(['snap_items','snap_address','prepay_id'])->toArray(),
			'current_page' => $pagniOrders->getCurrentPage()
		];
	}

	public function getDetailsByID($id){
		(new IDMustBePositiveInt())->goCheck();
		$detailOrders = OrderModel::get($id)->toArray();
		if(!$detailOrders){
			throw new OrderException();
		}
		foreach ($detailOrders['snap_items'] as $key => $value) {
            $detailOrders['snap_items'][$key] = (array)$value;
        }
        foreach ($detailOrders['snap_items'] as $key => $value) {
            $detailOrders['snap_items'][$key]['main_img_url'] = config('setting.img_prefix').$value['main_img_url'];
		}
		return $detailOrders;
	}

	public function getSummary($size=20,$page=1){
		(new PageParameter)->goCheck();
		$pagniOrders = OrderModel::getSummaryByPage($page,$size);
		if($pagniOrders->isEmpty()){
			return [
				'current_page' => $pagniOrders->getCurrentPage(),
				'data' => []
			];
		}
		$data = $pagniOrders->hidden(['snap_items','snap_address'])->toArray();
		return [
			'current_page' => $pagniOrders->getCurrentPage(),
			'data' => $data
		];
	}

	public function delivery($id){
		(new IDMustBePositiveInt())->goCheck();
		$order = new OrderService();
		$success = $order->delivery($id);
		if($success){
			return new SuccessMessage();
		}
	}


}