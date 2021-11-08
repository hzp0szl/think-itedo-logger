<?php
namespace IteLog;

use think\App;
use think\Config;
use think\Log;
use think\Request;

class Logger
{
    /**
     * 执行
     */
    public function run()
    {
        // 文件驱动
        if(\config('itelog.driver') == 'file'){
            Config::set('log.type', 'file');
        }
        // mongodb驱动
        if(\config('itelog.driver') == 'mongodb'){
            $dataSource = new DataSource();
            $array = $dataSource->assemble()->toArray();
            (new MongoDb())->into($array);
        }

    }
}