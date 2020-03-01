<?php
namespace app\api\validate;

use app\api\validate\BaseValidate;

class Count extends BaseValidate{
	protected $rule = [
		'count' => 'isPositiveInteger|between:1,20'
	];
}