<?php
namespace app\api\validate;

use app\api\validate\BaseValidate;
class ProductException extends BaseValidate{
	public $code = 404;
	//product 不存在
	public $msg = 'Product is not exist';
	public $errorCode = 20000;
}