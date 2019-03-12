<?php
/**
 * 系统导航分类
 * User: Dell
 * Date: 2018/7/12
 * Time: 14:30
 */
namespace app\admin\controller;
use app\admin\model\Wj as WjModel;
use app\admin\validate\WjValidate;
use app\admin\logic\WjLogic;
use app\lib\page\pageUrl;
class Wj extends BaseController
{
    /**
     * 分类列表
     * @return mixed
     */
    public function index(){

        $model = new WjModel();
        $result_data = WjLogic::search();//搜索
        $map = $result_data['map'];
        $this->assign('params',$result_data['params']);
        $list = $model->where($map)->paginate(10);
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
    public function edit(){

        $status_array = ['撇','好','非常好','牛b'];
        $this->assign('status_array',$status_array);
        $request = request();
        $model = new WjModel();
        $id = $request->param('id');
        if ($request->isPost()) {//请求数据，编辑
            $validate = new WjValidate();//验证数据合法性
            $validate->goCheck();
            $data = $request->param();
            if ($id){//更新
                $res = $model->allowField(true)->save($data,['id'=>$id]);
            }else{//新增
                $res = $model->allowField(true)->save($data);
            }
            if ($res){
                return json(['code'=>1,'msg'=>'编辑成功']);
            }
            fail_return(['msg'=>'编辑失败']);
        }else{
            $this->assign('info',$model->get($id));
            return  $this->fetch();
        }
    }
}