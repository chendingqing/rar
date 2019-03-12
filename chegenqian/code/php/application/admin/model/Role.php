<?php
/**
 * 角色
 * User: Dell
 * Date: 2018/7/13
 * Time: 10:27
 */
namespace app\admin\model;

class Role extends BaseModel
{
    protected $resultSetType = 'collection';
    protected $autoWriteTimestamp = true;
    public function node(){
        return $this->belongsToMany('Node','access','node_id','role_id');
    }
}