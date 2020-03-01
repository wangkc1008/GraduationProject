<?php
namespace app\api\controller\v1;

use think\Controller;
use app\api\validate\GetToken;
use app\api\validate\AppTokenGet;
use app\api\service\UserToken;
use app\api\service\Token as TokenService;
use app\api\service\AppToken;
use app\lib\exception\ParameterException;

class Token extends Controller{

	public function getToken($code=''){
		
		(new GetToken())->goCheck();
		$user = new UserToken($code);
		$token = $user->get();
		return [
			'token'=>$token
		];
	}

	public function getAppToken($ac='',$se=''){
		$app = new AppToken();
		$token = $app->get($ac,$se);
		return [
			'token'=>$token
		];
	}
	public function verifyToken($token='')
    {
        if(!$token){
            throw new ParameterException([
                'token不允许为空'
            ]);
        }
        $valid = TokenService::verifyToken($token);
        return [
            'isValid' => $valid
        ];
    }
}