<?php
namespace app\api\validate;

use app\lib\exception\ParameterException;
use think\Validate;
use think\Request;
class BaseValidate extends Validate{

	public function goCheck(){
		$param = Request::instance()->param();
		//批量检查传入参数
		$result = $this->batch()->check($param);
		if(!$result){
			//参数异常
			$e = new ParameterException([
				//传入异常信息
				'msg' => $this->error
			]);
			throw $e;
		}else{
			return true;
		}
	}

	protected function isPositiveInteger($value,$rule='',$data='',$field=''){
		if(is_numeric($value) && is_int($value + 0) && ($value + 0) > 0){
			return true;
		}else{
			return false;
		}
	}

	protected function isNotEmpty($value,$rule='',$data='',$field=''){
		if(empty($value)){
			return false;
		}else{
			return true;
		}
	}

	protected function isMobile($value,$rule='',$data='',$field=''){
		$rule = '^1(3|4|5|7|8)[0-9]\d{8}$^';
		$result = preg_match($rule, $value);
		if($result){
			return true;
		}else{
			return false;
		}
	}

	public function getDataByRule($arrays){
		if(array_key_exists('uid', $arrays)||array_key_exists('user_id',$arrays)){
			throw new ParameterException([
				'msg' => '当前参数中含有uid或user_id，请检查'
			]);
		}
		$dataArray = [];
		foreach($this->rule as $key=>$value){
			$dataArray[$key] = $arrays[$key];
		}
		return $dataArray;
	}


}