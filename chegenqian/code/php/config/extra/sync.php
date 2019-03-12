<?php
/**
 * 同步数据库设置
 * User: Dell
 * Date: 2018/7/26
 * Time: 19:29
 */
//数据库配置1
return[
    'sync_db_config' => [
        // 数据库类型
        'type'        => 'mysql',
        // 服务器地址
        'hostname'    => '127.0.0.1',
        // 数据库名
        'database'    => 'jingye',
        // 数据库用户名
        'username'    => 'root',
        // 数据库密码
        'password'    => '',
        // 数据库编码默认采用utf8
        'charset'     => 'utf8',
        // 数据库表前缀
        'prefix'      => 'tp_',
    ]
];
