<?php
namespace app\api\service;

use app\lib\Exception\TokenException;
use think\Exception;
use think\Cache;

class AccessToken{
	//获取access_token的api
	private $tokenUrl;
	//存到缓存
	const TOKRN_CACHED_KEY = 'access';
	//过期时间小于微信服务器中的过期时间7200
	const TOKEN_EXPIRE_IN = 7000;

	function __construct(){
		$url = config('wx.access_token_url');
		$url = sprintf($url,config('wx.app_id'),config('wx.app_secret'));
		$this->tokenUrl = $url;
	}

	public function get(){
		$token = $this->getFromCache();
		if(!$token){
			return $this->getFromServer();
		}else{
			return $token;
		}
	}

	private function getFromCache(){
		$token = cache(self::TOKRN_CACHED_KEY);
		if(!$token){
			return null;
		}
		return $token;
	}

	private function getFromServer(){
		$token = curl_get($this->tokenUrl);
		$token = json_decode($token,true);
		if(!$token){
			throw new TokenException('获取AccessToken异常');
		}
		if(!empty($token['errCode'])){
			throw new Exception($token['errmsg']);
		}
		$this->saveToCache($token['access_token']);
		return $token['access_token'];
	}

	private function saveToCache($token){
		$key = self::TOKRN_CACHED_KEY;
		$value = $token;
		$expire_in = self::TOKEN_EXPIRE_IN;
		$request = cache($key,$value,$expire_in);
		if(!$request){
			throw new TokenException([
				'msg'=>'通用缓存异常',
				'errorCode'=>10005   
			]);
		}
	}
}