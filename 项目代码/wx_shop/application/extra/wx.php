<?php

return [
	// 小程序app_id
	'app_id' => 'wx8bffa7527149d83a',
	// 小程序app_secret
	'app_secret' => '28b7c10720a5680fcc1ff42823ce0cad',
	// 微信使用code换取用户openid及session_key的url地址
	'login_url' => "https://api.weixin.qq.com/sns/jscode2session?" .
        "appid=%s&secret=%s&js_code=%s&grant_type=authorization_code",
    // 微信获取access_token的url地址
    'access_token_url' => "https://api.weixin.qq.com/cgi-bin/token?" .
        "grant_type=client_credential&appid=%s&secret=%s"
];