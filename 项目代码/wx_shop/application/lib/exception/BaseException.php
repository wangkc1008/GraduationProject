<?php
namespace app\lib\exception;

use think\Exception;

class BaseException extends Exception{
	//HTTP状态码，400，200
	public $code = 400;
	//错误具体信息
    //参数错误
	public $msg = 'Invalid parameter';
	//错误码
	public $errorCode = 10000;

	public function __construct($param = []){
		if(!is_array($param)){
			return ;
		}
		if(array_key_exists('code', $param)){
			$this->code = $param['code'];
		}
		if(array_key_exists('msg', $param)){
			$this->msg = $param['msg'];
		}
		if(array_key_exists('errorCode', $param)){
			$this->errorCode = $param['errorCode'];
		}
	}
}