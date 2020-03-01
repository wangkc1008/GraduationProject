<?php
namespace app\api\controller\v1;

use think\Controller;
use think\Request;
use app\api\validate\IDCollection;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\ThemeMissException;
use app\api\model\Theme as Theme_model;

class Theme extends Controller{

	/**
	 * [getTheme description]
	 * @url /theme?ids=id1,id2,....
	 * @param  [type] $id [description]
	 * @return 一组theme模型
	 */
	public function getSimpleList($ids=''){
		(new IDCollection())->goCheck();

		$id_array = explode(',', $ids);
		$themes = Theme_model::getThemesByID($id_array);

		if($themes->isEmpty()){
			throw new ThemeMissException();
		}
		return $themes;
	}
	/**
	 * [getComplexOne description]
	 * @url /theme/:id
	 * @param  $id 点击主题传递主题id显示产品信息
	 * @return 一组product信息
	 */
	public function getComplexOne($id){
		(new IDMustBePositiveInt())->goCheck();
		$products = Theme_model::getProductsWithTheme($id);
		if($products->isEmpty()){
			throw new ThemeMissException();
		}
		return $products;
	}
}
