<?php
namespace app\api\model;
use app\api\model\BaseModel;
use think\Exception;
use think\Db;
class Banner extends BaseModel{
	//被隐藏的字段
	protected $hidden = ['update_time','delete_time'];
	public static function getBannerByID($id){
		// $sql = 'select * from banner_item where banner_id='.$id;
		// $result = Db::query($sql);
		// 表达式
		// ->fetchSql()生成sql语句
		// $result = Db::table('banner_item')->where('banner_id','=',$id)->select();
		// 闭包
		// $result = Db::table('banner_item')->where(function($query) use ($id){
		// 	$query->where('banner_id','=',$id);
		// })->select();
		// 数组不建议使用
		 
		//with也可接受关联数组with(['item1','item2']) item.img通过item关联img
		$banner = self::with(['items','items.img'])->select($id);
		return $banner;
	}
	//一个banner(主键id)对应多个banner_item(外键为banner_id) 
	public function items(){
		//关联模型名字 外键 主键
		return $this->hasMany('banner_item','banner_id','id');
	}

}