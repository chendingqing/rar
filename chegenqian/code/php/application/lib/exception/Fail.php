<?php
/**
 * 内容流程错误
 * User: wj
 * Date: 2018/9/12
 * Time: 10:31
 */
namespace app\lib\exception;


class Fail extends BaseException{
    // HTTP 状态码 404,200
    public $http_code = 200;
    // 错误具体信息
    public $msg = '操作失败';
    // 自定义的错误码
    public $code = 0;
    public $error_type = 'json';
    public $is_show_web = false;
}