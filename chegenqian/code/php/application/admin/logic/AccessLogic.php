<?php
/**
 * 节点
 * User: Dell
 * Date: 2018/7/12
 * Time: 14:30
 */
namespace app\admin\logic;
use app\admin\model\Group as GroupModel;
use app\admin\model\Node as NodeModel;
use app\admin\model\Access as AccessModel;
class AccessLogic extends BaseLogic
{
    /**
     * 获取菜单
     * @param $role_id 角色id
     * @return array 返回数组
     * wj
     * 2018-7-14
     */
    public function get_menu(){
        //如果session中有数据优先读取
        $menu_list = session('menu_list');
        if (!empty($menu_list)){
            return $menu_list;
        }
        //session中无数据，在数据库中查找，并保存到session中
        $user_info = session('user_info');
        if ($user_info['username'] =='admin'){//管理员有所有的权限
            $list = NodeModel::where(['is_menu'=>['eq',1]])->select();
        }else{
            $role_id = $user_info['role_id'];
            $node_list = AccessModel::where(['role_id'=>['eq',$role_id]])->column('node_id');//获取角色下面所有的节点
            $node_str = implode(",", $node_list);
            $sql = 'is_menu=1 and (node_id in ('.$node_str.') or need_access=0)';
            $list = NodeModel::where($sql)->select();//获取角色下面所有的节点信息，包含不需要验证的节点
        }
        if (empty($list)){
            return [];
        }
        $data = [];
        $list = $list->toArray();
        foreach($list as $k=>$v){
            $group_id = $v['group_id'];
            if (empty($data[$group_id]['group_name'])){
                $group_info = GroupModel::where(['group_id'=>['eq',$v['group_id']]])->find();//获取节点组信息
                if (empty($group_info)){
                    continue;
                }
                $data[$group_id]['group_name'] = $group_info->group_name;
                $data[$group_id]['icon'] = $group_info->icon;
            }
            $data[$group_id]['node_list'][] = $v;
        }

        session('menu_list',$data);
        $list= $data;
        return $list;
    }

    /**
     * 验证权限
     * @return bool
     */
    public function check_access(){
        $user_info = session('user_info');
        if (empty($user_info)){//用户信息为空
            fail_return(['msg'=>'用户数据异常,请重新登录']);
        }
        if ($user_info['username'] =='admin'){//管理员有所有的权限
            return true;
        }
        $node_list = $mark_session =session('node_access');//获取节点session 数据
        if (empty($mark_session)){//session数据不存在，到数据库中查询，并保存为session
            $role_id = $user_info['role_id'];
            $access_list = AccessModel::where(['role_id'=>['eq',$role_id]])->column('node_id');//获取角色下面所有的节点id
            $node_str = implode(",", $access_list);
            $sql = 'node_id in ('.$node_str.') or need_access=0';
            $node_list = NodeModel::where($sql)->column('node_mark');//获取角色下面所有的节点唯一标示，包含不需要验证的节点
            if(empty($node_list)){//无任何权限
                return false;
            }
            session('node_access',$node_list);//保存到session
        }

        $nodeLogic = new NodeLogic();
        $node_mark = $nodeLogic->create_node_mark();//获取节点唯一标示
        if(in_array($node_mark,$node_list)){//这个地方就是判断权限的关键点
            return true;
        }
        fail_return(['msg'=>'无权限']);
        return false;
    }
}