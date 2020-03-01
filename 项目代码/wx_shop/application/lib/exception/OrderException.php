<?php
namespace app\lib\exception;

use app\lib\exception\BaseException;

class OrderException extends BaseException{
	protected $code = 404;
	protected $msg = '订单不存在，检查ID';
	protected $errorCode = 80000;
}