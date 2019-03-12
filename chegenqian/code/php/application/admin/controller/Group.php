<?php
/**
 * 系统导航分类
 * User: Dell
 * Date: 2018/7/12
 * Time: 14:30
 */
namespace app\admin\controller;
use app\admin\model\Group as GroupModel;
use app\admin\validate\GroupValidate;
use app\lib\page\pageUrl;
class Group extends BaseController
{
    /**
     * 分类列表
     * @return mixed
     */
    public function group_list(){
        $model = new GroupModel;
        $list = $model->paginate(6);
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
    public function group_edit(){
        $request = request();
        $groupModel = new GroupModel();
        $group_id = $request->param('id');
        if ($request->isPost()) {//请求数据，编辑
            $validate = new GroupValidate();//验证数据合法性
            $validate->goCheck();
            $data = $request->param();
            if ($group_id){//更新
                $groupModel->allowField(true)->save($data,['group_id'=>$group_id]);
            }else{//新增
                $groupModel->allowField(true)->save($data);
            }
            return json(['code'=>1,'msg'=>'编辑成功']);
        }else{
            $this->assign('info',$groupModel->get($group_id));
            return  $this->fetch();
        }
    }
}