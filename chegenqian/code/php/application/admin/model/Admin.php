<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 2018/7/13
 * Time: 19:27
 */
namespace app\admin\model;

class Admin extends BaseModel
{
    protected $resultSetType = 'collection';
    public function role(){
        return $this->hasOne('Role','role_id','role_id');
    }
    public function setPasswordAttr($value)
    {
        return md5($value);
    }
}