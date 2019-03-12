<?php
/**
 * 省市县相关
 * User: wj
 * Date: 2018/9/26
 * Time: 19:12
 */
namespace app\common\controller;

use app\common\controller\BaseController;
use app\common\logic\RegionLogic;

class Region extends BaseController
{
    /**
     * 3级联动
     * wj
     * 2018-9-26
     */
    public function linkage(){
        echo 111;exit;
        $request = request();
        $pid = $request->post('pid');
        $data = RegionLogic::get_sonlist($pid);
        success_return(['data'=>$data]);
    }
}
