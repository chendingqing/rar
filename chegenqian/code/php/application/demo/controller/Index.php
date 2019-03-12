<?php
/**
 * 首页
 * User: wj
 * Date: 2018/9/26
 * Time: 18:56
 */
namespace app\demo\controller;

use app\demo\controller\BaseController;

class Index extends BaseController
{
    /**
     * 3级联动
     * wj
     * 2018-9-26
     */
    public function index(){

        return $this->fetch();
    }
}
