<?php
namespace app\api\validate;

use app\api\validate\BaseValidate;

class IDCollection extends BaseValidate{
	protected $rule = [
		'ids' => 'require|checkIDs'
	];
	protected $message = [
		'ids' => 'ids参数必须为以逗号分割的多个正整数'
	];
	protected function checkIDs($value){
		$id_array = explode(',', $value);
		if(empty($id_array)){
			return false;
		}
		foreach($id_array as $id){
			if(!$this->isPositiveInteger($id)){
				return false;
			}
		}
		return true;
	}
}