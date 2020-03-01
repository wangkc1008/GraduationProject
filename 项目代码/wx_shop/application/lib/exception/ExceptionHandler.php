<?php
namespace app\lib\exception;
use Exception;
use think\exception\Handle;
use think\Request;
use think\Log;
class ExceptionHandler extends Handle{
	private $code;
	private $msg;
	private $errCode;
	//url路径

    //对所有异常渲染
    //\Exception位于根命名空间
	public function render(Exception $e){
		if($e instanceof BaseException){
		    //返回给客户端自定义异常格式 方便客户端反馈错误 不记录日志
            $this->msg = $e->msg;
            $this->code = $e->code;
            $this->errCode = $e->errorCode;
        }else{
		    //服务器内部错误 记录日志
		    if(config('app_debug')){
		    	//系统开发 调试模式打开 tp5默认render 方便开发者调试 
		    	return parent::render($e);
		    }else{
		    	//系统上线 调试模式关闭 不让客户端知道错误详情 
		    	$this->msg = 'Service system inner error';
	            $this->code = 500;
	            $this->errCode = 999;
	            $this->recordErrorLog($e);
		    }
            
        }
        //获得当前出现异常的url路径
        $request = Request::instance();
        $result = [
            'errCode' => $this->errCode,
		    'msg' => $this->msg,
		    'request_url' => $request->url()
        ];
		return json($result,$this->code);

	}
	//自定义日志记录异常
	private function recordErrorLog(Exception $e){
		//日志初始化
		Log::init([
			'type' => 'File',
			'path' => LOG_PATH,
			'level' => ['error']
		]);
		Log::record($e->getMessage(),'error');
	}
}