<?php
namespace app\api\validate;

use app\api\validate\BaseValidate;

class AppTokenGet extends BaseValidate{
	protected $rule = [
		'ac'=>'require|isNotEmpty',
		'se'=>'require|isNotEmpty'
	];
}