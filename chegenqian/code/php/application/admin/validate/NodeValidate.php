<?php
/**
 * 节点
 * User: Dell
 * Date: 2018/7/13
 * Time: 12:21
 */
namespace app\admin\validate;


class NodeValidate extends BaseValidate
{
    protected $rule = [
        'node_name' => 'require|isNotEmpty',
    ];
    protected $message   = [
        'node_name' => '节点名称不能为空',
    ];
}