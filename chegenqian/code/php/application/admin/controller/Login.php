<?php
namespace app\admin\controller;
use app\admin\logic\AdminLogic;
use think\Controller;
use think\Session;
class Login extends Controller
{
    /**
     * 登录
     * @return mixed
     * wj
     * 2018-7-14
     */
    public function index(){
        $user_info = session('user_info');
        if (!empty($user_info)){
            $this->redirect('Index/index');
        }
        $request = request();
        if ($request->isPost()){
            $adminLogic = new AdminLogic();
            return $adminLogic->login();
        }else{
            return $this->fetch('login');
        }
    }

    /**
     * 退出登录
     * wj
     * 2018-7-14
     */
    public function login_out(){
        Session::flush();
        Session::clear();
        $this->redirect('index');
    }
}
