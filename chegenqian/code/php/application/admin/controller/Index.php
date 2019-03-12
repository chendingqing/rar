<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 2018/7/4
 * Time: 22:43
 */
namespace app\admin\controller;

class Index extends BaseController
{
   public function index(){
       return $this->fetch();
   }
}
