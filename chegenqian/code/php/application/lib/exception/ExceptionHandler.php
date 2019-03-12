<?php
/**
 * Created by wj.
 * Author: wj
 * Date: 2017/4/24
 * Time: 3:33
 */

namespace app\lib\exception;

use think\Exception;
use think\exception\Handle;
use think\Request;
use think\Db;

class ExceptionHandler extends Handle
{

    private $http_code;
    private $msg;
    private $code;
    private $is_show_web;

    // 需要返回客户端当前请求的URL路径

    public function render(\Exception $e){

        if ($e instanceof BaseException){//如果是自定义的异常

            $this->http_code = $e->http_code;
            $this->msg = $e->msg;
            $this->code = $e->code;
            $this->is_show_web = $e->is_show_web;
        }else{//服务器内部异常，通常代码报错
            $this->http_code = 500;
            $this->msg = '服务器内部错误';
            $this->code = 999;
            $this->is_show_web = true;
        }
        $request = Request::instance();
        if (config('exception.log_is_insert')){//将错误信息记录到数据库
            $data['error_msg'] = $e->getMessage().'|'.$this->msg;
            $data['error_file'] = $e->getFile();
            $data['error_line'] = $e->getLine();
            $data['code'] =  $this->http_code;
            $data['error_code'] =  $this->code;
            $data['url'] =  $request->url();
            $data['create_time'] = time();
            Db::name('server_error')->insert($data);
        }
        $result = [
            'msg' => $this->msg,
            'code' => $this->code,
            'url' => $request->url(),
        ];
        if ($request->isAjax()){//是ajax 返回json
            return json($result, $this->http_code);
        }
        if ($this->is_show_web){//显示页面
            return parent::render($e);
        }else{//返回json
            return json($result, $this->http_code);
        }
    }
}