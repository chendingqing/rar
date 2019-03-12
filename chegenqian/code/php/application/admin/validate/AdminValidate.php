<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 2018/7/5
 * Time: 9:01
 */
namespace app\admin\validate;


class AdminValidate extends BaseValidate
{
    protected $rule = [
        'admin_id'=>'',
        'username|用户名' => '',
        'password|用户密码' => '',
        'confirm_password'=>'',
        'role_id' => '',
        'province' => 'require|isNotEmpty',
        'city' => 'require|isNotEmpty',
        'country' => 'require|isNotEmpty',
        'detail' => 'require|isNotEmpty',
        'captcha|验证码'=>'require|captcha'
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
}