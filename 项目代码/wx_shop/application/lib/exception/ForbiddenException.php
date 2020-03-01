<?php
namespace app\lib\exception;

use app\lib\exception\BaseException;

class ForbiddenException extends BaseException{

	protected $code = 403;
	protected $msg = '权限不足';
	protected $errorCode = 10001;
}