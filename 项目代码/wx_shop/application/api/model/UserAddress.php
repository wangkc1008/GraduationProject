<?php
namespace app\api\model;

use app\api\model\BaseModel;

class UserAddress extends BaseModel{
	protected $hidden = ['delete_time','update_time','user_id'];
	
}