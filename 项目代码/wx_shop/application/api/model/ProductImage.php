<?php
namespace app\api\model;

use app\api\model\BaseModel;

class ProductImage extends BaseModel{
	protected $hidden = ['delete_time','product_id','img_id'];

	public function images(){
		return $this->belongsTo('Image','img_id','id');
	}
}