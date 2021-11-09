<?php

namespace IteLog;

use think\Db;

/**
 * Class MongoDb
 * @package IteLog
 */
class MongoDb
{
    /**
     * mongodb入库
     *
     * @param $data
     * @throws \think\Exception
     */
    public function into($data)
    {
        $config = config('itelog.mongo');
        $config['type'] = '\think\mongo\Connection';
        $mongo = Db::connect($config);
        $mongo->name('ite_logger')->insert($data);
    }
}