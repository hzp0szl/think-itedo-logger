<?php

namespace IteLog;

use \think\Config as ThinkConfig;
use \think\App;
use think\db\Connection;
use think\Debug;

/**
 * 初始配置
 * Class Config
 * @package IteLog
 */
class Config
{
    /**
     * Config constructor.
     */
    public function __construct()
    {
        $this->openConfig();
    }

    /**
     * run
     */
    public function run()
    {
        //
    }

    /**
     * 初始开启配置
     */
    public function openConfig()
    {
        //设置debug开启模式
        App::$debug = true;
        //设置时区开始
        Debug::remark('behavior_start', 'time');

        ############## 重载config配置 ##############
        $config = ROOT_PATH . 'config/config.php';
        // 设置类型 不用写入file，切换成test
        ThinkConfig::set('log.type', 'test');
        ThinkConfig::load($config, 'config');

        ############## 开启数据库配置文件 ##############
        $filename = ROOT_PATH . 'config/database.php';
        // 开启debug模式
        ThinkConfig::set('debug', false);
        ThinkConfig::load($filename, 'database');
    }
}