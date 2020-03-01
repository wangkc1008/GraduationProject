<?php
namespace app\lib\exception;

class CategoryException extends BaseException{
	public $code = 404;
	//category 不存在
	public $msg = 'Category is not exist';
	public $errorCode = 50000;
}