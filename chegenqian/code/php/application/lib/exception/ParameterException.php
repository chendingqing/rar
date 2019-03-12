<?php
/**
 * 验证器错误返回
 * Author: wj
 * Date: 2017/5/2
 * Time: 2:15
 */

namespace app\lib\exception;


class ParameterException extends BaseException
{
    public $http_code = 200;
    public $msg = '参数错误';
    public $code = 0;
}