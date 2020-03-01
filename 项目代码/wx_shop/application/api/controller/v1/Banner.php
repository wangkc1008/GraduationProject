<?php
namespace app\api\controller\v1;

use app\lib\exception\BannerMissException;
use think\Controller;
use app\api\validate\IDMustBePositiveInt;
use app\api\model\Banner as Banner_model;

class Banner extends Controller{

	public function getBanner($id){
		//AOP 面向切面编程
		//验证层
		(new IDMustBePositiveInt())->goCheck();

		$banner = Banner_model::getBannerByID($id);
		if($banner->isEmpty()){
			//banner不存在异常
		    throw new BannerMissException();
        }
		return json($banner);
	}
}