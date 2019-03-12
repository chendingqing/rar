<?php
/**
 * 公用的
 * User: Dell
 * Date: 2018/7/14
 * Time: 14:33
 */
namespace app\lib\exception;


class CommonException extends BaseException
{
    public $code = 400;
    public $msg = '参数错误';
    public $errorCode = 10000;
}