<?php
namespace app\api\model;

use think\Model;

class BaseModel extends Model{
	//只有模型写入才可以自动生成时间
	//模型自动定义为delete_time create_time  update_time 
	//或定义 protected $createTime = 'createTimexxx'
	protected $autoWriteTimestamp = true;
	//供有需要的模型调用
	//读取配置文件中的图片url前缀 extra/setting.php 与数据库地址拼接
    //图片存放在public/images 
	protected function prefixImgUrl($value,$data){
        $value = config('setting.img_prefix').$value;
		return $value;
	}
}