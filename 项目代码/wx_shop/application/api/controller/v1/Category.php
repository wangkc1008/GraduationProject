<?php
namespace app\api\controller\v1;

use think\Controller;
use think\Request;
use app\lib\exception\CategoryException;
use app\api\model\Category as Category_model;
class Category extends Controller{

	public function getALLCategories(){
		//all(字段数组，关联关系)
		$categories = Category_model::where('is_delete','=',0)->with(['img'])->select();
		if($categories->isEmpty()){
			throw new CategoryException();
		}
		return $categories;
	}
}