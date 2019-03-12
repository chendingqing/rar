<?php
/**
 * 短信验证码
 * User: wj
 * Date: 2018/10/8
 * Time: 11:43
 */
namespace app\common\validate;


class SmslogValidate extends BaseValidate
{
    protected $rule = [
        'sms_phone' => 'require|isNotEmpty|isMobile',
        'sms_code'=>'require|isNotEmpty',
    ];
    protected $message   = [
        'sms_phone.require' => '手机号码不能为空',
        'sms_phone.isNotEmpty' => '手机号码不能为空',
        'sms_phone.isMobile' => '手机号码格式错误',
        'sms_code' => '验证码不能为空',
    ];
}