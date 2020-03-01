<?php
namespace app\lib\exception;

class BannerMissException extends BaseException{

	public $code = 404;
	//banner 不存在
	public $msg = 'Banner is not exist';
	public $errorCode = 40000;
}