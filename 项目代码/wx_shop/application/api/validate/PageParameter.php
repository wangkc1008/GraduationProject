<?php
namespace app\api\validate;

use app\api\validate\BaseValidate;

class PageParameter extends BaseValidate{
	protected $rule = [
		'page'=>'isPositiveInteger',
		'size'=>'isPositiveInteger'
	];

	protected $msg = [
		'page'=>'页码不能为空',
		'size'=>'每页数量不能为空'
	];
}