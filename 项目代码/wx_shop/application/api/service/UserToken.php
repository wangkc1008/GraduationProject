<?php
namespace app\api\service;
use app\api\service\Token;
use think\Excepeion;
use app\lib\exception\WeChatException;
use app\api\model\User;
use think\Cache;
use app\lib\exception\TokenException;
use app\lib\enum\ScopeEnum;
class UserToken extends Token{

	protected $code;
	protected $appID;
	protected $appSercet;
	protected $loginUrl;

	public function __construct($code){
		$this->code = $code;
		$this->appID = config('wx.app_id');
		$this->appSercet = config('wx.app_secret');
		$this->loginUrl = sprintf(config('wx.login_url'),$this->appID,$this->appSercet,$this->code);
	}
	public function get(){
		$result = curl_get($this->loginUrl);
		$wxResult = json_decode($result,true);
		if(empty($wxResult)){
			throw new Excepeion('获取session_key和openId异常，微信内部错误');
		}else{
			//正确时errCode不存在 微信接口不标准
			//$wxResult内有微信具体错误信息异常，建议返回给客户端
			$errCode = array_key_exists('errCode', $wxResult);
			if($errCode){
				$this->processLoginError($wxResult);
			}else{
				 return $this->grantToken($wxResult);
			}
		}
	}
	//生成令牌
	private function grantToken($wxResult){
		$openid = $wxResult['openid'];
		$user = User::getUserByOpenID($openid);
		if($user){
			$uid = $user->id;
		}else{
			$uid = $this->newUser($openid);
		}
		$cachedValue = $this->prepareCachedValue($wxResult,$uid);
		return $this->saveToCache($cachedValue);
	}
	private function saveToCache($cachedValue){
		$key = self::generateToken();
		$value = json_encode($cachedValue);
		$expire_in = config('setting.token_expire_in');
		$request = cache($key,$value,$expire_in);
		if(!$request){
			throw new TokenException([
				'msg'=>'通用缓存异常',
				'errorCode'=>10005   
			]);
		}
		return $key;

	}

	private function newUser($openid){
		$user = User::create([
			'openid'=>$openid
		]);
		return $user->id;
	}
	private function prepareCachedValue($wxResult,$uid){
		$cachedValue = $wxResult;
		$cachedValue['uid'] = $uid;
		$cachedValue['scope'] = ScopeEnum::User;
		return $cachedValue;
	}
	private function processLoginError($wxResult){
		throw new WeChatException([
			'msg' => $wxResult['errmsg'],
			'errCode' =>$wxResult['errCode']
		]);
		
	}
}