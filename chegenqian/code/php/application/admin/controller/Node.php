<?php
/**
 * 节点
 * User: Dell
 * Date: 2018/7/13
 * Time: 12:17
 */
namespace app\admin\controller;
use app\admin\model\Node as NodeModel;
use app\lib\page\pageUrl;
use app\admin\validate\NodeValidate;
use app\admin\model\Group as GroupModel;
use think\Session;
use Think\Cache;

class Node extends BaseController
{
    /**
     * 列表
     * @return mixed
     */
    public function lists(){
        $model = new NodeModel;
        $list = $model->order('node_url asc')->paginate(50);
        $page = new pageUrl($list->total,$list->listRows());
        $this->assign('page',$page->show());
        $this->assign('total',$list->total);
        $this->assign('list',$list);
        return $this->fetch();
    }
    /**
     * 编辑
     * @return mixed
     */
    public function edit(){
        $request = request();
        //获取组列表
        $group_list = GroupModel::all();
        $this->assign('group_list',$group_list);
        $model = new NodeModel();
        $id = $request->param('id');
        if ($request->isPost()) {//请求数据，编辑
            $validate = new NodeValidate();//验证数据合法性
            $validate->goCheck();
            $data = $request->param();
            if ($id){//更新
                $model->allowField(true)->save($data,['node_id'=>$id]);
            }else{//新增
                $model->allowField(true)->save($data);
            }
            $this->clear_cache();//清除缓存和session
            return json(['code'=>1,'msg'=>'编辑成功']);
        }else{
            $this->assign('info',$model->get($id));
            return  $this->fetch();
        }
    }

}