<?php
/**
 * 用户
 * User: Dell
 * Date: 2018/7/14
 * Time: 12:02
 */
namespace app\admin\logic;
use app\admin\validate\AdminValidate;
use app\admin\model\Admin as AdminModel;

class AdminLogic extends BaseLogic{
    /**
     * 用户登录
     * wj
     * 2018-7-14
     */
    public function login(){
        $request = request();
        $validate = new AdminValidate();
        $validate->doCheck('login');//验证
        $username = $request->post('username');
        $password = $request->post('password');
        $user = AdminModel::get(['username'=>$username]);
        if (empty($user)){//用户不存在
            fail_return(['msg'=>'用户不存在']);
        }
        if (empty($password)){//用户不存在
            fail_return(['msg'=>'密码不能为空']);
        }
        if($user->status !=1){//用户被禁用
            fail_return(['msg'=>'用户被冻结']);
        }
        if ($user->password != md5($password)){//密码错误
            fail_return(['msg'=>$password.'密码错误'.$username.md5($password)]);
        }
        $user->last_login_time = time();//修改登录时间
        $user->save();
        $data = $user->visible(['admin_id','username','role_id'])->toArray();
        session('user_info',$data);
        return json(['msg'=>'登录成功','code'=>1,'url'=>url('Index/index')],200);
    }

    /**
     * 用户搜索
     * efoam
     * 2018-9-13
     */
    static public function search(){
        $map = [];
        $request = request();
        $params = [];
        $params['startTime'] = $startTime = $request->param('startTime');//商品名称
        $params['endTime'] = $endTime = $request->param('endTime');//类型
        $params['artName'] = $username = $request->param('artName');//类型
        $username ? $map['username'] = array('like','%'.$username.'%') : '';
        $startTime ? $map['create_time'] = array('> time',$startTime) : '';
        $endTime ? $map['create_time'] = array('< time',$endTime) : '';
        $result_data['map'] = $map;
        $result_data['params'] = $params;
        return $result_data;
    }
}