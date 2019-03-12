<?php
/**
 * 省市县
 * User: wj
 * Date: 2018/9/26
 * Time: 13:58
 */
namespace app\common\logic;

use app\common\model\Region as RegionModel;

class RegionLogic extends BaseLogic{
    /**
     * 获取有的省
     * wj
     * 2018-9-26
     */
    static public function get_provicelist(){
        $map['level'] = array('eq',1);
        return RegionModel::where($map)->order('name_char asc')->select()->toArray();
    }
    /**
     * 获取有的市
     * wj
     * 2018-9-26
     */
    static public function get_citylist(){
        $map['level'] = array('eq',2);
        return RegionModel::where($map)->order('name_char asc')->select()->toArray();
    }
    /**
     * 获取有的县
     * wj
     * 2018-9-26
     */
    static public function get_countylist(){
        $map['level'] = array('eq',3);
        return RegionModel::where($map)->order('name_char asc')->select()->toArray();
    }
    /**
     * 获取下级
     * @param $pid 父id
     * wj
     * 2018-9-26
     * @return array
     */
    static public function get_sonlist($pid){
        $map['p_id'] = array('eq',$pid);
        return RegionModel::where($map)->order('name_char asc')->select()->toArray();
    }
}