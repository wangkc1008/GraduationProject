<?php
namespace app\lib\exception;

class ParameterException extends BaseException{

	public $code = 400;
	//参数错误
	public $msg = 'Parameter error';
	public $errCode = 10000;
}