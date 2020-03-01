<?php
namespace app\lib\exception;

class ThemeMissException extends BaseException{

	public $code = 404;
	//theme 不存在
	public $msg = 'Theme is not exist';
	public $errorCode = 30000;
}