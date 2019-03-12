<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 2018/7/5
 * Time: 9:01
 */
namespace app\admin\validate;


class WjValidate extends BaseValidate
{
    protected $rule = [
        'username' => 'require',
        'password' => 'require',
        'sort|is_display|status'=>'require|number|between:1,100',
        'email'=>'require|email',
        'ip'=>'require|ip',
    ];
    protected $scene = [
        'login'  =>  ['username'=>'require','password'=>'require','captcha'=>'require|captcha'],//登录验证
        'edit'  =>   ['username'=>'require|isNotEmpty','role_id'=>'require'],//编辑
        'password'=> ['password'=>'require|isNotEmpty','confirm_password'=>'require|isNotEmpty|check_password','admin_id'=>'require|isNotEmpty'],//编辑
    ];

    /**
     * 检查密码是否一样
     * @param $value
     * @param $rule
     * @param $data
     * @return bool|string
     */
    public function check_password($value,$rule,$data){
        if ($data['confirm_password'] !=$data['password']){
            return '两次密码不一致';
        }
        return true;
    }
    protected $message   = [
        'username' => 'username错误',
        'password' => 'password错误',
        'sort' => 'sort错误',
        'is_display' => 'is_display错误',
        'status' => 'status错误',
        'email' => 'email错误',
        'ip' => 'ip错误',

    ];
}