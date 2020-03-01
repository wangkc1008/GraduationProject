<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// return [
//     '__pattern__' => [
//         'name' => '\w+',
//     ],
//     '[hello]'     => [
//         ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
//         ':name' => ['index/hello', ['method' => 'post']],
//     ],

// ];
use think\Route;
//对多版本支持
Route::get('api/:version/banner/:id','api/:version.Banner/getBanner');
// Route::get('api/:version/theme/','api/:version.Theme/getSimpleList');
// Route::get('api/:version/theme/:id','api/:version.Theme/getComplexOne');
// Theme
Route::group('api/:version/theme',function(){
	Route::get('/','api/:version.Theme/getSimpleList');
	Route::get('/:id','api/:version.Theme/getComplexOne');
});
//id为正整数，正则表达式
// Route::get('api/:version/product/:id','api/:version.Product/getOne',[],['id'=>'\d+']);
// Route::get('api/:version/product/all/','api/:version.Product/getALLByCategoryID');
// Route::get('api/:version/product/recent/','api/:version.Product/getRecent');
//Products
Route::group('api/:version/product',function(){
	Route::get('/:id','api/:version.Product/getOne',[],['id'=>'\d+']);
	Route::get('/by_category/','api/:version.Product/getProducts');
	Route::get('/recent/','api/:version.Product/getRandom');
});
Route::get('api/:version/category/all/','api/:version.Category/getALLCategories');
//Token
Route::post('api/:version/token/user/','api/:version.Token/getToken');
Route::post('api/:version/token/verify/','api/:version.Token/verifyToken');
Route::post('api/:version/token/app','api/:version.Token/getAppToken');
//Address
Route::post('api/:version/address/','api/:version.Address/handleAddress');
Route::get('api/:version/address', 'api/:version.Address/getAddress');
//Orders
Route::group('api/:version/order',function(){
	Route::post('/save','api/:version.Order/placeData');
	Route::get('/by_user','api/:version.Order/getSummaryByUser');
	Route::get('/details/:id','api/:version.Order/getDetailsByID',[],['id'=>'\d+']);
	Route::get('/paginate','api/:version.Order/getSummary');
	Route::put('/delivery','api/:version.Order/delivery');
});
//Pay
Route::post('api/:version/pay/pre_order', 'api/:version.Pay/getPreOrder');
Route::post('api/:version/pay/notify', 'api/:version.Pay/receiveNotify');

// Route::rule('路由表达式','路由地址','请求类型','路由参数（数组）','变量规则（数组）');
// //请求类型 GET POST DELETE PUT *
// Route::rule('hello','sample/Test/hello','GET|POST',['https'=>false]);
// Route::get('hello','sample/Test/hello');
// Route::any()   //*
// Route::get('api/:version/address/second/','api/:version.Address/second');