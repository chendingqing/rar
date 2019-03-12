<?php
/**
 * 节点
 * User: Dell
 * Date: 2018/7/13
 * Time: 10:46
 */
namespace app\admin\model;

class Node extends BaseModel
{
    protected $resultSetType = 'collection';
    protected $autoWriteTimestamp = true;
    public function group(){
        return $this->belongsTo('Group','group_id','group_id');

    }
    public function roles(){
        return $this->belongsToMany('Role','Access','role_id','node_id');
    }

}