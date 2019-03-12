<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 2018/7/7
 * Time: 16:11
 */
namespace app\admin\model;

class Group extends BaseModel
{
    protected $resultSetType = 'collection';
    protected $autoWriteTimestamp = true;
    public function node(){
        return $this->hasMany('Node','group_id','group_id');
    }
}