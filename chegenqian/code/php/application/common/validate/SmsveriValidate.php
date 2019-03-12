<?php
/**
 * 短信相关
 * User: wj
 * Date: 2018/10/8
 * Time: 11:43
 */
namespace app\common\validate;


class SmsveriValidate extends BaseValidate
{
    protected $rule = [
        'mobile' => 'require|isNotEmpty|isMobile',
    ];
    protected $message   = [
        'mobile' => '手机号码格式错误',
    ];
}