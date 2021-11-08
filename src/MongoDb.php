<?php

namespace IteLog;

use think\Db;
/**
 * Class MongoDb
 * @package IteLog
 */
class MongoDb
{

    public function into($data)
    {
        $config = config('itelog.mongo');
        $config['type'] = 'mongo';
        $mongo = Db::connect($config);
        dd($mongo);
    }
}