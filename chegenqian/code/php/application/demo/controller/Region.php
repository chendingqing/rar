<?php
/**
 * 省市县相关
 * User: wj
 * Date: 2018/9/26
 * Time: 18:56
 */
namespace app\demo\controller;

use app\common\logic\RegionLogic;
use app\demo\controller\BaseController;

class Region extends BaseController
{
    /**
     * 3级联动
     * wj
     * 2018-9-26
     */
    public function linkage(){
        $request = request();
        if ($request->isAjax()){
            $pid = $request->post('pid');
            $data = RegionLogic::get_sonlist($pid);
            success_return(['data'=>$data]);
        }
        $provice_list = RegionLogic::get_provicelist();//获取所有的省
        $this->assign('provice_list',$provice_list);
        return $this->fetch();
    }
}
