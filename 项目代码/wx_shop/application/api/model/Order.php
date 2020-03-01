<?php
namespace app\api\model;

use app\api\model\BaseModel;

class Order extends BaseModel{

	protected $hidden = ['user_id', 'delete_time', 'update_time'];

    public function getSnapImgAttr($value,$data){
        return $this->prefixImgUrl($value,$data);
    }

	public static function getSummaryByUser($uid,$page,$size){
		$pagniData = self::where('user_id','=',$uid)->order('create_time desc')->paginate($size,true,['page'=>$page]);
		return $pagniData;
	}

	public function getSnapItemsAttr($value){
		if(empty($value)){
			return null;
		}
		return json_decode($value);
	}

	public function getSnapAddressAttr($value){
		if(empty($value)){
			return null;
		}
		return json_decode($value);
	}

	public static function getSummaryByPage($page=1,$size=20){
		$pagniData = self::order('create_time desc')->paginate($size,true,['page'=>$page]);
		return $pagniData;
	}
}