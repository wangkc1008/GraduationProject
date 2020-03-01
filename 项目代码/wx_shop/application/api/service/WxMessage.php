<?php
namespace app\api\service;
use app\api\service\AccessToken;
use think\Exception;

class WxMessage{

	private $sendUrl = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?" .
    "access_token=%s";
    private $touser;
    //不让子类控制颜色
    private $color = 'black';
    
    protected $tplID;
    protected $page;
    protected $formID;
    protected $data;
    protected $emphasisKeyWord;

    function __construct(){
    	$accessToken = new AccessToken();
    	$token = $accessToken->get();
    	$this->sendUrl = sprintf($this->sendUrl,$token);
    }

    public function sendMessage($openID){
    	$data = [
            'touser' => $openID,
            'template_id' => $this->tplID,
            'page' => $this->page,
            'form_id' => $this->formID,
            'data' => $this->data,
//            'color' => $this->color,
            'emphasis_keyword' => $this->emphasisKeyWord
        ];
        $result = curl_post($this->sendUrl,$data);
        $result = json_decode($result,true);
        if($result['errCode'] == 0){
        	return true;
        }else{
        	throw new Exception('模板消息发送失败,  ' . $result['errmsg']);
        }
    }
}