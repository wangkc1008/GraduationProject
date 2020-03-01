<?php
namespace app\api\model;
use app\api\model\BaseModel;

class Category extends BaseModel{
	protected $hidden = ['delete_time','update_time','topic_img_id'];
	//一对一关系
	public function img(){
		return $this->belongsTo('image','topic_img_id','id');
	}
}