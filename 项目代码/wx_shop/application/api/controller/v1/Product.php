<?php
namespace app\api\controller\v1;

use think\Controller;
use app\api\validate\Count;
use app\lib\exception\ProductException;
use app\api\validate\IDMustBePositiveInt;
use app\api\model\Product as Product_model;

class Product extends Controller{

	public function getRandom($count=20){
		(new Count())->goCheck();
		$products = Product_model::getMostProduct($count);
		if(empty($products)){
			throw new ProductException();
		}
		foreach ($products as $key => $value) {
            $products[$key]['main_img_url'] = config('setting.img_prefix').$value['main_img_url'];
        }
		return $products;
	}

	public function getProducts($id){
		(new IDMustBePositiveInt())->goCheck();
		$products = Product_model::getProductsByCategoryID($id);
		if($products->isEmpty()){
			throw new ProductException();
		}
		$products = $products->hidden(['summary']);
		return $products;
	}

	public function getOne($id){
		(new IDMustBePositiveInt())->goCheck();
		$product = Product_model::getProductDetailByID($id);
		if($product->isEmpty()){
			throw new ProductException();
		}
		$product = $product->hidden(['summary']);
		return $product;
	}
}
