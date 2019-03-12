<?php
/**
 * 角色
 * User: Dell
 * Date: 2018/7/13
 * Time: 10:29
 */
namespace app\admin\validate;


class RoleValidate extends BaseValidate
{
    protected $rule = [
        'role_name' => 'require|isNotEmpty',
    ];
    protected $message   = [
        'role_name' => '角色不能为空',
    ];
}