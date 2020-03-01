<?php
namespace app\lib\exception;

use app\lib\exception\BaseException;

class WeChatException extends BaseException{

	protected $code = 400;
	protected $msg = 'WeChat unknow error';
	protected $errCode = 999;
}