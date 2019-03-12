<?php
/**
 * 节点
 * User: Dell
 * Date: 2018/7/12
 * Time: 14:30
 */
namespace app\admin\logic;



class WjLogic extends BaseLogic
{
    /**
     * 文章搜索条件组装
     * wj
     * 2018-8-2
     * @return mixed
     * $result_data['map'] = $map; 搜索查询条件
     * $result_data['params'] = $params;  模板显示的搜索条件
     * $result_data['category_list'] = $category_list; 需要显示的子分类
     */
    static public function search(){
        $map = [];
        $request = request();
        $params = [];
        $params['username'] = $username = $request->param('username');//商品名称
        $params['phone'] = $phone = $request->param('phone');//类型
        $params['is_display'] = $is_display = $request->param('is_display');//是否显示
        $username ? $map['username'] = array('like','%'.$username.'%') : '';
        $phone ? $map['phone'] = array('eq',$phone) : '';



        if ( in_array($is_display,[0,1]) and $is_display !=''){
            $map['is_display'] = array('eq',$is_display);
        }

        $result_data['map'] = $map;
        $result_data['params'] = $params;
        return $result_data;
    }
}