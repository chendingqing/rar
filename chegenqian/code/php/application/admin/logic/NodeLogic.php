<?php
/**
 * 节点
 * User: Dell
 * Date: 2018/7/12
 * Time: 14:30
 */
namespace app\admin\logic;
use app\admin\model\Group as GroupModel;
use app\admin\model\Group;
use app\admin\model\Node as NodeModel;
use app\admin\model\Access as AccessModel;
use app\admin\model\Node;
use think\Cache;

class NodeLogic extends BaseLogic
{
    /**
     * 检查当前url是否已经加入节点表,没有加入就新增
     * wj
     * 2018-7-13
     */
    public function check_node_url(){
        $request = request();
        $module = $request->module();//当前模块
        $controller = $request->controller();//当前控制器
        $action = $request->action();//当前操作
        $node_mark = $this->create_node_mark();
        $node_status = $this->check_node_mark($node_mark);
        $node_url = '/'.$module.'/'.$controller.'/'.$action;
        if (!$node_status){
            $nodeModel = new NodeModel();
            $data['module'] = $module;
            $data['controller'] = $controller;
            $data['action'] = $action;
            $data['node_url'] = $node_url;
            $data['node_mark'] = $node_mark;
            $data['status'] = 0;
            $nodeModel->save($data);
        }
    }

    /**
     * 创建节点标示
     * @return string
     * wj
     * 2018-7-14
     */
    public function create_node_mark(){
        $request = request();
        $module = $request->module();//当前模块
        $controller = $request->controller();//当前控制器
        $action = $request->action();//当前操作
        $node_url = '/'.$module.'/'.$controller.'/'.$action;
        return base64_encode($node_url);
    }
    /**
     * 检查当前节点标示是否存在数据库
     * @param $node_mark 节点标示
     * @return bool 存在返回true，不存在返回false
     * wj
     * 2018-7-13
     */
    public function check_node_mark($node_mark){
        $node_list = Cache::get('node_mark');
        if (!empty($node_list)){
            if(in_array($node_mark,$node_list)){//缓存中已经存在
                return true;
            }
        }
        //如果缓存中不存在就到数据库里面去找
        $node_list = NodeModel::column('node_mark');
        if (empty($node_list)){
            return false;
        }
        Cache::set('node_mark',$node_list,1800);
        if(in_array($node_mark,$node_list)){//数据库中已经存在
            return true;
        }
        return false;
    }

    /**
     * 获取组下面的所有节点
     * @return array
     */
    public function group_node(){
        $request = request();
        $role_id = $request->get('role_id');
        $groupModel = new GroupModel();
        $map_node['status'] = array('eq',1);
        $group_list = GroupModel::hasWhere('node',$map_node)->select()->toArray();
        foreach($group_list as $k=>&$v){
          $node_list = Node::all(['group_id'=>$v['group_id'],'status'=>1]);
          if (!empty($node_list)){
              $v['node_list'] = $node_list->toArray();
          }
        }
        return $group_list;
    }
    /**
     * 判断节点是否属于角色
     * @param $node_id 节点id
     * @param $role_id 角色id
     * @return bool
     * wj
     * 2018-7-14
     */
    public function node_is_role($node_id,$role_id){
        $map['node_id'] = array('eq',$node_id);
        $map['role_id'] = array('eq',$role_id);
        $list = AccessModel::get($map);
        if (empty($list)){
            return false;
        }else{
            return true;
        }
    }
    /**
     * 获取targ
     * @return array
     * wj
     * 2018-7-14
     */
    public function get_targ(){
        $node_mark = $this->create_node_mark();
        $node_info = NodeModel::get(['node_mark'=>$node_mark]);
        if (empty($node_info)){
            return [];
        }
        if(!empty($node_info->group)){
            $tag =[$node_info->group->group_name,$node_info->node_name];
        }else{
            $tag =[$node_info->node_name];
        }
        $node_id = $node_info['node_id'];
        $data['tag'] = $tag;
        $data['node_id'] = $node_id;
        return $data;
    }
}