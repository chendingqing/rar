<?php
/**
 * 节点是否属于某个角色
 * User: wj
 * Date: 2018/7/13
 * Time: 18:19
 */
function node_is_role($node_id,$role_id){
    $logic = new \app\admin\logic\NodeLogic();
    $res =  $logic->node_is_role($node_id,$role_id);
    if ($res){
        return ' layui-form-checked';
    }
}

/**
 * 案例是否属于某个案列类型
 * wj
 * 2018-8-7
 * @param $case_type_id 案例类型id
 * @param $case_id 案例id
 * @return string
 */
function caseType_to_case($case_type_id,$case_id){
    $res = \app\admin\logic\CaseType::is_chekced($case_type_id,$case_id);
    if ($res){
        return 'checked=checked';
    }
}

/**
 * 判断url和seo已经关联
 * @param $url_id
 * @param $seo_id
 * @return string
 * wj
 * 2018-8-30
 */
function url_in_seo($url_id,$seo_id){
    $logic = new \app\admin\logic\SeoSet();
    $res =  $logic->url_in_seo($url_id,$seo_id);
    if ($res){
        return 'checked=checked';
    }
}