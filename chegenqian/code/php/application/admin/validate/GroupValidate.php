<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 2018/7/7
 * Time: 16:12
 */
namespace app\admin\validate;


class GroupValidate extends BaseValidate
{
    protected $rule = [
        'group_name' => 'require|isNotEmpty',
    ];
    protected $message   = [
        'group_name' => '分类名称不能为空',
    ];
}