<?php
namespace app\api\controller\v1;

use app\api\controller\BaseController;
use think\Request;
use app\api\model\User as UserModel;
use app\api\validate\AddressNew;
use app\lib\exception\UserException;
use app\api\service\Token as TokenService;
use app\lib\exception\SuccessMessage;
use app\api\model\UserAddress;

class Address extends BaseController{

	protected $beforeActionList = [
		'checkPrimaryScope' => ['only'=>'createOrUpdateAddress,getUserAddress']
	];
	/*
	protected $beforeActionList = [
		'first' => ['only' => 'second']
	];
	protected function first(){
		echo 'first';
	}

	public function second(){
		echo " second";
	}*/

	/**
     * 获取用户地址信息
     * @return UserAddress
     * @throws UserException
     */
    public function getAddress(){
        $uid = TokenService::getCurrentUid();
        $userAddress = UserAddress::where('user_id', $uid)
            ->find();
        if(!$userAddress){
            throw new UserException([
               'msg' => '用户地址不存在',
                'errorCode' => 60001
            ]);
        }
        return $userAddress;
    }

	public function handleAddress(){
		$validate = new AddressNew();
		$validate->goCheck();
		
		//从当前用户token中获得用户uid
		$uid = TokenService::getCurrentUid();
		//根据用户uid获得用户模型
		$user = UserModel::get($uid);
		if(!$user){
			throw new UserException([
				'code' => 404,
				'msg' => '用户信息不存在',
				'errorCode' => 60001
			]);
		}
		//获得当前用户user_address表中的地址信息
		$userAddress = $user->address;
		//通过验证器获得传来的用户地址信息 保证数据的合法性
		$data = $validate->getDataByRule(input('post.'));
		if(!$userAddress){
			//新增的save来自关联关系
			$user->address()->save($data); 
		}else{
			//更新的save来自模型
			$user->address->save($data);
		}
		return new SuccessMessage();
	}
}