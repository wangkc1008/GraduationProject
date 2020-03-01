<?php
namespace app\api\model;

use app\api\model\BaseModel;

class Product extends BaseModel{
	protected $hidden = [
		'create_time','update_time','pivot','delete_time','category_id','from'
	];
	public function getMainImgUrlAttr($value,$data){
		return $this->prefixImgUrl($value,$data);
	}

	public static function getMostProduct($count){
	    $id_array = array();
	    $sql = "select count(id) as num from t_shop_product ";
	    $max_num = self::query($sql)[0]['num'];
	    for ($i = 0;count($id_array) < $count; $i++) {
	        $rand_id = rand(0,$max_num - 1) + 1;
	        if (!in_array($rand_id,$id_array)) {
	            $id_array[] = $rand_id;
            }
        }
        $ids_str = implode($id_array,',');
	    $sql = "select * from `t_shop_product` where `id` in ($ids_str) and is_delete = 0 ";
        $result = self::query($sql);
		return $result;
	}

	public static function getProductsByCategoryID($id){
		$result = self::where('category_id','=',$id)->where('is_delete','=',0)->select();
		return $result;
	}

	public static function getProductDetailByID($id){
		//闭包 传入query对象 对关联模型中的元素进行排序
		$result = self::with([
			'productImgs'=>function($query){
				$query->with(['images'])->order('order asc');
		}])
		->with(['productProperty'])->select($id);
		return $result;
	}
	//命名不加下划线
	public function productImgs(){
		//关联模型 外键 主键
		return $this->hasMany('ProductImage','product_id','id');
	}

	public function productProperty(){
		//关联模型 外键 主键
		return $this->hasMany('ProductProperty','product_id','id');
	}
}