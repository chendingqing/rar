<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 2018/7/4
 * Time: 22:43
 */
namespace app\admin\controller;
use app\admin\logic\NodeLogic;
use Think\Cache;
use think\Controller;
use app\admin\logic\AccessLogic;

class BaseController extends Controller
{
    public $model_name;
    protected $beforeActionList = [
        'check_model' =>  ['only'=>'sort_by_id,del_by_id,char_by_id,display_by_id,status_by_id'],//检查模型的合法性
        'init'
    ];

    /**
     * 初始化
     * wj
     * 2018-7-13
     */
    public function init(){
        $user_info = session('user_info');
        if (empty($user_info)){
            $this->redirect('Login/index');
        }
        $accesslogic = new AccessLogic();
        $nodeLogic = new NodeLogic();
        $nodeLogic->check_node_url();//将新节点加入数据库
        $this->assign('menu',$accesslogic->get_menu());//获取菜单
        $node_info = $nodeLogic->get_targ();
        $this->assign('targ',$node_info['tag']);//获取targ
        $this->assign('node_id',$node_info['node_id']);//获取targ
        $access = $accesslogic->check_access();//检查权限

    }

    /**
     * @throws \app\lib\exception\ModelException
     * 检查model是否合法
     */
    public  function check_model(){
        $request  = request();
        $model = $request->param('model');
        if (empty($model)){
            $model = $request->controller();
        }
        $model_string = '\app\admin\model\\'.$model;
        if (!class_exists($model_string)) {//模型不存在
            fail_return(['msg'=>'模型不存在']);
        }
        $this->model_name = $model_string;
    }
    /**
     * 排序（根据主键）
     * wj
     * 2018-7-5
     */
    public function sort_by_id(){
        $request  = request();
        $model_name = $this->model_name;
        $model = $model_name::get($request->param('id'));
        $model->sort = $request->param('sort');
        $res = $model->allowField(true)->save();
        if ($res) {
            return json(['msg'=>'修改成功','code'=>1]);
        } else {
            fail_return();
        }
    }
    /**
     * 显示/隐藏（根据主键）
     * wj
     * 2018-7-5
     */
    public function display_by_id(){
        $request  = request();
        $model_name = $this->model_name;
        $model = $model_name::get($request->param('id'));
        if ($model->is_display ==1 ){
            $is_display = 0;
        }else{
            $is_display = 1;
        }
        $model->is_display = $is_display;
        $res = $model->allowField(true)->save();
        if ($res) {
            return json(['msg'=>'修改成功','code'=>1]);
        } else {
            fail_return();
        }
    }
    /**
     * 显示/隐藏（根据主键）
     * wj
     * 2018-7-5
     */
    public function status_by_id(){
        $request  = request();
        $model_name = $this->model_name;
        $model = $model_name::get($request->param('id'));
        if ($model->status ==1 ){
            $value = 0;
        }else{
            $value = 1;
        }
        $model->status = $value;
        $res = $model->allowField(true)->save();
        if ($res) {
            return json(['msg'=>'修改成功','code'=>1]);
        } else {
            fail_return();
        }
    }
    /**
     * 删除（根据主键）
     * wj
     * 2018-7-5
     */
    public function del_by_id(){
        $request = request();
        $model_name = $this->model_name;
        $res =$model_name::destroy($request->param('ids'));
        if ($res) {
            if ($model_name =='\app\admin\model\Node'){//如果是删除了节点，需要清空节点相关缓存
                $this->clear_cache();
            }
            return json(['msg'=>'修改成功','code'=>1]);
        } else {
            fail_return();
        }
    }
    /**
     * 修改某个字段（根据主键）
     * wj
     * 2018-7-5
     */
    public function char_by_id(){
        $request  = request();
        $model_name =$this->model_name;
        $id = $request->param('id');
        $char = $request->param('char');
        $char_val = $request->param('char_val');
        $model = $model_name::get($id);
        $model->$char = $char_val;
        $res = $model->allowField(true)->save();
        if ($res) {
            return json(['msg'=>'修改成功','code'=>1]);
        } else {
            fail_return();
        }
    }

    /**
     * 清除缓存
     * wj
     * 2018-9-14
     */
    public function clear_cache(){
        Cache::rm('node_mark');//删除缓存的节点数据
        Session::delete('node_access');//删除session中的权限
        Session::delete('menu_list');//删除session 中的 菜单
    }
}
