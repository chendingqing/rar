<?php
/**
 * 清除缓存
 * User: wj
 * Date: 2018/9/12
 * Time: 18:02
 */
namespace app\admin\controller;

use think\Cache;
use think\Session;

class Clearcache extends BaseController{
    /**
     * 清除缓存
     * wj
     * 2018-9-12
     */
    public function index(){
        Cache::clear();//清除
        Session::delete('node_access');//删除session中的权限
        Session::delete('menu_list');//删除session 中的 菜单
        return json(['code'=>1,'msg'=>'缓存清除成功']);
    }
}