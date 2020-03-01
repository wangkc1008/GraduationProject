<?php
namespace app\lib\exception;

use app\lib\exception\BaseException;

class TokenException extends BaseException{
	public $code = 401;
	public $msg = 'Token已过期或不存在';
	public $errorCode = 10001;

}