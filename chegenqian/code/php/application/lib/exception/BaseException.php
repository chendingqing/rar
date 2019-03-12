<?php
/**
 * Created by wj
 * Author: wj
 * Date: 2018/9/12
 */

namespace app\lib\exception;


use think\Exception;

class BaseException extends Exception
{
    // HTTP 状态码 404,200
    public $http_code = 400;
    // 错误具体信息
    public $msg = '参数错误';
    // 自定义的错误码
    public $code = 0;
    public $error_type = 'json';
    public $is_show_web = false;

    public function __construct($params = []){
        if( !is_array($params)){
            return ;
        }
        if(array_key_exists('http_code',$params)){
            $this->http_code = $params['http_code'];
        }
        if(array_key_exists('msg',$params)){
            $this->msg = $params['msg'];
        }
        if(array_key_exists('code',$params)){
            $this->code = $params['code'];
        }
        if(array_key_exists('error_type',$params)){
            $this->error_type = $params['error_type'];
        }
        if(array_key_exists('is_show_web',$params)){
            $this->is_show_web = $params['is_show_web'];
        }
    }

}