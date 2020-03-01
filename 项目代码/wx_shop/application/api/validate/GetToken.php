<?php
namespace app\api\validate;

use app\api\validate\BaseValidate;

class GetToken extends BaseValidate{

	protected $rule = [
		'code' => 'require|isNotEmpty'
	];

	protected $message =[
		'code' => 'code必须携带'
	];
}