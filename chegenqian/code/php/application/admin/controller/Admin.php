<?php
/**
 * 后台用户管理
 * User: Dell
 * Date: 2018/7/4
 * Time: 22:43
 */
namespace app\admin\controller;
use app\Admin\Model\Role as RoleModel;
use app\admin\model\Admin as AdminModel;
use app\admin\validate\AdminValidate;
use app\lib\page\pageUrl;
use app\admin\logic\AdminLogic as AdminLogic;

class Admin extends BaseController
{

    /**
     *添加编辑用户
     * wj
     * 2018-7-14
     */
    public function edit(){
        $request = request();
        $model = new AdminModel;
        $id = $request->param('id');
        $role_list = RoleModel::all();
        $this->assign('role_list',$role_list);
        if ($request->isPost()){//请求数据，编辑
            $validate = new AdminValidate();//验证数据合法性
            if (!$request->param("mark"))
                $validate->doCheck('edit');
            $data = $request->param();
            if (!$request->param('status'))
                $data['status'] = 0;
            if ($id){//更新
                $model->allowField(true)->save($data,['admin_id'=>$id]);
                return json(['code'=>1,'msg'=>'编辑成功']);
            }else{//新增
                //$data['password'] = md5($data['password']);
                $model->allowField(true)->save($data);
                return json(['code'=>1,'msg'=>'添加成功']);
            }
        }else{//页面展示
            $this->assign('info',$model->get($id));
            return $this->fetch();
        }
    }
    /**
     * 用户列表
     * wj
     * 2018-7-14
     * @return mixed
     */
    public function lists(){
        $result_data = AdminLogic::search();//搜索
        $map = $result_data['map'];
        $this->assign('params',$result_data['params']);
        $model = new AdminModel;
        $list = $model->where($map)->paginate(10);
        $page = new pageUrl($list->total,$list->listRows());
        $this->assign('page',$page->show());
        $this->assign('total',$list->total);
        $this->assign('list',$list);
        return $this->fetch('index');
    }
    /**
     * 修改密码
     * @return \think\response\Json
     */
    public function edit_password(){
        $request = request();
        $validate = new AdminValidate();//验证数据合法性
        $validate->doCheck('password');
        $password = $request->post('password');
        $adminModel = new AdminModel();
        $res = $adminModel->allowField(true)->save(['password'=>$password],['admin_id'=>$request->post('admin_id')]);
        if ($res){
            return json(['code'=>1,'msg'=>'修改成功']);
        }else{
            return json(['msg'=>'修改失败'],400);
        }
    }

    /*
     * 查看用户
     */
    public function show(){
        $request = request();
        $model = new AdminModel;
        $id = $request->param('id');
        $this->assign('info',$model->get($id));
        return $this->fetch();
    }
}
