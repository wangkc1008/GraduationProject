<?php
namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\validate\IDMustBePositiveInt;
use app\api\service\Pay as PayService;
use app\api\service\WxNotify;
class Pay extends BaseController{
	//只允许用户访问
	protected $beforeActionList = [
		'checkExclusiveScope' => ['only' => 'getPreOrder']
	];

	public function getPreOrder($id=''){
		(new IDMustBePositiveInt())->goCheck();
		$pay = new PayService($id);
		return $pay->pay();
	}
	//接收微信异步推送支付信息
	public function receiveNotify()
    {
    	$notify = new WxNotify();
        $notify->handle();
    }

}