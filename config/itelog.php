<?php

return [
    //是否开启true false
    'logger' => true,
    //异常开启true false
    'exception' => true,
    //驱动 mongodb | file | mysql（后续完善）
    'driver' => 'mongodb',
    //driver是mongodb 时 需要填写表名
    'mongo_table' => 'ite_logger',
    //mongo 链接配置
    'mongo' => [
        'hostname' => '127.0.0.1',// 服务器地址
        'database' => 'itedo',// 数据库名
        'table' => 'itedo',// 数据库名
        'username' => 'root',// 用户名
        'prefix' => '',// 前缀
        'password' => '123',// 密码
        'hostport' => 27017,// 端口
        'charset' => 'utf8',// 数据库字符集
    ]
];
