<?php
namespace app\api\model;

use app\api\model\BaseModel;

class Image extends BaseModel{
	protected $hidden = ['id','from','update_time','delete_time'];
	//获取器/读取器 value(当前属性字段) data(该表所有字段)
	public function getUrlAttr($value,$data){
		return $this->prefixImgUrl($value,$data);
	}
}  