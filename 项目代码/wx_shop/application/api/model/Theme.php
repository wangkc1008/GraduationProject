<?php
namespace app\api\model;

use app\api\model\BaseModel;

class Theme extends BaseModel{

	protected $hidden = ['delete_time','update_time','topic_img_id','head_img_id'];

	public static function getThemesByID($ids=''){
		$result = self::with(['topicImg','headImg'])->select($ids);
		return $result;
	}

	public static function getProductsWithTheme($id){
		$result = self::with('products,topicImg,headImg')->select($id);
		return $result;
	}
	//一对一关系 theme表本身包含外键 使用belongsTo 不包含外键时使用hasOne
	public function topicImg(){
		return $this->belongsTo('image','topic_img_id','id');
	}
	//一对一关系
	public function headImg(){

		return $this->belongsTo('image','head_img_id','id');
	}

	public function products(){
		//关联模型 中间表 外键 主键
		return $this->belongsToMany('product','theme_product','product_id','theme_id')->where('is_delete','=',0);
	}
}