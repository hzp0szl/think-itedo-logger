# thinkphp-itedo-logger

### 框架版本
<a href="https://github.com/hzp0szl/itedo-logger">laravel版本</a>
` | `
<a href="https://github.com/hzp0szl/think-itedo-logger">thinkphp版本</a>

### 简介
	辅助thinkphp调试包，记录请求数据、数据库执行SQL语句、相应相关数据。支持file日志、mongodb、mysql（后续更新）。
	不足之处希望感兴趣的您指导加以修正。感谢！！！

### 版本 (其他版本后续新增)
```
PHP:        ^V7.0
Thinkphp:   5.0.22
```

###镜像包
```
composer require itedo/think-itedo-logger -vvv
```

### config/tags.php
添加 IteLog\Config 和 IteLog\Logger 至对应的标签栏
```
    // 应用初始化
    'app_init'     => ['IteLog\Config'],
    
    // 应用结束
    'app_end'      => ['IteLog\Logger'],
```
### config/database.php
```
    // 数据库调试模式
    'debug'           => true,
```
### config/新增配置itelog.php
```
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
        'username' => 'root',// 用户名
        'prefix' => '',// 前缀
        'password' => '123',// 密码
        'hostport' => 27017,// 端口
        'charset' => 'utf8',// 数据库字符集
    ]
];
```

### Mongodb驱动时配置
需配置php扩展  php_mongodb