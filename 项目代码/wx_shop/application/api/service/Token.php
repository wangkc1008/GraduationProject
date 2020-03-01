<?php
namespace app\api\service;
use think\Request;
use think\Cache;
use app\lib\exception\TokenException;
use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
class Token{
	
	public static function generateToken(){
		$randChars = getRandChars(32);
		$dateStamp = $_SERVER['REQUEST_TIME_FLOAT'];
		$salt = config('secure.token_salt');
		return md5($randChars.$dateStamp.$salt);
	}

	public static function getCurrentUid(){
		$uid = self::getCurrentTokenVar('uid'); 
		return $uid;
	}

	public static function getCurrentTokenVar($key){
		$token = Request::instance()->header('token');
		$var = Cache::get($token);
		if(!$var){
			throw new TokenException();
		}else{
			if(!is_array($var)){
				$var = json_decode($var,true);
			}
			if(array_key_exists($key,$var)){
				return $var[$key];
			}else{
				throw new Excepeion('尝试获取的Token变量并不存在');
			}
		}

	}
	//用户和管理员都可以访问的权限控制
	public static function needPrimaryScope(){
		$scope = self::getCurrentTokenVar('scope');
		if($scope){
			if($scope >= ScopeEnum::User){
				return true;
			}else{
				throw new ForbiddenException();
			}
		}else{
			throw new TokenException();
		}
	}
	//仅有用户可以访问的权限控制
	public static function needExclusiveScope(){
		$scope = self::getCurrentTokenVar('scope');
		if($scope){
			if($scope == ScopeEnum::User){
				return true;
			}else{
				throw new ForbiddenException();
			}
		}else{
			throw new TokenException();
		}
	}

	public static function isValidOperate($checkedUID){
		if(!$checkedUID){
			throw new Excepeion('检查时请传入uid');
		}
		$currentUid = self::getCurrentUid();
		if($currentUid == $checkedUID){
			return true;
		}
		return false;

	}

	public static function verifyToken($token)
    {
        $exist = Cache::get($token);
        if($exist){
            return true;
        }
        else{
            return false;
        }
    }


}