<?php
/**
 * 图片保存
 * User: wj
 * Date: 2018/7/13
 * Time: 12:21
 */
namespace app\admin\validate;


class ImageList extends BaseValidate
{
    protected $rule = [
        'image_list' => 'require|isNotEmpty|checkImageList',
        'relation_id' => 'require|is_number',
        'image_type' => 'require|is_number',
    ];
    protected $message   = [
        'image_list' => '图片不能为空',
        'relation_id' => '管理id必须为正整数',
        'image_type' => '图片类型必须为正整数',
    ];
}