<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * 返回数据
 * wj
 * 2018-9-12
 * @param $params
 * $params['code']          1：流程处理成功，0表示流程处理失败
 * $params['msg']           提示信息
 * $params['http_code']     状态码
 * @throws \app\lib\exception\Fail
 */
function fail_return($params=[]){
    $e = new \app\lib\exception\Fail($params);
    throw $e;
}
/**
 * 成功返回数据
 * wj
 * 2018-9-26
 * @param array $params
 * $params[code] 1标示成功，0标示事变
 * $params[msg] 提示信息
 * $params[data] 应用数据
 */
function success_return($params = []){
    $result_data=[
        'code'=>1,
        'msg'=>'success',
        'data'=>[],
    ];
    if (array_key_exists('code',$params)){
        $result_data['result_data'] = $params['code'];
    }
    if (array_key_exists('msg',$params)){
        $result_data['msg'] = $params['msg'];
    }
    if (array_key_exists('data',$params)){
        $result_data['data'] = $params['data'];
    }
    echo json_encode($result_data);
    exit;
}

/**
 * 递归创建目录
 * wj
 * 2018-10-9
 * @param $dir 目录路径
 * @return bool
 */
function create_folders($dir) {
    return is_dir($dir) or (create_folders(dirname($dir)) and mkdir($dir, 0777));
}
