<?php
namespace app\api\model;

use app\api\model\BaseModel;

class ProductProperty extends BaseModel{
	protected $hidden = ['delete_time','update_time','product_id'];
}