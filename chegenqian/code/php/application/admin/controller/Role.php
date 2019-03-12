<?php
/**
 * 角色
 * User: Dell
 * Date: 2018/7/13
 * Time: 10:26
 */
namespace app\admin\controller;
use app\admin\logic\NodeLogic;
use app\admin\model\Access;
use app\admin\model\Role as RoleModel;
use app\admin\model\Access as AccessModel;
use app\admin\validate\RoleValidate;
use app\admin\logic\RoleLogic as RoleLogic;
use app\lib\page\pageUrl;

class Role extends BaseController
{
    /**
     * 分类列表
     * @return mixed
     */
    public function role_list(){
        $model = new RoleModel;
        $list = $model->paginate(10);
        $page = new pageUrl($list->total,$list->listRows());
        $this->assign('page',$page->show());
        $this->assign('total',$list->total);
        $this->assign('list',$list);
        return $this->fetch();
    }
    /**
     * 分类编辑
     * @return mixed
     */
    public function role_edit(){
        $request = request();
        $roleModel = new RoleModel();
        $role_id = $request->param('role_id');
        if(!$role_id)
            $role_id = $request->param('id');
        if ($request->isPost()) {//请求数据，编辑
            $validate = new RoleValidate();//验证数据合法性
            if (!$request->param("mark"))
                $validate->goCheck();
            $data = $request->param();
            if (!$request->param('status'))
                $data['status'] = 0;
            if ($role_id){//更新
                $roleModel->allowField(true)->save($data,['role_id'=>$role_id]);
                return json(['code'=>1,'msg'=>'编辑成功']);
            }else{//新增
                $roleModel->allowField(true)->save($data);
                return json(['code'=>1,'msg'=>'添加成功']);
            }

        }else{
            $this->assign('info',$roleModel->get($role_id));
            return  $this->fetch('edit');
        }
    }
    /**
     * 为角色设置节点
     * @return bool|mixed|\think\response\Json
     */
    public function set_node(){
        $request = request();
        $role_id = $request->param('role_id');
        $node_ids = $request->param('node_ids/a');
        if ($request->isPost()) {//请求数据，编辑
            if ($role_id){
                AccessModel::where('role_id','=',$role_id)->delete();
            }
            if (empty($node_ids)){
                fail_return(['msg'=>'编辑失败']);
            }
            foreach($node_ids as $k=>$v){
                $data[$k]['node_id'] = $v;
                $data[$k]['role_id'] = $role_id;
            }
            $accessModel = new AccessModel();
            $accessModel->saveAll($data);
            return json(['code'=>1,'msg'=>'编辑成功']);
        }else{//页面展示
            $nodeModel = new NodeLogic();
            $list = $nodeModel->group_node();
            $this->assign('role_id',$role_id);
            $this->assign('list',$list);
            return  $this->fetch();
        }
    }

}