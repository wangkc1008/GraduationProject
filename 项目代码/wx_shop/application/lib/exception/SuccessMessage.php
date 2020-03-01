<?php
namespace app\lib\exception;

use app\lib\exception\BaseException;

class SuccessMessage{

	protected $code = 201;
	protected $msg = 'ok';
	protected $errorCode = 0;
}