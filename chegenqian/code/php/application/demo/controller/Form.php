<?php
/**
 * 表单
 * User: wj
 * Date: 2018/9/26
 * Time: 19:08
 */
namespace app\demo\controller;

use app\demo\controller\BaseController;
class Form extends BaseController
{
    /**
     * 表单元素
     * wj
     * 2018-9-26
     */
    public function index(){
        return $this->fetch();
    }
}