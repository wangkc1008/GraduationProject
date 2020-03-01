<?php
namespace app\api\service;

use app\lib\exception\OrderException;
use app\api\service\WxMessage;
use app\api\model\User as UserModel;
use app\lib\exception\UserException;

class DeliveryMessage extends WxMessage{
	const DELIVERY_MSG_ID = 'URkERaSPYVsUmPgnVreZwBbulPfAvkBBU7ij3_HDupY';

	public function sendDeliveryMessage($order,$tplJunmPage=''){
		if(!$order){
			throw new OrderException();
		}
		$this->tplID = self::DELIVERY_MSG_ID;
		$this->formID = $order->prepay_id;
		$this->page = $tplJunmPage;
		$this->prepareMessageData($order);
		$this->emphasisKeyWord='keyword2.DATA';
		return parent::sendMessage($this->getUserOpenID($order->user_id));
	}

	private function prepareMessageData($order){
		$dateTime = new \DateTime();
		$data = [
			'keyword1' => [
				'value' => '顺丰快递'
			],
			'keyword2' => [
				'value' => $order->snap_name,
				'color' => '#27408B'
			],
			'keyword3' => [
				'value' => $order->order_no
			],
			'keyword4' => [
				'value' => $dateTime->format("Y-m-d H:i")
			]

		];
		$this->data = $data;
	}
	public function getUserOpenID($uid){
		$user = UserModel::get($uid);
		if(!$uid){
			throw new UserException();
		}
		return $user->openid;
	}
}