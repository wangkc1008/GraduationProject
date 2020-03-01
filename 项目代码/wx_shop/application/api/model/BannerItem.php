<?php
namespace app\api\model;
use app\api\model\BaseModel;

class BannerItem extends BaseModel{
	protected $hidden = ['id','img_id','banner_id','update_time','delete_time'];
	//banner_item(img_id)与image(id)为一对一关系
	public function img(){
		//关联模型名字 外键 主键
		return $this->belongsTo('image','img_id','id');
	}
}